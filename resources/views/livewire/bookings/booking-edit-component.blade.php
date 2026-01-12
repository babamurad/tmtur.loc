<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактирование бронирования #{{ $booking_data->id }}</h4>
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary waves-effect waves-light">
                        <i class="bx bx-arrow-back mr-1"></i> Назад
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Edit Form -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Детали заказа</h4>

                        <form wire:submit.prevent="update">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Статус</label>
                                <div class="col-md-9">
                                    <select class="form-control" wire:model.live="status">
                                        <option value="pending">Pending (Ожидает)</option>
                                        <option value="confirmed">Confirmed (Подтвержден)</option>
                                        <option value="paid">Paid (Оплачен)</option>
                                        <option value="cancelled">Cancelled (Отменен)</option>
                                        <option value="completed">Completed (Завершен)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Заметки администратора</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" wire:model="notes" rows="5"></textarea>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Сумма заказа</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control"
                                        value="${{ number_format($booking_data->total_price_cents / 100, 2) }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Количество людей</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{ $booking_data->people_count }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="form-group row justify-content-end">
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-primary w-md">Сохранить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Дополнительные услуги --}}
                @if($booking_data->bookingServices->isNotEmpty())
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Выбранные дополнительные услуги</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Услуга</th>
                                            <th>Цена</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($booking_data->bookingServices as $bs)
                                            <tr>
                                                <td>{{ $bs->service->title ?? 'Удаленная услуга' }}</td>
                                                <td>
                                                    @if(isset($bs->service))
                                                        ${{ number_format($bs->service->price_cents / 100, 2) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Info Cards -->
            <div class="col-xl-4">
                <!-- Customer Info -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Информация о клиенте</h4>
                        @if($booking_data->customer)
                            <p class="mb-1"><strong>Имя:</strong> {{ $booking_data->customer->full_name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $booking_data->customer->email }}</p>
                            <p class="mb-1"><strong>Телефон:</strong> {{ $booking_data->customer->phone }}</p>
                            <p class="mb-1"><strong>Дата регистрации:</strong>
                                {{ $booking_data->customer->created_at->format('d.m.Y') }}</p>
                        @else
                            <p class="text-muted">Информация отсутствует (Гость)</p>
                        @endif
                    </div>
                </div>

                <!-- Tour Info -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Информация о туре</h4>
                        @if($booking_data->tourGroup && $booking_data->tourGroup->tour)
                            <p class="mb-1"><strong>Тур:</strong> {{ $booking_data->tourGroup->tour->title }}</p>
                            <p class="mb-1"><strong>Дата начала:</strong>
                                {{ optional($booking_data->tourGroup->start_date)->format('d.m.Y') ?? '-' }}</p>
                            <div class="mt-3">
                                @if($booking_data->tourGroup->tour->first_media_url)
                                    <img src="{{ $booking_data->tourGroup->tour->first_media_url }}" class="img-fluid rounded"
                                        alt="Tour Image">
                                @endif
                            </div>
                        @else
                            <p class="text-muted">Тур не найден</p>
                        @endif
                    </div>
                </div>

                <!-- Referer Info -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Источник перехода</h4>
                        @if($booking_data->referer)
                            <div class="alert alert-info mb-0">
                                <i class="bx bx-link mr-1"></i> {{ $booking_data->referer }}
                            </div>
                        @else
                            <p class="text-muted">Не определен</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>