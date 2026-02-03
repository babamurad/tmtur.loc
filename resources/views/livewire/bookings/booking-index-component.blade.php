<div class="page-content">
    <div class="container-fluid">

        {{-- 1. Заголовок + кнопка «Создать» --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Бронирования</h4>

                    <a href="{{ route('bookings.create') }}" class="btn btn-success waves-effect waves-light">
                        <i class="fas fa-plus-circle font-size-16 align-middle mr-1"></i>
                        Создать
                    </a>
                </div>
            </div>
        </div>

        {{-- 2. Панель «поиск + таблица» --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- 2.1 Поисковая строка --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                                        placeholder="Поиск по ID, клиенту или email...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="dropdown" wire:ignore.self>
                                            <button class="btn btn-secondary btn-sm dropdown-toggle mr-1" type="button"
                                                id="columnsDropdown" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fas fa-columns"></i> Колонки
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="columnsDropdown"
                                                style="max-height: 300px; overflow-y: auto;"
                                                onclick="event.stopPropagation()" wire:ignore.self>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" wire:model.live="visibleColumns.id"> ID
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox"
                                                            wire:model.live="visibleColumns.customer">
                                                        Клиент
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" wire:model.live="visibleColumns.tour">
                                                        Тур
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox"
                                                            wire:model.live="visibleColumns.created_at">
                                                        Создано
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" wire:model.live="visibleColumns.amount">
                                                        Сумма
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" wire:model.live="visibleColumns.status">
                                                        Статус
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" wire:model.live="visibleColumns.source">
                                                        Источник
                                                    </label>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox"
                                                            wire:model.live="visibleColumns.people_count">
                                                        Человек
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox"
                                                            wire:model.live="visibleColumns.starts_at">
                                                        Дата начала
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox"
                                                            wire:model.live="visibleColumns.accommodation">
                                                        Проживание
                                                    </label>
                                                </li>
                                                <li>
                                                    <label class="dropdown-item">
                                                        <input type="checkbox" wire:model.live="visibleColumns.notes">
                                                        Заметки
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>

                                        <span class="text-muted small">Показать</span>
                                        <select class="form-select form-select-sm mx-2" wire:model.live="perPage"
                                            style="width: auto;">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        <span class="text-muted small">из {{ $bookings->total() }} результатов</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2.2 Таблица --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        @if($visibleColumns['id'])
                                        <th>ID</th> @endif
                                        @if($visibleColumns['customer'])
                                        <th>Клиент</th> @endif
                                        @if($visibleColumns['tour'])
                                        <th>Тур</th> @endif
                                        @if($visibleColumns['created_at'])
                                        <th>Создано</th> @endif
                                        @if($visibleColumns['amount'])
                                        <th>Сумма</th> @endif
                                        @if($visibleColumns['people_count'])
                                        <th>Чел.</th> @endif
                                        @if($visibleColumns['starts_at'])
                                        <th>Начало</th> @endif
                                        @if($visibleColumns['accommodation'])
                                        <th>Жилье</th> @endif
                                        @if($visibleColumns['notes'])
                                        <th>Инфо</th> @endif
                                        @if($visibleColumns['status'])
                                        <th>Статус</th> @endif
                                        @if($visibleColumns['source'])
                                        <th>Источник</th> @endif
                                        <th class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            @if($visibleColumns['id'])
                                                <td>#{{ $booking->id }}</td>
                                            @endif
                                            @if($visibleColumns['customer'])
                                                <td>
                                                    @if($booking->customer)
                                                        <h6 class="mb-0">{{ $booking->customer->full_name }}</h6>
                                                        <small class="text-muted">{{ $booking->customer->email }}</small>
                                                    @else
                                                        <span class="text-muted">Гость / Не указан</span>
                                                    @endif
                                                </td>
                                            @endif
                                            @if($visibleColumns['tour'])
                                                <td>
                                                    @if($booking->tourGroup && $booking->tourGroup->tour)
                                                        {{ $booking->tourGroup->tour->title }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endif
                                            @if($visibleColumns['created_at'])
                                                <td>
                                                    {{ $booking->created_at->format('d.m.Y H:i') }}
                                                </td>
                                            @endif
                                            @if($visibleColumns['amount'])
                                                <td>${{ number_format($booking->total_price_cents / 100, 2) }}</td>
                                            @endif
                                            @if($visibleColumns['people_count'])
                                                <td class="text-center">{{ $booking->people_count }}</td>
                                            @endif
                                            @if($visibleColumns['starts_at'])
                                                <td>
                                                    @if($booking->tourGroup && $booking->tourGroup->starts_at)
                                                        {{ $booking->tourGroup->starts_at->format('d.m.Y') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endif
                                            @if($visibleColumns['accommodation'])
                                                <td>
                                                    @if($booking->accommodation_type)
                                                        <span
                                                            class="badge badge-soft-primary font-size-12">{{ ucfirst($booking->accommodation_type) }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endif
                                            @if($visibleColumns['notes'])
                                                <td>
                                                    @if($booking->notes)
                                                        <i class="fas fa-comment-alt text-warning" data-toggle="tooltip"
                                                            title="{{ $booking->notes }}"></i>
                                                    @endif
                                                </td>
                                            @endif
                                            @if($visibleColumns['status'])
                                                <td>
                                                    <span
                                                        class="badge badge-pill badge-{{ $booking->status === 'paid' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning') }} font-size-12">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                            @endif
                                            @if($visibleColumns['source'])
                                                <td>
                                                    @if($booking->referer)
                                                        <span
                                                            class="badge badge-soft-info font-size-12">{{ $booking->referer }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                <a href="{{ route('bookings.edit', $booking->id) }}"
                                                    class="btn btn-sm btn-outline-primary waves-effect waves-light"
                                                    data-toggle="tooltip" title="Редактировать">
                                                    <i class="fas fa-edit font-size-14"></i>
                                                </a>

                                                @if($booking->status !== 'cancelled')
                                                    <button type="button" wire:click="cancelBooking({{ $booking->id }})"
                                                        wire:confirm="Вы уверены, что хотите отменить это бронирование?"
                                                        class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                        title="Отменить">
                                                        <i class="fas fa-times font-size-14"></i>
                                                    </button>
                                                @endif

                                                @if($booking->customer && $booking->customer->email)
                                                    @php
                                                        $isBlocked = in_array($booking->customer->email, $blockedEmails ?? []);
                                                    @endphp

                                                    @if($isBlocked)
                                                        <button type="button"
                                                            wire:click="unblockUser('{{ $booking->customer->email }}')"
                                                            wire:confirm="Разблокировать пользователя {{ $booking->customer->email }}?"
                                                            class="btn btn-sm btn-outline-warning waves-effect waves-light"
                                                            title="Разблокировать">
                                                            <i class="fas fa-unlock font-size-14"></i>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            wire:click="blockUser('{{ $booking->customer->email }}')"
                                                            wire:confirm="Заблокировать пользователя {{ $booking->customer->email }}? Он больше не сможет делать заказы."
                                                            class="btn btn-sm btn-outline-dark waves-effect waves-light"
                                                            title="Заблокировать">
                                                            <i class="fas fa-ban font-size-14"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                                <button type="button" wire:click="deleteBooking({{ $booking->id }})"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    title="Удалить">
                                                    <i class="fas fa-trash font-size-14"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count(array_filter($visibleColumns)) + 1 }}"
                                                class="text-center text-muted py-4">
                                                Бронирований не найдено.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- 2.3 Пагинация --}}
                        @if($bookings->hasPages())
                            <div class="pt-3">
                                {{ $bookings->links() }}
                            </div>
                        @endif

                    </div>{{-- /.card-body --}}
                </div>{{-- /.card --}}
            </div>{{-- /.col-12 --}}
        </div>{{-- /.row --}}

    </div>{{-- container-fluid --}}
</div>