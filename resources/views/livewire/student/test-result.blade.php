<div class="max-w-3xl mx-auto pb-20 mt-8" style="font-family: var(--font-sans, system-ui, sans-serif);">

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes popIn {
            0% {
                transform: scale(0.5);
                opacity: 0
            }

            70% {
                transform: scale(1.1)
            }

            100% {
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-6px)
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%)
            }

            100% {
                transform: translateX(200%)
            }
        }

        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 0.6
            }

            100% {
                transform: scale(4);
                opacity: 0
            }
        }

        @keyframes barFill {
            from {
                width: 0
            }

            to {
                width: var(--bar-w)
            }
        }

        .res-wrap * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        /* Hero */
        .res-hero {
            text-align: center;
            margin-bottom: 2.5rem;
            animation: fadeUp .6s ease both
        }

        .res-badge {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #d1fae5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            animation: popIn .7s cubic-bezier(.36, .07, .19, .97) both .2s, float 3s ease-in-out 1s infinite
        }

        .res-badge svg {
            width: 36px;
            height: 36px;
            color: #059669
        }

        .res-hero h1 {
            font-size: 28px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: .5rem
        }

        .res-hero p {
            font-size: 15px;
            color: #64748b;
            line-height: 1.6
        }

        .res-hero strong {
            color: #0f172a
        }

        /* Score cards */
        .res-score-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 2rem
        }

        .res-score-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: fadeUp .6s ease both
        }

        .res-score-card.is-pre {
            border: 1.5px solid #93c5fd
        }

        .res-score-card.is-post {
            border: 1.5px solid #6ee7b7
        }

        .res-score-card .res-accent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px
        }

        .res-score-card.is-pre .res-accent {
            background: #3b82f6
        }

        .res-score-card.is-post .res-accent {
            background: #10b981
        }

        .res-score-card .res-shim {
            position: absolute;
            inset: 0;
            overflow: hidden;
            border-radius: inherit;
            pointer-events: none
        }

        .res-score-card .res-shim::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 60%;
            height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .25), transparent);
            animation: shimmer 2.5s ease-in-out 1.2s infinite
        }

        .res-sc-eyebrow {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-bottom: .5rem
        }

        .is-pre .res-sc-eyebrow {
            color: #3b82f6
        }

        .is-post .res-sc-eyebrow {
            color: #10b981
        }

        .res-sc-title {
            font-size: 14px;
            color: #64748b;
            margin-bottom: .75rem
        }

        .res-sc-num {
            font-size: 52px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: .5rem
        }

        .is-pre .res-sc-num {
            color: #1e40af
        }

        .is-post .res-sc-num {
            color: #065f46
        }

        .res-sc-sub {
            font-size: 13px;
            color: #94a3b8
        }

        /* Analytics stats */
        .res-section-label {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-bottom: .875rem;
            animation: fadeUp .5s ease both .3s;
            opacity: 0;
            animation-fill-mode: forwards
        }

        .res-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 2.5rem
        }

        .res-stat {
            background: #f8fafc;
            border-radius: 14px;
            padding: 1rem .75rem;
            text-align: center;
            animation: fadeUp .5s ease both;
            transition: transform .2s
        }

        .res-stat:hover {
            transform: translateY(-3px)
        }

        .res-stat:nth-child(1) {
            animation-delay: .28s
        }

        .res-stat:nth-child(2) {
            animation-delay: .35s
        }

        .res-stat:nth-child(3) {
            animation-delay: .42s
        }

        .res-stat:nth-child(4) {
            animation-delay: .49s
        }

        .res-stat-label {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: .5rem
        }

        .res-stat-val {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a
        }

        .res-stat-unit {
            font-size: 11px;
            color: #94a3b8;
            margin-left: 2px;
            font-weight: 400
        }

        /* N-Gain block */
        .res-ngain {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            animation: fadeUp .6s ease both .5s;
            opacity: 0;
            animation-fill-mode: forwards
        }

        .res-ngain-inner {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap
        }

        .res-ngain-tag {
            display: inline-block;
            font-size: 11px;
            color: #1d4ed8;
            background: #dbeafe;
            border: 1px solid #bfdbfe;
            padding: 4px 10px;
            border-radius: 8px;
            margin-bottom: .75rem;
            letter-spacing: .08em;
            font-weight: 600
        }

        .res-ngain-title {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: .4rem
        }

        .res-ngain-desc {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
            max-width: 320px
        }

        .res-ngain-scorebox {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 16px;
            padding: 1.5rem 2rem;
            text-align: center;
            min-width: 160px;
            flex-shrink: 0
        }

        .res-ngain-num {
            font-size: 48px;
            font-weight: 700;
            color: #065f46;
            margin-bottom: .25rem
        }

        .res-ngain-cat {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .1em
        }

        .res-ngain-cat span {
            color: #0f172a;
            font-weight: 600
        }

        /* Progress bar */
        .res-prog-wrap {
            margin-top: 1.25rem
        }

        .res-prog-track {
            height: 6px;
            background: #e2e8f0;
            border-radius: 99px;
            overflow: hidden;
            margin-bottom: 6px
        }

        .res-prog-fill {
            height: 100%;
            border-radius: 99px;
            width: 0;
            transition: width 1.2s cubic-bezier(.22, 1, .36, 1) 1s
        }

        .res-prog-labels {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #94a3b8
        }

        /* Toggle detail */
        .res-toggle-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 auto 1.5rem;
            background: none;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 20px;
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
            transition: color .2s, border-color .2s
        }

        .res-toggle-btn:hover {
            color: #0f172a;
            border-color: #cbd5e1
        }

        .res-toggle-btn svg {
            transition: transform .3s
        }

        .res-toggle-btn.open svg {
            transform: rotate(180deg)
        }

        /* Detail panel */
        .res-detail {
            display: none;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 1.75rem;
            margin-bottom: 2rem
        }

        .res-detail.open {
            display: block;
            animation: fadeUp .3s ease
        }

        .res-detail-heading {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: .75rem;
            margin-bottom: 1.25rem
        }

        .res-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem
        }

        .res-sub-label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: .75rem
        }

        .res-formula {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1rem;
            font-family: monospace;
            font-size: 13px;
            color: #475569;
            line-height: 2
        }

        .res-formula-hdr {
            font-size: 11px;
            color: #94a3b8;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: .5rem;
            margin-bottom: .75rem;
            font-family: system-ui
        }

        .res-formula-result {
            font-size: 20px;
            font-weight: 700;
            color: #059669
        }

        .res-matrix-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 8px;
            opacity: .35;
            transition: opacity .2s
        }

        .res-matrix-row.active {
            opacity: 1;
            border-color: #6ee7b7;
            background: #f0fdf4
        }

        .res-matrix-row-label {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a
        }

        .res-matrix-row-range {
            font-size: 12px;
            color: #64748b
        }

        /* Export */
        .res-export {
            border-top: 1px solid #f1f5f9;
            padding-top: 1.75rem;
            margin-bottom: 2rem;
            animation: fadeUp .5s ease both .7s;
            opacity: 0;
            animation-fill-mode: forwards
        }

        .res-export-title {
            text-align: center;
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .12em;
            margin-bottom: 1rem
        }

        .res-export-btns {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center
        }

        .res-export-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid;
            transition: transform .2s, opacity .2s;
            position: relative;
            overflow: hidden
        }

        .res-export-btn:hover {
            transform: translateY(-2px);
            opacity: .85
        }

        .res-export-btn:active::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, .35);
            width: 100%;
            padding-top: 100%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: ripple .5s linear
        }

        .res-export-btn.pre {
            color: #1d4ed8;
            border-color: #93c5fd;
            background: #dbeafe
        }

        .res-export-btn.quiz {
            color: #92400e;
            border-color: #fcd34d;
            background: #fef3c7
        }

        .res-export-btn.post {
            color: #065f46;
            border-color: #6ee7b7;
            background: #d1fae5
        }

        .res-export-btn svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0
        }

        /* CTA */
        .res-cta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeUp .5s ease both .8s;
            opacity: 0;
            animation-fill-mode: forwards
        }

        .res-cta-sec {
            flex: 1;
            min-width: 160px;
            padding: 12px 24px;
            background: none;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: background .2s, color .2s;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center
        }

        .res-cta-sec:hover {
            background: #f8fafc;
            color: #0f172a
        }

        .res-cta-pri {
            flex: 1;
            min-width: 160px;
            padding: 12px 24px;
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            color: #065f46;
            cursor: pointer;
            transition: transform .2s, opacity .2s;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center
        }

        .res-cta-pri:hover {
            transform: translateY(-2px);
            opacity: .85
        }

        /* Pending N-Gain */
        .res-pending {
            background: #f8fafc;
            border: 2px dashed #e2e8f0;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeUp .6s ease both .5s;
            opacity: 0;
            animation-fill-mode: forwards
        }

        .res-pending h3 {
            font-size: 16px;
            font-weight: 600;
            color: #475569;
            margin-bottom: .5rem
        }

        .res-pending p {
            font-size: 13px;
            color: #94a3b8;
            max-width: 360px;
            margin: 0 auto
        }
    </style>

    <div class="res-wrap">

        {{-- HERO --}}
        <div class="res-hero">
            <div class="res-badge">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1>Congratulations!</h1>
            <p>You have successfully completed <strong>{{ $currentTest->title }}</strong>.</p>
        </div>

        {{-- SCORE CARDS --}}
        <div class="res-score-grid">
            <div class="res-score-card {{ strtolower($currentTest->type) === 'pretest' ? 'is-pre' : '' }}"
                style="animation-delay:.1s">
                <div class="res-accent"></div>
                <div class="res-shim"></div>
                <div class="res-sc-eyebrow">Initial Knowledge</div>
                <div class="res-sc-title">Pre-test score</div>
                <div class="res-sc-num" data-count-to="{{ $preTestResultId ? number_format($preTestScore, 0) : 0 }}"
                    id="pre-score-num">
                    {{ $preTestResultId ? '0' : '-' }}
                </div>
                @if (strtolower($currentTest->type) === 'pretest')
                    <div class="res-sc-sub">{{ $testQuestionsCorrect }} of {{ $testQuestionsTotal }} correct</div>
                @else
                    <div class="res-sc-sub">{{ $preTestResultId ? 'Completed' : 'Not taken' }}</div>
                @endif
            </div>

            <div class="res-score-card is-post {{ strtolower($currentTest->type) === 'posttest' ? '' : '' }}"
                style="animation-delay:.2s">
                <div class="res-accent"></div>
                <div class="res-shim"></div>
                <div class="res-sc-eyebrow">Final Assessment</div>
                <div class="res-sc-title">Post-test score</div>
                <div class="res-sc-num" data-count-to="{{ $postTestResultId ? number_format($postTestScore, 0) : 0 }}"
                    id="post-score-num">
                    {{ $postTestResultId ? '0' : '-' }}
                </div>
                @if (strtolower($currentTest->type) === 'posttest')
                    <div class="res-sc-sub">{{ $testQuestionsCorrect }} of {{ $testQuestionsTotal }} correct</div>
                @else
                    <div class="res-sc-sub">{{ $postTestResultId ? 'Completed' : 'Pending' }}</div>
                @endif
            </div>
        </div>

        {{-- ANALYTICS --}}
        <p class="res-section-label">Reading &amp; module analytics</p>
        <div class="res-stat-grid">
            <div class="res-stat">
                <div class="res-stat-label">Reading speed</div>
                <div class="res-stat-val" data-count-to="{{ $readingWpm }}" id="stat-wpm">0<span
                        class="res-stat-unit">wpm</span></div>
            </div>
            <div class="res-stat">
                <div class="res-stat-label">Time spent</div>
                <div class="res-stat-val" data-count-to="{{ floor($readingTime / 60) }}" id="stat-time">0<span
                        class="res-stat-unit">m</span></div>
            </div>
            <div class="res-stat">
                <div class="res-stat-label">Total words</div>
                <div class="res-stat-val" data-count-to="{{ $readingWords }}" id="stat-words">0</div>
            </div>
            <div class="res-stat">
                <div class="res-stat-label">In-module quiz</div>
                <div class="res-stat-val">{{ $moduleQuizCorrect }}<span
                        class="res-stat-unit">/{{ $moduleQuizTotal }}</span></div>
            </div>
        </div>

        {{-- N-GAIN --}}
        @if ($preTestResultId && $postTestResultId)
            @php
                $ngainPct = min(max($nGainScore, 0), 1) * 100;
                $progressColor = match (true) {
                    $nGainCategory === 'Tinggi (High)' => '#10b981',
                    $nGainCategory === 'Sedang (Medium)' => '#f59e0b',
                    $nGainCategory === 'Rendah (Low)' => '#f97316',
                    default => '#6b7280',
                };
                $scoreDisplay = $nGainCategory === 'Maksimal (Perfect)' ? 'Perfect' : number_format($nGainScore, 2);
            @endphp

            <div class="res-ngain">
                <div class="res-ngain-inner">
                    <div>
                        <div class="res-ngain-tag">Learning Effectiveness</div>
                        <div class="res-ngain-title">Normalized gain (N-Gain)</div>
                        <div class="res-ngain-desc">Calculates actual improvement relative to maximum possible
                            improvement.</div>
                        <div class="res-prog-wrap">
                            <div class="res-prog-track">
                                <div class="res-prog-fill" id="ngain-bar"
                                    style="background:{{ $progressColor }};--bar-w:{{ $ngainPct }}%;"></div>
                            </div>
                            <div class="res-prog-labels">
                                <span>0</span><span>0.30</span><span>0.70</span><span>1.0</span></div>
                        </div>
                    </div>
                    <div class="res-ngain-scorebox">
                        <div class="res-ngain-num" id="ngain-display" data-ngain="{{ $nGainScore }}">
                            @if ($nGainCategory === 'Maksimal (Perfect)')
                                ✓
                            @else
                                0
                            @endif
                        </div>
                        <div class="res-ngain-cat">Category: <span>{{ $nGainCategory }}</span></div>
                    </div>
                </div>
            </div>

            {{-- Toggle detail --}}
            <button class="res-toggle-btn" id="res-toggle-btn" onclick="resToggleDetail()">
                <span id="res-toggle-label">View detailed analytics matrix</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div class="res-detail" id="res-detail-panel">
                <div class="res-detail-heading">Research analytics details</div>
                <div class="res-detail-grid">
                    <div>
                        <div class="res-sub-label">1. N-Gain calculation</div>
                        <div class="res-formula">
                            <div class="res-formula-hdr">Formula: (Post &minus; Pre) / (100 &minus; Pre)</div>
                            @if ($nGainCategory === 'Maksimal (Perfect)')
                                <div
                                    style="color:#059669;background:#f0fdf4;padding:.75rem;border-radius:8px;border:1px solid #bbf7d0">
                                    Perfect score maintained.</div>
                            @elseif($preTestScore == 100 && $postTestScore < 100)
                                <div
                                    style="color:#dc2626;background:#fef2f2;padding:.75rem;border-radius:8px;border:1px solid #fecaca">
                                    Invalid formula: result is a decrease.</div>
                            @else
                                = ({{ number_format($postTestScore, 0) }} &minus; {{ number_format($preTestScore, 0) }})
                                / (100 &minus; {{ number_format($preTestScore, 0) }})<br>
                                = {{ $gainActual }} / {{ $gainMax }}<br>
                                = <span class="res-formula-result">{{ number_format($nGainScore, 2) }}</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="res-sub-label">2. Matrix (Hake, 1999)</div>
                        <div class="res-matrix-row {{ $nGainCategory === 'Tinggi (High)' ? 'active' : '' }}">
                            <div>
                                <div class="res-matrix-row-label">High (Tinggi)</div>
                                <div class="res-matrix-row-range">Score &ge; 0.70</div>
                            </div>
                        </div>
                        <div class="res-matrix-row {{ $nGainScore >= 0.3 && $nGainScore < 0.7 && !$isDecrease ? 'active' : '' }}"
                            style="{{ $nGainScore >= 0.3 && $nGainScore < 0.7 && !$isDecrease ? '' : 'border-color:#fcd34d;background:#fef3c7' }}">
                            <div>
                                <div class="res-matrix-row-label">Medium (Sedang)</div>
                                <div class="res-matrix-row-range">0.30 &le; Score &lt; 0.70</div>
                            </div>
                        </div>
                        <div
                            class="res-matrix-row {{ $nGainScore > 0 && $nGainScore < 0.3 && !$isDecrease ? 'active' : '' }}">
                            <div>
                                <div class="res-matrix-row-label">Low (Rendah)</div>
                                <div class="res-matrix-row-range">0 &lt; Score &lt; 0.30</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="res-pending">
                <h3>N-Gain analysis pending</h3>
                <p>Complete both the Pre-Test and Post-Test to unlock your learning effectiveness matrix.</p>
            </div>
        @endif

        {{-- EXPORT --}}
        <div class="res-export">
            <div class="res-export-title">Export reports (PDF)</div>
            <div class="res-export-btns">
                @if ($preTestResultId)
                    <button wire:click="downloadPreTest" class="res-export-btn pre">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Pre-test
                    </button>
                @endif
                @if ($quizResultId)
                    <button wire:click="downloadQuiz" class="res-export-btn quiz">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Quiz
                    </button>
                @endif
                @if ($postTestResultId)
                    <button wire:click="downloadPostTest" class="res-export-btn post">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Post-test
                    </button>
                @endif
                @if (!$preTestResultId && !$quizResultId && !$postTestResultId)
                    <p style="font-size:13px;color:#94a3b8">No reports available to download yet.</p>
                @endif
            </div>
        </div>

        {{-- CTA --}}
        <div class="res-cta">
            <a href="{{ route('dashboard') }}" class="res-cta-sec">Return to dashboard</a>
            <a href="{{ route('modules.student.index') }}" class="res-cta-pri">Explore more modules &rarr;</a>
        </div>

    </div>

    <script>
        (function() {
            function animCount(el, target, duration, renderFn) {
                if (!el || isNaN(target)) return;
                const start = performance.now();
                const update = now => {
                    const p = Math.min((now - start) / duration, 1);
                    const ease = 1 - Math.pow(1 - p, 3);
                    renderFn(el, Math.round(ease * target));
                    if (p < 1) requestAnimationFrame(update);
                };
                requestAnimationFrame(update);
            }

            window.addEventListener('load', function() {
                // Score numbers
                const preEl = document.getElementById('pre-score-num');
                const postEl = document.getElementById('post-score-num');
                if (preEl && preEl.dataset.countTo) setTimeout(() => animCount(preEl, +preEl.dataset.countTo,
                    900, (el, v) => el.textContent = v), 400);
                if (postEl && postEl.dataset.countTo) setTimeout(() => animCount(postEl, +postEl.dataset
                    .countTo, 900, (el, v) => el.textContent = v), 600);

                // Stats
                const wpmEl = document.getElementById('stat-wpm');
                const timeEl = document.getElementById('stat-time');
                const wordsEl = document.getElementById('stat-words');
                if (wpmEl) setTimeout(() => animCount(wpmEl, +wpmEl.dataset.countTo, 800, (el, v) => el
                    .innerHTML = v + '<span class="res-stat-unit">wpm</span>'), 500);
                if (timeEl) setTimeout(() => animCount(timeEl, +timeEl.dataset.countTo, 700, (el, v) => el
                    .innerHTML = v + '<span class="res-stat-unit">m</span>'), 600);
                if (wordsEl) setTimeout(() => animCount(wordsEl, +wordsEl.dataset.countTo, 800, (el, v) => el
                    .textContent = v.toLocaleString()), 700);

                // N-Gain
                const ngainEl = document.getElementById('ngain-display');
                const barEl = document.getElementById('ngain-bar');
                if (ngainEl && ngainEl.dataset.ngain) {
                    const target = parseFloat(ngainEl.dataset.ngain);
                    const startTime = performance.now();
                    setTimeout(() => {
                        const run = now => {
                            const p = Math.min((now - startTime - 800) / 1100, 1);
                            const ease = 1 - Math.pow(1 - Math.max(p, 0), 3);
                            ngainEl.textContent = (ease * target).toFixed(2);
                            if (p < 1) requestAnimationFrame(run);
                            else ngainEl.textContent = target.toFixed(2);
                        };
                        requestAnimationFrame(run);
                    }, 800);
                }
                if (barEl) {
                    setTimeout(() => {
                        barEl.style.width = barEl.style.getPropertyValue('--bar-w') || '0%';
                    }, 900);
                }
            });

            window.resToggleDetail = function() {
                const panel = document.getElementById('res-detail-panel');
                const btn = document.getElementById('res-toggle-btn');
                const lbl = document.getElementById('res-toggle-label');
                if (!panel) return;
                panel.classList.toggle('open');
                btn.classList.toggle('open');
                lbl.textContent = panel.classList.contains('open') ? 'Hide detailed analytics' :
                    'View detailed analytics matrix';
            };
        })();
    </script>
