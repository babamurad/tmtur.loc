<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать тур</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Туры</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Левая колонка – основные данные -->
            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Детали тура</h5>

                        <form wire:submit.prevent="save">
                            <div class="row">
                                <!-- Название -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Название <span class="text-danger">*</span></label>
                                        <input type="text" wire:model.debounce.300ms="title"
                                               class="form-control @error('title') is-invalid @enderror">
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        <small class="form-text text-muted">Slug: {{ $slug }}</small>
                                    </div>
                                </div>

                                <!-- Категория -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Категория <span class="text-danger">*</span></label>
                                        <select wire:model.defer="category_id"
                                                class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">-- выберите категорию --</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Цена -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Цена (в копейках) <span class="text-danger">*</span></label>
                                        <input type="number" wire:model.defer="base_price_cents"
                                               class="form-control @error('base_price_cents') is-invalid @enderror">
                                        @error('base_price_cents') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Длительность -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Длительность (дней) <span class="text-danger">*</span></label>
                                        <input type="number" wire:model.defer="duration_days"
                                               class="form-control @error('duration_days') is-invalid @enderror">
                                        @error('duration_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <!-- Краткое описание (Quill) -->
                                <div class="col-md-12" wire:ignore>
                                    <div class="form-group">
                                        <label>Краткое описание</label>
                                        <div id="quill-editor-short-desc" style="height: 200px;"></div>
                                        @error('short_description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Программа тура -->
                            <h5 class="card-title mb-4 mt-4">Программа тура</h5>
                            <button type="button" class="btn btn-sm btn-outline-success mb-2"
                                    wire:click="addItineraryDay">+ Добавить день</button>
                            @foreach($itinerary_days as $idx => $day)
                                @if(($day['_delete'] ?? false)) @continue @endif
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between">
                                        <span>День {{ $day['day_number'] }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                wire:click="removeItineraryDay({{ $idx }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" placeholder="№"
                                                       wire:model.defer="itinerary_days.{{ $idx }}.day_number" min="1">
                                                @error("itinerary_days.{$idx}.day_number") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" placeholder="Заголовок дня"
                                                       wire:model.defer="itinerary_days.{{ $idx }}.title">
                                                @error("itinerary_days.{$idx}.title") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="3" placeholder="Описание дня"
                                                          wire:model.defer="itinerary_days.{{ $idx }}.description"></textarea>
                                                @error("itinerary_days.{$idx}.description") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        @if(!empty($day['id']))
                                            <input type="hidden" wire:model="itinerary_days.{{ $idx }}.id">
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- Что включено / не включено -->
                            <h5 class="card-title mb-4 mt-4">Что включено / не включено</h5>
                            <button type="button" class="btn btn-sm btn-outline-success mb-2"
                                    wire:click="addInclusion">+ Добавить пункт</button>
                            @foreach($inclusions as $idx => $inc)
                                @if(($inc['_delete'] ?? false)) @continue @endif
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between">
                                        <span>Пункт {{ $idx + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                wire:click="removeInclusion({{ $idx }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="form-control"
                                                        wire:model.defer="inclusions.{{ $idx }}.type">
                                                    <option value="included">Включено</option>
                                                    <option value="not_included">Не включено</option>
                                                </select>
                                                @error("inclusions.{$idx}.type") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" placeholder="Описание"
                                                       wire:model.defer="inclusions.{{ $idx }}.item">
                                                @error("inclusions.{$idx}.item") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        @if(!empty($inc['id']))
                                            <input type="hidden" wire:model="inclusions.{{ $idx }}.id">
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- Размещение -->
                            <h5 class="card-title mb-4 mt-4">Размещение</h5>
                            <button type="button" class="btn btn-sm btn-outline-success mb-2"
                                    wire:click="addAccommodation">+ Добавить отель</button>
                            @foreach($accommodations as $idx => $acc)
                                @if(($acc['_delete'] ?? false)) @continue @endif
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between">
                                        <span>Отель {{ $idx + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                wire:click="removeAccommodation({{ $idx }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Локация"
                                                       wire:model.defer="accommodations.{{ $idx }}.location">
                                                @error("accommodations.{$idx}.location") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control" placeholder="Кол-во ночей" min="1"
                                                       wire:model.defer="accommodations.{{ $idx }}.nights_count">
                                                @error("accommodations.{$idx}.nights_count") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Стандарт"
                                                       wire:model.defer="accommodations.{{ $idx }}.standard_options">
                                                @error("accommodations.{$idx}.standard_options") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" placeholder="Комфорт"
                                                       wire:model.defer="accommodations.{{ $idx }}.comfort_options">
                                                @error("accommodations.{$idx}.comfort_options") <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                        @if(!empty($acc['id']))
                                            <input type="hidden" wire:model="accommodations.{{ $idx }}.id">
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- Кнопки -->
                            <div class="form-group mb-0 mt-4">
                                <button type="submit" class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="fas fa-save font-size-16 align-middle mr-1"></i>Сохранить
                                </button>
                                <a href="{{ route('tours.index') }}"
                                   class="btn btn-secondary waves-effect waves-light">
                                    <i class="fas fa-times font-size-16 align-middle mr-1"></i>Отмена
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Правая колонка – изображение и публикация -->
            <div class="col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Изображение</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('newimage') is-invalid @enderror"
                                       id="image" wire:model="newimage" accept="image/*">
                                <label class="custom-file-label" for="image">
                                    {{ $newimage ? $newimage->getClientOriginalName() : ($image ? basename($image) : 'Выберите файл') }}
                                </label>
                                @error('newimage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Превью -->
                        <div class="position-relative mb-3" style="height:200px;">
                            <div wire:loading.remove wire:target="newimage">
                                @if($newimage)
                                    <img src="{{ $newimage->temporaryUrl() }}" alt="Preview"
                                         class="img-fluid rounded" style="max-height:200px;object-fit:cover;">
                                @elseif($image)
                                    <img src="{{ asset('uploads/'.$image) }}" alt="Current"
                                         class="img-fluid rounded" style="max-height:200px;object-fit:cover;">
                                @else
                                    <img src="{{ asset('assets/images/media/sm-5.jpg') }}" alt="Placeholder"
                                         class="img-fluid rounded" style="max-height:200px;object-fit:cover;">
                                @endif
                            </div>
                        </div>

                        <!-- Опубликовано -->
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_published"
                                       wire:model.defer="is_published">
                                <label class="custom-control-label" for="is_published">Опубликовано</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quill CSS --}}
@push('quill-css')
    <link href="{{ asset('vendor/livewire-quill/quill.snow.min.css') }}" rel="stylesheet">
@endpush

{{-- Quill JS + инициализация --}}
@push('quill-js')
    <script src="{{ asset('vendor/livewire-quill/quill.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editor = new Quill('#quill-editor-short-desc', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold','italic','underline','strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link','clean']
                    ]
                }
            });

            /* начальное значение из модели */
            editor.root.innerHTML = @js($short_description);

            /* синхронизация с Livewire */
            editor.on('text-change', () => {
            @this.set('short_description', editor.root.innerHTML);
            });
        });
    </script>
@endpush
