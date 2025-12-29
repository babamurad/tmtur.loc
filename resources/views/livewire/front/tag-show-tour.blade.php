<div class="container mt-5 pt-5">
    <div class="row">

        <div class="col-md-8">
            <h1 class="text-center mb-3">Тег: {{ $tag->tr('name') }}</h1>
            
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
                @forelse($tours as $tour)
                    <div class="{{ $view === 'grid' ? 'col-sm-6 mb-4' : 'col-12' }}">
                        <x-tour-card :tour="$tour" :view="$view" />
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Нет туров с этим тегом.
                        </div>
                    </div>
                @endforelse
            </div>

            {{ $tours->links('pagination::bootstrap-4') }}
        </div>

        @livewire('front.tours-sidebar')

    </div>
</div>
