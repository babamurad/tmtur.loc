<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Create Tour Category</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('tour-categories.index') }}">Tour Categories</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Tour Category details</h5>

                        <form wire:submit.prevent="save">
                            {{-- Title --}}
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="title"
                                       wire:model.defer="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="e.g. City Tour Category"
                                       wire:keyup="generateSlug">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text"
                                       id="slug"
                                       wire:model.defer="slug"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       placeholder="e.g. city-tour-category">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Content --}}
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea id="content"
                                          wire:model.defer="content"
                                          class="form-control @error('content') is-invalid @enderror"
                                          placeholder="e.g. Description of the tour category"></textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Image --}}
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file"
                                       id="image"
                                       wire:model.defer="image"
                                       class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

                            {{-- Buttons --}}
                            <div class="form-group mb-0">
                                <button type="submit"
                                        class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Save
                                </button>
                                <a href="{{ route('tour-categories.index') }}"
                                   class="btn btn-secondary waves-effect waves-light">
                                    <i class="bx bx-x font-size-16 align-middle mr-1"></i>
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>