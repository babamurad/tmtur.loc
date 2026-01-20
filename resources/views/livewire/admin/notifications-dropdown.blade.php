<div class="dropdown d-inline-block" wire:poll.30s>
    <button type="button" class="btn header-item noti-icon waves-effect pr-4" id="page-header-notifications-dropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="mdi mdi-bell-outline"></i>
        @if($this->notifications->count() > 0)
            <span class="badge badge-danger badge-pill">{{ $this->notifications->count() }}</span>
        @endif
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0"> Уведомления </h6>
                </div>
                <div class="col-auto">
                    <a href="javascript:void(0)" wire:click="markAllAsRead" class="small font-weight-bold"> Очистить
                        все</a>
                </div>
            </div>
        </div>
        <div data-simplebar style="max-height: 230px;">
            @forelse($this->notifications as $notification)
                <a href="{{ $notification->data['link'] ?? '#' }}"
                    wire:click.prevent="markAsRead('{{ $notification->id }}')" class="text-reset notification-item">
                    <div class="media">
                        <div class="avatar-xs mr-3">
                            <span class="avatar-title bg-primary rounded-circle">
                                <i class="{{ $notification->data['icon'] ?? 'bx-bell' }}"></i>
                            </span>
                        </div>
                        <div class="media-body">
                            <h6 class="mt-0 mb-1">{{ $notification->data['title'] ?? 'Уведомление' }}</h6>
                            <p class="font-size-12 mb-1">{{ $notification->data['message'] ?? '' }}</p>
                            <p class="font-size-11 font-weight-bold mb-0 text-muted">
                                <i class="mdi mdi-clock-outline"></i> {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-3 text-center">
                    <p class="text-muted mb-0">Нет новых уведомлений</p>
                </div>
            @endforelse
        </div>
    </div>
</div>