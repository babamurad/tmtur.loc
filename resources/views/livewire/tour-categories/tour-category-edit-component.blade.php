<div class="page-content">
    <div class="container-fluid">




        <div class="row">

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Tour Category Details</h4>

                        <form wire:submit.prevent="save">
                            
                            {{-- Language Tabs --}}
                            <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                @foreach(config('app.available_locales') as $locale)
                                    <li class="nav-item">
                                        <a class="nav-link @if($loop->first) active @endif" 
                                           data-toggle="tab" 
                                           href="#tab_{{ $locale }}" 
                                           role="tab">
                                            <span class="d-none d-sm-block">{{ strtoupper($locale) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Tab Content --}}
                            <div class="tab-content p-3 text-muted">
                                @foreach(config('app.available_locales') as $locale)
                                    <div class="tab-pane @if($loop->first) active @endif" 
                                         id="tab_{{ $locale }}" 
                                         role="tabpanel">
                                        
                                        {{-- Title --}}
                                        <div class="form-group">
                                            <label for="title_{{ $locale }}">Title ({{ strtoupper($locale) }})</label>
                                            <input type="text"
                                                   id="title_{{ $locale }}"
                                                   @if($locale === config('app.fallback_locale'))
                                                       wire:model="trans.{{ $locale }}.title"
                                                       wire:keyup="generateSlug"
                                                   @else
                                                       wire:model.defer="trans.{{ $locale }}.title"
                                                   @endif
                                                   class="form-control @error("trans.$locale.title") is-invalid @enderror">
                                            @error("trans.$locale.title")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Content --}}
                                        <div class="form-group">
                                            <label>Content ({{ strtoupper($locale) }})</label>
                                            <x-quill wire:model.defer="trans.{{ $locale }}.content" />
                                            @error("trans.$locale.content")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Settings</h4>

                        {{-- Image --}}
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file"
                                   id="image"
                                   wire:model="image"
                                   class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($image)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                                </div>
                            @endif
                        </div>

                        {{-- Slug --}}
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text"
                                   id="slug"
                                   readonly
                                   class="form-control @error('slug') is-invalid @enderror"
                                   wire:model="slug"
                                   placeholder="Auto-generated">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Is Published --}}
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       id="is_published"
                                       wire:model="is_published">
                                <label class="custom-control-label" for="is_published">Is Published</label>
                            </div>
                        </div>

                        <hr>

                        {{-- Buttons --}}
                        <div class="form-group mb-0 text-center">
                            <button type="button" wire:click="save"
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
