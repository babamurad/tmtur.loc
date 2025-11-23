<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать группу туров</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('tour-groups.index') }}">Группы туров</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Левая колонка – основные поля -->
            <div class="col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Основные параметры</h5>

                        <form wire:submit.prevent="save">
                            @csrf
                            <!-- Tour -->
                            <div class="form-group">
                                <label>Тур <span class="text-danger">*</span></label>
                                <select wire:model.defer="tour_id" class="form-control @error('tour_id') is-invalid @enderror">
                                    <option value="">-- Выберите тур --</option>
                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}">{{ $tour->title }}</option>
                                    @endforeach
                                </select>
                                @error('tour_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Starts At -->
                            <div class="form-group">
                                <label>Начало <span class="text-danger">*</span></label>
                                <input type="datetime-local" wire:model.defer="starts_at" class="form-control @error('starts_at') is-invalid @enderror">
                                @error('starts_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Max People -->
                            <div class="form-group">
                                <label>Макс. людей <span class="text-danger">*</span></label>
                                <input type="number" min="1" wire:model.defer="max_people" class="form-control @error('max_people') is-invalid @enderror">
                                @error('max_people') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Current People -->
                            <div class="form-group">
                                <label>Текущее кол-во</label>
                                <input type="number" min="0" wire:model.defer="current_people" class="form-control @error('current_people') is-invalid @enderror">
                                @error('current_people') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Price -->
                            <div class="form-group">
                                <label>Цена (центы) <span class="text-danger">*</span></label>
                                <input type="number" min="0" wire:model.defer="price_cents" class="form-control @error('price_cents') is-invalid @enderror">
                                @error('price_cents') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label>Статус <span class="text-danger">*</span></label>
                                <select wire:model.defer="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="draft">Черновик</option>
                                    <option value="open">Открыто</option>
                                    <option value="closed">Закрыто</option>
                                    <option value="cancelled">Отменено</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-success">
                                    <i class="bx bx-check-double"></i> Сохранить
                                </button>
                                <a href="{{ route('tour-groups.index') }}" class="btn btn-secondary ml-2">
                                    <i class="bx bx-x"></i> Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Правая колонка – услуги -->
            <div class="col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Дополнительные услуги</h5>

                        <!-- поиск -->
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-sm"
                                   placeholder="Найти услугу..."
                                   wire:model.live.debounce.300ms="search">
                        </div>

                        <!-- таблица -->
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless align-middle">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Услуга</th>
                                    <th class="text-end">Цена, ¢</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($services as $service)
                                    @php $id = (int)$service->id; @endphp
                                    {{-- фильтр по поиску --}}
                                    @if($search && !str_contains(mb_strtolower($service->name), mb_strtolower($search)))
                                        @continue
                                    @endif
                                    <tr wire:key="srv-{{ $id }}">
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       id="ch{{ $id }}"
                                                       wire:model.live="checked.{{ $id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <label for="ch{{ $id }}" class="mb-0">
                                                {{ $service->name }}
                                                <small class="text-muted">({{ $service->type }})</small>
                                            </label>
                                        </td>
                                        <td style="width:130px">
                                            <input type="number"
                                                   min="0" step="1"
                                                   class="form-control form-control-sm text-end"
                                                   wire:model.defer="prices.{{ $id }}"
                                                {{ empty($checked[$id]) ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted">Нет доступных услуг.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
