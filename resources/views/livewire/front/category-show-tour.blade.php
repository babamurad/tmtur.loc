<div class="container mt-5 pt-5">
    <div class="row">

        <div class="col-md-8">
            <h1 class="text-center mb-3">{{ $category->tr('title') }}</h1>
            <div class="text-center mb-4">
                {!! $category->tr('content') !!}
            </div>

            {{-- VIEW SWITCHER --}}
            <div class="d-flex justify-content-end mb-3 align-items-center">

                @if(!empty($availableDurations))
                    <div class="dropdown mr-2" wire:ignore>
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            id="durationFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-calendar-alt"></i> {{ __('Дней') }}
                        </button>
                        <div class="dropdown-menu p-2" aria-labelledby="durationFilterDropdown" style="min-width: 200px;"
                            onclick="event.stopPropagation()">
                            <h6 class="dropdown-header">{{ __('Выберите длительность') }}</h6>
                            @foreach($availableDurations as $duration)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model.live="selectedDurations"
                                        value="{{ $duration }}" id="duration-{{ $duration }}">
                                    <label class="form-check-label" for="duration-{{ $duration }}">
                                        {{ $duration }}
                                        {{ $duration == 1 ? 'день' : ($duration >= 2 && $duration <= 4 ? 'дня' : 'дней') }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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

            {{ $tours->links('pagination::bootstrap-4') }}
        </div>

        @livewire('front.tours-sidebar')

    </div>
</div>