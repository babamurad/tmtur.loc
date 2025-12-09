<div>
    <div class="container mt-5 pt-3">
        <h2 class="text-center mb-4">{{ __('messages.available_dates') }}</h2>

        {{-- Фильтры по месяцу и году --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="monthFilter">{{ __('Месяц') }}</label>
                <select wire:model.live="month" id="monthFilter" class="form-control">
                    @foreach($months as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="yearFilter">{{ __('Год') }}</label>
                <select wire:model.live="year" id="yearFilter" class="form-control">
                    @foreach($years as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Список групп (компактные строки, данные из TourGroup) --}}
        <div class="row">
            @forelse($groups as $group)
                @php
                    $available = max(0, (int) $group->freePlaces());
                    $capacity  = (int) $group->max_people;
                    $booked    = max(0, $capacity - $available);
                @endphp

                <div class="col-12 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column flex-md-row align-items-md-center">
                            <div class="flex-fill">
                                <div class="d-flex flex-wrap align-items-center mb-2">
                                    <h5 class="mb-0 mr-2">
                                        {{ $group->tour?->tr('title') ?? $group->tour?->title }}
                                    </h5>
                                </div>

                                <div class="text-muted small mb-2">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    @if($group->starts_at)
                                        {{ \Carbon\Carbon::parse($group->starts_at)->format('d.m.Y') }}
                                    @endif
                                </div>

                                <div class="small">
                                    <div>Забронировали: {{ $booked }} из {{ $capacity }}</div>
                                    <div>Свободных мест: {{ $available }}</div>
                                </div>
                            </div>

                            <div class="text-md-right mt-3 mt-md-0">
                                @if($group->price_min)
                                    <div class="small text-muted">
                                        {{ __('Цена от за человека') }}
                                    </div>
                                    <div class="h5 mb-2">
                                        ${{ number_format($group->price_min, 0, '.', ' ') }}
                                    </div>
                                @endif

                                <button
                                    type="button"
                                    class="btn btn-primary btn-block {{ $available <= 0 ? 'disabled' : '' }}"
                                    wire:click="openBookingModal({{ $group->id }})"
                                    @if($available <= 0) disabled @endif
                                >
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

        @if($groups->hasPages())
            <div class="pt-3">
                {{ $groups->links() }}
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
    </div>

    {{-- Модальное окно "Заказать" --}}
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

        {{-- Подложка под модальное окно --}}
        <div class="modal-backdrop fade show"></div>
    @endif
</div>
