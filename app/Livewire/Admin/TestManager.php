<?php

namespace App\Livewire\Admin;

use App\Models\Test;
use App\Models\Question;
use App\Models\Module;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class TestManager extends Component
{
    use WithPagination;

    // --- STATE UJIAN (TEST) ---
    public $search = '';
    public $test_id, $title, $module_id, $type = 'pre-test', $duration = 60, $passing_score = 70, $is_active = false;
    public $isModalOpen = false;

    // --- STATE SOAL (QUESTION) ---
    public $isQuestionListOpen = false; // Modal daftar soal
    public $isQuestionFormOpen = false; // Modal form tambah/edit soal

    public $selectedTestId;
    public $selectedTestTitle = '';
    public $testQuestions = []; // Menyimpan soal-soal milik test yang dipilih

    // Form Soal
    public $question_id, $passage, $question_text, $indicator, $explanation;
    public $options = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tests = Test::withCount('questions')
            ->with('module')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);

        $modules = Module::orderBy('order', 'asc')->get();

        $indicators = [
            'Main Idea',
            'Supporting Detail',
            'Inference',
            'Vocabulary in Context',
            'Reference'
        ];

        return view('livewire.admin.test-manager', [
            'tests' => $tests,
            'modules' => $modules,
            'indicators' => $indicators
        ])->layout('components.layouts.dashboard', ['title' => 'Test Manager']);
    }

    // ==========================================
    // 1. TEST CRUD METHODS
    // ==========================================
    public function createTest()
    {
        $this->resetTestFields();
        $this->isModalOpen = true;
    }

    public function editTest($id)
    {
        $test = Test::findOrFail($id);
        $this->test_id = $id;
        $this->title = $test->title;
        $this->module_id = $test->module_id;
        $this->type = $test->type;
        $this->duration = $test->duration;
        $this->passing_score = $test->passing_score;
        $this->is_active = $test->is_active;
        $this->isModalOpen = true;
    }

    public function saveTest()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'type' => 'required|in:pre-test,post-test,quiz',
            'duration' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:1|max:100',
        ]);

        $existingTest = Test::where('module_id', $this->module_id)->where('type', $this->type)->where('id', '!=', $this->test_id)->first();
        if ($existingTest) {
            toast("This module already has a {$this->type}.", 'warning');
            return;
        }

        Test::updateOrCreate(['id' => $this->test_id], [
            'title' => $this->title,
            'module_id' => $this->module_id,
            'type' => $this->type,
            'duration' => $this->duration,
            'passing_score' => $this->passing_score,
            'is_active' => $this->is_active,
        ]);

        $this->isModalOpen = false;
        toast($this->test_id ? 'Test updated!' : 'New test created!', 'success');
    }

    public function deleteTest($id)
    {
        Test::findOrFail($id)->delete(); // Akan otomatis menghapus soal-soalnya karena Cascade
        toast('Test deleted permanently.', 'error');
    }

    private function resetTestFields()
    {
        $this->test_id = null;
        $this->title = '';
        $this->module_id = '';
        $this->type = 'pre-test';
        $this->duration = 60;
        $this->passing_score = 70;
        $this->is_active = false;
    }

    // ==========================================
    // 2. QUESTION CRUD METHODS (KHUSUS UNTUK TEST TERPILIH)
    // ==========================================

    // Buka Modal Daftar Soal
    public function manageQuestions($test_id)
    {
        $test = Test::findOrFail($test_id);
        $this->selectedTestId = $test->id;
        $this->selectedTestTitle = $test->title;
        $this->loadTestQuestions();
        $this->isQuestionListOpen = true;
    }

    // Muat ulang daftar soal di memori
    public function loadTestQuestions()
    {
        $this->testQuestions = Question::where('test_id', $this->selectedTestId)->latest()->get();
    }

    // Buka Modal Bikin Soal Baru
    public function createQuestion()
    {
        $this->resetQuestionFields();
        $this->isQuestionListOpen = false;
        $this->isQuestionFormOpen = true;
    }

    // Edit Soal
    public function editQuestion($id)
    {
        $question = Question::with('options')->findOrFail($id);
        $this->question_id = $id;
        $this->passage = $question->passage;
        $this->question_text = $question->question_text;
        $this->indicator = $question->indicator;
        $this->explanation = $question->explanation;

        $this->options = [];
        foreach ($question->options as $opt) {
            $this->options[] = ['text' => $opt->option_text, 'is_correct' => (bool) $opt->is_correct];
        }
        while (count($this->options) < 5) {
            $this->options[] = ['text' => '', 'is_correct' => false];
        }

        $this->isQuestionListOpen = false;
        $this->isQuestionFormOpen = true;
    }

    // Fungsi radio button kunci jawaban
    public function setCorrectOption($index)
    {
        foreach ($this->options as $i => $opt) {
            $this->options[$i]['is_correct'] = ($i === $index);
        }
    }

    public function saveQuestion()
    {
        // Filter opsi kosong
        $filledOptions = array_values(array_filter($this->options, fn($opt) => trim($opt['text']) !== ''));

        $this->options = $filledOptions;

        $this->validate([
            'question_text' => 'required|string',
            'indicator' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
        ], ['options.min' => 'Provide at least 2 options.']);

        if (!collect($this->options)->contains('is_correct', true)) {
            $this->addError('options_error', 'Select exactly one correct answer.');
            return;
        }

        $question = Question::updateOrCreate(['id' => $this->question_id], [
            'test_id' => $this->selectedTestId, // Ikat ke Test ini!
            'passage' => $this->passage,
            'question_text' => $this->question_text,
            'indicator' => $this->indicator,
            'explanation' => $this->explanation,
        ]);

        $question->options()->delete();

        foreach ($this->options as $option) {
            $question->options()->create([
                'option_text' => $option['text'],
                'is_correct' => $option['is_correct']
            ]);
        }

        $this->isQuestionFormOpen = false;
        $this->loadTestQuestions(); // Reload soal
        $this->isQuestionListOpen = true; // Kembali ke modal daftar soal
        toast($this->question_id ? 'Question updated!' : 'Question added to test!', 'success');
    }

    public function deleteQuestion($id)
    {
        Question::findOrFail($id)->delete();
        $this->loadTestQuestions(); // Reload list
        toast('Question deleted.', 'error');
    }

    // Kembali dari Form Soal ke Daftar Soal
    public function backToQuestionList()
    {
        $this->isQuestionFormOpen = false;
        $this->loadTestQuestions();
        $this->isQuestionListOpen = true;
    }

    private function resetQuestionFields()
    {
        $this->question_id = null;
        $this->passage = '';
        $this->question_text = '';
        $this->indicator = '';
        $this->explanation = '';
        $this->options = [
            ['text' => '', 'is_correct' => true],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
        ];
    }
}
