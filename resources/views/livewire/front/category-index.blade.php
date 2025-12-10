<div class="container">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('menu.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tours.category.index') }}">{{ __('menu.tours') }}</a></li>
                <li class="breadcrumb-item active">{{ __('menu.categories') }}</li>                
            </ol>
        </nav>
    </div>
    <div class="row">

        <div class="col-md-8">
            <h2 class="text-center mb-4">{{ __('messages.all_tours') }}</h2>

            {{-- VIEW SWITCHER --}}
            <div class="d-flex justify-content-end mb-3">
                <button wire:click="setView('grid')"
                        class="btn btn-sm {{ $view === 'grid' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                    <i class="fa fa-th"></i>
                </button>

                <button wire:click="setView('list')"
                        class="btn btn-sm ml-2 {{ $view === 'list' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <div class="row">
                @foreach($tours as $tour)
                    <div class="{{ $view === 'grid' ? 'col-sm-6 mb-4' : 'col-12' }}">
                        <x-tour-card :tour="$tour" :view="$view" />
                    </div>
                @endforeach
            </div>

            {{ $tours->links() }}
        </div>

        @livewire('front.tours-sidebar')

    </div>
</div>
