<?php

namespace App\Livewire\Admin;

use App\Models\Vocabulary;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;

class VocabularyManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Filter & Search
    public $search = '';
    public $category_filter = '';

    // Form Properties (Single Add/Edit)
    public $vocab_id, $word, $definition, $context_sentence, $category;
    public $isModalOpen = false;

    // Import Properties
    public $isImportModalOpen = false;
    public $importFile;

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
            'total_words' => Vocabulary::count()
        ])->layout('components.layouts.dashboard', ['title' => 'Vocabulary Vault']);
    }

    // ==========================================
    // 1. SINGLE WORD CRUD
    // ==========================================
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

        Vocabulary::updateOrCreate(
            ['word' => strtolower($this->word)], // Mencegah duplikasi kata
            [
                'definition' => $this->definition,
                'context_sentence' => $this->context_sentence,
                'category' => $this->category ?? 'General',
            ]
        );

        $this->isModalOpen = false;
        toast($this->vocab_id ? 'Word updated!' : 'New word added to vault!', 'success');
        $this->resetInputFields();
    }

    public function deleteWord($id)
    {
        Vocabulary::findOrFail($id)->delete();
        Alert::success('Deleted!', 'The word has been removed from the vault.');
    }

    // ==========================================
    // 2. EXPORT FUNCTIONALITY (JSON & CSV)
    // ==========================================
    public function exportJson()
    {
        $data = Vocabulary::select('word', 'definition', 'context_sentence', 'category')->get();

        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        }, 'vocabulary_vault.json', [
            'Content-Type' => 'application/json',
        ]);
    }

    public function exportCsv()
    {
        $data = Vocabulary::select('word', 'definition', 'context_sentence', 'category')->get();

        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['word', 'definition', 'context_sentence', 'category']); // Header

            foreach ($data as $row) {
                fputcsv($handle, [$row->word, $row->definition, $row->context_sentence, $row->category]);
            }
            fclose($handle);
        }, 'vocabulary_vault.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    // ==========================================
    // 3. IMPORT FUNCTIONALITY
    // ==========================================
    public function openImportModal()
    {
        $this->importFile = null;
        $this->isImportModalOpen = true;
    }

    public function importData()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt,json|max:10240', // Max 10MB
        ]);

        $extension = $this->importFile->getClientOriginalExtension();
        $path = $this->importFile->getRealPath();
        $count = 0;

        // IMPORT JSON
        if ($extension === 'json') {
            $data = json_decode(file_get_contents($path), true);
            if (is_array($data)) {
                foreach ($data as $item) {
                    if (!empty($item['word']) && !empty($item['definition'])) {
                        Vocabulary::updateOrCreate(
                            ['word' => strtolower(trim($item['word']))],
                            [
                                'definition' => $item['definition'],
                                'context_sentence' => $item['context_sentence'] ?? null,
                                'category' => $item['category'] ?? 'General',
                            ]
                        );
                        $count++;
                    }
                }
            }
        }
        // IMPORT CSV
        elseif (in_array($extension, ['csv', 'txt'])) {
            if (($handle = fopen($path, 'r')) !== false) {
                $header = fgetcsv($handle, 1000, ',');
                $header = array_map('strtolower', $header); // Pastikan header huruf kecil

                $wordIdx = array_search('word', $header);
                $defIdx = array_search('definition', $header);
                $ctxIdx = array_search('context_sentence', $header);
                $catIdx = array_search('category', $header);

                if ($wordIdx !== false && $defIdx !== false) {
                    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                        if (!empty($data[$wordIdx]) && !empty($data[$defIdx])) {
                            Vocabulary::updateOrCreate(
                                ['word' => strtolower(trim($data[$wordIdx]))],
                                [
                                    'definition' => $data[$defIdx],
                                    'context_sentence' => $ctxIdx !== false ? ($data[$ctxIdx] ?? null) : null,
                                    'category' => $catIdx !== false ? ($data[$catIdx] ?? 'General') : 'General',
                                ]
                            );
                            $count++;
                        }
                    }
                }
                fclose($handle);
            }
        }

        $this->isImportModalOpen = false;
        $this->importFile = null;
        toast("$count words successfully imported!", 'success');
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
