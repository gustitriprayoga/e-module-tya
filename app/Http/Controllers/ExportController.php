<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function downloadTestResult($id)
    {
        // Load data dan opsi jawaban
        $result = TestResult::with(['test.module', 'user', 'test.questions.options'])->findOrFail($id);

        // Amankan data jawaban
        $answers = $result->answers;
        if (is_string($answers)) {
            $answers = json_decode($answers, true);
        }

        // --- LOGIC BARU: Deteksi Tipe Tes Yang Lebih Fleksibel ---
        $typeStr = strtolower($result->test->type);

        // Set default sebagai cadangan
        $config = ['color' => '#6366f1', 'label' => 'Result'];

        if (str_contains($typeStr, 'pre')) {
            $config = ['color' => '#3b82f6', 'label' => 'Pre-Test'];
        } elseif (str_contains($typeStr, 'post')) {
            $config = ['color' => '#10b981', 'label' => 'Post-Test'];
        } elseif (str_contains($typeStr, 'quiz')) {
            $config = ['color' => '#f59e0b', 'label' => 'Quiz'];
        }
        // -------------------------------------------------------

        $pdf = Pdf::loadView('pdf.test-result', [
            'result' => $result,
            'answers' => $answers ?? [],
            'config' => $config
        ]);

        $moduleTitle = $result->test->module->title ?? 'Module';
        $filename = "{$config['label']}_{$result->user->name}_{$moduleTitle}.pdf";

        return $pdf->download(str_replace(' ', '_', $filename));
    }
}
