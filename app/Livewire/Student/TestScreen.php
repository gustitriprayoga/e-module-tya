<?php

namespace App\Livewire\Student;

use App\Models\Test;
use App\Models\Question;
use App\Models\TestResult;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class TestScreen extends Component
{
    public Test $test;
    public Collection $questions;
    public int $currentQuestionIndex = 0;
    public array $answers = [];
    public $timeLeft;
    public bool $isFinished = false;

    public function mount($testId)
    {
        $this->test = Test::findOrFail($testId);
        $this->timeLeft = $this->test->duration * 60;

        // Ambil pertanyaan yang dikelompokkan berdasarkan passage terlebih dahulu
        $passageQuestions = Question::where('test_id', $testId)
            ->whereNotNull('test_passage_id')
            ->with(['options', 'testPassage']) // Eager load relasi
            ->orderBy('test_passage_id') // Urutkan berdasarkan passage
            ->orderBy('id') // Kemudian urutkan berdasarkan ID soal
            ->get();

        // Ambil pertanyaan yang tidak memiliki passage
        $standaloneQuestions = Question::where('test_id', $testId)
            ->whereNull('test_passage_id')
            ->with('options')
            ->orderBy('id')
            ->get();

        // Gabungkan keduanya menjadi satu collection
        $this->questions = $passageQuestions->concat($standaloneQuestions);

        if ($this->questions->isEmpty()) {
            toast('This test has no questions yet. Please contact the instructor.', 'error');
            // Redirect using a more Livewire-friendly way if possible, or ensure this works in context.
            return redirect()->route('dashboard');
        }
        
        // Inisialisasi jawaban
        foreach ($this->questions as $q) {
            $this->answers[$q->id] = null;
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->questions->count() - 1) {
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

        // Ambil ulang data Test beserta kunci jawabannya langsung dari database
        $testData = Test::with('questions.options')->find($this->test->id);
        $totalQuestions = $testData->questions->count();
        $correctAnswers = 0;

        // Kalkulasi Skor
        foreach ($testData->questions as $question) {
            $selectedOptionId = $this->answers[$question->id] ?? null;
            $correctOption = $question->options->where('is_correct', true)->first();

            if ($correctOption && (string)$selectedOptionId === (string)$correctOption->id) {
                $correctAnswers++;
            }
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Simpan hasil
        $result = new TestResult();
        $result->user_id = Auth::id();
        $result->test_id = $this->test->id;
        $result->score = $score;
        $result->answers = json_encode($this->answers);
        $result->completed_at = now();
        $result->save();

        $this->isFinished = true;
        toast('Test submitted successfully!', 'success');

        return redirect()->route('student.test.result', $this->test->id);
    }

    public function render()
    {
        return view('livewire.student.test-screen')->layout('components.layouts.reader');
    }
}
