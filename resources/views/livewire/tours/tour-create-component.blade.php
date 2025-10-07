<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Create Tour</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tours</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Tour details</h5>

                        <form wire:submit.prevent="save">
                            <div class="row">
                                
                            </div>
                            {{-- Title --}}
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                    id="title"
                                    wire:model.debounce.300ms="title"
                                    wire:input="generateSlug"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="e.g. City Tour">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <span>Slug: {{ $slug }}</span>
                            </div>
                            

                            {{-- Category --}}
                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select wire:model.defer="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                    <option value="">-- Choose category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="base_price_cents">Price <span class="text-danger">*</span> </label>
                                <input type="number"
                                       wire:model.defer="base_price_cents"
                                       class="form-control @error('base_price_cents') is-invalid @enderror"
                                       placeholder="e.g. 1500">
                                @error('base_price_cents')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Duration Days --}}
                            <div class="form-group">
                                <label for="duration_days">Duration (days) <span class="text-danger">*</span> </label>
                                <input type="number"
                                       wire:model.defer="duration_days"
                                       class="form-control @error('duration_days') is-invalid @enderror"
                                       placeholder="e.g. 5">
                                @error('duration_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Content --}}
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea id="content"
                                          wire:model.defer="content"
                                          class="form-control @error('content') is-invalid @enderror"
                                          placeholder="e.g. Description of the tour"></textarea>
                                @error('content')
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
                                <a href="{{ route('tours.index') }}"
                                   class="btn btn-secondary waves-effect waves-light">
                                    <i class="bx bx-x font-size-16 align-middle mr-1"></i>
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                                                    {{-- Image --}}
                                            <div class="form-group">
                                                <label for="image">Выберите изображение</label>
                                                <div class="custom-file">
                                                    <input type="file"
                                                        class="custom-file-input @error('image') is-invalid @enderror"
                                                        id="image"
                                                        wire:model="image"
                                                        accept="image/*">
                                                    <label class="custom-file-label" for="image">
                                                        @if ($image)
                                                            {{ $image->getClientOriginalName() }}
                                                        @else
                                                            Выбрать изображение
                                                        @endif
                                                    </label>
                                                    @error('image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                                {{-- контейнер 200 px --}}
                                                <div class="position-relative mb-3" style="height:200px;">

                                                    {{-- спиннер во время загрузки --}}
                                                    <!-- <div wire:loading wire:target="image" class="spinner-border text-primary m-2 top-50 start-50">
                                                        <span class="sr-only"></span>
                                                    </div> -->

                                                    {{-- картинка или плейсхолдер --}}
                                                    <div wire:loading.remove wire:target="image">
                                                        @if ($image)
                                                            {{-- свежезагруженное изображение --}}
                                                            <img class="img-fluid rounded"
                                                                style="max-height:200px; object-fit:cover;"
                                                                src="{{ $image->temporaryUrl() }}"
                                                                alt="Preview">
                                                        @else
                                                            {{-- постоянное изображение, если нужно --}}
                                                            <img class="img-fluid rounded"
                                                                style="max-height:200px; object-fit:cover;"
                                                                src="{{ asset('assets/images/media/sm-5.jpg') }}"
                                                                alt="Placeholder">
                                                        @endif
                                                    </div>
                                                </div>

                                            {{-- Is Published --}}
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox"
                                                        class="custom-control-input"
                                                        id="is_published"
                                                        wire:model.defer="is_published">
                                                    <label class="custom-control-label" for="is_published">Is Published</label>
                                                </div>
                                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
