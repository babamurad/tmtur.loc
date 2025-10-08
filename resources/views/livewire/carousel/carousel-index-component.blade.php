<div class="page-content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 1. Заголовок + кнопка «Создать» на одной строке --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Carousel Slides</h4>

                    <a href="{{ route('carousels.create') }}"
                       class="btn btn-success waves-effect waves-light">
                        <i class="bx bx-plus-circle font-size-16 align-middle mr-1"></i>
                        Create
                    </a>
                </div>
            </div>
        </div>

        {{-- 2. Панель «поиск + таблица» --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- 2.1 Поисковая строка --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input
                                        type="text"
                                        wire:model.live.debounce.300ms="search"
                                        class="form-control"
                                        placeholder="Search carousel slides…"
                                    >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted small">Show</span>
                                        <select class="form-select form-select-sm mx-2" wire:model.live="perPage" style="width: auto;">
                                            <option value="8">8</option>
                                            <option value="15">15</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                        <span class="text-muted small">of {{ $carouselSlides->total() }} results</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2.2 Таблица --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Sort Order</th>
                                        <th>Active</th>
                                        <th style="width: 120px" class="text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($carouselSlides as $slide)
                                    <tr>
                                        <td>{{ $slide->id }}</td>
                                        <td>
                                            @if($slide->image)
                                                <img class="rounded" src="{{ asset('uploads/' . $slide->image) }}" alt="{{ $slide->title }}" height="50">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-weight-semibold">
                                                {{ $slide->title }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ Str::limit($slide->description, 50) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $slide->sort_order }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($slide->is_active)
                                                <span class="badge badge-soft-success font-size-12">Active</span>
                                            @else
                                                <span class="badge badge-soft-danger font-size-12">Inactive</span>
                                            @endif
                                        </td>

                                        {{-- Кнопки действий --}}
                                        <td class="text-center">
                                            <a href="{{ route('carousels.edit', $slide->id) }}"
                                               class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                               data-toggle="tooltip" title="Edit">
                                                <i class="bx bx-pencil font-size-14"></i>
                                            </a>

                                            <button wire:click="delete({{ $slide->id }})" class="btn btn-sm btn-outline-danger waves-effect waves-light">
                                                <i class="bx bx-trash font-size-14"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No carousel slides found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>{{-- /.table-responsive --}}

                        {{-- 2.3 Пагинация --}}
                        @if($carouselSlides->hasPages())
                        <div class="pt-3">
                            {{ $carouselSlides->links('pagination::bootstrap-4') }}
                        </div>
                        @endif

                    </div>{{-- /.card-body --}}
                </div>{{-- /.card --}}
            </div>{{-- /.col-12 --}}
        </div>{{-- /.row --}}

    </div>{{-- container-fluid --}}
</div>
