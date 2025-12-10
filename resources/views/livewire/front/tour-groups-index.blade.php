<div>
    <div class="container mt-4 pt-2">
        <h2 class="text-center mb-4">{{ __('messages.available_dates') }}</h2>

        {{-- Фильтры по месяцу и году --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="monthFilter">{{ __('Месяц') }}</label>
                <select wire:model.live="month" id="monthFilter" class="form-control form-control-sm">
                    @foreach($months as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="yearFilter">{{ __('Год') }}</label>
                <select wire:model.live="year" id="yearFilter" class="form-control form-control-sm">
                    @foreach($years as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Список групп --}}
        <div class="row">
            @forelse($groups as $group)
                @php
                    $available = max(0, (int) $group->freePlaces());
                    $capacity  = (int) $group->max_people;
                    $booked    = max(0, $capacity - $available);
                @endphp

                <div class="col-12 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            {{-- 1-я строка: название тура --}}
                            <h6 class="mb-1">
                                <a href="{{ route('our-tours.show', $group->tour?->slug) }}">
                                    {{ $group->tour?->tr('title') ?? $group->tour?->title }}
                                </a>
                            </h6>

                            {{-- 2-я строка: дата + места | цена (прижата к правому краю) --}}
                            <div class="d-flex flex-wrap align-items-center justify-content-between small mb-2">
                                {{-- Дата и места --}}
                                <div class="d-flex align-items-center">
                                    <span class="text-nowrap text-muted mr-2">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ \Carbon\Carbon::parse($group->starts_at)->format('d.m.Y') }}
                                    </span>

                                    <span class="badge badge-info mr-1">
                                        <i class="fas fa-user-check mr-1"></i>Забронировали: {{ $booked }} из {{ $capacity }}
                                    </span>
                                    <span class="badge badge-success">
                                        <i class="fas fa-user-plus mr-1"></i>Свободных мест: {{ $available }}
                                    </span>
                                </div>

                                {{-- Цена (прижата к правому краю) --}}
                                @if($group->price_min)
                                    <div class="text-nowrap">
                                        <span class="badge badge-success text-muted">{{ __('Цена от за человека') }}</span>
                                        <span class="h6 mb-0 font-weight-bold">
                                            <i class="fas fa-money-bill-wave mr-1 text-success"></i>${{ number_format($group->price_min, 0, '.', ' ') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- 3-я строка: кнопка Заказать --}}
                            <div class="text-right">
                                <button
                                    type="button"
                                    class="btn btn-primary btn-sm rounded {{ $available <= 0 ? 'disabled' : '' }}"
                                    wire:click="openBookingModal({{ $group->id }})"
                                    @if($available <= 0) disabled @endif
                                >
                                    <i class="fas fa-ticket-alt mr-1"></i>
                                    {{ $available <= 0 ? __('Мест нет') : __('Заказать') }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    {{ __('messages.no_tour_groups_available') }}
                </div>
            @endforelse
        </div>

        {{-- Пагинация --}}
        @if($groups->hasPages())
            <div class="pt-3">
                {{ $groups->links() }}
            </div>
        @endif

        {{-- Сообщение об успехе --}}
        @if (session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
    </div>

    {{-- Модальное окно бронирования --}}
    @if($showBookingModal)
        <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('Заказ тура') }}
                            @if($selectedGroup)
                                – {{ $selectedGroup->tour?->tr('title') ?? $selectedGroup->tour?->title }}
                                @if($selectedGroup->starts_at)
                                    {{ \Carbon\Carbon::parse($selectedGroup->starts_at)->format('d.m.Y') }}
                                @endif
                            @endif
                        </h5>
                        <button type="button" class="close" aria-label="Close" wire:click="closeBookingModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form wire:submit.prevent="submitBooking">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="booking_name">Имя</label>
                                    <input type="text"
                                           id="booking_name"
                                           class="form-control @error('booking_name') is-invalid @enderror"
                                           wire:model.defer="booking_name">
                                    @error('booking_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="booking_email">Email</label>
                                    <input type="email"
                                           id="booking_email"
                                           class="form-control @error('booking_email') is-invalid @enderror"
                                           wire:model.defer="booking_email">
                                    @error('booking_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="booking_phone">Телефон (WhatsApp)</label>
                                    <input type="text"
                                           id="booking_phone"
                                           class="form-control @error('booking_phone') is-invalid @enderror"
                                           wire:model.defer="booking_phone">
                                    @error('booking_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="booking_guests">Кол-во человек</label>
                                    <input type="number"
                                           min="1"
                                           id="booking_guests"
                                           class="form-control @error('booking_guests') is-invalid @enderror"
                                           wire:model.defer="booking_guests">
                                    @error('booking_guests') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="booking_message">Комментарий</label>
                                <textarea id="booking_message"
                                          rows="3"
                                          class="form-control @error('booking_message') is-invalid @enderror"
                                          wire:model.defer="booking_message"></textarea>
                                @error('booking_message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            @error('booking_general')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeBookingModal">
                                {{ __('Отмена') }}
                            </button>
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                {{ __('Отправить') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    @endif
</div>