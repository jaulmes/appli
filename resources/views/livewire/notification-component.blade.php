<div>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="bi bi-bell"></i>
        <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
            {{Auth::User()->unreadnotifications->count()}}
        </span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header"></span>
        <div class="dropdown-divider"></div>
        @forelse($user->unreadNotifications as $notification)
            <a href="#" class="dropdown-item" wire:click="marckReadNotification">
                <i class="fas fa-envelope mr-2"></i>{{$notification->data['message']}}: {{$notification->data['titre']}}
            </a>
        @empty
            <a href="#" class="dropdown-item" wire:click="marckReadNotification">
                <i class="fas fa-envelope mr-2"></i>auccune notification disponible
            </a>
        @endforelse
        </div>
    </li>
</div>
