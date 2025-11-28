<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Create Tour Group</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('tour-groups.index') }}">Tour Groups</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Tour Group details</h5>

                        <form wire:submit.prevent="save">
                            {{-- Tour --}}
                            <div class="form-group">
                                <label for="tour_id">Tour <span class="text-danger">*</span></label>
                                <select wire:model.defer="tour_id" class="form-control @error('tour_id') is-invalid @enderror">
                                    <option value="">-- Choose tour --</option>
                                    @foreach ($tours as $tour)
                                        <option value="{{ $tour->id }}">{{ $tour->title }}</option>
                                    @endforeach
                                </select>
                                @error('tour_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Starts At --}}
                            <div class="form-group">
                                <label for="starts_at">Starts At <span class="text-danger">*</span></label>
                                <input type="datetime-local"
                                       id="starts_at"
                                       wire:model.defer="starts_at"
                                       class="form-control @error('starts_at') is-invalid @enderror">
                                @error('starts_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Max People --}}
                            <div class="form-group">
                                <label for="max_people">Max People <span class="text-danger">*</span></label>
                                <input type="number"
                                       id="max_people"
                                       wire:model.defer="max_people"
                                       class="form-control @error('max_people') is-invalid @enderror"
                                       min="1">
                                @error('max_people')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Current People --}}
                            <div class="form-group">
                                <label for="current_people">Current People</label>
                                <input type="number"
                                       id="current_people"
                                       wire:model.defer="current_people"
                                       class="form-control @error('current_people') is-invalid @enderror"
                                       min="0">
                                @error('current_people')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price Min --}}
                            <div class="form-group">
                                <label for="price_min">Min Price ($) <span class="text-danger">*</span></label>
                                <input type="number"
                                       id="price_min"
                                       wire:model.defer="price_min"
                                       class="form-control @error('price_min') is-invalid @enderror"
                                       min="0">
                                @error('price_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Price Max --}}
                            <div class="form-group">
                                <label for="price_max">Max Price ($) <span class="text-danger">*</span></label>
                                <input type="number"
                                       id="price_max"
                                       wire:model.defer="price_max"
                                       class="form-control @error('price_max') is-invalid @enderror"
                                       min="0">
                                @error('price_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select wire:model.defer="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="draft">Draft</option>
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="form-group mb-0">
                                <button type="submit"
                                        class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Save
                                </button>
                                <a href="{{ route('tour-groups.index') }}"
                                   class="btn btn-secondary waves-effect waves-light">
                                    <i class="bx bx-x font-size-16 align-middle mr-1"></i>
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xl-6">
                <!-- Services -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Дополнительные услуги</h5>

                        @forelse($services as $service)
                            <div class="row align-items-center mb-2">
                                <div class="col-auto">
                                    <input type="checkbox"
                                           wire:model.live="serviceChecked.{{ $service->id }}"
                                           id="srv_{{ $service->id }}">
                                </div>

                                <div class="col">
                                    <label for="srv_{{ $service->id }}" class="mb-0">
                                        {{ $service->name }} ({{ $service->type }})
                                    </label>
                                </div>

                                <div class="col-auto">
                                    <input type="number"
                                           class="form-control form-control-sm"
                                           style="width:120px"
                                           wire:model="servicePrices.{{ $service->id }}"
                                           min="0"
                                           step="1"
                                        {{ empty($serviceChecked[$service->id]) ? 'disabled' : '' }}>
                                    <small class="text-muted">цена (¢)</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Нет доступных услуг.</p>
                        @endforelse
                    </div>
                </div>
        </div>
    </div>
</div>


