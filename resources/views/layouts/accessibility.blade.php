<style>
    /* Widget */
    #a11y-toggle {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        border: none;
        cursor: -webkit-grabbing;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(0,0,0,0.25);
        transition: background 0.2s, transform 0.2s;
        font-size: 22px;
    }
    #a11y-toggle:hover { background: #b7bac3; transform: scale(1.08); }
    #a11y-toggle:focus { outline: 1px solid #93c5fd; outline-offset: 2px; }

    #a11y-panel {
        position: fixed;
        bottom: 86px;
        right: 24px;
        z-index: 9998;
        width: 280px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        padding: 20px;
        display: none;
        flex-direction: column;
        gap: 18px;
        font-family: inherit;
    }
    #a11y-panel.open { display: flex; }

    /* Darkmode */
html.a11y-dark aside,
html.a11y-dark #sidebar {
    background-color: #111827 !important;
    border-color: #374151 !important;
}
html.a11y-dark #sidebar a,
html.a11y-dark #sidebar span,
html.a11y-dark #sidebar p {
    color: #d1d5db !important;
}
html.a11y-dark #sidebar a:hover {
    background-color: #1f2937 !important;
    color: #f9fafb !important;
}
html.a11y-dark #sidebar .border-gray-200 {
    border-color: #374151 !important;
}
html.a11y-dark #sidebar button:hover {
    background-color: #1f2937 !important;
    color: #f87171 !important;
}

