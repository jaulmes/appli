{{-- Blade: notification-marquee.blade.php --}}
<div 
    class="notification-marquee py-2 position-relative" 
    wire:poll.visible.10s="loadNotifications"
    role="region" 
    aria-live="polite" 
    aria-label="Notifications récentes"
>
    @php $unread = $users->unreadNotifications ?? collect(); @endphp

    @if($unread->count() > 0)
        <div class="d-flex align-items-center mb-2 gap-2">
            <span class="badge bg-primary me-2" aria-hidden="true">{{ $unread->count() }}</span>
            <strong class="me-auto text-dark">Notifications</strong>

            {{-- Marquer tout comme lu --}}
            <button 
                wire:click="markAllAsRead" 
                class="btn btn-sm btn-outline-secondary"
                type="button"
                title="Marquer toutes les notifications comme lues"
            >
                Marquer tout lu
            </button>
        </div>

        <div class="marquee-wrapper bg-dark text-white rounded" tabindex="0">
            <div class="marquee-track">
                @foreach ($unread as $notification)
                    @php
                        $msg = $notification->data['message'] ?? 'Nouveau rappel';
                        $client = $notification->data['client'] ?? 'N/A';
                        $date = $notification->data['date'] ?? null;
                        $suiviId = $notification->data['suivi_id'] ?? null;
                    @endphp

                    <div class="marquee-item d-inline-flex align-items-center px-4" title="{{ strip_tags($msg) }}">
                        <span class="me-2" aria-hidden="true">🔔</span>

                        <div class="me-3">
                            <div class="fw-semibold small text-white">{{ \Illuminate\Support\Str::limit($msg, 80) }}</div>
                            <div class="small text-muted">
                                Client: {{ $client }} · 
                                Date: {{ $date ?? '—' }} · 
                                <span class="text-white-50">Reçu: {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>

                        @if($suiviId)
                            <a href="{{ route('suivi.show', $suiviId) }}" class="btn btn-sm btn-link text-warning me-2" wire:click.prevent>
                                Voir
                            </a>
                        @endif

                        <button
                            type="button"
                            class="btn btn-sm btn-outline-light ms-2"
                            wire:click="markAsReadAndDismiss('{{ $notification->id }}')"
                            aria-label="Fermer cette notification"
                            title="Ignorer / Marquer comme lu"
                        >
                            ✕
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

<style>
/* wrapper */
.marquee-wrapper {
    overflow: hidden;
    position: relative;
    height: 56px;
}

/* track: items are laid out inline and scrolled with CSS animation */
.marquee-track {
    display: inline-flex;
    align-items: center;
    gap: 1rem;
    white-space: nowrap;
    padding-left: 100%; /* start off-screen to the right */
    animation: marquee-scroll 38s linear infinite;
    will-change: transform;
}

/* single item visuals */
.marquee-item {
    display: inline-flex;
    align-items: center;
    min-width: 320px;
    background: transparent;
    border-right: 1px solid rgba(255,255,255,0.06);
}

/* pause on hover or focus for accessibility */
.marquee-wrapper:hover .marquee-track,
.marquee-wrapper:focus .marquee-track,
.marquee-wrapper:active .marquee-track {
    animation-play-state: paused;
}

/* respects system reduced motion preference */
@media (prefers-reduced-motion: reduce) {
    .marquee-track {
        animation: none;
        transform: none;
        padding-left: 0;
    }
}

/* keyframes */
@keyframes marquee-scroll {
    0%   { transform: translateX(0%); }
    100% { transform: translateX(-100%); }
}

/* responsive adjustments */
@media (max-width: 576px) {
    .marquee-item { min-width: 240px; padding: .5rem; }
    .marquee-wrapper { height: auto; padding: .25rem; }
}
</style>

</div>

