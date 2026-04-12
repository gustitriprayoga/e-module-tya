<?php

namespace App\Livewire\Admin;

use App\Models\Question;
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

    // Array untuk maksimal 5 Pilihan Jawaban (A-E)
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
        // 1. Buang opsi yang teks-nya kosong (Sehingga admin bebas membuat 3 atau 4 pilihan saja)
        $filledOptions = array_filter($this->options, function ($opt) {
            return trim($opt['text']) !== '';
        });

        // Re-index array agar berurutan kembali (0, 1, 2, dst)
        $this->options = array_values($filledOptions);

        // 2. Validasi Inti
        $this->validate([
            'question_text' => 'required|string',
            'indicator' => 'required|string',
            'options' => 'required|array|min:2', // Minimal harus ada 2 pilihan jawaban
            'options.*.text' => 'required|string',
        ], [
            'options.min' => 'You must provide at least 2 answer options.',
        ]);

        // 3. Validasi Kunci Jawaban (Pastikan ada 1 yang true)
        $hasCorrect = collect($this->options)->contains('is_correct', true);
        if (!$hasCorrect) {
            $this->addError('options_error', 'Please select exactly one correct answer (click the circle).');
            return;
        }

        // 4. Simpan Soal Inti
        $question = Question::updateOrCreate(['id' => $this->question_id], [
            'passage' => $this->passage,
            'question_text' => $this->question_text,
            'indicator' => $this->indicator,
            'explanation' => $this->explanation,
        ]);

        // 5. Hapus opsi lama jika ini adalah mode edit
        $question->options()->delete();

        // 6. Simpan Opsi Jawaban Baru
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

        // Memuat opsi dari database
        $this->options = [];
        foreach ($question->options as $opt) {
            $this->options[] = ['text' => $opt->option_text, 'is_correct' => (bool) $opt->is_correct];
        }

        // Tambahkan slot kosong agar genap 5 slot untuk di UI
        while (count($this->options) < 5) {
            $this->options[] = ['text' => '', 'is_correct' => false];
        }

        $this->isModalOpen = true;
    }

    public function deleteQuestion($id)
    {
        Question::findOrFail($id)->delete();
        toast('The question has been removed from the bank.', 'error');
    }

    private function resetInputFields()
    {
        $this->question_id = null;
        $this->passage = '';
        $this->question_text = '';
        $this->indicator = '';
        $this->explanation = '';

        // Format standar: 5 Pilihan, A otomatis tersetting benar (Admin bisa ubah)
        $this->options = [
            ['text' => '', 'is_correct' => true],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
            ['text' => '', 'is_correct' => false],
        ];
    }
}
