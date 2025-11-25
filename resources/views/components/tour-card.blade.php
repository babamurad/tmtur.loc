@props(['tour', 'view' => 'grid'])

@if($view === 'grid')
    @include('components.tour-card-grid', ['tour' => $tour])
@else
    @include('components.tour-card-list', ['tour' => $tour])
@endif
