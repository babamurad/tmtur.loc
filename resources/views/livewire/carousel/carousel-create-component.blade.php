<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Create Carousel Slide</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('carousels.index') }}">Carousel Slides</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Slide details</h5>

                        <form wire:submit.prevent="save">
                            {{-- Title --}}
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                    id="title"
                                    wire:model.defer="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="e.g. Amazing Destinations">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Description --}}
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description"
                                          wire:model.defer="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="e.g. Discover the world with us"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Button Text --}}
                            <div class="form-group">
                                <label for="button_text">Button Text</label>
                                <input type="text"
                                    id="button_text"
                                    wire:model.defer="button_text"
                                    class="form-control @error('button_text') is-invalid @enderror"
                                    placeholder="e.g. Learn More">
                                @error('button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Button Link --}}
                            <div class="form-group">
                                <label for="button_link">Button Link</label>
                                <input type="text"
                                    id="button_link"
                                    wire:model.defer="button_link"
                                    class="form-control @error('button_link') is-invalid @enderror"
                                    placeholder="e.g. /tours">
                                @error('button_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Sort Order --}}
                            <div class="form-group">
                                <label for="sort_order">Sort Order <span class="text-danger">*</span></label>
                                <input type="number"
                                    id="sort_order"
                                    wire:model.defer="sort_order"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    min="0">
                                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Image --}}
                            <div class="form-group">
                                <label for="image">Image <span class="text-danger">*</span></label>
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
                                            Choose image
                                        @endif
                                    </label>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($image)
                                    <div class="mt-2">
                                        <img src="{{ $image->temporaryUrl() }}" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                @endif
                            </div>

                            {{-- Is Active --}}
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                        class="custom-control-input"
                                        id="is_active"
                                        wire:model.defer="is_active">
                                    <label class="custom-control-label" for="is_active">Is Active</label>
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="form-group mb-0">
                                <button type="submit"
                                        class="btn btn-success waves-effect waves-light mr-2">
                                    <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                    Save
                                </button>
                                <a href="{{ route('carousels.index') }}"
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
