<div class="py-2 position-relative" style="overflow: hidden;" wire:poll.10s="loadNotifications">
    @if(count($users->unreadNotifications) > 0)
        <div class="marquee-wrapper w-100 bg-dark">
            <div class="marquee-text text-white d-flex">
                <span class="badge bg-blue">{{ count($users->notifications)}}</span>
                @foreach ($users->unreadNotifications as $notification)
                    <span class="mx-5">
                        🔔 <strong>{{ $notification->data['message'] ?? 'Nouveau rappel' }}</strong> – 
                        Client: {{ $notification->data['client'] ?? 'N/A' }} – 
                        Date: {{ $notification->data['date'] ?? 'N/A' }} – 
                        <small>Reçu: {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}</small>
                        @if (isset($notification->data['suivi_id']))
                            <a href="{{ route('suivi.show', $notification->data['suivi_id']) }}" class="text-warning mx-2" wire:click="markAsReadAndDismiss('{{ $notification['id'] }}')">[Voir le suivi]</a>
                        @endif
                        <button wire:click="markAsReadAndDismiss('{{ $notification['id'] }}')" class="btn btn-sm btn-outline-light ms-2">×</button>
                    </span>
                @endforeach
            </div>
        </div>
    @endif
</div>
