<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Статистика ссылки</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.link-generator') }}">Генератор</a></li>
                            <li class="breadcrumb-item active">Статистика</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-soft-primary">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Отчет</h5>
                                    <p>{{ $link->source }}</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light text-primary font-size-20">
                                        <i class="bx bx-stats"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-15 text-truncate">ID: {{ $link->id }}</h5>
                                <p class="text-muted mb-0 text-truncate">Создано:
                                    {{ $link->created_at->format('d.m.Y') }}
                                </p>
                            </div>

                            <div class="col-sm-6">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="font-size-15">{{ $link->click_count }}</h5>
                                            <p class="text-muted mb-0">Кликов</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('admin.link-generator') }}"
                                            class="btn btn-primary waves-effect waves-light btn-sm">Назад <i
                                                class="mdi mdi-arrow-right ml-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Детали</h4>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Целевая страница :</th>
                                        <td><a href="{{ $link->target_url }}" target="_blank"
                                                class="text-truncate d-block"
                                                style="max-width: 200px;">{{ $link->target_url }}</a></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Всего заработано :</th>
                                        <td>${{ number_format($link->total_earnings, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Выплачено :</th>
                                        <td>${{ number_format($link->total_paid, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Баланс :</th>
                                        <td
                                            class="{{ $link->balance > 0 ? 'text-success font-weight-bold' : 'text-muted' }}">
                                            ${{ number_format($link->balance, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">История переходов</h4>
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Дата/Время</th>
                                        <th>IP Адрес</th>
                                        <th>Устройство / Браузер</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clicks as $click)
                                        <tr>
                                            <td>
                                                {{ $click->created_at->format('d.m.Y H:i:s') }}
                                            </td>
                                            <td>{{ $click->ip_address }}</td>
                                            <td>
                                                {{ $this->parseUserAgent($click->user_agent) }}
                                                <small class="d-block text-muted text-truncate" style="max-width: 300px;"
                                                    title="{{ $click->user_agent }}">
                                                    {{ $click->user_agent }}
                                                </small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">Переходов пока нет</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $clicks->links() }}
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">История заказов (Bookings)</h4>
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Клиент</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th>Дата</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($link->bookings()->latest()->get() as $booking)
                                        <tr>
                                            <td><a href="{{ route('bookings.edit', $booking->id) }}"
                                                    class="text-body font-weight-bold">#{{ $booking->id }}</a></td>
                                            <td>
                                                {{ $booking->customer->name ?? 'Гость' }}
                                                <small
                                                    class="d-block text-muted">{{ $booking->customer->email ?? '' }}</small>
                                            </td>
                                            <td>
                                                ${{ number_format($booking->total_price_cents / 100, 2) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-pill badge-soft-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'warning') }} font-size-12">
                                                    {{ $booking->status }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $booking->created_at->format('d.m.Y H:i') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Заказов пока нет
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>