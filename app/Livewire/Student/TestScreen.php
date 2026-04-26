<?php

namespace App\Livewire\Student;

use App\Models\Test;
use App\Models\TestResult;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TestScreen extends Component
{
    public $test;
    public $questions;
    public $currentQuestionIndex = 0;
    public $answers = [];
    public $timeLeft;
    public $isFinished = false;

    public function mount($testId)
    {
        $this->test = Test::with(['questions.options'])->findOrFail($testId);
        $this->questions = $this->test->questions;

        if ($this->questions->isEmpty()) {
            toast('This test has no questions yet. Please contact the instructor.', 'error');
            return redirect()->route('dashboard');
        }

        $this->timeLeft = $this->test->duration * 60;

        foreach ($this->questions as $q) {
            $this->answers[$q->id] = null;
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function selectAnswer($questionId, $optionId)
    {
        $this->answers[$questionId] = $optionId;
    }

    public function submitTest()
    {
        if ($this->isFinished) return;

        // 1. SOLUSI LIVEWIRE: Ambil ulang data Test beserta kunci jawabannya langsung dari database
        $testData = Test::with('questions.options')->find($this->test->id);

        $totalQuestions = $testData->questions->count();
        $correctAnswers = 0;

        // Kalkulasi Skor yang akurat
        foreach ($testData->questions as $question) {
            $selectedOptionId = $this->answers[$question->id] ?? null;
            $correctOption = $question->options->where('is_correct', true)->first();

            if ($correctOption && (string)$selectedOptionId === (string)$correctOption->id) {
                $correctAnswers++;
            }
        }

        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        // 2. SOLUSI DATABASE: Paksa simpan data (Bypass Fillable) agar "answers" tidak dibuang
        $result = new TestResult();
        $result->user_id = Auth::id();
        $result->test_id = $this->test->id;
        $result->score = $score;
        $result->answers = is_array($this->answers) ? json_encode($this->answers) : $this->answers;
        $result->completed_at = now();
        $result->save();

        $this->isFinished = true;

        toast('Test submitted successfully!', 'success');

        return redirect()->route('student.test.result', $this->test->id);
    }

    public function render()
    {
        return view('livewire.student.test-screen')->layout('components.layouts.app');
    }
}
