<div>
  <li class="nav-item dropdown">
    <!-- Notification Bell -->
    <a class="nav-link position-relative" data-bs-toggle="dropdown" href="#">
      <i class="bi bi-bell fs-5"></i>
      <!-- Badge for unread notifications -->
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        {{ Auth::user()->unreadNotifications->count() }}
      </span>
    </a>

    <!-- Dropdown Menu -->
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow">
      <!-- Dropdown Header -->
      <span class="dropdown-header bg-light fw-bold text-center py-2">
        Notifications
      </span>
      <div class="dropdown-divider"></div>

      <!-- Notifications List -->
      @forelse ($user->unreadNotifications as $notification)
        <a href="#" class="dropdown-item d-flex align-items-start py-2" wire:click="marckReadNotification">
          <div class="me-3">
            <i class="bi bi-envelope fs-4 text-primary"></i>
          </div>
          <div class="text-wrap">
            <small class="d-block fw-bold">{{ $notification->data['message'] }}</small>
            <small class="text-muted">{{ $notification->data['titre'] }}</small>
          </div>
        </a>
        <div class="dropdown-divider"></div>
      @empty
        <!-- No notifications message -->
        <a href="#" class="dropdown-item text-center text-muted py-3">
          <i class="bi bi-inbox"></i> Aucune notification disponible
        </a>
      @endforelse
    </div>
  </li>
</div>
