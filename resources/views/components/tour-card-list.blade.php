<div class="card mb-3 shadow-sm">
    <div class="row no-gutters">
        <div class="col-md-4">
            <div class="position-relative h-100">
                <a href="{{ route('our-tours.show', $tour->slug) }}">
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
                <a href="{{ route('our-tours.show', $tour->slug) }}">
                    <h5>{{ $tour->tr('title') }}</h5>
                </a>

                <p class="text-muted small">
                    {!! Str::words(strip_tags($tour->tr('short_description')), 30) !!}
                </p>

                {{-- Tour group info --}}
                @if($tour->groupsOpen && $tour->groupsOpen->count() > 0)
                    @php
                        $nextGroup = $tour->groupsOpen->first();
                        $minPrice = $tour->groupsOpen->min('price_cents');
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
                                <strong class="text-success">${{ number_format($minPrice, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-auto">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold text-danger">
                            <i class="fas fa-clock"></i>
                            {{ $tour->duration_days }} {{ __('messages.days_label') }}
                        </span>

                        <span class="text-warning">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </span>
                    </div>

                    <a href="{{ route('our-tours.show', $tour->slug) }}"
                       class="btn btn-dark btn-sm w-100">
                        {{ __('messages.read_more') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

