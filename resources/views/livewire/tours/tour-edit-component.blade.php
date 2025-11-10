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
            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Детали тура</h5>

                        <form wire:submit.prevent="saveAndClose">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Название <span class="text-danger">*</span></label>
                                        <input type="text" wire:model.debounce.300ms="title"
{{--                                               wire:input="generateSlug"--}}
                                               class="form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Slug (URL-адрес)</label>
                                        <input type="text" wire:model.defer="slug"
                                               class="form-control @error('slug') is-invalid @enderror">
                                        @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group" wire:ignore>
                                        <label for="category_ids_select2">Категории <span class="text-danger">*</span></label>
                                        <select id="category_ids_select2"
                                                class="form-control select2 @error('category_id') is-invalid @enderror"
                                                name="category_id[]"
                                                multiple="multiple">
                                            @foreach($categories as $category)
                                                {{-- Проверяем, есть ли ID категории в массиве $category_id --}}
                                                <option value="{{ $category->id }}"
                                                        @if(in_array($category->id, $category_id)) selected @endif>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Базовая цена, $ <span class="text-danger">*</span></label>
                                        <input type="number" wire:model.defer="base_price_cents"
                                               class="form-control @error('base_price_cents') is-invalid @enderror">
                                        @error('base_price_cents')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Длительность, дней <span class="text-danger">*</span></label>
                                        <input type="number" wire:model.defer="duration_days"
                                               class="form-control @error('duration_days') is-invalid @enderror">
                                        @error('duration_days')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Краткое описание</label>
                                        <div wire:ignore>
                                            <div id="quill-editor-short-desc" style="height: 250px;"></div>
                                        </div>
                                        @error('short_description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <span wire:loading.remove>Сохранить и закрыть</span>
                                    <span wire:loading>Обновление...</span>
                                </button>
                                <button class="btn btn-success waves-effect waves-light" wire:click.prevent="save">
                                    <span wire:loading.remove>Сохранить изменения</span>
                                    <span wire:loading>Обновление...</span>
                                </button>
                                <a href="{{ route('tours.index') }}" class="btn btn-secondary ml-2">Отмена</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Медиа и Статус</h5>

                        {{-- СТАРЫЙ БЛОК БЫЛ ЗАМЕНЕН НА ЭТОТ НОВЫЙ БЛОК --}}
                        <div class="form-group">
                            <label for="newimage">Изображение</label>

                            @if ($image && !$newimage)
                                <div class="mb-3">
                                    <img src="{{ $image }}" alt="Текущее изображение" class="img-fluid rounded">
                                </div>
                            @endif

                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input @error('newimage') is-invalid @enderror"
                                       id="newimage"
                                       wire:model="newimage" {{-- Используем wire:model без .defer для превью --}}
                                       accept="image/*">

                                <label class="custom-file-label" for="newimage">
                                    {{-- Динамический текст: Имя нового файла, если он выбран --}}
                                    {{ $newimage ? $newimage->getClientOriginalName() : 'Выберите файл' }}
                                </label>
                                @error('newimage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            @if ($newimage)
                                <p class="mt-2">Предпросмотр нового файла:</p>
                                <img src="{{ $newimage->temporaryUrl() }}" class="img-fluid rounded mb-3">
                            @endif
                        </div>
                        {{-- КОНЕЦ ИСПРАВЛЕННОГО БЛОКА --}}

                        <div class="form-group mt-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_published"
                                       wire:model.defer="is_published">
                                <label class="custom-control-label" for="is_published">Опубликовано</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Section: Itinerary Days -->
                        <h5 class="card-title mb-4 mt-4">Программа тура</h5>
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addItineraryDay">+ Добавить день</button>
                            @foreach($itinerary_days as $index => $day)
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>День {{ $index + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeItineraryDay({{ $index }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="number" wire:model.defer="itinerary_days.{{ $index }}.day_number" class="form-control" placeholder="№" min="1">
                                                @error("itinerary_days.{$index}.day_number") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" wire:model.defer="itinerary_days.{{ $index }}.title" class="form-control" placeholder="Заголовок дня">
                                                @error("itinerary_days.{$index}.title") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <textarea wire:model.defer="itinerary_days.{{ $index }}.description" class="form-control" placeholder="Описание дня" rows="3"></textarea>
                                                @error("itinerary_days.{$index}.description") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Section: Inclusions -->
                        <h5 class="card-title mb-4 mt-4">Что включено / не включено</h5>
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addInclusion">+ Добавить пункт</button>
                            @foreach($inclusions as $index => $inc)
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>Пункт {{ $index + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeInclusion({{ $index }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select wire:model.defer="inclusions.{{ $index }}.type" class="form-control">
                                                    <option value="included">Включено</option>
                                                    <option value="not_included">Не включено</option>
                                                </select>
                                                @error("inclusions.{$index}.type") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" wire:model.defer="inclusions.{{ $index }}.item" class="form-control" placeholder="Описание">
                                                @error("inclusions.{$index}.item") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Section: Accommodations -->
                        <h5 class="card-title mb-4 mt-4">Размещение</h5>
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-outline-success mb-2" wire:click="addAccommodation">+ Добавить отель</button>
                            @foreach($accommodations as $index => $acc)
                                <div class="card mb-2">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span>Отель {{ $index + 1 }}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger" wire:click="removeAccommodation({{ $index }})">Удалить</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" wire:model.defer="accommodations.{{ $index }}.location" class="form-control" placeholder="Локация">
                                                @error("accommodations.{$index}.location") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" wire:model.defer="accommodations.{{ $index }}.nights_count" class="form-control" placeholder="Кол-во ночей" min="1">
                                                @error("accommodations.{$index}.nights_count") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <input type="text" wire:model.defer="accommodations.{{ $index }}.standard_options" class="form-control" placeholder="Стандарт">
                                                @error("accommodations.{$index}.standard_options") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" wire:model.defer="accommodations.{{ $index }}.comfort_options" class="form-control" placeholder="Комфорт">
                                                @error("accommodations.{$index}.comfort_options") <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Select2 CSS and JS Push --}}
@push('select2')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        // Инициализация Select2 и синхронизация с Livewire
        $(document).ready(function() {
            let select2 = $('#category_ids_select2');
            select2.select2();

            // Отправляем выбранные значения в Livewire при изменении
            select2.on('change', function (e) {
                let data = $(this).val() || [];
            @this.set('category_id', data);
            });

            // Обновление Select2 при изменении в Livewire (если нужно)
            Livewire.hook('element.updated', (el, component) => {
                if (el.id === 'category_ids_select2') {
                    $(el).select2();
                }
            });
        });
    </script>
@endpush

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
                        [{ 'font': [] }, { 'size': [] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'header': 1 }, { 'header': 2 }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean']
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
