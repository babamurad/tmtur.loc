<div class="container mt-5 pt-3">
    <h2 class="text-center mb-4">{{ __('messages.available_dates') }}</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <label for="monthFilter">{{ __('Месяц') }}</label>
            <select wire:model.live="month" id="monthFilter" class="form-control">
                @foreach($months as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="yearFilter">{{ __('Год') }}</label>
            <select wire:model.live="year" id="yearFilter" class="form-control">
                @foreach($years as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        @forelse($groups as $group)
            @php
                $available = $group->freePlaces();
                $percent   = $group->max_people > 0 ? (int) round($available / $group->max_people * 100) : 0;
                $badge     = $percent >= 50 ? 'bg-success' : ($percent > 0 ? 'bg-warning text-dark' : 'bg-danger');
            @endphp
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="mb-2">{{ optional($group->tour)->tr('title') ?? optional($group->tour)->title ?? 'Тур' }}</h5>
                        <div class="text-muted mb-2">
                            <i class="far fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($group->starts_at)->format('d.m.Y H:i') }}
                        </div>
                        <div class="mb-2">
                            {{ __('messages.available_seats') }}: <span class="badge {{ $badge }}">{{ $available }}</span>
                        </div>
                        <div class="small text-muted">{{ __('messages.price_per_person') }}: <strong>{{ number_format($group->price_max, 0, '.', ' ') }}</strong> TMT</div>
                        <div class="small text-muted">{{ __('messages.price_full_group', ['count' => $group->max_people]) }}: <strong>{{ number_format($group->price_min, 0, '.', ' ') }}</strong> TMT</div>
                        <div class="mt-auto pt-3">
                            <a class="btn btn-primary btn-block {{ $available > 0 ? '' : 'disabled' }}" href="#">{{ __('messages.book_now') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">{{ __('messages.no_tour_groups_available') }}</div>
        @endforelse
    </div>

    @if($groups->hasPages())
        <div class="pt-3">
            {{ $groups->links() }}
        </div>
    @endif
</div>
