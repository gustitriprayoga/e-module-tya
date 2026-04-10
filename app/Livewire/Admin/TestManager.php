<?php

namespace App\Livewire\Admin;

use App\Models\Test;
use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class TestManager extends Component
{
    use WithPagination;

    // Properties for Test CRUD
    public $search = '';
    public $test_id, $title, $type = 'pre-test', $duration = 60, $passing_score = 70, $is_active = false;
    public $isModalOpen = false;

    // Properties for Question Management (Attach/Detach)
    public $isQuestionModalOpen = false;
    public $selectedTestId;
    public $selectedTestTitle = '';
    public $selectedQuestions = []; // Array of Question IDs
    public $questionSearch = '';
    public $indicatorFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // 1. Load Tests
        $tests = Test::withCount('questions')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        // 2. Load Questions for Modal (If open)
        $availableQuestions = [];
        if ($this->isQuestionModalOpen) {
            $availableQuestions = Question::when($this->questionSearch, function ($query) {
                $query->where('question_text', 'like', '%' . $this->questionSearch . '%');
            })->when($this->indicatorFilter, function ($query) {
                $query->where('indicator', $this->indicatorFilter);
            })->latest()->get();
        }

        $indicators = [
            'Main Idea',
            'Supporting Detail',
            'Inference',
            'Vocabulary in Context',
            'Reference'
        ];

        return view('livewire.admin.test-manager', [
            'tests' => $tests,
            'availableQuestions' => $availableQuestions,
            'indicators' => $indicators
        ])->layout('components.layouts.dashboard', ['title' => 'Test Manager']);
    }

    // ==========================================
    // TEST CRUD METHODS
    // ==========================================
    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $test = Test::findOrFail($id);
        $this->test_id = $id;
        $this->title = $test->title;
        $this->type = $test->type;
        $this->duration = $test->duration;
        $this->passing_score = $test->passing_score;
        $this->is_active = $test->is_active;

        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:pre-test,post-test',
            'duration' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:1|max:100',
        ]);

        Test::updateOrCreate(['id' => $this->test_id], [
            'title' => $this->title,
            'type' => $this->type,
            'duration' => $this->duration,
            'passing_score' => $this->passing_score,
            'is_active' => $this->is_active,
        ]);

        $this->isModalOpen = false;
        toast($this->test_id ? 'Test settings updated!' : 'New test created!', 'success');
        $this->resetInputFields();
    }

    public function deleteTest($id)
    {
        Test::findOrFail($id)->delete();
        Alert::success('Deleted', 'Test has been deleted permanently.');
    }

    private function resetInputFields()
    {
        $this->test_id = null;
        $this->title = '';
        $this->type = 'pre-test';
        $this->duration = 60;
        $this->passing_score = 70;
        $this->is_active = false;
    }

    // ==========================================
    // QUESTION ASSIGNMENT METHODS
    // ==========================================
    public function manageQuestions($id)
    {
        $test = Test::with('questions')->findOrFail($id);
        $this->selectedTestId = $test->id;
        $this->selectedTestTitle = $test->title;

        // Ambil ID soal yang sudah terhubung dengan test ini
        $this->selectedQuestions = $test->questions->pluck('id')->map(fn($id) => (string) $id)->toArray();

        $this->isQuestionModalOpen = true;
    }

    public function saveQuestions()
    {
        $test = Test::findOrFail($this->selectedTestId);

        // Fitur Sync: Otomatis memasukkan ID baru dan menghapus ID lama dari pivot table
        $test->questions()->sync($this->selectedQuestions);

        $this->isQuestionModalOpen = false;
        toast('Questions successfully synced to the test!', 'success');
    }
}
