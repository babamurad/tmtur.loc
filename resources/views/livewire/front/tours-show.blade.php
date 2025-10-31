<div class="container">
    <h1>{{ $tour->title }}</h1>

    {{-- выбираем дату группы --}}
    <div class="form-group">
        <label>Даты групп:</label>
        <select wire:model="selectedGroupId" class="form-control">
            <option value="">-- выберите дату --</option>
            @foreach($tour->groupsOpen as $g)
                <option value="{{ $g->id }}">
                    {{ $g->starts_at->format('d.m.Y') }}
                    (осталось {{ $g->freePlaces() }} мест)
                </option>
            @endforeach
        </select>
    </div>

    {{-- сколько человек --}}
    <div class="form-group">
        <label>Кол-во человек:</label>
        <input type="number" wire:model="peopleCount" min="1" max="9" class="form-control">
    </div>

    {{-- доп. услуги --}}
    @if($selectedGroupId)
        <h5>Дополнительные услуги</h5>
        @foreach($availableServices as $s)
            <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       wire:model="services.{{ $s->id }}"
                       value="{{ $s->id }}"
                       id="serv{{ $s->id }}">
                <label class="form-check-label" for="serv{{ $s->id }}">
                    {{ $s->title }} (+{{ $s->pivot->price_cents/100 }} ₽)
                </label>
            </div>
        @endforeach
    @endif

    {{-- кнопка «Добавить в корзину» --}}
    <button class="btn btn-primary"
            wire:click="addToCart"
        {{ !$selectedGroupId ? 'disabled' : '' }}>
        Добавить в корзину
    </button>

    {{-- мини-корзина в правом верхнем углу --}}
    @livewire('front.cart-widget')
</div>
