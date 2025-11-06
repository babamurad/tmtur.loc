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
                <li class="nav-item"><a class="nav-link" href="/#home" wire:navigate>Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/#about">About Turkmenistan</a></li>
                <!-- Выпадающий пункт «Tours» -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#"
                       id="toursDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Tours
                    </a>
                    <div class="dropdown-menu" aria-labelledby="toursDropdown">
                        @foreach($categories as $category)
                            <a class="dropdown-item" href="#">{{ $category->title }}</a>
                        @endforeach
                        <a class="dropdown-item" href="#">All tours</a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('visa') }}" wire:navigate>Visa</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="/#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
