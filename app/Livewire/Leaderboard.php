<?php

namespace App\Livewire;

use App\Models\ReadingHistory;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Leaderboard extends Component
{
    public function render()
    {
        // Mengambil 20 peringkat teratas berdasarkan WPM
        $rankings = ReadingHistory::with('user')
            ->select('user_id', DB::raw('MAX(wpm_result) as top_wpm'))
            ->groupBy('user_id')
            ->orderBy('top_wpm', 'desc')
            ->take(20)
            ->get();

        return view('livewire.leaderboard', [
            'rankings' => $rankings
        ])->title('Reading Leaderboard - LitFlow');
    }
}
