<div class="card h-100 shadow">
    <div class="position-relative">
        <a href="{{ route('our-tours.show', $tour->slug) }}">
            <img src="{{ $tour->first_media_url }}"
                 class="card-img-top"
                 alt="{{ $tour->tr('title') }}">
        </a>
        
        {{-- Badge for available groups --}}
        @if($tour->groupsOpen && $tour->groupsOpen->count() > 0)
            <span class="badge badge-success position-absolute" style="top: 10px; right: 10px;">
                <i class="fas fa-check-circle"></i> {{ __('messages.available') ?? 'Доступно' }}
            </span>
        @endif
    </div>

    <div class="card-body d-flex flex-column">
        <a href="{{ route('our-tours.show', $tour->slug) }}">
            <h5 class="card-title">{{ $tour->tr('title') }}</h5>
        </a>

        <p class="card-text small">
            {!! Str::words(strip_tags($tour->tr('short_description')), 20) !!}
        </p>

        {{-- Tour group info --}}
        @if($tour->groupsOpen && $tour->groupsOpen->count() > 0)
            @php
                $nextGroup = $tour->groupsOpen->first();
                $minPrice = $tour->groupsOpen->min('price_min');
            @endphp
            <div class="mb-2">
                <small class="text-muted d-block">
                    <i class="fas fa-calendar-alt"></i> 
                    {{ __('messages.next_departure') ?? 'Ближайший выезд' }}: 
                    <strong>{{ \Carbon\Carbon::parse($nextGroup->starts_at)->format('d.m.Y') }}</strong>
                </small>
                <div class="d-flex flex-column mt-2">
                    @php
                        $maxPrice = $tour->groupsOpen->max('price_max');
                        $minPrice = $tour->groupsOpen->min('price_min');
                        $maxPeople = $tour->groupsOpen->max('max_people');
                    @endphp
                    
                    @if($maxPeople > 1)
                        <span class="badge badge-secondary border text-left mb-1 font-weight-normal text-muted">
                             <i class="fas fa-user"></i> 1 {{ __('messages.person') ?? 'чел.' }}: <strong>${{ number_format($maxPrice, 0) }}</strong>
                        </span>
                        <span class="badge badge-success border text-left font-weight-normal text-success">
                             <i class="fas fa-users"></i> {{ $maxPeople }} {{ __('messages.people') ?? 'чел.' }}: <strong>${{ number_format($minPrice, 0) }}</strong>
                        </span>
                    @else
                        <span class="text-success font-weight-bold">
                            ${{ number_format($minPrice, 0) }}
                        </span>
                    @endif
                </div>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-auto">
            <span class="fw-bold text-danger">{{ $tour->duration_days }} {{ __('messages.days_label') }}</span>
            <span class="text-warning">
                @for($i = 0; $i < 5; $i++)
                    <i class="fa-solid fa-star"></i>
                @endfor
            </span>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('our-tours.show', $tour->slug) }}"
           class="btn btn-dark w-100">{{ __('messages.read_more') }}</a>
    </div>
</div>

