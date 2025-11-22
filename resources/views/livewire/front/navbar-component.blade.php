<nav id="mainNav" class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="/#home">
            <i class="fa-solid fa-fire text-danger mr-2"></i>TmTourism
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/#home" wire:navigate>{{ __('menu.home') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#about">{{ __('menu.about') }}</a>
                </li>

                {{-- Выпадающий пункт «Туры» --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       id="toursDropdown"
                       role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        {{ __('menu.tours') }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="toursDropdown">
                        @foreach($categories as $category)
                            <a class="dropdown-item"
                               href="{{ route('tours.category.show', $category->slug) }}">
                                {{ $category->tr('title') }}
                            </a>
                        @endforeach

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                           href="{{ route('tours.category.index') }}">
                            {{ __('menu.all_tours') }}
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('visa') }}" wire:navigate>{{ __('menu.visa') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog.index') }}">{{ __('menu.blog') }}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#contact">{{ __('menu.contact') }}</a>
                </li>

            </ul>

            {{-- Переключатель языков (Livewire-компонент) --}}
            @livewire('language-switcher')
        </div>
    </div>
</nav>