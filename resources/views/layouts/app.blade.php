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

    @vite(['resources/js/app.js', 'resources/css/app.css'])

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
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="22" />
                </a>
            </div>

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Меню</li>
                    <li>
                        <a href="{{ route('dashboard') }}" class="waves-effect"><i class='bx bx-home-smile'></i><span>Дашборд</span></a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-world"></i><span>Туры и услуги</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('tour-categories.index') }}"><i class="mdi mdi-format-align-justify"></i>Категории туров</a></li>
                            <li><a href="{{ route('tours.index') }}"><i class="bx bx-map-alt"></i>Туры</a></li>
                            <li><a href="{{ route('tour-groups.index') }}"><i class="bx bx-group"></i> Группы туров</a></li>
                            <li><a href="{{ route('services.index') }}"><i class="bx bx-add-to-queue"></i> Услуги</a></li>
                            <li><a href="{{ route('inclusions.index') }}"><i class="bx bx-check-square"></i> Включения</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-receipt"></i><span>Контент</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('carousels.index') }}"><i class="bx bx-images"></i> Слайды карусели</a></li>
                            <li><a href="{{ route('categories.index') }}"><i class="mdi mdi-format-align-justify"></i> Категории постов</a></li>
                            <li><a href="{{ route('posts.index') }}"><i class="bx bx-file-blank"></i> Посты</a></li>
                            <li><a href="{{ route('reviews.index') }}"><i class="bx bx-chat"></i> Отзывы</a></li>
                            <li><a href="{{ route('gallery.index') }}"><i class="bx bx-image-alt"></i> Галерея</a></li>
                        </ul>
                    </li>


                    <li><a href="#"><i class="bx bx-diamond"></i> Элементы культуры</a></li>
                    <li><a href="#"><i class="bx bx-user"></i> Клиенты</a></li>
                    <li><a href="{{ route('guides.index') }}"><i class="bx bx-id-card"></i> Гиды</a></li>

                    @livewire('MessageNavComponent')

                    <li><a href="{{ route('admin.contact-infos') }}"><i class="bx bx-info-circle"></i> Контактная информация</a></li>
                    <li><a href="{{ route('admin.newsletter-subscribers') }}"><i class="bx bx-envelope"></i> Подписчики рассылки</a></li>


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
                            <a class="btn btn-sm btn-link btn-block text-center font-size-14" href="javascript:void(0)">
                                Загрузить еще.. <i class="mdi mdi-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                             alt="Header Avatar">
                        <span class="d-none d-sm-inline-block ml-1">{{ auth()->user()->name }}</span>
                        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                           href="{{ route('admin.profile-edit') }}"
                           wire:navigate
                        >
                            <span>Профиль</span>
                            <span>
                                    <span class="badge badge-pill badge-soft-danger">1</span>
                                </span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                           href="javascript:void(0)">
                            Настройки
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between"
                           href="javascript:void(0)">
                            <span>Блокировка экрана</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center justify-content-between border-0 bg-transparent">
                                <span>Выйти</span>
                            </button>
                        </form>
                    </div>
                </div>

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
                            Дизайн и разработка: Bobo
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
@livewireAlertScripts
</body>

</html>
