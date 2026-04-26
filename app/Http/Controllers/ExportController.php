<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function downloadTestResult($id)
    {
        // Tambahkan 'test.questions.options' pada pemanggilan relasi
        $result = \App\Models\TestResult::with(['test.module', 'user', 'test.questions.options'])->findOrFail($id);

        // Tentukan tema warna berdasarkan tipe tes
        $config = match ($result->test->type) {
            'pretest' => ['color' => '#3b82f6', 'label' => 'Pre-Test'],
            'posttest' => ['color' => '#10b981', 'label' => 'Post-Test'],
            'quiz' => ['color' => '#f59e0b', 'label' => 'Quiz'],
            default => ['color' => '#6366f1', 'label' => 'Result'],
        };

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.test-result', [
            'result' => $result,
            'config' => $config
        ]);

        // Nama file dinamis
        $moduleTitle = $result->test->module->title ?? 'Umum';
        $filename = "{$config['label']}_{$result->user->name}_{$moduleTitle}.pdf";

        return $pdf->download(str_replace(' ', '_', $filename));
    }
}
