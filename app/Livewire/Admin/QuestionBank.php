<?php

namespace App\Livewire\Admin;

use App\Models\Question;
use App\Models\QuestionOption;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionBank extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $indicator_filter = '';

    // Form Properties
    public $question_id, $passage, $question_text, $indicator, $explanation;

    // Array untuk 5 Pilihan Jawaban (A-E)
    public $options = [];

    public $isModalOpen = false;

    public function mount()
    {
        $this->resetInputFields();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Question::query();

        if ($this->search) {
            $query->where('question_text', 'like', '%' . $this->search . '%')
                ->orWhere('passage', 'like', '%' . $this->search . '%');
        }

        if ($this->indicator_filter) {
            $query->where('indicator', $this->indicator_filter);
        }

        $indicators = [
            'Main Idea',
            'Supporting Detail',
            'Inference',
            'Vocabulary in Context',
            'Reference'
        ];

        return view('livewire.admin.question-bank', [
            'questions' => $query->latest()->paginate(10),
            'indicators' => $indicators
        ])->layout('components.layouts.dashboard', ['title' => 'Question Bank']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    // Fungsi untuk memastikan hanya ada 1 jawaban benar
    public function setCorrect($index)
    {
        foreach ($this->options as $i => $option) {
            $this->options[$i]['is_correct'] = ($i === $index);
        }
    }

    public function save()
    {
        // Validasi
        $this->validate([
            'question_text' => 'required|string',
            'indicator' => 'required|string',
            'options.*.text' => 'required|string', // Pastikan semua opsi dari A-E terisi
        ]);

        // Simpan Soal Inti
        $question = Question::updateOrCreate(['id' => $this->question_id], [
            'passage' => $this->passage,
            'question_text' => $this->question_text,
            'indicator' => $this->indicator,
            'explanation' => $this->explanation,
        ]);

        // Hapus opsi lama jika ini adalah mode edit
        $question->options()->delete();

        // Simpan Opsi Jawaban (A-E)
        foreach ($this->options as $option) {
            $question->options()->create([
                'option_text' => $option['text'],
                'is_correct' => $option['is_correct']
            ]);
        }

        $this->isModalOpen = false;
        toast($this->question_id ? 'Question updated successfully!' : 'New question added to bank!', 'success');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $question = Question::with('options')->findOrFail($id);
        $this->question_id = $id;
        $this->passage = $question->passage;
        $this->question_text = $question->question_text;
        $this->indicator = $question->indicator;
        $this->explanation = $question->explanation;

        // Memuat opsi dari database (Pastikan selalu ada 5 untuk UI)
        $this->options = [];
        foreach ($question->options as $opt) {
            $this->options[] = ['text' => $opt->option_text, 'is_correct' => $opt->is_correct];
        }

        // Jika opsi dari DB kurang dari 5 (misal data lama), tambahkan agar genap 5 (A-E)
        while (count($this->options) < 5) {
            $this->options[] = ['text' => '', 'is_correct' => false];
        }

        $this->isModalOpen = true;
    }

    public function deleteQuestion($id)
    {
        Question::findOrFail($id)->delete();
        Alert::success('Deleted!', 'The question has been removed from the bank.');
    }

    private function resetInputFields()
    {
        $this->question_id = null;
        $this->passage = '';
        $this->question_text = '';
        $this->indicator = '';
        $this->explanation = '';

        // Format standar: 5 Pilihan (A, B, C, D, E) dimana A adalah default benar (bisa diubah nanti)
        $this->options = [
            ['text' => '', 'is_correct' => true],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
        ];
    }
}
