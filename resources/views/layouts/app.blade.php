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

                    @if(!auth()->user()->isReferral())
                        {{-- Dashboard visible to all authorized --}}
                        <li class="{{ request()->routeIs('dashboard') ? 'mm-active' : '' }}">
                            <a href="{{ route('dashboard') }}"
                                class="waves-effect {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class='bx bx-home-smile'></i><span>{{ __('menu.dashboard') }}</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('bookings*', 'customers*') ? 'mm-active' : '' }}">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-bitcoin"></i><span>{{ __('menu.sales') }}</span>
                            </a>
                            <ul class="sub-menu {{ request()->routeIs('bookings*', 'customers*') ? 'mm-show' : '' }}"
                                aria-expanded="false">
                                <li><a href="{{ route('bookings.index') }}"
                                        class="{{ request()->routeIs('bookings*') ? 'active' : '' }}"><i
                                            class='bx bx-calendar-check'></i><span>{{ __('menu.bookings') }}</span></a></li>
                                <li><a href="{{ route('customers.index') }}"
                                        class="{{ request()->routeIs('customers*') ? 'active' : '' }}"><i
                                            class="bx bx-user"></i> {{ __('menu.customers') }}</a></li>
                            </ul>
                        </li>

                        <li
                            class="{{ request()->routeIs('tour-categories*', 'admin.tags*', 'admin.tours*', 'tour-groups*', 'services*', 'inclusions*') ? 'mm-active' : '' }}">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-world"></i><span>{{ __('menu.tours_and_services') }}</span></a>
                            <ul class="sub-menu {{ request()->routeIs('tour-categories*', 'admin.tags*', 'admin.tours*', 'tour-groups*', 'services*', 'inclusions*') ? 'mm-show' : '' }}"
                                aria-expanded="false">
                                <li><a href="{{ route('tour-categories.index') }}"
                                        class="{{ request()->routeIs('tour-categories*') ? 'active' : '' }}"><i
                                            class="mdi mdi-format-align-justify"></i>{{ __('menu.tour_categories') }}</a>
                                </li>
                                <li><a href="{{ route('admin.tags.index') }}"
                                        class="{{ request()->routeIs('admin.tags*') ? 'active' : '' }}"><i
                                            class="bx bx-purchase-tag-alt"></i>
                                        {{ __('menu.tags') }}</a></li>

                                <li><a href="{{ route('admin.tours.index') }}"
                                        class="{{ request()->routeIs('admin.tours*') ? 'active' : '' }}"><i
                                            class="bx bx-map-alt"></i>{{ __('menu.tours') }}</a>
                                </li>
                                <li><a href="{{ route('tour-groups.index') }}"
                                        class="{{ request()->routeIs('tour-groups*') ? 'active' : '' }}"><i
                                            class="bx bx-group"></i> {{ __('menu.tour_groups') }}</a></li>
                                <li><a href="{{ route('services.index') }}"
                                        class="{{ request()->routeIs('services*') ? 'active' : '' }}"><i
                                            class="bx bx-add-to-queue"></i>
                                        {{ __('menu.services') }}</a></li>
                                <li><a href="{{ route('inclusions.index') }}"
                                        class="{{ request()->routeIs('inclusions*') ? 'active' : '' }}"><i
                                            class="bx bx-check-square"></i>
                                        {{ __('menu.inclusions') }}</a></li>
                            </ul>
                        </li>

                        <li
                            class="{{ request()->routeIs('carousels*', 'categories*', 'posts*', 'admin.reviews*', 'admin.pages*', 'gallery*') ? 'mm-active' : '' }}">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-receipt"></i><span>{{ __('menu.content') }}</span></a>
                            <ul class="sub-menu {{ request()->routeIs('carousels*', 'categories*', 'posts*', 'admin.reviews*', 'admin.pages*', 'gallery*') ? 'mm-show' : '' }}"
                                aria-expanded="false">
                                <li><a href="{{ route('carousels.index') }}"
                                        class="{{ request()->routeIs('carousels*') ? 'active' : '' }}"><i
                                            class="bx bx-images"></i> {{ __('menu.carousel') }}</a></li>
                                <li><a href="{{ route('categories.index') }}"
                                        class="{{ request()->routeIs('categories*') ? 'active' : '' }}"><i
                                            class="mdi mdi-format-align-justify"></i> {{ __('menu.post_categories') }}</a>
                                </li>
                                <li><a href="{{ route('posts.index') }}"
                                        class="{{ request()->routeIs('posts*') ? 'active' : '' }}"><i
                                            class="bx bx-file-blank"></i> {{ __('menu.posts') }}</a></li>
                                <li><a href="{{ route('admin.reviews.index') }}"
                                        class="{{ request()->routeIs('admin.reviews*') ? 'active' : '' }}"><i
                                            class="bx bx-chat"></i> {{ __('menu.reviews') }}</a></li>
                                <li><a href="{{ route('admin.pages.index') }}"
                                        class="{{ request()->routeIs('admin.pages*') ? 'active' : '' }}"><i
                                            class="bx bx-file"></i> {{ __('menu.pages') }}</a>
                                </li>
                                <li><a href="{{ route('gallery.index') }}"
                                        class="{{ request()->routeIs('gallery*') ? 'active' : '' }}"><i
                                            class="bx bx-image-alt"></i> {{ __('menu.gallery') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="{{ request()->routeIs('admin.locations*', 'admin.hotels*', 'admin.places*', 'admin.routes*') ? 'mm-active' : '' }}">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-map-pin"></i><span>{{ __('menu.locations') }}</span></a>
                            <ul class="sub-menu {{ request()->routeIs('admin.locations*', 'admin.hotels*', 'admin.places*', 'admin.routes*') ? 'mm-show' : '' }}"
                                aria-expanded="false">
                                <li><a href="{{ route('admin.locations.index') }}"
                                        class="{{ request()->routeIs('admin.locations*') ? 'active' : '' }}"><i
                                            class="bx bx-map"></i> {{ __('menu.locations') }}</a>
                                </li>
                                <li><a href="{{ route('admin.hotels.index') }}"
                                        class="{{ request()->routeIs('admin.hotels*') ? 'active' : '' }}"><i
                                            class="bx bx-building-house"></i>
                                        {{ __('menu.hotels') }}</a></li>
                                <li><a href="{{ route('admin.places.index') }}"
                                        class="{{ request()->routeIs('admin.places*') ? 'active' : '' }}"><i
                                            class="bx bx-diamond"></i> {{ __('menu.places') }}</a>
                                </li>
                                <li><a href="{{ route('admin.routes.index') }}"
                                        class="{{ request()->routeIs('admin.routes*') ? 'active' : '' }}"><i
                                            class="bx bx-customize"></i>
                                        {{ __('menu.route_program') }}</a></li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('users*', 'guides*') ? 'mm-active' : '' }}">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-group"></i><span>{{ __('menu.users_section') }}</span></a>
                            <ul class="sub-menu {{ request()->routeIs('users*', 'guides*') ? 'mm-show' : '' }}"
                                aria-expanded="false">
                                <li><a href="{{ route('users.index') }}"
                                        class="{{ request()->routeIs('users*') ? 'active' : '' }}"><i
                                            class="bx bx-user-circle"></i>
                                        {{ __('menu.users_section') }}</a>
                                </li>
                                <li><a href="{{ route('guides.index') }}"
                                        class="{{ request()->routeIs('guides*') ? 'active' : '' }}"><i
                                            class="bx bx-id-card"></i> {{ __('menu.guides') }}</a></li>
                            </ul>
                        </li>


                        <li
                            class="{{ request()->routeIs('admin.contact-infos*', 'admin.newsletter-subscribers*', 'admin.link-generator*', 'admin.contact-messages-table*') ? 'mm-active' : '' }}">
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-trending-up"></i><span>{{ __('menu.marketing') }}</span></a>
                            <ul class="sub-menu {{ request()->routeIs('admin.contact-infos*', 'admin.newsletter-subscribers*', 'admin.link-generator*', 'admin.contact-messages-table*') ? 'mm-show' : '' }}"
                                aria-expanded="false">
                                @livewire('MessageNavComponent')
                                <li><a href="{{ route('admin.contact-infos') }}"
                                        class="{{ request()->routeIs('admin.contact-infos*') ? 'active' : '' }}"><i
                                            class="bx bx-info-circle"></i>
                                        {{ __('menu.contacts') }}</a>
                                </li>
                                <li><a href="{{ route('admin.newsletter-subscribers') }}"
                                        class="{{ request()->routeIs('admin.newsletter-subscribers*') ? 'active' : '' }}"><i
                                            class="bx bx-envelope"></i>
                                        {{ __('menu.subscribers') }}</a></li>
                                <li><a href="{{ route('admin.link-generator') }}"
                                        class="{{ request()->routeIs('admin.link-generator*') ? 'active' : '' }}"><i
                                            class="bx bx-link"></i>
                                        {{ __('menu.link_generator') }}</a></li>
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
                                <i class="mdi mdi-plus"></i> {{ __('menu.create_new') }}
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu">

                                <!-- item-->
                                <a href="{{ route('admin.tours.create') }}" class="dropdown-item notify-item">
                                    <i class="bx bx-map-alt mr-1"></i> {{ __('menu.tour') }}
                                </a>

                                <!-- item-->
                                <a href="{{ route('posts.create') }}" class="dropdown-item notify-item">
                                    <i class="bx bx-file-blank mr-1"></i> {{ __('menu.article') }}
                                </a>

                                <!-- item-->
                                <a href="{{ route('admin.hotels.create') }}" class="dropdown-item notify-item">
                                    <i class="bx bx-building-house mr-1"></i> {{ __('menu.hotel') }}
                                </a>

                                <!-- item-->
                                <a href="{{ route('guides.create') }}" class="dropdown-item notify-item">
                                    <i class="bx bx-id-card mr-1"></i> {{ __('menu.guide') }}
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

                                <form class="p-3" action="{{ route('admin.global-search') }}" method="GET">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" name="q" class="form-control"
                                                placeholder="{{ __('menu.search_placeholder') }}"
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



                        <livewire:admin.notifications-dropdown />
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
        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif

        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        {{ date('Y') }} © TMTourism.
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