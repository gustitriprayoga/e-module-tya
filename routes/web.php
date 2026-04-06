<?php

use App\Livewire\HomePage;
use App\Livewire\ModuleExplorer;
use App\Livewire\Leaderboard;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public Routes
Route::get('/', HomePage::class)->name('home');
Route::get('/modules', ModuleExplorer::class)->name('modules.index');
Route::get('/leaderboard', Leaderboard::class)->name('leaderboard');

// --- Public Routes ---
Route::middleware('guest')->group(function () {
    // Halaman Login Livewire
    Route::get('/login', Login::class)->name('login');
});


// --- Protected Routes (Must be Logged In) ---
Route::middleware(['auth'])->group(function () {

    // Prosedur Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // SweetAlert Feedback (Opsional)
        toast('You have been logged out safely.', 'success');

        return redirect('/');
    })->name('logout');

    // Group Dashboard Berdasarkan Role (Spatie)
    Route::prefix('dashboard')->group(function () {

        // 1. Dashboard Admin (Peneliti/Dosen)
        Route::middleware(['role:admin'])->get('/admin', function () {
            return view('dashboard.admin'); // Ganti dengan Livewire component jika ada
        })->name('dashboard.admin');

        // 2. Dashboard Peserta (Mahasiswa/Dosen dari SSO)
        Route::middleware(['role:mahasiswa|dosen'])->get('/student', function () {
            return view('dashboard.student'); // Ganti dengan Livewire component jika ada
        })->name('dashboard.student');
    });
});