/* Highcontrast */
html.a11y-contrast aside,
html.a11y-contrast #sidebar {
    background-color: #000 !important;
    border-color: #fff !important;
}
html.a11y-contrast #sidebar a {
    color: #fff !important;
}
html.a11y-contrast #sidebar a:hover {
    background-color: #ffff00 !important;
    color: #000 !important;
}

    .a11y-section-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9ca3af;
        margin-bottom: 6px;
    }

    /* Fontsize */
    .a11y-font-controls {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .a11y-font-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1.5px solid #e5e7eb;
        background: #f9fafb;
        cursor: pointer;
        font-weight: 700;
        font-size: 16px;
        color: #374151;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s, border-color 0.15s;
        flex-shrink: 0;
    }
    .a11y-font-btn:hover { background: #eff6ff; border-color: #3b82f6; color: #1d4ed8; }
    .a11y-font-btn:focus { outline: 2px solid #93c5fd; }
    .a11y-font-label {
        flex: 1;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }
    .a11y-font-reset {
        font-size: 11px;
        color: #6b7280;
        background: none;
        border: none;
        cursor: pointer;
        text-decoration: underline;
        padding: 0;
    }
    .a11y-font-reset:hover { color: #1d4ed8; }

    /* Switches */
    .a11y-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .a11y-toggle-label {
        font-size: 13px;
        font-weight: 500;
        color: #374151;
    }
    .a11y-switch {
        position: relative;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
    }
    .a11y-switch input { opacity: 0; width: 0; height: 0; }
    .a11y-switch-slider {
        position: absolute;
        inset: 0;
        background: #d1d5db;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .a11y-switch-slider::before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: white;
        top: 3px;
        left: 3px;
        transition: transform 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .a11y-switch input:checked + .a11y-switch-slider { background: #1d4ed8; }
    .a11y-switch input:checked + .a11y-switch-slider::before { transform: translateX(20px); }
    .a11y-switch input:focus + .a11y-switch-slider { outline: 2px solid #93c5fd; }

    /* Reset */
    .a11y-reset-all {
        width: 100%;
        padding: 8px;
        border-radius: 8px;
        border: 1.5px solid #e5e7eb;
        background: #f9fafb;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        transition: background 0.15s, color 0.15s;
    }
    .a11y-reset-all:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }

    /* Darkmode */
    html.a11y-dark {
        filter: none;
    }
    html.a11y-dark body,
    html.a11y-dark .bg-white,
    html.a11y-dark main,
    html.a11y-dark .bg-white {
        background-color: #1f2937 !important;
        color: #f9fafb !important;
    }
    html.a11y-dark .text-gray-900 { color: #f9fafb !important; }
    html.a11y-dark .text-gray-700 { color: #e5e7eb !important; }
    html.a11y-dark .text-gray-600 { color: #d1d5db !important; }
    html.a11y-dark .text-gray-500 { color: #9ca3af !important; }
    html.a11y-dark .border-gray-200,
    html.a11y-dark .border-gray-300,
    html.a11y-dark .divide-gray-100 > * { border-color: #374151 !important; }
    html.a11y-dark header,
    html.a11y-dark nav { background-color: #111827 !important; }
    html.a11y-dark input,
    html.a11y-dark select,
    html.a11y-dark textarea {
        background-color: #374151 !important;
        color: #f9fafb !important;
        border-color: #4b5563 !important;
    }
    html.a11y-dark #a11y-panel {
        background: #1f2937;
        border-color: #374151;
    }
    html.a11y-dark .a11y-section-label { color: #6b7280; }
    html.a11y-dark .a11y-toggle-label { color: #e5e7eb; }
    html.a11y-dark .a11y-font-label { color: #e5e7eb; }
    html.a11y-dark .a11y-font-btn {
        background: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }
    html.a11y-dark .a11y-reset-all {
        background: #374151;
        border-color: #4b5563;
        color: #9ca3af;
    }

    /* Contrast */
    html.a11y-contrast body { background: #000 !important; color: #fff !important; }
    html.a11y-contrast .bg-white,
    html.a11y-contrast [class*="bg-gray"] { background: #000 !important; }
    html.a11y-contrast .text-gray-900,
    html.a11y-contrast .text-gray-700,
    html.a11y-contrast .text-gray-600,
    html.a11y-contrast .text-gray-500 { color: #fff !important; }
    html.a11y-contrast a { color: #ffff00 !important; text-decoration: underline !important; }
    html.a11y-contrast button,
    html.a11y-contrast .bg-blue-600 { background: #ffff00 !important; color: #000 !important; border: 2px solid #fff !important; }
    html.a11y-contrast input,
    html.a11y-contrast select { background: #000 !important; color: #fff !important; border: 2px solid #fff !important; }
    html.a11y-contrast .border-gray-200,
    html.a11y-contrast .border-gray-300 { border-color: #fff !important; }
    html.a11y-contrast header,
    html.a11y-contrast nav { background: #000 !important; border-bottom: 2px solid #fff !important; }
    html.a11y-contrast #a11y-panel { background: #000; border: 2px solid #fff; }
    html.a11y-contrast .a11y-section-label,
    html.a11y-contrast .a11y-toggle-label,
    html.a11y-contrast .a11y-font-label { color: #fff !important; }
    html.a11y-contrast .a11y-font-btn { background: #000 !important; color: #fff !important; border: 2px solid #fff !important; }
    html.a11y-contrast #a11y-toggle { background: #ffff00 !important; color: #000 !important; }
</style>

{{-- Trigger --}}
<button id="a11y-toggle"
    aria-label="Open accessibility settings"
    aria-expanded="false"
    aria-controls="a11y-panel"
    title="Accessibility Settings">
    <i class="fa-solid fa-universal-access"></i>
</button>

{{-- UI --}}
<div id="a11y-panel" role="dialog" aria-label="Accessibility Settings" aria-hidden="true">

    {{-- Font --}}
    <div>
        <p class="a11y-section-label">Text Size</p>
        <div class="a11y-font-controls">
            <button class="a11y-font-btn" id="a11y-font-down" aria-label="Decrease text size">A−</button>
            <span class="a11y-font-label" id="a11y-font-display">100%</span>
            <button class="a11y-font-btn" id="a11y-font-up" aria-label="Increase text size">A+</button>
            <button class="a11y-font-reset" id="a11y-font-reset" aria-label="Reset text size">Reset</button>
        </div>
    </div>

    {{-- Theme --}}
    <div>
        <p class="a11y-section-label">Theme</p>
        <div class="a11y-toggle-row">
            <span class="a11y-toggle-label">🌙 Dark Mode</span>
            <label class="a11y-switch" aria-label="Toggle dark mode">
                <input type="checkbox" id="a11y-dark-toggle">
                <span class="a11y-switch-slider"></span>
            </label>
        </div>
    </div>

    {{-- Contrast --}}
    <div>
        <p class="a11y-section-label">Contrast</p>
        <div class="a11y-toggle-row">
            <span class="a11y-toggle-label">⚡ High Contrast</span>
            <label class="a11y-switch" aria-label="Toggle high contrast mode">
                <input type="checkbox" id="a11y-contrast-toggle">
                <span class="a11y-switch-slider"></span>
            </label>
        </div>
    </div>

    {{-- Clear --}}
    <button class="a11y-reset-all" id="a11y-reset-all" aria-label="Reset all accessibility settings">
        ↺ Reset All Settings
    </button>
</div>

<script>
(function () {
    const html = document.documentElement;
    const panel = document.getElementById('a11y-panel');
    const toggleBtn = document.getElementById('a11y-toggle');

    // ── Font ──
    const FONT_STEP = 10;
    const FONT_MIN = 80;
    const FONT_MAX = 150;
    let fontSize = parseInt(localStorage.getItem('a11y_font') || '100');

    function applyFont() {
        html.style.fontSize = fontSize + '%';
        document.getElementById('a11y-font-display').textContent = fontSize + '%';
        localStorage.setItem('a11y_font', fontSize);
    }

    document.getElementById('a11y-font-up').addEventListener('click', () => {
        if (fontSize < FONT_MAX) { fontSize += FONT_STEP; applyFont(); }
    });
    document.getElementById('a11y-font-down').addEventListener('click', () => {
        if (fontSize > FONT_MIN) { fontSize -= FONT_STEP; applyFont(); }
    });
    document.getElementById('a11y-font-reset').addEventListener('click', () => {
        fontSize = 100; applyFont();
    });

    // ── Darkmode ──
    const darkToggle = document.getElementById('a11y-dark-toggle');
    let isDark = localStorage.getItem('a11y_dark') === 'true';

    function applyDark(val) {
        isDark = val;
        html.classList.toggle('a11y-dark', isDark);
        darkToggle.checked = isDark;
        localStorage.setItem('a11y_dark', isDark);
        // Exclusive
        if (isDark) {
            isContrast = false;
            html.classList.remove('a11y-contrast');
            contrastToggle.checked = false;
            localStorage.setItem('a11y_contrast', false);
        }
    }

    darkToggle.addEventListener('change', () => applyDark(darkToggle.checked));

    // ── Contrast ──
    const contrastToggle = document.getElementById('a11y-contrast-toggle');
    let isContrast = localStorage.getItem('a11y_contrast') === 'true';

    function applyContrast(val) {
        isContrast = val;
        html.classList.toggle('a11y-contrast', isContrast);
        contrastToggle.checked = isContrast;
        localStorage.setItem('a11y_contrast', isContrast);
        // Exclusive
        if (isContrast) {
            isDark = false;
            html.classList.remove('a11y-dark');
            darkToggle.checked = false;
            localStorage.setItem('a11y_dark', false);
        }
    }

    contrastToggle.addEventListener('change', () => applyContrast(contrastToggle.checked));

    // ── Reset ──
    document.getElementById('a11y-reset-all').addEventListener('click', () => {
        fontSize = 100; applyFont();
        applyDark(false);
        applyContrast(false);
    });

    // ── Toggle ──
    toggleBtn.addEventListener('click', () => {
        const isOpen = panel.classList.toggle('open');
        toggleBtn.setAttribute('aria-expanded', isOpen);
        panel.setAttribute('aria-hidden', !isOpen);
        if (isOpen) panel.querySelector('button, input').focus();
    });

    // Blur
    document.addEventListener('click', (e) => {
        if (!panel.contains(e.target) && e.target !== toggleBtn) {
            panel.classList.remove('open');
            toggleBtn.setAttribute('aria-expanded', false);
            panel.setAttribute('aria-hidden', true);
        }
    });

    // Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && panel.classList.contains('open')) {
            panel.classList.remove('open');
            toggleBtn.focus();
        }
    });

    // Boot
    applyFont();
    if (isDark) applyDark(true);
    if (isContrast) applyContrast(true);
})();
</script>