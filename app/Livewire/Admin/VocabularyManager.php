<?php

namespace App\Livewire\Admin;

use App\Models\Vocabulary;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

class VocabularyManager extends Component
{
    use WithPagination;

    // Filter & Search
    public $search = '';
    public $category_filter = '';

    // Form Properties (Single Add/Edit)
    public $vocab_id, $word, $definition, $context_sentence, $category;
    public $isModalOpen = false;
    public $isImportModalOpen = false;

    // Reset pagination ketika melakukan pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Vocabulary::query();

        if (!empty($this->search)) {
            $query->where('word', 'like', '%' . $this->search . '%')
                ->orWhere('definition', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->category_filter)) {
            $query->where('category', $this->category_filter);
        }

        $vocabularies = $query->orderBy('word', 'asc')->paginate(15);
        $categories = Vocabulary::select('category')->distinct()->pluck('category');

        return view('livewire.admin.vocabulary-manager', [
            'vocabularies' => $vocabularies,
            'categories' => $categories,
            'total_words' => Vocabulary::count() // Untuk tracker target 3.500
        ])->layout('components.layouts.dashboard', ['title' => 'Vocabulary Vault']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $vocab = Vocabulary::findOrFail($id);
        $this->vocab_id = $vocab->id;
        $this->word = $vocab->word;
        $this->definition = $vocab->definition;
        $this->context_sentence = $vocab->context_sentence;
        $this->category = $vocab->category;

        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'word' => 'required|string|max:255',
            'definition' => 'required|string',
            'context_sentence' => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        Vocabulary::updateOrCreate(['id' => $this->vocab_id], [
            'word' => strtolower($this->word), // Simpan dalam huruf kecil agar seragam
            'definition' => $this->definition,
            'context_sentence' => $this->context_sentence,
            'category' => $this->category ?? 'General',
        ]);

        $this->isModalOpen = false;
        toast($this->vocab_id ? 'Word updated!' : 'New word added to vault!', 'success');
        $this->resetInputFields();
    }

    public function deleteWord($id)
    {
        Vocabulary::findOrFail($id)->delete();
        Alert::success('Deleted!', 'The word has been removed from the vault.');
    }

    public function openImportModal()
    {
        $this->isImportModalOpen = true;
    }

    private function resetInputFields()
    {
        $this->vocab_id = null;
        $this->word = '';
        $this->definition = '';
        $this->context_sentence = '';
        $this->category = '';
    }
}
