<div class="module-reader min-h-screen w-full flex flex-col relative overflow-x-hidden"
    x-data="moduleTracker">

    {{-- ================================================== --}}
    {{-- CSS VARIABLES & THEME --}}
    {{-- ================================================== --}}
    <style>
        /* ===== THEME TOKENS ===== */
        :root {
            --bg-page:        #F7F5F0;
            --bg-surface:     #FFFFFF;
            --bg-surface-alt: #F3F1EC;
            --bg-overlay:     rgba(255,255,255,0.92);

            --text-primary:   #1A1814;
            --text-secondary: #4A4642;
            --text-muted:     #8C877F;
            --text-inverse:   #FFFFFF;

            --border-soft:    #E8E4DE;
            --border-medium:  #D4CFC8;

            --accent:         #2563EB;
            --accent-light:   #EFF6FF;
            --accent-hover:   #1D4ED8;

            --success:        #059669;
            --success-light:  #ECFDF5;
            --danger:         #DC2626;
            --danger-light:   #FEF2F2;

            --tracker-bg:     #1A1814;
            --tracker-border: rgba(255,255,255,0.08);
            --tracker-text:   #F7F5F0;
            --tracker-muted:  rgba(247,245,240,0.45);

            --tooltip-bg:     #1A1814;
            --tooltip-text:   #F7F5F0;
            --tooltip-muted:  rgba(247,245,240,0.55);
            --tooltip-accent: #60A5FA;
            --tooltip-border: rgba(255,255,255,0.06);

            --nav-bg:         rgba(247,245,240,0.96);
            --nav-border:     #E8E4DE;
            --nav-shadow:     0 1px 0 rgba(0,0,0,0.06);

            --shadow-card:    0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
            --shadow-float:   0 8px 32px rgba(0,0,0,0.16), 0 2px 8px rgba(0,0,0,0.08);

            --radius-sm:      10px;
            --radius-md:      16px;
            --radius-lg:      24px;
            --radius-xl:      32px;

            --font-serif:     'Georgia', 'Times New Roman', serif;
            --font-sans:      system-ui, -apple-system, 'Segoe UI', sans-serif;
            --font-mono:      'SF Mono', 'Fira Code', monospace;
        }

        /* ===== DARK MODE ===== */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-page:        #0F0E0C;
                --bg-surface:     #1A1814;
                --bg-surface-alt: #221F1A;
                --bg-overlay:     rgba(26,24,20,0.95);

                --text-primary:   #F0EDE8;
                --text-secondary: #B8B0A4;
                --text-muted:     #6B6560;
                --text-inverse:   #0F0E0C;

                --border-soft:    #2A2620;
                --border-medium:  #38332B;

                --accent:         #3B82F6;
                --accent-light:   #172554;
                --accent-hover:   #60A5FA;

                --success:        #10B981;
                --success-light:  #022C22;
                --danger:         #EF4444;
                --danger-light:   #2D0B0B;

                --tracker-bg:     #1A1814;
                --tracker-border: rgba(255,255,255,0.06);
                --tracker-text:   #F0EDE8;
                --tracker-muted:  rgba(240,237,232,0.40);

                --tooltip-bg:     #F0EDE8;
                --tooltip-text:   #1A1814;
                --tooltip-muted:  rgba(26,24,20,0.55);
                --tooltip-accent: #2563EB;
                --tooltip-border: rgba(0,0,0,0.08);

                --nav-bg:         rgba(15,14,12,0.96);
                --nav-border:     #2A2620;
                --nav-shadow:     0 1px 0 rgba(255,255,255,0.04);

                --shadow-card:    0 1px 3px rgba(0,0,0,0.3), 0 4px 16px rgba(0,0,0,0.2);
                --shadow-float:   0 8px 32px rgba(0,0,0,0.5), 0 2px 8px rgba(0,0,0,0.3);
            }
        }

        /* ===== FORCED DARK (via class) ===== */
        .dark {
            --bg-page:        #0F0E0C;
            --bg-surface:     #1A1814;
            --bg-surface-alt: #221F1A;
            --bg-overlay:     rgba(26,24,20,0.95);
            --text-primary:   #F0EDE8;
            --text-secondary: #B8B0A4;
            --text-muted:     #6B6560;
            --text-inverse:   #0F0E0C;
            --border-soft:    #2A2620;
            --border-medium:  #38332B;
            --accent:         #3B82F6;
            --accent-light:   #172554;
            --accent-hover:   #60A5FA;
            --success:        #10B981;
            --success-light:  #022C22;
            --danger:         #EF4444;
            --danger-light:   #2D0B0B;
            --tracker-bg:     #1A1814;
            --tracker-border: rgba(255,255,255,0.06);
            --tracker-text:   #F0EDE8;
            --tracker-muted:  rgba(240,237,232,0.40);
            --tooltip-bg:     #F0EDE8;
            --tooltip-text:   #1A1814;
            --tooltip-muted:  rgba(26,24,20,0.55);
            --tooltip-accent: #2563EB;
            --tooltip-border: rgba(0,0,0,0.08);
            --nav-bg:         rgba(15,14,12,0.96);
            --nav-border:     #2A2620;
            --nav-shadow:     0 1px 0 rgba(255,255,255,0.04);
            --shadow-card:    0 1px 3px rgba(0,0,0,0.3), 0 4px 16px rgba(0,0,0,0.2);
            --shadow-float:   0 8px 32px rgba(0,0,0,0.5), 0 2px 8px rgba(0,0,0,0.3);
        }

        /* ===== BASE ===== */
        .module-reader {
            background-color: var(--bg-page);
            color: var(--text-primary);
            font-family: var(--font-sans);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ===== NAVBAR ===== */
        .mr-nav {
            background: var(--nav-bg);
            border-bottom: 1px solid var(--nav-border);
            box-shadow: var(--nav-shadow);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .mr-nav-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: var(--bg-surface-alt);
            border: 1px solid var(--border-soft);
            color: var(--text-secondary);
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .mr-nav-back:hover {
            background: var(--border-soft);
            color: var(--text-primary);
            transform: translateX(-1px);
        }

        .mr-nav-title {
            font-weight: 800;
            font-size: 15px;
            color: var(--text-primary);
            line-height: 1.3;
            text-align: center;
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ===== PROGRESS BAR ===== */
        .mr-progress-track {
            background: var(--border-soft);
            border-radius: 99px;
            height: 4px;
            overflow: hidden;
            flex: 1;
        }

        .mr-progress-fill {
            background: var(--accent);
            height: 100%;
            border-radius: 99px;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mr-page-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--accent);
            white-space: nowrap;
        }

        /* ===== THEME TOGGLE ===== */
        .mr-theme-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--bg-surface-alt);
            border: 1px solid var(--border-soft);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .mr-theme-btn:hover {
            background: var(--border-soft);
            color: var(--text-primary);
        }

        /* ===== FLOATING TRACKER ===== */
        .mr-tracker {
            background: var(--tracker-bg);
            border: 1px solid var(--tracker-border);
            color: var(--tracker-text);
            box-shadow: var(--shadow-float);
            transition: all 0.3s ease;
        }

        .mr-tracker-label {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--tracker-muted);
        }

        .mr-tracker-value {
            font-family: var(--font-mono);
            font-weight: 900;
            font-size: 17px;
            line-height: 1;
            color: var(--tracker-text);
        }

        .mr-tracker-accent {
            color: var(--accent);
        }

        .mr-tracker-divider {
            width: 1px;
            height: 32px;
            background: var(--tracker-border);
        }

        /* ===== CONTENT SURFACE ===== */
        .mr-surface {
            background: var(--bg-surface);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
        }

        /* ===== PAGE HEADER ===== */
        .mr-page-title {
            font-family: var(--font-serif);
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            font-weight: 700;
            font-style: italic;
            color: var(--text-primary);
            line-height: 1.3;
            margin: 0 0 12px;
        }

        .mr-title-bar {
            height: 3px;
            width: 48px;
            background: var(--accent);
            border-radius: 99px;
            opacity: 0.6;
        }

        /* ===== AUDIO PLAYER ===== */
        .mr-audio-wrap {
            background: var(--bg-surface);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-md);
            padding: 6px;
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
            align-self: flex-start;
        }

        .mr-audio-play {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            border-radius: calc(var(--radius-md) - 4px);
            font-weight: 700;
            font-size: 13px;
            transition: all 0.15s ease;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .mr-audio-play.idle {
            background: var(--bg-surface-alt);
            color: var(--text-secondary);
        }

        .mr-audio-play.idle:hover {
            background: var(--accent-light);
            color: var(--accent);
        }

        .mr-audio-play.active {
            background: var(--accent-light);
            color: var(--accent);
        }

        .mr-audio-stop {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: calc(var(--radius-md) - 4px);
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            background: transparent;
            transition: all 0.15s ease;
        }

        .mr-audio-stop:hover {
            background: var(--danger-light);
            color: var(--danger);
        }

        /* ===== READING TEXT ===== */
        .mr-reading-text {
            font-family: var(--font-serif);
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            line-height: 1.85;
            color: var(--text-secondary);
            text-align: justify;
            word-break: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .mr-reading-text .vocab-word {
            color: var(--accent);
            font-weight: 700;
            border-bottom: 2px dashed;
            border-color: color-mix(in srgb, var(--accent) 40%, transparent);
            cursor: pointer;
            border-radius: 2px;
            padding: 0 2px;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .mr-reading-text .vocab-word:hover,
        .mr-reading-text .vocab-word.active {
            background: var(--accent-light);
            color: var(--accent-hover);
        }

        /* ===== QUIZ BLOCK ===== */
        .mr-quiz {
            background: var(--bg-surface);
            border: 1px solid var(--border-soft);
            border-radius: var(--radius-lg);
            padding: clamp(20px, 4vw, 32px);
            box-shadow: var(--shadow-card);
        }

        .mr-quiz-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-light);
            color: var(--accent);
            border-radius: var(--radius-sm);
            padding: 4px 10px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 14px;
        }

        .mr-quiz-question {
            font-size: clamp(1rem, 2.5vw, 1.15rem);
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.5;
            margin: 0 0 20px;
        }

        .mr-option {
            width: 100%;
            text-align: left;
            padding: 14px 16px;
            border-radius: var(--radius-md);
            border: 2px solid var(--border-soft);
            background: var(--bg-page);
            cursor: pointer;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: all 0.15s ease;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            -webkit-tap-highlight-color: transparent;
        }

        .mr-option:hover:not(:disabled) {
            border-color: var(--accent);
            background: var(--accent-light);
            color: var(--text-primary);
        }

        .mr-option:disabled { cursor: default; }

        .mr-option.opt-correct {
            border-color: var(--success);
            background: var(--success-light);
            color: var(--success);
        }

        .mr-option.opt-faded {
            border-color: var(--border-soft);
            opacity: 0.35;
        }

        .mr-option-letter {
            flex-shrink: 0;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 900;
            background: var(--bg-surface-alt);
            color: var(--text-muted);
            transition: all 0.15s ease;
        }

        .mr-option:hover:not(:disabled) .mr-option-letter {
            background: var(--accent);
            color: white;
        }

        .mr-option.opt-correct .mr-option-letter {
            background: var(--success);
            color: white;
        }

        .mr-quiz-feedback {
            margin-top: 16px;
            padding: 14px 16px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 14px;
        }

        .mr-quiz-feedback.correct {
            background: var(--success-light);
            color: var(--success);
            border: 1px solid color-mix(in srgb, var(--success) 20%, transparent);
        }

        .mr-quiz-feedback.wrong {
            background: var(--danger-light);
            color: var(--danger);
            border: 1px solid color-mix(in srgb, var(--danger) 20%, transparent);
        }

        /* ===== NAV BUTTONS ===== */
        .mr-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            white-space: nowrap;
            -webkit-tap-highlight-color: transparent;
        }

        .mr-btn:active { transform: scale(0.97); }

        .mr-btn-ghost {
            background: var(--bg-surface);
            border: 1.5px solid var(--border-medium);
            color: var(--text-secondary);
        }

        .mr-btn-ghost:hover {
            background: var(--bg-surface-alt);
            color: var(--text-primary);
        }

        .mr-btn-dark {
            background: var(--text-primary);
            color: var(--bg-page);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .mr-btn-dark:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        .mr-btn-accent {
            background: var(--accent);
            color: white;
            box-shadow: 0 4px 16px color-mix(in srgb, var(--accent) 35%, transparent);
        }

        .mr-btn-accent:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }

        /* ===== LOADING ===== */
        .mr-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 80px 0;
        }

        .mr-spinner {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 3px solid var(--border-soft);
            border-top-color: var(--accent);
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ===== VOCAB TOOLTIP ===== */
        #vocab-tooltip {
            position: fixed;
            z-index: 9999;
            width: min(320px, calc(100vw - 24px));
            background: var(--tooltip-bg);
            color: var(--tooltip-text);
            border-radius: var(--radius-md);
            box-shadow: 0 12px 40px rgba(0,0,0,0.25), 0 2px 8px rgba(0,0,0,0.12);
            border: 1px solid var(--tooltip-border);
            padding: 16px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.18s ease, transform 0.18s ease;
            transform: translateY(4px);
            /* Force legible colors — never inherit ambiguous colors */
        }

        #vocab-tooltip.visible {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        #vocab-tooltip .vt-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid var(--tooltip-border);
        }

        #vocab-tooltip .vt-badge {
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--tooltip-accent);
            /* Hard-coded fallback for safety */
        }

        #vocab-tooltip .vt-close {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            border: none;
            background: var(--tooltip-border);
            color: var(--tooltip-text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            line-height: 1;
            opacity: 0.5;
            transition: opacity 0.15s;
        }

        #vocab-tooltip .vt-close:hover { opacity: 1; }

        #vocab-tooltip .vt-word {
            font-size: 18px;
            font-weight: 800;
            color: var(--tooltip-text);
            margin-bottom: 6px;
            font-family: var(--font-serif);
            font-style: italic;
        }

        #vocab-tooltip .vt-definition {
            font-size: 13px;
            line-height: 1.6;
            color: var(--tooltip-text);
            opacity: 0.85;
            margin-bottom: 0;
        }

        #vocab-tooltip .vt-example {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--tooltip-border);
            font-size: 11px;
            color: var(--tooltip-text);
            opacity: 0.55;
            font-style: italic;
            line-height: 1.5;
        }

        #vocab-tooltip .vt-arrow {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-top: 7px solid var(--tooltip-bg);
        }

        /* ===== SCROLLBAR ===== */
        .module-reader ::-webkit-scrollbar { width: 5px; }
        .module-reader ::-webkit-scrollbar-track { background: transparent; }
        .module-reader ::-webkit-scrollbar-thumb {
            background: var(--border-medium);
            border-radius: 99px;
        }

        /* ===== EMPTY STATE ===== */
        .mr-empty {
            text-align: center;
            padding: 48px 24px;
            background: var(--bg-surface);
            border: 1px dashed var(--border-medium);
            border-radius: var(--radius-lg);
            color: var(--text-muted);
            font-weight: 600;
            font-size: 14px;
        }

        /* ===== NAV DIVIDER ===== */
        .mr-nav-divider {
            height: 1px;
            background: var(--border-soft);
            margin: 0 -4px;
        }

        /* ===== SECTION DIVIDER ===== */
        .mr-section-divider {
            height: 1px;
            background: var(--border-soft);
            margin: 40px 0;
        }
    </style>

    {{-- ================================================== --}}
    {{-- FLOATING TRACKER --}}
    {{-- ================================================== --}}
    <div class="mr-tracker fixed bottom-0 left-0 right-0 sm:bottom-5 sm:left-auto sm:right-5 sm:w-auto
                flex items-center justify-between sm:justify-start gap-5
                px-5 py-3.5 sm:px-5 sm:py-3 sm:rounded-2xl
                border-t sm:border z-50">

        {{-- Time --}}
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"
                style="background: color-mix(in srgb, var(--accent) 15%, transparent);">
                <svg class="w-4 h-4" style="color: var(--accent)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="mr-tracker-label">Time Spent</div>
                <div class="mr-tracker-value" x-text="formatTime(globalSeconds + pageSeconds)">0:00</div>
            </div>
        </div>

        <div class="mr-tracker-divider hidden sm:block"></div>

        {{-- WPM --}}
        <div class="text-right sm:text-left">
            <div class="mr-tracker-label">Est. WPM</div>
            <div class="mr-tracker-value mr-tracker-accent" x-text="calculateLiveWPM()">--</div>
        </div>

        {{-- Theme Toggle (visible on mobile tracker too) --}}
        <div class="sm:hidden">
            <button class="mr-theme-btn" @click="toggleTheme()" :title="darkMode ? 'Light mode' : 'Dark mode'"
                style="background: transparent; border-color: var(--tracker-border); color: var(--tracker-muted);">
                <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <svg x-show="darkMode" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>
        </div>
    </div>

    {{-- ================================================== --}}
    {{-- NAVBAR --}}
    {{-- ================================================== --}}
    <nav class="mr-nav sticky top-0 z-40 w-full">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">

            {{-- Top Row --}}
            <div class="flex items-center justify-between gap-3 py-3 sm:py-4">
                <a href="{{ route('dashboard') }}" class="mr-nav-back">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Dashboard</span>
                    <span class="sm:hidden">Back</span>
                </a>

                <h2 class="mr-nav-title" title="{{ $module->title ?? 'Module Reading' }}">
                    {{ $module->title ?? 'Learning Module' }}
                </h2>

                <button class="mr-theme-btn hidden sm:flex" @click="toggleTheme()"
                    :title="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>

            {{-- Progress Row --}}
            @if ($totalPages > 0)
                <div class="flex items-center gap-3 pb-3">
                    <span class="mr-page-label">{{ $currentPageIndex + 1 }} / {{ $totalPages }}</span>
                    <div class="mr-progress-track">
                        <div class="mr-progress-fill"
                            style="width: {{ (($currentPageIndex + 1) / $totalPages) * 100 }}%"></div>
                    </div>
                    <span class="mr-page-label" style="color: var(--text-muted); font-weight: 600;">
                        {{ round((($currentPageIndex + 1) / $totalPages) * 100) }}%
                    </span>
                </div>
            @endif
        </div>
    </nav>

    {{-- ================================================== --}}
    {{-- MAIN CONTENT --}}
    {{-- ================================================== --}}
    <main class="flex-1 w-full">
        <div class="w-full max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12 pb-28 sm:pb-28">

            {{-- Loading State --}}
            <div wire:loading wire:target="nextPage, prevPage" class="mr-loading">
                <div class="mr-spinner"></div>
                <p style="color: var(--text-muted); font-size: 13px; font-weight: 600;">Loading content...</p>
            </div>

            <div wire:loading.remove wire:target="nextPage, prevPage">
                @if ($currentPage)

                    {{-- PAGE HEADER --}}
                    <header class="flex flex-col sm:flex-row sm:items-start justify-between gap-5 mb-10 sm:mb-14"
                        x-data="audioPlayer">
                        <div class="flex-1 min-w-0">
                            <h1 class="mr-page-title">{{ $currentPage->title }}</h1>
                            <div class="mr-title-bar"></div>
                        </div>

                        {{-- AUDIO PLAYER --}}
                        <div x-show="hasReadableText" x-cloak class="mr-audio-wrap w-full sm:w-auto">
                            <button @click="togglePlay"
                                class="mr-audio-play flex-1 sm:flex-none"
                                :class="isPlaying ? 'active' : 'idle'">
                                <svg x-show="!isPlaying" class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd" fill-rule="evenodd" />
                                </svg>
                                <svg x-show="isPlaying" x-cloak class="w-4 h-4 shrink-0 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span x-text="isPlaying ? 'Pause' : (isPaused ? 'Resume' : 'Listen')"></span>
                            </button>

                            <button @click="stop" x-show="isPlaying || isPaused" x-cloak
                                class="mr-audio-stop" title="Stop Audio">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9 10h6v4H9z" />
                                </svg>
                            </button>
                        </div>
                    </header>

                    {{-- CONTENT BLOCKS --}}
                    <div style="display: flex; flex-direction: column; gap: 40px;">
                        @forelse($contentBlocks as $block)

                            {{-- TEXT BLOCK --}}
                            @if (in_array($block['type'], ['pbl_intro', 'reading_text', 'text']))
                                <div class="read-aloud-text mr-reading-text">
                                    {!! $this->renderHighlightedText($block['content']['text'] ?? $block['content']) !!}
                                </div>

                            {{-- QUIZ BLOCK --}}
                            @elseif($block['type'] === 'quiz')
                                <div class="mr-quiz">
                                    <div class="mr-quiz-badge">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Knowledge Check
                                    </div>

                                    <p class="mr-quiz-question">{{ $block['content']['text'] }}</p>

                                    <div style="display: flex; flex-direction: column; gap: 10px;">
                                        @foreach ($block['content']['options'] as $index => $opt)
                                            @php $status = $userAnswers[$block['id']] ?? null; @endphp
                                            <button
                                                wire:click="checkAnswer({{ $block['id'] }}, {{ $opt['is_correct'] ? 'true' : 'false' }})"
                                                @disabled(isset($userAnswers[$block['id']]))
                                                class="mr-option
                                                    {{ $status === 'correct' && $opt['is_correct'] ? 'opt-correct' : '' }}
                                                    {{ $status && !$opt['is_correct'] ? 'opt-faded' : '' }}">

                                                <span class="mr-option-letter">{{ chr(65 + $index) }}</span>
                                                <span style="padding-top: 6px; line-height: 1.5; flex: 1;">
                                                    {{ $opt['answer'] }}
                                                </span>
                                            </button>
                                        @endforeach
                                    </div>

                                    @if (isset($userAnswers[$block['id']]))
                                        <div class="mr-quiz-feedback {{ $userAnswers[$block['id']] === 'correct' ? 'correct' : 'wrong' }}">
                                            @if ($userAnswers[$block['id']] === 'correct')
                                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Correct! Well done.
                                            @else
                                                <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Not quite. Try reviewing the text above.
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif

                        @empty
                            <div class="mr-empty">Content is being prepared.</div>
                        @endforelse
                    </div>

                    {{-- SECTION DIVIDER --}}
                    <div class="mr-section-divider"></div>

                    {{-- NAVIGATION BUTTONS --}}
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;">

                        @if ($currentPageIndex > 0)
                            <button class="mr-btn mr-btn-ghost flex-1 sm:flex-none" @click="goPrev()">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if ($currentPageIndex < $totalPages - 1)
                            <button class="mr-btn mr-btn-dark flex-1 sm:flex-none" @click="goNext()">
                                Next
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @else
                            <button class="mr-btn mr-btn-accent flex-1 sm:flex-none" @click="finish()">
                                <span wire:loading.remove wire:target="finishModule" class="flex items-center gap-2">
                                    Finish Module
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="finishModule" class="flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>

    {{-- ================================================== --}}
    {{-- VOCAB TOOLTIP --}}
    {{-- ================================================== --}}
    <div id="vocab-tooltip" role="tooltip" aria-hidden="true">
        <div class="vt-header">
            <span class="vt-badge" id="vt-badge">Vocabulary</span>
            <button class="vt-close" id="vt-close-btn" aria-label="Close tooltip">✕</button>
        </div>
        <div class="vt-word" id="vt-word"></div>
        <p class="vt-definition" id="vt-definition"></p>
        <p class="vt-example" id="vt-example" style="display:none;"></p>
        <div class="vt-arrow" id="vt-arrow"></div>
    </div>

    {{-- ================================================== --}}
    {{-- SCRIPTS --}}
    {{-- ================================================== --}}
    <script>
        document.addEventListener('alpine:init', () => {

            // ===== MODULE TRACKER =====
            Alpine.data('moduleTracker', () => ({
                globalSeconds: {{ $totalSeconds ?? 0 }},
                totalWords:    {{ $totalWords ?? 0 }},
                pageSeconds:   0,
                timer:         null,
                darkMode:      false,

                init() {
                    // Detect saved or system preference
                    const saved = localStorage.getItem('mr-theme');
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.darkMode = saved ? saved === 'dark' : prefersDark;
                    this.applyTheme();

                    this.startTimer();

                    window.addEventListener('reset-timer', (e) => {
                        this.globalSeconds = e.detail[0].totalSeconds;
                        this.pageSeconds   = 0;
                    });
                },

                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('mr-theme', this.darkMode ? 'dark' : 'light');
                    this.applyTheme();
                },

                applyTheme() {
                    const el = document.querySelector('.module-reader');
                    if (this.darkMode) {
                        el.classList.add('dark');
                    } else {
                        el.classList.remove('dark');
                    }
                },

                startTimer() {
                    if (this.timer) clearInterval(this.timer);
                    this.timer = setInterval(() => { this.pageSeconds++; }, 1000);
                },

                calculateLiveWPM() {
                    const totalSec = this.globalSeconds + this.pageSeconds;
                    if (totalSec < 10 || this.totalWords === 0) return '--';
                    return Math.round((this.totalWords / totalSec) * 60);
                },

                formatTime(sec) {
                    const m = Math.floor(sec / 60);
                    const s = sec % 60;
                    return m + ':' + String(s).padStart(2, '0');
                },

                goNext()   { window.speechSynthesis.cancel(); @this.call('nextPage',     this.pageSeconds); },
                goPrev()   { window.speechSynthesis.cancel(); @this.call('prevPage',     this.pageSeconds); },
                finish()   { window.speechSynthesis.cancel(); @this.call('finishModule', this.pageSeconds); },
            }));

            // ===== AUDIO PLAYER =====
            Alpine.data('audioPlayer', () => ({
                synth:          window.speechSynthesis,
                utterance:      null,
                isPlaying:      false,
                isPaused:       false,
                hasReadableText: false,

                init() {
                    setTimeout(() => {
                        this.hasReadableText = document.querySelectorAll('.read-aloud-text').length > 0;
                    }, 150);
                    window.addEventListener('beforeunload', () => this.stop());
                    window.addEventListener('reset-timer',  () => this.stop());
                },

                togglePlay() {
                    if (this.isPlaying) {
                        this.synth.pause();
                        this.isPlaying = false;
                        this.isPaused  = true;
                    } else if (this.isPaused) {
                        this.synth.resume();
                        this.isPlaying = true;
                        this.isPaused  = false;
                    } else {
                        const els   = document.querySelectorAll('.read-aloud-text');
                        const text  = Array.from(els).map(el => el.innerText).join(' . ');
                        if (!text.trim()) return;

                        this.utterance          = new SpeechSynthesisUtterance(text);
                        this.utterance.lang     = 'en-US';
                        this.utterance.rate     = 0.9;
                        this.utterance.onend    = () => this.resetState();
                        this.utterance.onerror  = () => this.resetState();

                        this.synth.speak(this.utterance);
                        this.isPlaying = true;
                        this.isPaused  = false;
                    }
                },

                stop()       { this.synth.cancel(); this.resetState(); },
                resetState() { this.isPlaying = false; this.isPaused = false; },
            }));
        });

        // ===== LIVEWIRE EVENTS =====
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('scrollToTop', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // ===== VOCAB TOOLTIP =====
        (() => {
            const tooltip   = document.getElementById('vocab-tooltip');
            const vtBadge   = document.getElementById('vt-badge');
            const vtWord    = document.getElementById('vt-word');
            const vtDef     = document.getElementById('vt-definition');
            const vtEx      = document.getElementById('vt-example');
            const vtArrow   = document.getElementById('vt-arrow');
            const vtClose   = document.getElementById('vt-close-btn');

            let activeWord  = null;
            let arrowAbove  = true;

            function showTooltip(el) {
                const d = el.dataset;

                // Populate content
                vtBadge.textContent  = [d.level, d.category].filter(Boolean).join(' · ') || 'Vocabulary';
                vtWord.textContent   = el.textContent.trim();
                vtDef.textContent    = d.definition || '';

                if (d.example) {
                    vtEx.textContent   = 'e.g. ' + d.example;
                    vtEx.style.display = 'block';
                } else {
                    vtEx.style.display = 'none';
                }

                tooltip.setAttribute('aria-hidden', 'false');

                // Position
                positionTooltip(el);

                tooltip.classList.add('visible');
                el.classList.add('active');
                activeWord = el;
            }

            function positionTooltip(el) {
                // Reset to measure natural size
                tooltip.style.left   = '-9999px';
                tooltip.style.top    = '0';
                tooltip.style.bottom = 'auto';

                const rect    = el.getBoundingClientRect();
                const isMobile = window.innerWidth < 640;
                const tw      = tooltip.offsetWidth;
                const th      = tooltip.offsetHeight;
                const margin  = 12;
                const arrowH  = 8;

                if (isMobile) {
                    // Mobile: anchor to bottom of viewport above tracker
                    tooltip.style.left      = '50%';
                    tooltip.style.transform = 'translateX(-50%)';
                    tooltip.style.bottom    = '72px';
                    tooltip.style.top       = 'auto';
                    vtArrow.style.display   = 'none';
                } else {
                    tooltip.style.transform = 'none';
                    vtArrow.style.display   = 'block';

                    let left = rect.left + rect.width / 2 - tw / 2 + window.scrollX;
                    left     = Math.max(margin, Math.min(left, window.innerWidth - tw - margin + window.scrollX));

                    const spaceAbove = rect.top;
                    const spaceBelow = window.innerHeight - rect.bottom;

                    if (spaceAbove >= th + arrowH + margin) {
                        // Place above
                        tooltip.style.top    = (rect.top - th - arrowH - margin + window.scrollY) + 'px';
                        tooltip.style.bottom = 'auto';
                        vtArrow.style.top    = '100%';
                        vtArrow.style.bottom = 'auto';
                        vtArrow.style.borderTopColor    = getComputedStyle(document.documentElement).getPropertyValue('--tooltip-bg').trim();
                        vtArrow.style.borderBottomColor = 'transparent';
                        vtArrow.style.borderTopWidth    = '7px';
                        vtArrow.style.borderBottomWidth = '0';
                    } else {
                        // Place below
                        tooltip.style.top    = (rect.bottom + arrowH + margin + window.scrollY) + 'px';
                        tooltip.style.bottom = 'auto';
                        vtArrow.style.bottom = '100%';
                        vtArrow.style.top    = 'auto';
                        vtArrow.style.borderBottomColor = getComputedStyle(document.documentElement).getPropertyValue('--tooltip-bg').trim();
                        vtArrow.style.borderTopColor    = 'transparent';
                        vtArrow.style.borderBottomWidth = '7px';
                        vtArrow.style.borderTopWidth    = '0';
                    }

                    tooltip.style.left = left + 'px';
                }
            }

            function hideTooltip() {
                tooltip.classList.remove('visible');
                tooltip.setAttribute('aria-hidden', 'true');
                if (activeWord) {
                    activeWord.classList.remove('active');
                    activeWord = null;
                }
            }

            // Events
            document.addEventListener('click', (e) => {
                if (vtClose.contains(e.target)) { hideTooltip(); return; }
                const word = e.target.closest('.vocab-word');
                if (word) {
                    e.stopPropagation();
                    if (activeWord === word) { hideTooltip(); return; }
                    showTooltip(word);
                } else if (!tooltip.contains(e.target)) {
                    hideTooltip();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') hideTooltip();
            });

            window.addEventListener('resize', () => {
                if (activeWord) positionTooltip(activeWord);
            });

            window.addEventListener('scroll', () => {
                if (activeWord && window.innerWidth >= 640) positionTooltip(activeWord);
            }, { passive: true });
        })();
    </script>
</div>
