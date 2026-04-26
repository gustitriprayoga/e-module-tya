<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

// --- Public & Auth Components ---
use App\Livewire\HomePage;
use App\Livewire\ModuleExplorer;
use App\Livewire\Leaderboard;
use App\Livewire\Auth\Login;

// --- Admin Components ---
use App\Livewire\Dashboard\AdminDashboard;
use App\Livewire\Admin\ModuleManager;
use App\Livewire\Admin\SessionManager;
use App\Livewire\Admin\ContentBuilder;
use App\Livewire\Admin\VocabularyManager;
use App\Livewire\Admin\QuestionBank;
use App\Livewire\Admin\TestManager;

// --- Student Components ---
use App\Livewire\Student\Dashboard as StudentDashboard;
use App\Livewire\Student\TestScreen;

use App\Http\Controllers\ExportController;

// ==========================================
// 1. PUBLIC ROUTES
// ==========================================
Route::get('/', HomePage::class)->name('home');
Route::get('/modules-list', ModuleExplorer::class)->name('modules.index');
Route::get('/leaderboard', Leaderboard::class)->name('leaderboard');

Route::get('/download-result/{id}', [ExportController::class, 'downloadTestResult'])
    ->name('test.download')
    ->middleware(['auth']);

// ==========================================
// 2. GUEST ROUTES (Belum Login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});


// ==========================================
// 3. PROTECTED ROUTES (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // --- Logout Handler ---
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        Alert::toast('You have been logged out safely.', 'success');
        return redirect('/');
    })->name('logout');


    // ==========================================
    // 3A. DASHBOARD ADMIN (Peneliti / Dosen)
    // ==========================================
    Route::middleware(['role:admin'])->prefix('dashboard/admin')->group(function () {
        Route::get('/', AdminDashboard::class)->name('dashboard.admin');

        // Module & Content Management
        Route::get('/modules', ModuleManager::class)->name('admin.modules');
        Route::get('/modules/{module_id}/sessions', SessionManager::class)->name('admin.sessions');
        Route::get('/sessions/{session_id}/builder', ContentBuilder::class)->name('admin.content-builder');

        // Vocabulary & Instruments
        Route::get('/vocabulary', VocabularyManager::class)->name('admin.vocabulary');
        Route::get('/questions', QuestionBank::class)->name('admin.questions');
        Route::get('/tests', TestManager::class)->name('admin.tests');
    });


    // ==========================================
    // 3B. DASHBOARD PESERTA (Mahasiswa & SSO)
    // ==========================================
    Route::middleware(['role:mahasiswa|dosen'])->group(function () {
        Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
        Route::get('/test/{testId}', TestScreen::class)->name('student.test');
        // Route::get('/read/{module_slug}/{session_id?}', \App\Livewire\Student\ModuleReader::class)->name('student.reader');
        Route::get('/read/{module_slug}', \App\Livewire\Student\ModuleReader::class)->name('student.reader');

        Route::get('/modules', \App\Livewire\Student\ModuleList::class)->name('modules.student.index');
        Route::get('/test/{test_id}/result', \App\Livewire\Student\TestResult::class)->name('student.test.result');

        // Note: Nanti rute untuk Student Module Viewer (melihat materi) bisa ditambahkan di sini
    });
});
