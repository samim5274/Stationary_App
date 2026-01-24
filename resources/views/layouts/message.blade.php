
{{-- SUCCESS --}}
@if(session('success'))
    <div class="popup-message popup-success">
        <div class="flex items-start gap-3">
            <div class="flex-1">{{ session('success') }}</div>
            <button type="button" class="popup-close">✕</button>
        </div>
    </div>
@endif

{{-- ERROR --}}
@if(session('error'))
    <div class="popup-message popup-error">
        <div class="flex items-start gap-3">
            <div class="flex-1">{{ session('error') }}</div>
            <button type="button" class="popup-close">✕</button>
        </div>
    </div>
@endif

{{-- WARNING --}}
@if(session('warning'))
    <div class="popup-message popup-warning">
        <div class="flex items-start gap-3">
            <div class="flex-1">{{ session('warning') }}</div>
            <button type="button" class="popup-close">✕</button>
        </div>
    </div>
@endif

{{-- VALIDATION ERRORS --}}
@if($errors->any())
    <div class="popup-message popup-error">
        <div class="flex items-start gap-3">
            <div class="flex-1">
                <p class="font-semibold mb-1">Please fix the following:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="popup-close">✕</button>
        </div>
    </div>
@endif

@once
<script>
document.addEventListener("DOMContentLoaded", () => {
    const popups = document.querySelectorAll('.popup-message');

    popups.forEach((popup, index) => {
        // stack position
        popup.style.top = (80 + (index * 72)) + "px";

        // show animation
        setTimeout(() => popup.classList.add('show'), 120 + (index * 120));

        // close button
        const closeBtn = popup.querySelector('.popup-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => popup.classList.remove('show'));
        }

        // auto hide
        setTimeout(() => popup.classList.remove('show'), 4000 + (index * 300));
    });
});
</script>

<style>
/* Base popup */
.popup-message {
    position: fixed;
    right: 1.25rem;
    z-index: 9999;
    width: min(420px, calc(100vw - 2.5rem));
    padding: 0.9rem 1.1rem;
    border-radius: 0.75rem;
    box-shadow: 0 12px 30px rgba(0,0,0,.15);
    opacity: 0;
    transform: translateY(2.5rem);
    transition: all 0.45s ease;
    font-size: 0.875rem;
}
.popup-message.show {
    opacity: 1;
    transform: translateY(0);
}

/* Close button */
.popup-close {
    line-height: 1;
    padding: 0.15rem 0.35rem;
    font-weight: bold;
    opacity: .75;
    transition: opacity .2s;
}
.popup-close:hover {
    opacity: 1;
}

/* ========== LIGHT MODE ========== */
.popup-success {
    background: #22c55e; /* green-500 */
    color: #ffffff;
}
.popup-error {
    background: #ef4444; /* red-500 */
    color: #ffffff;
}
.popup-warning {
    background: #facc15; /* yellow-400 */
    color: #1f2937;      /* gray-800 */
}

/* ========== DARK MODE ========== */
.dark .popup-message {
    box-shadow: 0 12px 30px rgba(0,0,0,.6);
}

.dark .popup-success {
    background: #166534; /* green-800 */
    color: #ecfdf5;
}

.dark .popup-error {
    background: #7f1d1d; /* red-900 */
    color: #fee2e2;
}

.dark .popup-warning {
    background: #854d0e; /* yellow-900 */
    color: #fef9c3;
}
</style>
@endonce
