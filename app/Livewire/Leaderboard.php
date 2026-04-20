<?php

namespace App\Livewire;

use App\Models\ReadingHistory;
use App\Models\Module;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Leaderboard extends Component
{
    public $selectedModule = null;

    public function mount()
    {
        $firstModule = Module::where('is_published', true)
            ->orderBy('order', 'asc')
            ->first();

        if ($firstModule) {
            $this->selectedModule = $firstModule->id;
        }
    }

    public function render()
    {
        $modules = Module::where('is_published', true)
            ->orderBy('order', 'asc')
            ->get();

        $rankings = collect();

        if ($this->selectedModule) {
            /*
             * FIX: Query aggregasi + eager load user tidak bisa langsung.
             * Solusi: subquery dulu untuk dapat top_wpm per user,
             * lalu join ke users table secara manual.
             */
            $rawRankings = ReadingHistory::select(
                'user_id',
                DB::raw('MAX(wpm_result) as top_wpm')
            )
                ->where('module_id', $this->selectedModule)
                ->whereNotNull('wpm_result')
                ->where('wpm_result', '>', 0)
                ->groupBy('user_id')
                ->orderByDesc('top_wpm')
                ->take(20)
                ->get();

            // Ambil semua user_id hasil query, lalu load usernya sekaligus
            $userIds  = $rawRankings->pluck('user_id')->filter()->unique();
            $userMap  = User::whereIn('id', $userIds)
                ->select('id', 'name', 'nim_nip')   // sesuaikan kolom yang ada
                ->get()
                ->keyBy('id');

            // Tempelkan relasi user ke masing-masing row
            $rankings = $rawRankings->map(function ($row) use ($userMap) {
                $row->user = $userMap->get($row->user_id);
                return $row;
            });
        }

        return view('livewire.leaderboard', compact('rankings', 'modules'))
            ->title('Reading Leaderboard - LitFlow');
    }
}
