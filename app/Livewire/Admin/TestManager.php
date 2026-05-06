<?php

namespace App\Livewire\Admin;

use App\Models\Test;
use App\Models\Question;
use App\Models\Module;
use App\Models\TestPassage;
use Livewire\Component;
use Livewire\WithPagination;

class TestManager extends Component
{
    use WithPagination;

    // --- STATE UJIAN (TEST) ---
    public $search = '';
    public $test_id, $title, $module_id, $type = 'pre-test', $duration = 60, $passing_score = 70, $is_active = false;
    public $isModalOpen = false;

    // --- STATE MODAL UTAMA (MANAGE QUESTIONS) ---
    public $isQuestionManagerOpen = false;
    public ?Test $test = null; // Akan menampung test yang dipilih beserta relasinya

    // --- STATE FORM PASSAGE ---
    public $isPassageFormOpen = false;
    public $passage_id, $passage_title, $passage_content;

    // --- STATE FORM SOAL (QUESTION) ---
    public $isQuestionFormOpen = false;
    public $question_id, $question_text, $indicator, $explanation;
    public $question_passage_id; // Untuk menyimpan passage_id saat membuat/mengedit soal
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

        $indicators = ['Main Idea', 'Supporting Detail', 'Inference', 'Vocabulary in Context', 'Reference'];

        return view('livewire.admin.test-manager', [
            'tests' => $tests,
            'modules' => $modules,
            'indicators' => $indicators,
        ])->layout('components.layouts.dashboard', ['title' => 'Test Manager']);
    }

    // ==========================================
    // 1. TEST CRUD METHODS (TIDAK BERUBAH)
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
        Test::findOrFail($id)->delete();
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
    // 2. REFACTORED QUESTION & PASSAGE MANAGER
    // ==========================================

    public function manageQuestions($testId)
    {
        $this->loadCompleteTest($testId);
        $this->isQuestionManagerOpen = true;
    }

    public function loadCompleteTest($testId)
    {
        $this->test = Test::with('testPassages.questions.options')->findOrFail($testId);
    }

    // --- Passage CRUD Methods ---
    public function createPassage()
    {
        $this->resetPassageFields();
        $this->isPassageFormOpen = true;
    }

    public function editPassage($passageId)
    {
        $passage = TestPassage::findOrFail($passageId);
        $this->passage_id = $passage->id;
        $this->passage_title = $passage->title;
        $this->passage_content = $passage->content;
        $this->isPassageFormOpen = true;
    }

    public function savePassage()
    {
        $this->validate([
            'passage_content' => 'required|string',
            'passage_title' => 'nullable|string|max:255',
        ]);

        TestPassage::updateOrCreate(['id' => $this->passage_id], [
            'test_id' => $this->test->id,
            'title' => $this->passage_title,
            'content' => $this->passage_content,
        ]);

        $this->isPassageFormOpen = false;
        $this->loadCompleteTest($this->test->id);
        toast($this->passage_id ? 'Passage updated!' : 'New passage added!', 'success');
    }

    public function deletePassage($passageId)
    {
        TestPassage::findOrFail($passageId)->delete();
        $this->loadCompleteTest($this->test->id);
        toast('Passage and its questions deleted.', 'error');
    }

    private function resetPassageFields()
    {
        $this->passage_id = null;
        $this->passage_title = '';
        $this->passage_content = '';
    }

    // --- Question CRUD Methods ---
    public function createQuestion($passageId)
    {
        $this->resetQuestionFields();
        $this->question_passage_id = $passageId;
        $this->isQuestionFormOpen = true;
    }

    public function editQuestion($questionId)
    {
        $question = Question::with('options')->findOrFail($questionId);
        $this->question_id = $question->id;
        $this->question_passage_id = $question->test_passage_id;
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
        $this->isQuestionFormOpen = true;
    }

    public function saveQuestion()
    {
        $filledOptions = array_values(array_filter($this->options, fn ($opt) => trim($opt['text']) !== ''));
        $this->options = $filledOptions;

        $this->validate([
            'question_passage_id' => 'required|exists:test_passages,id',
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
            'test_id' => $this->test->id,
            'test_passage_id' => $this->question_passage_id,
            'question_text' => $this->question_text,
            'indicator' => $this->indicator,
            'explanation' => $this->explanation,
            'passage' => null, // Pastikan field lama dikosongkan
        ]);

        $question->options()->delete();

        foreach ($this->options as $option) {
            $question->options()->create([
                'option_text' => $option['text'],
                'is_correct' => $option['is_correct']
            ]);
        }

        $this->isQuestionFormOpen = false;
        $this->loadCompleteTest($this->test->id);
        toast($this->question_id ? 'Question updated!' : 'Question added!', 'success');
    }

     public function deleteQuestion($id)
    {
        Question::findOrFail($id)->delete();
        $this->loadCompleteTest($this->test->id);
        toast('Question deleted.', 'error');
    }

    private function resetQuestionFields()
    {
        $this->question_id = null;
        $this->question_passage_id = null;
        $this->question_text = '';
        $this->indicator = '';
        $this->explanation = '';
        $this->options = [['text' => '', 'is_correct' => true], ['text' => '', 'is_correct' => false], ['text' => '', 'is_correct' => false], ['text' => '', 'is_correct' => false], ['text' => '', 'is_correct' => false]];
    }

    // --- Radio button helper ---
    public function setCorrectOption($index)
    {
        foreach ($this->options as $i => $opt) {
            $this->options[$i]['is_correct'] = ($i === $index);
        }
    }
}
