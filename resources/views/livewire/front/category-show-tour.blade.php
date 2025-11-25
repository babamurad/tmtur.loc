<div class="container mt-5 pt-5">
    <div class="row">

        <div class="col-md-8">
            <h2 class="text-center mb-3">{{ $category->tr('title') }}</h2>
            <div class="text-center mb-4">
                {!! $category->tr('content') !!}
            </div>

            {{-- VIEW SWITCHER --}}
            <div class="d-flex justify-content-end mb-3">
                <button wire:click="setView('grid')"
                        class="btn btn-outline-secondary btn-sm {{ $view === 'grid' ? 'active' : '' }}">
                    <i class="fa fa-th"></i>
                </button>

                <button wire:click="setView('list')"
                        class="btn btn-outline-secondary btn-sm ml-2 {{ $view === 'list' ? 'active' : '' }}">
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

            {{ $tours->links('pagination::bootstrap-4') }}
        </div>

        @livewire('front.tours-sidebar')

    </div>
</div>
