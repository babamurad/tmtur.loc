<nav id="mainNav" class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm nav-glass"
    style="min-height: 110px; font-size: 15px; padding-top: 25px; padding-bottom: 25px;">
    <style>
        .nav-link:hover {
            color: #0d6efd !important;
            /* Bootstrap Primary Blue or custom logo color */
            transition: color 0.2s ease-in-out;
        }

        .nav-link {
            font-weight: 400 !important;
            /* Explicit Regular weight */
            letter-spacing: 0.02em;
            /* Premium spacing */
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #ffffff;
                padding: 20px;
                margin-top: 15px;
                border-radius: 12px;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
                border: 1px solid rgba(0, 0, 0, 0.03);
            }

            .nav-item {
                border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            }

            .nav-link {
                padding-top: 15px !important;
                padding-bottom: 15px !important;
                font-size: 16px !important;
            }

            .nav-right-block {
                flex-direction: column;
                align-items: flex-start !important;
                margin-top: 15px;
                width: 100%;
            }

            .nav-right-block>a,
            .nav-right-block>div {
                margin-left: 0 !important;
                margin-right: 0 !important;
                margin-bottom: 15px;
            }

            .nav-auth-actions {
                width: 100%;
                flex-direction: column;
                align-items: stretch !important;
            }

            .nav-auth-actions .btn {
                width: 100%;
                display: block;
                margin-left: 0 !important;
            }

            .navbar-toggler {
                border: none !important;
                padding: 0;
            }

            .navbar-toggler:focus {
                outline: none;
                box-shadow: none;
            }

        }

        .custom-dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
    </style>
    <div class="container-fluid px-lg-5">
        <a class="navbar-brand font-weight-bold d-flex align-items-center" href="/#home">
            <i class="fa-solid fa-fire text-danger mr-2"></i>TmTourism
        </a>

        <button class="navbar-toggler navbar-toggler-right border-0" type="button" data-toggle="collapse"
            data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-lg-4 align-items-lg-center nav-links-spaced">

                <li class="nav-item mx-2">
                    <a class="nav-link text-hover-primary" href="/#home" wire:navigate
                        style="color: #2D2D2D;">{{ __('menu.home') }}</a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link" href="/#about">{{ __('menu.about') }}</a>
                </li> -->

                {{-- Выпадающий пункт «Туры» (Alpine.js) --}}
                <li class="nav-item dropdown mx-2" x-data="{ open: false }" @click.outside="open = false"
                    @mouseleave="open = false">
                    <a class="nav-link custom-dropdown-toggle text-hover-primary" href="#" id="toursDropdown"
                        role="button" @click.prevent="open = !open" :class="{ 'show': open }"
                        :aria-expanded="open.toString()" style="color: #2D2D2D;">
                        {{ __('menu.tours') }}
                    </a>

                    <div class="dropdown-menu" :class="{ 'show': open }" aria-labelledby="toursDropdown">
                        @foreach($categories as $category)
                            <a class="dropdown-item" href="{{ route('tours.category.show', $category->slug) }}"
                                wire:navigate @click="open = false">
                                {{ $category->tr('title') }}
                            </a>
                        @endforeach

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('tours.category.index') }}" wire:navigate
                            @click="open = false">
                            {{ __('menu.all_tours') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('front.tour-groups') }}" wire:navigate
                            @click="open = false">
                            {{ __('menu.tour_groups') }}
                        </a>
                    </div>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link text-hover-primary" href="{{ route('visa') }}" wire:navigate
                        style="color: #2D2D2D;">{{ __('menu.visa') }}</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link text-hover-primary" href="{{ route('blog.index') }}" wire:navigate
                        style="color: #2D2D2D;">{{ __('menu.blog') }}</a>
                </li>

                <li class="nav-item dropdown mx-2" x-data="{ open: false }" @click.outside="open = false"
                    @mouseleave="open = false">
                    <a class="nav-link custom-dropdown-toggle text-hover-primary" href="#" id="aboutDropdown"
                        role="button" @click.prevent="open = !open" :class="{ 'show': open }"
                        :aria-expanded="open.toString()" style="color: #2D2D2D;">
                        {{ __('menu.about_us') }}
                    </a>

                    <div class="dropdown-menu" :class="{ 'show': open }" aria-labelledby="aboutDropdown">
                        <a class="dropdown-item" href="{{ route('about') }}" wire:navigate @click="open = false">
                            {{ __('menu.about_company') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('reviews.index') }}" wire:navigate
                            @click="open = false">
                            {{ __('menu.reviews') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('gallery') }}" wire:navigate @click="open = false">
                            {{ __('menu.gallery') }}
                        </a>
                    </div>
                </li>

                <li class="nav-item mx-2 mr-lg-4">
                    <a class="nav-link text-hover-primary" href="/#contact"
                        style="color: #2D2D2D;">{{ __('menu.contact') }}</a>
                </li>

            </ul>

            <div class="d-flex align-items-center ml-auto nav-right-block">


                {{-- Переключатель языков (Livewire-компонент) --}}
                <div class="mr-3">
                    @livewire('language-switcher')
                </div>

                <div class="d-flex align-items-center nav-auth-actions">
                    @auth
                        <div class="dropdown" x-data="{ open: false }" @click.outside="open = false">
                            <a class="nav-link custom-dropdown-toggle font-weight-medium text-dark" href="#" role="button"
                                id="accountMenu" @click.prevent="open = !open" :class="{ 'show': open }"
                                :aria-expanded="open.toString()">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" :class="{ 'show': open }"
                                aria-labelledby="accountMenu">
                                <a class="dropdown-item" href="{{ route('front.profile') }}" wire:navigate
                                    @click="open = false">
                                    {{ __('menu.profile') ?? 'Редактировать профиль' }}
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-link p-0 text-danger">{{ __('menu.logout') ?? 'Logout' }}</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('front.login') }}" class="nav-link mr-4 text-hover-primary" wire:navigate
                            style="color: #6B7280;">{{ __('menu.login') ?? 'Войти' }}</a>
                        <!-- <a href="{{ route('front.register') }}" class="btn btn-primary btn-sm px-5 shadow-sm"
                                                        style="border-radius: 50px !important; text-transform: none !important; font-size: 0.85rem; font-weight: 400; box-shadow: 0 4px 15px rgba(59, 113, 202, 0.2) !important;"
                                                        wire:navigate>{{ __('menu.register') ?? 'Регистрация' }}</a> -->
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>