<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Edit Carousel Slide</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('carousels.index') }}">Carousel Slides</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save">
            <div class="row">
                {{-- Main Content Column --}}
                <div class="col-lg-8">
                    {{-- Content Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-edit-alt font-size-18 align-middle mr-1 text-primary"></i>
                                Content
                            </h5>

                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#lang-{{ config('app.fallback_locale') }}" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">{{ strtoupper(config('app.fallback_locale')) }}</span>
                                    </a>
                                </li>
                                @foreach(config('app.available_locales') as $locale)
                                    @continue($locale === config('app.fallback_locale'))
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#lang-{{ $locale }}" role="tab">
                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content">
                                {{-- Default Language Tab --}}
                                <div class="tab-pane active" id="lang-{{ config('app.fallback_locale') }}" role="tabpanel">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text"
                                            id="title"
                                            wire:model.defer="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="e.g. Amazing Destinations">
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description"
                                                  wire:model.defer="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  rows="3"
                                                  placeholder="e.g. Discover the world with us"></textarea>
                                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="button_text">Button Text</label>
                                        <input type="text"
                                            id="button_text"
                                            wire:model.defer="button_text"
                                            class="form-control @error('button_text') is-invalid @enderror"
                                            placeholder="e.g. Learn More">
                                        @error('button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- Other Language Tabs --}}
                                @foreach(config('app.available_locales') as $locale)
                                    @continue($locale === config('app.fallback_locale'))
                                    <div class="tab-pane" id="lang-{{ $locale }}" role="tabpanel">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text"
                                                   wire:model.defer="trans.{{ $locale }}.title"
                                                   class="form-control"
                                                   placeholder="Title in {{ strtoupper($locale) }}">
                                            @error("trans.$locale.title") <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea wire:model.defer="trans.{{ $locale }}.description"
                                                      class="form-control"
                                                      rows="3"
                                                      placeholder="Description in {{ strtoupper($locale) }}"></textarea>
                                            @error("trans.$locale.description") <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Button Text</label>
                                            <input type="text"
                                                   wire:model.defer="trans.{{ $locale }}.button_text"
                                                   class="form-control"
                                                   placeholder="Button text in {{ strtoupper($locale) }}">
                                            @error("trans.$locale.button_text") <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Button Link Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-link font-size-18 align-middle mr-1 text-primary"></i>
                                Button Link
                            </h5>
                            <div class="form-group mb-0">
                                <label for="button_link">URL</label>
                                <input type="text"
                                    id="button_link"
                                    wire:model.defer="button_link"
                                    class="form-control @error('button_link') is-invalid @enderror"
                                    placeholder="e.g. /tours or https://example.com">
                                @error('button_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="form-text text-muted">Leave empty if no button link is needed</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="col-lg-4">
                    {{-- Image Preview --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-image font-size-18 align-middle mr-1 text-primary"></i>
                                Image
                            </h5>
                            
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input @error('newImage') is-invalid @enderror"
                                        id="newImage"
                                        wire:model="newImage"
                                        accept="image/*">
                                    <label class="custom-file-label" for="newImage">
                                        @if ($newImage)
                                            {{ $newImage->getClientOriginalName() }}
                                        @else
                                            Choose image
                                        @endif
                                    </label>
                                    @error('newImage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @if ($newImage)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>New Image Preview:</small></p>
                                    <img src="{{ $newImage->temporaryUrl() }}" class="img-fluid rounded shadow-sm" alt="New image preview">
                                </div>
                            @elseif ($currentImage)
                                <div class="mt-3">
                                    <p class="text-muted mb-2"><small>Current Image:</small></p>
                                    <img src="{{ asset('uploads/' . $currentImage) }}" class="img-fluid rounded shadow-sm" alt="Current image">
                                </div>
                            @else
                                <div class="mt-3 text-center p-4 bg-light rounded">
                                    <i class="bx bx-image-add font-size-48 text-muted"></i>
                                    <p class="text-muted mb-0 mt-2">No image selected</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Settings --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bx bx-cog font-size-18 align-middle mr-1 text-primary"></i>
                                Settings
                            </h5>

                            <div class="form-group">
                                <label for="sort_order">
                                    Sort Order <span class="text-danger">*</span>
                                    <i class="bx bx-info-circle text-muted" data-toggle="tooltip" title="Lower numbers appear first"></i>
                                </label>
                                <input type="number"
                                    id="sort_order"
                                    wire:model.defer="sort_order"
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                    min="0">
                                @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-0">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                        class="custom-control-input"
                                        id="is_active"
                                        wire:model.defer="is_active">
                                    <label class="custom-control-label" for="is_active">
                                        <strong>Active</strong>
                                        <br>
                                        <small class="text-muted">Show this slide on the website</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="card">
                        <div class="card-body">
                            <button type="submit"
                                    class="btn btn-success btn-block waves-effect waves-light">
                                <i class="bx bx-check-double font-size-16 align-middle mr-1"></i>
                                Save Changes
                            </button>
                            <a href="{{ route('carousels.index') }}"
                               class="btn btn-secondary btn-block waves-effect waves-light mt-2">
                                <i class="bx bx-x font-size-16 align-middle mr-1"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
