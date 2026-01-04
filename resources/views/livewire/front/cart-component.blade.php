<div class="container py-5">
    <h1 class="mb-4">Корзина</h1>

    @if($rows->isEmpty())
        <div class="alert alert-info">
            Ваша корзина пуста. <a href="{{ route('front.tour-groups') }}">Перейти к выбору туров</a>.
        </div>
    @else
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Тур</th>
                        <th>Дата</th>
                        <th>Кол-во людей</th>
                        <th>Цена за чел.</th>
                        <th>Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($rows as $idx => $row)
                        @php
                            $group = \App\Models\TourGroup::find($row['tour_group_id']);
                            if(!$group) continue;
                            
                            $basePrice = $group->getPriceForPeople($row['people']);
                            $lineTotal = $basePrice * $row['people'];
                            
                            // Services
                            $servicesTotal = 0;
                            // Need to fetch services to calculate price
                            $selectedServices = \App\Models\TourGroupService::whereIn('service_id', $row['services'] ?? [])
                                ->where('tour_group_id', $group->id)
                                ->get();
                                
                            foreach($selectedServices as $s) {
                                $servicesTotal += $s->price_cents / 100;
                            }
                            $lineTotal += ($servicesTotal * $row['people']);
                            
                            $grandTotal += $lineTotal;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $group->tour->title ?? 'Tour' }}</strong>
                                @if(count($selectedServices) > 0)
                                    <br>
                                    <small class="text-muted">
                                        + Услуги: 
                                        {{ $selectedServices->map(fn($s) => $s->service->title . ' ($'.number_format($s->price_cents/100, 2).')')->implode(', ') }}
                                    </small>
                                @endif
                            </td>
                            <td>{{ $group->start_date ? $group->start_date->format('d.m.Y') : '-' }}</td>
                            <td>{{ $row['people'] }}</td>
                            <td>${{ number_format($basePrice + $servicesTotal, 2) }}</td>
                            <td>${{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Итого:</strong></td>
                        <td><strong>${{ number_format($grandTotal, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            <button wire:click="checkout" wire:loading.attr="disabled" class="btn btn-success btn-lg">
                <span wire:loading.remove>Оформить заказ</span>
                <span wire:loading>Обработка...</span>
            </button>
        </div>
    @endif
</div>
