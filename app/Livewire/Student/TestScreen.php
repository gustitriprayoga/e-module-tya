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

        // PENGAMAN: Jika admin/seeder belum memasukkan soal ke dalam ujian ini
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

        $totalQuestions = count($this->questions);
        $correctAnswers = 0;

        foreach ($this->questions as $question) {
            $selectedOptionId = $this->answers[$question->id] ?? null;
            $correctOption = $question->options->where('is_correct', true)->first();

            if ($correctOption && $selectedOptionId == $correctOption->id) {
                $correctAnswers++;
            }
        }

        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        TestResult::create([
            'user_id' => Auth::id(),
            'test_id' => $this->test->id,
            'score' => $score,
            'completed_at' => now(),
        ]);

        $this->isFinished = true;

        toast('Test submitted successfully!', 'success');

        // PENTING: Arahkan ke halaman analitik (Test Result)
        return redirect()->route('student.test.result', $this->test->id);
    }

    public function render()
    {
        return view('livewire.student.test-screen')
            ->layout('components.layouts.reader', ['title' => $this->test->title ?? 'Test']);
    }
}
