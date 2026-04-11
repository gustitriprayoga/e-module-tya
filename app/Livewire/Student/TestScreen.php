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
    public $answers = []; // Menyimpan ID pilihan jawaban
    public $timeLeft; // Dalam detik
    public $isFinished = false;

    public function mount($testId)
    {
        // Load test beserta soal dan pilihannya
        $this->test = Test::with(['questions.options'])->findOrFail($testId);
        $this->questions = $this->test->questions;
        $this->timeLeft = $this->test->duration * 60;

        // Inisialisasi jawaban kosong
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

        // Hitung Skor
        foreach ($this->questions as $question) {
            $selectedOptionId = $this->answers[$question->id];
            $correctOption = $question->options->where('is_correct', true)->first();

            if ($selectedOptionId == $correctOption->id) {
                $correctAnswers++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;

        // Simpan Hasil ke Database
        TestResult::create([
            'user_id' => Auth::id(),
            'test_id' => $this->test->id,
            'score' => $score,
            'completed_at' => now(),
        ]);

        $this->isFinished = true;

        return redirect()->route('student.test.result', ['test_id' => $this->test->id]);
    }

    public function render()
    {
        return view('livewire.student.test-screen')
            ->layout('components.layouts.app'); // Gunakan layout standar tanpa sidebar admin
    }
}
