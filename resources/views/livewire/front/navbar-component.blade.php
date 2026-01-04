<nav id="mainNav" class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm nav-glass">
    <div class="container">
        <a class="navbar-brand font-weight-bold d-flex align-items-center" href="/#home">
            <i class="fa-solid fa-fire text-danger mr-2"></i>TmTourism
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto align-items-lg-center nav-links-spaced">

                <li class="nav-item">
                    <a class="nav-link" href="/#home" wire:navigate>{{ __('menu.home') }}</a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link" href="/#about">{{ __('menu.about') }}</a>
                </li> -->

                {{-- Выпадающий пункт «Туры» (Alpine.js) --}}
                <li class="nav-item dropdown" x-data="{ open: false }" @click.outside="open = false" @mouseleave="open = false">
                    <a class="nav-link dropdown-toggle" href="#" id="toursDropdown" role="button"
                       @click.prevent="open = !open"
                       :class="{ 'show': open }"
                       :aria-expanded="open.toString()">
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

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('visa') }}" wire:navigate>{{ __('menu.visa') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog.index') }}" wire:navigate>{{ __('menu.blog') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#contact">{{ __('menu.contact') }}</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}" wire:navigate>
                        <i class="fas fa-shopping-cart fa-lg text-primary"></i>
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                                  style="font-size: 0.6rem; top: 5px !important; right: -5px;">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>

            </ul>

            {{-- Переключатель языков (Livewire-компонент) --}}
            @livewire('language-switcher')

            <div class="ml-lg-3 d-flex align-items-center nav-auth-actions">
                @auth
                    <div class="dropdown" x-data="{ open: false }" @click.outside="open = false">
                        <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button" id="accountMenu"
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
                    <a href="{{ route('front.login') }}" class="btn btn-outline-secondary btn-sm mr-2 nav-ghost-btn"
                        wire:navigate>{{ __('menu.login') ?? 'Войти' }}</a>
                    <a href="{{ route('front.register') }}" class="btn btn-primary btn-sm nav-cta-btn"
                        wire:navigate>{{ __('menu.register') ?? 'Регистрация' }}</a>
                @endauth
            </div>
        </div>
    </div>
</nav>