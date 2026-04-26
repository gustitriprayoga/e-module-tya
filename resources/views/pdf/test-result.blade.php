<!DOCTYPE html>
<html>

<head>
    <title>Hasil Tes</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
            font-size: 13px;
            line-height: 1.5;
        }

        /* ===== HEADER ===== */
        .header {
            background-color: {{ $config['color'] }};
            color: white;
            padding: 32px 40px 60px;
            text-align: center;
        }

        .header h1 {
            margin: 0 0 6px;
            font-size: 26px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .header p {
            margin: 0;
            font-size: 12px;
            opacity: 0.85;
        }

        /* ===== CONTENT WRAPPER ===== */
        .content {
            padding: 0 36px 36px;
        }

        /* ===== SCORE CARD ===== */
        .score-wrap {
            margin-top: -40px;
            margin-bottom: 28px;
        }

        .score-box {
            border: 2px solid {{ $config['color'] }};
            border-radius: 12px;
            padding: 18px 24px;
            text-align: center;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .score-label {
            margin: 0 0 4px;
            color: #6b7280;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
            font-weight: bold;
        }

        .score-value {
            font-size: 52px;
            font-weight: bold;
            color: {{ $config['color'] }};
            margin: 0;
            line-height: 1;
        }

        .score-sub {
            margin: 6px 0 0;
            color: #9ca3af;
            font-size: 11px;
        }

        /* ===== INFO TABLE ===== */
        .info-section {
            margin-bottom: 28px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-section td {
            padding: 10px 16px;
            font-size: 12px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        .info-section tr:last-child td {
            border-bottom: none;
        }

        .info-section td:first-child {
            color: #6b7280;
            font-weight: bold;
            width: 30%;
            background-color: #f9fafb;
        }

        .info-section td:last-child {
            color: #1f2937;
        }

        /* ===== SECTION TITLE ===== */
        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #1f2937;
            margin: 0 0 14px;
            padding-bottom: 8px;
            border-bottom: 2px solid {{ $config['color'] }};
        }

        /* ===== QUESTION CARD ===== */
        .question-card {
            margin-bottom: 12px;
            padding: 14px 16px;
            border-radius: 8px;
            border-left: 5px solid #d1d5db;
            background-color: #f9fafb;
        }

        .question-card.correct {
            border-left-color: #10b981;
            background-color: #f0fdf4;
        }

        .question-card.wrong {
            border-left-color: #ef4444;
            background-color: #fef2f2;
        }

        /* ===== BADGE ===== */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .badge-success {
            background-color: #10b981;
            color: white;
        }

        .badge-danger {
            background-color: #ef4444;
            color: white;
        }

        /* ===== QUESTION TEXT ===== */
        .question-text {
            margin: 0 0 10px;
            font-weight: bold;
            font-size: 13px;
            color: #111827;
        }

        /* ===== ANSWER ROW ===== */
        .answer-row {
            font-size: 12px;
            color: #374151;
            margin: 0;
        }

        .answer-row .answer-label {
            font-weight: bold;
            color: #6b7280;
        }

        .answer-row .answer-user-correct {
            color: #059669;
            font-weight: bold;
        }

        .answer-row .answer-user-wrong {
            color: #dc2626;
            font-weight: bold;
        }

        .answer-row .answer-correct {
            color: #059669;
            font-weight: bold;
        }

        /* ===== DIVIDER ===== */
        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 20px 0;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
    <div class="header">
        <h1>{{ $config['label'] }} Report</h1>
        <p>E-Module TYA &mdash; Digital Learning Achievement</p>
    </div>

    <div class="content">

        {{-- SCORE BOX --}}
        <div class="score-wrap">
            <div class="score-box">
                <p class="score-label">Final Score</p>
                <p class="score-value">{{ $result->score }}</p>
                <p class="score-sub">out of 100</p>
            </div>
        </div>

        {{-- INFO TABLE --}}
        <div class="info-section">
            <table>
                <tr>
                    <td>Student</td>
                    <td>{{ $result->user->name }}</td>
                </tr>
                <tr>
                    <td>Module</td>
                    <td>{{ $result->test->module->title }}</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{ $result->created_at->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <span style="color: #10b981; font-weight: bold;">&#10003; Completed</span>
                    </td>
                </tr>
            </table>
        </div>

        {{-- REVIEW JAWABAN --}}
        <p class="section-title">Review Jawaban</p>

        @foreach ($result->test->questions as $index => $question)
            @php
                /*
                 * FIX: Kunci pada $result->answers bisa berupa STRING (dari JSON decode),
                 * sedangkan $question->id adalah INTEGER.
                 * Casting ke string agar perbandingan selalu cocok.
                 */
                $answersMap = $result->answers ?? [];
                $questionKey = (string) $question->id;

                // 1. Ambil ID opsi yang dipilih user
                $userOptionId = $answersMap[$questionKey] ?? ($answersMap[$question->id] ?? null);

                // 2. Cari objek Option yang dipilih user
                $userOption = $question->options->where('id', (int) $userOptionId)->first();
                $userAnswerText = $userOption ? $userOption->option_text : 'Tidak dijawab';

                // 3. Cari opsi jawaban benar
                $correctOption = $question->options->firstWhere('is_correct', true);
                $correctAnswerText = $correctOption ? $correctOption->option_text : 'Kunci tidak diset';

                // 4. Validasi benar/salah
                $isCorrect = $userOption && (bool) $userOption->is_correct;
            @endphp

            <div class="question-card {{ $isCorrect ? 'correct' : 'wrong' }}">
                <span class="badge {{ $isCorrect ? 'badge-success' : 'badge-danger' }}">
                    {{ $isCorrect ? '✓ Benar' : '✗ Salah' }}
                </span>

                <p class="question-text">
                    {{ $index + 1 }}. {{ $question->question_text }}
                </p>

                <p class="answer-row">
                    <span class="answer-label">Jawaban Anda: </span>
                    <span class="{{ $isCorrect ? 'answer-user-correct' : 'answer-user-wrong' }}">
                        {{ $userAnswerText }}
                    </span>
                </p>

                @if (!$isCorrect)
                    <p class="answer-row" style="margin-top: 4px;">
                        <span class="answer-label">Jawaban Benar: </span>
                        <span class="answer-correct">{{ $correctAnswerText }}</span>
                    </p>
                @endif
            </div>
        @endforeach

        <div class="footer">
            <p>Dokumen ini digenerate otomatis oleh sistem E-Module TYA &bull; {{ now()->format('d M Y') }}</p>
        </div>

    </div>
</body>

</html>
