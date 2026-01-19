<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>TmTourism - Админ и Дашборд</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- @vite(['resources/js/app.js', 'resources/css/app.css']) -->

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" />


    @livewireStyles

    @stack('quill-css')
    @stack('scripts')
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <div class="navbar-brand-box">
                    <a href="/" class="logo" target="_blank">
                        <img src="{{ asset('img/tmtourism-logo2.png') }}" alt="" height="42" style="height: 70px;" />
                    </a>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Меню</li>

                        @if(!auth()->user()->isReferral())
                            {{-- Dashboard visible to all authorized --}}
                            <li class="{{ request()->routeIs('dashboard') ? 'mm-active' : '' }}">
                                <a href="{{ route('dashboard') }}"
                                    class="waves-effect {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class='bx bx-home-smile'></i><span>Дашборд</span>
                                </a>
                            </li>

                            <li class="{{ request()->routeIs('bookings*', 'customers*') ? 'mm-active' : '' }}">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-bitcoin"></i><span>Продажи</span>
                                </a>
                                <ul class="sub-menu {{ request()->routeIs('bookings*', 'customers*') ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    <li><a href="{{ route('bookings.index') }}"
                                            class="{{ request()->routeIs('bookings*') ? 'active' : '' }}"><i
                                                class='bx bx-calendar-check'></i><span>Бронирования</span></a></li>
                                    <li><a href="{{ route('customers.index') }}"
                                            class="{{ request()->routeIs('customers*') ? 'active' : '' }}"><i
                                                class="bx bx-user"></i> Клиенты</a></li>
                                </ul>
                            </li>

                            <li
                                class="{{ request()->routeIs('tour-categories*', 'admin.tags*', 'admin.tours*', 'tour-groups*', 'services*', 'inclusions*') ? 'mm-active' : '' }}">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-world"></i><span>Туры и услуги</span></a>
                                <ul class="sub-menu {{ request()->routeIs('tour-categories*', 'admin.tags*', 'admin.tours*', 'tour-groups*', 'services*', 'inclusions*') ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    <li><a href="{{ route('tour-categories.index') }}"
                                            class="{{ request()->routeIs('tour-categories*') ? 'active' : '' }}"><i
                                                class="mdi mdi-format-align-justify"></i>Категории туров</a></li>
                                    <li><a href="{{ route('admin.tags.index') }}"
                                            class="{{ request()->routeIs('admin.tags*') ? 'active' : '' }}"><i
                                                class="bx bx-purchase-tag-alt"></i>
                                            Теги</a></li>

                                    <li><a href="{{ route('admin.tours.index') }}"
                                            class="{{ request()->routeIs('admin.tours*') ? 'active' : '' }}"><i
                                                class="bx bx-map-alt"></i>Туры</a>
                                    </li>
                                    <li><a href="{{ route('tour-groups.index') }}"
                                            class="{{ request()->routeIs('tour-groups*') ? 'active' : '' }}"><i
                                                class="bx bx-group"></i> Группы
                                            туров</a></li>
                                    <li><a href="{{ route('services.index') }}"
                                            class="{{ request()->routeIs('services*') ? 'active' : '' }}"><i
                                                class="bx bx-add-to-queue"></i>
                                            Услуги</a></li>
                                    <li><a href="{{ route('inclusions.index') }}"
                                            class="{{ request()->routeIs('inclusions*') ? 'active' : '' }}"><i
                                                class="bx bx-check-square"></i>
                                            Включения</a></li>
                                </ul>
                            </li>

                            <li
                                class="{{ request()->routeIs('carousels*', 'categories*', 'posts*', 'reviews*', 'admin.pages*', 'gallery*') ? 'mm-active' : '' }}">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-receipt"></i><span>Контент</span></a>
                                <ul class="sub-menu {{ request()->routeIs('carousels*', 'categories*', 'posts*', 'reviews*', 'admin.pages*', 'gallery*') ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    <li><a href="{{ route('carousels.index') }}"
                                            class="{{ request()->routeIs('carousels*') ? 'active' : '' }}"><i
                                                class="bx bx-images"></i> Слайды
                                            карусели</a></li>
                                    <li><a href="{{ route('categories.index') }}"
                                            class="{{ request()->routeIs('categories*') ? 'active' : '' }}"><i
                                                class="mdi mdi-format-align-justify"></i> Категории постов</a></li>
                                    <li><a href="{{ route('posts.index') }}"
                                            class="{{ request()->routeIs('posts*') ? 'active' : '' }}"><i
                                                class="bx bx-file-blank"></i> Посты</a></li>
                                    <li><a href="{{ route('reviews.index') }}"
                                            class="{{ request()->routeIs('reviews*') ? 'active' : '' }}"><i
                                                class="bx bx-chat"></i> Отзывы</a></li>
                                    <li><a href="{{ route('admin.pages.index') }}"
                                            class="{{ request()->routeIs('admin.pages*') ? 'active' : '' }}"><i
                                                class="bx bx-file"></i> Страницы</a>
                                    </li>
                                    <li><a href="{{ route('gallery.index') }}"
                                            class="{{ request()->routeIs('gallery*') ? 'active' : '' }}"><i
                                                class="bx bx-image-alt"></i> Галерея</a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="{{ request()->routeIs('admin.locations*', 'admin.hotels*', 'admin.places*', 'admin.routes*') ? 'mm-active' : '' }}">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-map-pin"></i><span>Локации</span></a>
                                <ul class="sub-menu {{ request()->routeIs('admin.locations*', 'admin.hotels*', 'admin.places*', 'admin.routes*') ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    <li><a href="{{ route('admin.locations.index') }}"
                                            class="{{ request()->routeIs('admin.locations*') ? 'active' : '' }}"><i
                                                class="bx bx-map"></i> Локации</a>
                                    </li>
                                    <li><a href="{{ route('admin.hotels.index') }}"
                                            class="{{ request()->routeIs('admin.hotels*') ? 'active' : '' }}"><i
                                                class="bx bx-building-house"></i>
                                            Отели</a></li>
                                    <li><a href="{{ route('admin.places.index') }}"
                                            class="{{ request()->routeIs('admin.places*') ? 'active' : '' }}"><i
                                                class="bx bx-diamond"></i> Места</a>
                                    </li>
                                    <li><a href="{{ route('admin.routes.index') }}"
                                            class="{{ request()->routeIs('admin.routes*') ? 'active' : '' }}"><i
                                                class="bx bx-customize"></i>
                                            Программа тура</a></li>
                                </ul>
                            </li>

                            <li class="{{ request()->routeIs('users*', 'guides*') ? 'mm-active' : '' }}">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-group"></i><span>Пользователи</span></a>
                                <ul class="sub-menu {{ request()->routeIs('users*', 'guides*') ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    <li><a href="{{ route('users.index') }}"
                                            class="{{ request()->routeIs('users*') ? 'active' : '' }}"><i
                                                class="bx bx-user-circle"></i>
                                            Пользователи</a>
                                    </li>
                                    <li><a href="{{ route('guides.index') }}"
                                            class="{{ request()->routeIs('guides*') ? 'active' : '' }}"><i
                                                class="bx bx-id-card"></i> Гиды</a></li>
                                </ul>
                            </li>


                            <li
                                class="{{ request()->routeIs('admin.contact-infos*', 'admin.newsletter-subscribers*', 'admin.link-generator*', 'admin.contact-messages-table*') ? 'mm-active' : '' }}">
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-trending-up"></i><span>Маркетинг</span></a>
                                <ul class="sub-menu {{ request()->routeIs('admin.contact-infos*', 'admin.newsletter-subscribers*', 'admin.link-generator*', 'admin.contact-messages-table*') ? 'mm-show' : '' }}"
                                    aria-expanded="false">
                                    @livewire('MessageNavComponent')
                                    <li><a href="{{ route('admin.contact-infos') }}"
                                            class="{{ request()->routeIs('admin.contact-infos*') ? 'active' : '' }}"><i
                                                class="bx bx-info-circle"></i>
                                            Контакты</a>
                                    </li>
                                    <li><a href="{{ route('admin.newsletter-subscribers') }}"
                                            class="{{ request()->routeIs('admin.newsletter-subscribers*') ? 'active' : '' }}"><i
                                                class="bx bx-envelope"></i>
                                            Подписчики</a></li>
                                    <li><a href="{{ route('admin.link-generator') }}"
                                            class="{{ request()->routeIs('admin.link-generator*') ? 'active' : '' }}"><i
                                                class="bx bx-link"></i>
                                            Генератор ссылок</a></li>
                                </ul>
                            </li>
                        @endif


                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <header id="page-topbar">
            <div class="navbar-header">

                <div class="d-flex align-items-left">
                    <button type="button" class="btn btn-sm mr-2 d-lg-none px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    @if(!auth()->user()->isReferral())
                            <div class="dropdown d-none d-sm-inline-block">
                                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-plus"></i> Создать
                                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                                </button>
                                <div class="dropdown-menu">

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        Приложение
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        ПО
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        Система EMS
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        CRM Приложение
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">

                            <div class="dropdown d-none d-sm-inline-block ml-2">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    id="page-header-search-dropdown" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                    aria-labelledby="page-header-search-dropdown">

                                    <form class="p-3">
                                        <div class="form-group m-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Поиск ..."
                                                    aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="mdi mdi-magnify"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>



                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon waves-effect pr-4"
                                    id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="mdi mdi-bell-outline"></i>
                                    <span class="badge badge-danger badge-pill">3</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                    aria-labelledby="page-header-notifications-dropdown">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0"> Уведомления </h6>
                                            </div>
                                            <div class="col-auto">
                                                <a href="#!" class="small font-weight-bold"> Смотреть все</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-simplebar style="max-height: 230px;">
                                        <a href="" class="text-reset notification-item">
                                            <div class="media">
                                                <img src="{{ asset('assets/images/users/avatar-5.jpg') }}"
                                                    class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">Samuel Coverdale</h6>
                                                    <p class="font-size-12 mb-1">You have new follower on Instagram</p>
                                                    <p class="font-size-11 font-weight-bold mb-0 text-muted"><i
                                                            class="mdi mdi-clock-outline"></i> 2 min ago</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="" class="text-reset notification-item">
                                            <div class="media">
                                                <div class="avatar-xs mr-3">
                                                    <span class="avatar-title bg-primary rounded-circle">
                                                        <i class="mdi mdi-cloud-download-outline"></i>
                                                    </span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">Download Available !</h6>
                                                    <p class="font-size-11 mb-1">Latest version of admin is now available.
                                                        Please download here.</p>
                                                    <p class="font-size-11 font-weight-bold mb-0 text-muted"><i
                                                            class="mdi mdi-clock-outline"></i> 4 hours ago</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="" class="text-reset notification-item">
                                            <div class="media">
                                                <img src="{{ asset('assets/images/users/avatar-8.jpg') }}"
                                                    class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="media-body">
                                                    <h6 class="mt-0 mb-1">Victoria Mendis</h6>
                                                    <p class="font-size-12 mb-1">Just upgraded to premium account.</p>
                                                    <p class="font-size-11 font-weight-bold mb-0 text-muted"><i
                                                            class="mdi mdi-clock-outline"></i> 1 day ago</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="p-2">
                                        <a class="btn btn-sm btn-link btn-block text-center font-size-14"
                                            href="javascript:void(0)">
                                            Загрузить еще.. <i class="mdi mdi-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    @else
                            {{-- Keep the structure for referral but empty/minimal if needed, or just close the div and start
                            user dropdown --}}
                        </div>
                        <div class="d-flex align-items-center">
                    @endif

                    <!-- user-profile-dropdown -->
                    <livewire:user-profile-dropdown />

                </div>
            </div>
        </header>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            {{ $slot }}

            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            2025 © Opatix.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Дизайн и разработка: tmtourism.com
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Overlay-->
    <div class="menu-overlay"></div>

    <!-- 1. jQuery обязательно ПЕРВЫЙ -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- 2. Bootstrap и плагины -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>

    <!-- 3. Ваши стеки -->
    @stack('select2')
    @stack('quill-js')

    <!-- 4. Остальное -->
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireAlertScripts
</body>

</html>