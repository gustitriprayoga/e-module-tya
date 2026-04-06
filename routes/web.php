<?php

use App\Livewire\HomePage;
use App\Livewire\ModuleExplorer;
use App\Livewire\Leaderboard;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\AdminDashboard;
use App\Livewire\Dashboard\StudentDashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

// --- Public Routes ---
Route::get('/', HomePage::class)->name('home');
Route::get('/modules', ModuleExplorer::class)->name('modules.index');
Route::get('/leaderboard', Leaderboard::class)->name('leaderboard');

// --- Guest Routes (Belum Login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// --- Protected Routes (Wajib Login) ---
Route::middleware(['auth'])->group(function () {

    // Prosedur Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        Alert::toast('You have been logged out safely.', 'success');
        return redirect('/');
    })->name('logout');

    // --- DASHBOARD ROUTING ---

    // 1. Dashboard Admin (Peneliti/Dosen Pengampu)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard/admin', AdminDashboard::class)->name('dashboard.admin');
        // Nanti route manajemen modul bisa ditambahkan di sini
    });

    // 2. Dashboard Peserta (Mahasiswa & Dosen dari SSO)
    Route::middleware(['role:mahasiswa|dosen'])->group(function () {
        Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
        // Nanti route pengerjaan pre-test & post-test bisa ditambahkan di sini
    });
});
