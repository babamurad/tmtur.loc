<div class="page-content">
    <div class="container-fluid">
        <div class="card card-animate">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title mb-1">Подписчики рассылки</h4>
                        <p class="card-subtitle text-muted mb-0">Всего: {{ $totalSubscribers }} | Активных: {{ $activeSubscribers }}</p>
                    </div>
                    <button wire:click="exportCsv" class="btn btn-success">
                        <i class="mdi mdi-download"></i> Экспорт CSV
                    </button>
                </div>

                {{-- Фильтры --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label>Поиск по email</label>
                                    <input type="text" wire:model.debounce.300ms="search" class="form-control" placeholder="Введите email...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label>Статус</label>
                                    <select wire:model="filterStatus" class="form-control">
                                        <option value="all">Все</option>
                                        <option value="active">Активные</option>
                                        <option value="inactive">Неактивные</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Таблица подписчиков --}}
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th>Email</th>
                                    <th>Дата подписки</th>
                                    <th>IP адрес</th>
                                    <th>Статус</th>
                                    <th class="text-center">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($subscribers as $subscriber)
                                    <tr>
                                        <td>
                                            <strong>{{ $subscriber->email }}</strong>
                                        </td>
                                        <td>
                                            @if($subscriber->subscribed_at)
                                                {{ $subscriber->subscribed_at->format('d.m.Y H:i') }}
                                                <br>
                                                <small class="text-muted">{{ $subscriber->subscribed_at->diffForHumans() }}</small>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $subscriber->ip_address ?? '—' }}</span>
                                        </td>
                                        <td>
                                            @if($subscriber->is_active)
                                                <span class="badge badge-success">Активен</span>
                                            @else
                                                <span class="badge badge-secondary">Неактивен</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button 
                                                wire:click="toggleStatus({{ $subscriber->id }})" 
                                                class="btn btn-sm {{ $subscriber->is_active ? 'btn-warning' : 'btn-success' }}"
                                                title="{{ $subscriber->is_active ? 'Деактивировать' : 'Активировать' }}"
                                            >
                                                <i class="mdi mdi-{{ $subscriber->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <button 
                                                wire:click="delete({{ $subscriber->id }})" 
                                                class="btn btn-sm btn-danger"
                                                title="Удалить"
                                            >
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="mdi mdi-email-outline" style="font-size: 48px;"></i>
                                                <p class="mt-2">Подписчиков не найдено</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($subscribers->hasPages())
                            <div class="p-3">
                                {{ $subscribers->links() }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
