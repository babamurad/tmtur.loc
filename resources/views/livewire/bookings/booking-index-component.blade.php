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
                                        <th>ID</th>
                                        <th>Клиент</th>
                                        <th>Тур</th>
                                        <th>Дата начала</th> {{-- Уточнил заголовок --}}
                                        <th>Создано</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th>Источник</th>
                                        <th class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>#{{ $booking->id }}</td>
                                            <td>
                                                @if($booking->customer)
                                                    <h6 class="mb-0">{{ $booking->customer->full_name }}</h6>
                                                    <small class="text-muted">{{ $booking->customer->email }}</small>
                                                @else
                                                    <span class="text-muted">Гость / Не указан</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($booking->tourGroup && $booking->tourGroup->tour)
                                                    {{ $booking->tourGroup->tour->title }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($booking->tourGroup)
                                                    {{ optional($booking->tourGroup->start_date)->format('d.m.Y') ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{ $booking->created_at->format('d.m.Y H:i') }}
                                            </td>
                                            <td>${{ number_format($booking->total_price_cents / 100, 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-pill badge-{{ $booking->status === 'paid' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning') }} font-size-12">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($booking->referer)
                                                    <span
                                                        class="badge badge-soft-info font-size-12">{{ $booking->referer }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
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
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
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