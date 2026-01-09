<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать маршрут</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.routes.index') }}">Маршруты</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Основная информация</h5>

                            <div class="form-group">
                                <label>Название маршрута <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="title"
                                    placeholder="Название (например: По Шелковому пути)">
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Описание</label>
                                <textarea class="form-control" wire:model="description" rows="3"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Порядок сортировки</label>
                                <input type="number" class="form-control" wire:model="sort_order">
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title m-0">Остановки маршрута (Локации)</h5>
                                <div>
                                    <button type="button" class="btn btn-sm btn-info mr-2" wire:click="addDay(true)">
                                        <i class="bx bx-plus-circle"></i> Добавить локацию в этот день
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" wire:click="addDay(false)">
                                        <i class="bx bx-calendar-plus"></i> Добавить следующий день
                                    </button>
                                </div>
                            </div>

                            @foreach($days as $index => $day)
                                <div class="card border mb-3" wire:key="day-{{ $index }}">
                                    <div
                                        class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                        <strong>Остановка {{ $index + 1 }} <span
                                                class="text-muted font-weight-normal ml-2">(День
                                                {{ $day['day_number'] }})</span></strong>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            wire:click="removeDay({{ $index }})" title="Удалить остановку">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>№ Дня</label>
                                                    <input type="number" class="form-control form-control-sm"
                                                        wire:model="days.{{ $index }}.day_number">
                                                    @error("days.$index.day_number") <span
                                                    class="text-danger small">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label>Локация <span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm"
                                                        wire:model.live="days.{{ $index }}.location_id">
                                                        <option value="">Выберите локацию...</option>
                                                        @foreach($locations as $location)
                                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error("days.$index.location_id") <span
                                                    class="text-danger small">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Заголовок (опционально)</label>
                                            <input type="text" class="form-control form-control-sm"
                                                wire:model="days.{{ $index }}.title" placeholder="Заголовок дня">
                                        </div>

                                        <div class="form-group">
                                            <label>Описание <span class="text-danger">*</span></label>
                                            <x-quill wire:model.defer="days.{{ $index }}.description" />
                                            @error("days.$index.description") <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        @php
                                            $selectedLocId = $days[$index]['location_id'] ?? null;
                                            $selectedLocation = $locations->find($selectedLocId);
                                        @endphp

                                        @if($selectedLocation)
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label class="small text-muted">Места для посещения</label>
                                                    <div class="border rounded p-2 bg-white"
                                                        style="max-height: 150px; overflow-y: auto;">
                                                        @forelse($selectedLocation->places as $place)
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="day-{{ $index }}-place-{{ $place->id }}"
                                                                    wire:model="days.{{ $index }}.place_ids"
                                                                    value="{{ $place->id }}">
                                                                <label class="custom-control-label"
                                                                    for="day-{{ $index }}-place-{{ $place->id }}">
                                                                    {{ $place->name }}
                                                                </label>
                                                            </div>
                                                        @empty
                                                            <small class="text-muted">Нет мест</small>
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small text-muted">Отели</label>
                                                    <div class="border rounded p-2 bg-white"
                                                        style="max-height: 150px; overflow-y: auto;">
                                                        @forelse($selectedLocation->hotels as $hotel)
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                    id="day-{{ $index }}-hotel-{{ $hotel->id }}"
                                                                    wire:model="days.{{ $index }}.hotel_ids"
                                                                    value="{{ $hotel->id }}">
                                                                <label class="custom-control-label"
                                                                    for="day-{{ $index }}-hotel-{{ $hotel->id }}">
                                                                    {{ $hotel->name }}
                                                                </label>
                                                            </div>
                                                        @empty
                                                            <small class="text-muted">Нет отелей</small>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Статус</h5>
                            <div class="custom-control custom-switch mb-3">
                                <input type="checkbox" class="custom-control-input" id="is_active"
                                    wire:model="is_active">
                                <label class="custom-control-label" for="is_active">Активен</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="bx bx-save"></i> Сохранить
                            </button>
                            <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary btn-block mt-2">
                                <i class="bx bx-x"></i> Отмена
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>