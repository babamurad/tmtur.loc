<div class="card mb-3 shadow-sm">
    <div class="row no-gutters">
        <div class="col-md-4">
            <div class="position-relative h-100">
                <a href="{{ route('tours.show', $tour->slug) }}">
                    <img src="{{ $tour->first_media_url }}" class="card-img h-100" alt="{{ $tour->tr('title') }}" style="object-fit: cover;">
                </a>
                
                {{-- Badge for available groups --}}
                @if($tour->groupsOpen && $tour->groupsOpen->count() > 0)
                    <span class="badge badge-success position-absolute" style="top: 10px; right: 10px;">
                        <i class="fas fa-check-circle"></i> {{ __('messages.available') ?? 'Доступно' }}
                    </span>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div class="card-body d-flex flex-column h-100">
                <a href="{{ route('tours.show', $tour->slug) }}">
                    <h5>{{ $tour->tr('title') }}</h5>
                </a>

                <p class="text-muted small">
                    {!! Str::words(strip_tags($tour->tr('short_description')), 30) !!}
                </p>

                {{-- Tour group info --}}
                @if($tour->groupsOpen && $tour->groupsOpen->count() > 0)
                    @php
                        $nextGroup = $tour->groupsOpen->first();
                        $minPrice = $tour->groupsOpen->min('price_min');
                    @endphp
                    <div class="mb-3 p-2 bg-light rounded">
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted d-block">
                                    <i class="fas fa-calendar-alt text-primary"></i> 
                                    {{ __('messages.next_departure') ?? 'Ближайший выезд' }}
                                </small>
                                <strong>{{ \Carbon\Carbon::parse($nextGroup->starts_at)->format('d.m.Y') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">
                                    <i class="fas fa-dollar-sign text-success"></i> 
                                    {{ __('messages.price') ?? 'Цена' }}
                                </small>
                                @php
                                    $maxPrice = $tour->groupsOpen->max('price_max');
                                    $minPrice = $tour->groupsOpen->min('price_min');
                                    $maxPeople = $tour->groupsOpen->max('max_people');
                                @endphp

                                @if($maxPeople > 1)
                                    <div class="d-flex flex-column">
                                        <span class="badge badge-secondary border text-left mb-1 font-weight-normal text-muted">
                                             <i class="fas fa-user"></i> 1 {{ __('messages.person') ?? 'чел.' }}: <strong>${{ number_format($maxPrice, 0) }}</strong>
                                        </span>
                                        <span class="badge badge-success border text-left font-weight-normal text-success">
                                             <i class="fas fa-users"></i> {{ $maxPeople }} {{ __('messages.people') ?? 'чел.' }}: <strong>${{ number_format($minPrice, 0) }}</strong>
                                        </span>
                                    </div>
                                @else
                                    <strong class="text-success">${{ number_format($minPrice, 0) }}</strong>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-auto">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold text-danger">
                            <i class="fas fa-clock"></i>
                            {{ trans_choice('messages.days', $tour->duration_days, ['count' => $tour->duration_days]) }}
                        </span>

                        <span class="text-warning">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </span>
                    </div>

                    <a href="{{ route('tours.show', $tour->slug) }}"
                       class="btn btn-dark btn-sm w-100">
                        {{ __('messages.read_more') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

