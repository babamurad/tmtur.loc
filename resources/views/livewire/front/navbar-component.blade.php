<nav id="mainNav" class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm nav-glass" style="min-height: 110px; font-size: 15px; padding-top: 25px; padding-bottom: 25px;">
    <style>
        .nav-link:hover {
            color: #0d6efd !important; /* Bootstrap Primary Blue or custom logo color */
            transition: color 0.2s ease-in-out;
        }
        .nav-link {
            font-weight: 400 !important; /* Explicit Regular weight */
            letter-spacing: 0.02em; /* Premium spacing */
        }
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #ffffff;
                padding: 20px;
                margin-top: 15px;
                border-radius: 12px;
                box-shadow: 0 15px 40px rgba(0,0,0,0.08);
                border: 1px solid rgba(0,0,0,0.03);
            }
            .nav-item {
                border-bottom: 1px solid rgba(0,0,0,0.03);
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
            .nav-right-block > a, .nav-right-block > div {
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
                    <a class="nav-link text-hover-primary" href="/#home" wire:navigate style="color: #2D2D2D;">{{ __('menu.home') }}</a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link" href="/#about">{{ __('menu.about') }}</a>
                </li> -->

                {{-- Выпадающий пункт «Туры» (Alpine.js) --}}
                <li class="nav-item dropdown mx-2" x-data="{ open: false }" @click.outside="open = false" @mouseleave="open = false">
                    <a class="nav-link dropdown-toggle text-hover-primary" href="#" id="toursDropdown" role="button"
                       @click.prevent="open = !open"
                       :class="{ 'show': open }"
                       :aria-expanded="open.toString()" style="color: #2D2D2D;">
                        {{ __('menu.tours') }}
                    </a>

                    <div class="dropdown-menu mega-dropdown" :class="{ 'show': open }" aria-labelledby="toursDropdown">
                        <div class="dropdown-heading text-uppercase text-muted small px-3 pt-2 pb-1">
                            {{ __('menu.tours') }}
                        </div>
                        <div class="dropdown-grid px-2 pb-2">
                            @foreach($categories as $category)
                                <a class="dropdown-item d-flex align-items-center "
                                    href="{{ route('tours.category.show', $category->slug) }}" wire:navigate @click="open = false">
                                    <span class="badge-dot mr-2"></span>
                                    <span class="category">{{ $category->tr('title') }}</span>
                                </a>
                            @endforeach
                        </div>

                        <div class="dropdown-footer border-top px-3 py-2">
                            <a class="dropdown-item font-weight-semibold d-flex align-items-center"
                                href="{{ route('tours.category.index') }}" wire:navigate @click="open = false">
                                <i class="fa-solid fa-arrow-right mr-2 text-primary"></i><span class="category">
                                    {{ __('menu.all_tours') }}
                                </span></a>
                            <a class="dropdown-item font-weight-semibold d-flex align-items-center"
                                href="{{ route('front.tour-groups') }}" wire:navigate @click="open = false">
                                <i class="fa-solid fa-arrow-right mr-2 text-primary"></i><span class="category">
                                    {{ __('menu.tour_groups') }}
                                </span></a>
                        </div>
                    </div>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link text-hover-primary" href="{{ route('visa') }}" wire:navigate style="color: #2D2D2D;">{{ __('menu.visa') }}</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link text-hover-primary" href="{{ route('blog.index') }}" wire:navigate style="color: #2D2D2D;">{{ __('menu.blog') }}</a>
                </li>

                <li class="nav-item mx-2 mr-lg-4">
                    <a class="nav-link text-hover-primary" href="/#contact" style="color: #2D2D2D;">{{ __('menu.contact') }}</a>
                </li>

            </ul>
            
            <div class="d-flex align-items-center ml-auto nav-right-block">
                <a class="nav-link position-relative mr-3 p-0" href="{{ route('cart.index') }}" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 22px; height: 22px; color: #6B7280;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                     @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                              style="font-size: 0.6rem; top: -5px !important; right: -8px;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- Переключатель языков (Livewire-компонент) --}}
                <div class="mr-3">
                    @livewire('language-switcher')
                </div>

                <div class="d-flex align-items-center nav-auth-actions">
                    @auth
                        <div class="dropdown" x-data="{ open: false }" @click.outside="open = false">
                            <a class="nav-link dropdown-toggle font-weight-medium text-dark" href="#" role="button" id="accountMenu"
                               @click.prevent="open = !open"
                               :class="{ 'show': open }"
                               :aria-expanded="open.toString()">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" :class="{ 'show': open }" aria-labelledby="accountMenu">
                                <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-link p-0 text-danger">{{ __('menu.logout') ?? 'Logout' }}</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('front.login') }}" class="nav-link mr-4 text-hover-primary"
                            wire:navigate style="color: #6B7280;">{{ __('menu.login') ?? 'Войти' }}</a>
                        <a href="{{ route('front.register') }}" class="btn btn-primary btn-sm px-5 shadow-sm"
                           style="border-radius: 50px !important; text-transform: none !important; font-size: 0.85rem; font-weight: 400; box-shadow: 0 4px 15px rgba(59, 113, 202, 0.2) !important;"
                            wire:navigate>{{ __('menu.register') ?? 'Регистрация' }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>