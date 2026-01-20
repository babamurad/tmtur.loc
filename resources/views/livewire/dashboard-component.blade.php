<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Админ панель</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Админ</a></li>
                            <li class="breadcrumb-item active">Дашборд</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="avatar-sm float-right">
                            <span class="avatar-title bg-soft-primary rounded-circle">
                                <i class="bx bx-layer m-0 h3 text-primary"></i>
                            </span>
                        </div>
                        <h6 class="text-muted text-uppercase mt-0">Туры</h6>
                        <h3 class="my-3">{{ $toursCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="avatar-sm float-right">
                            <span class="avatar-title bg-soft-primary rounded-circle">
                                <i class="bx bx-dollar-circle m-0 h3 text-primary"></i>
                            </span>
                        </div>
                        <h6 class="text-muted text-uppercase mt-0">Группы</h6>
                        <h3 class="my-3">{{ $tourGroupsCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="avatar-sm float-right">
                            <span class="avatar-title bg-soft-primary rounded-circle">
                                <i class="bx bx-analyse m-0 h3 text-primary"></i>
                            </span>
                        </div>
                        <h6 class="text-muted text-uppercase mt-0">Бронирования</h6>
                        <h3 class="my-3">{{ $bookingsCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="avatar-sm float-right">
                            <span class="avatar-title bg-soft-primary rounded-circle">
                                <i class="bx bx-basket m-0 h3 text-primary"></i>
                            </span>
                        </div>
                        <h6 class="text-muted text-uppercase mt-0">Подписчики </h6>
                        <h3 class="my-3">{{ $subscribersCount }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-lg-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="dropdown float-right position-relative">
                            <a href="#" class="dropdown-toggle h4 text-muted" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" class="dropdown-item">Action</a></li>
                                <li><a href="#" class="dropdown-item">Another action</a></li>
                                <li><a href="#" class="dropdown-item">Something else here</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a href="#" class="dropdown-item">Separated link</a></li>
                            </ul>
                        </div>
                        <h4 class="card-title d-inline-block mb-3">Последние сообщения с сайта</h4>

                        <div data-simplebar="init" style="max-height: 380px;">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: -15px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper"
                                            style="height: auto; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 0px;">
                                                @forelse($recentMessages as $msg)
                                                    <a href="{{ route('admin.contact-messages-table') }}"
                                                        class="d-flex align-items-center border-bottom py-3">
                                                        <div class="mr-3">
                                                            <div
                                                                class="avatar-sm rounded-circle bg-soft-primary align-self-center text-center">
                                                                <span
                                                                    class="avatar-title rounded-circle text-primary bg-soft-primary font-size-18">
                                                                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="w-100">
                                                            <div class="d-flex justify-content-between">
                                                                <h6 class="mb-1">{{ $msg->name }}</h6>
                                                                <p class="text-muted font-size-11 mb-0">
                                                                    {{ $msg->created_at->format('d.m H:i') }}</p>
                                                            </div>
                                                            <p class="text-muted font-size-13 mb-0">
                                                                {{ Str::limit($msg->message, 40) }}</p>
                                                        </div>
                                                    </a>
                                                @empty
                                                    <p class="text-center py-3">Сообщений нет</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: auto; height: 405px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar"
                                    style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar"
                                    style="height: 356px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-lg-8">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="dropdown float-right position-relative">
                            <a href="#" class="dropdown-toggle h4 text-muted" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#" class="dropdown-item">Action</a></li>
                                <li><a href="#" class="dropdown-item">Another action</a></li>
                                <li><a href="#" class="dropdown-item">Something else here</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a href="#" class="dropdown-item">Separated link</a></li>
                            </ul>
                        </div>
                        <h4 class="card-title d-inline-block">Последние бронирования</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Тур</th>
                                        <th>Клиент</th>
                                        <th>Дата</th>
                                        <th>Цена</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBookings as $booking)
                                        <tr>
                                            <td>{{ $booking->id }}</td>
                                            <td>{{ $booking->tourGroup?->tour?->tr('title') ?? 'Тур' }}</td>
                                            <td>{{ $booking->customer->full_name ?? 'Клиент' }}</td>
                                            <td>{{ $booking->created_at->format('d.m.Y') }}</td>
                                            <td>${{ number_format($booking->total_price_cents / 100, 2) }}</td>
                                            <td>
                                                @if($booking->status == 'confirmed')
                                                    <span class="badge badge-success">Подтвержден</span>
                                                @elseif($booking->status == 'cancelled')
                                                    <span class="badge badge-danger">Отменен</span>
                                                @else
                                                    <span class="badge badge-warning">Ожидание</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Бронирований нет</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->

        </div>
        <!-- end row-->

    </div> <!-- container-fluid -->
</div>