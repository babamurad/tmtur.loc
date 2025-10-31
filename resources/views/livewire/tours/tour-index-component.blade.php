<div class="page-content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 1. Заголовок + кнопка «Создать» на одной строке --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Tours</h4>

                    <a href="{{ route('tours.create') }}"
                       class="btn btn-success waves-effect waves-light">
                        <i class="fas fa-plus-circle font-size-16 align-middle mr-1"></i>
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
                                        placeholder="Search tours…"
                                    >
                                </div>
                            </div>




                            {{-- можно сюда добавить фильтры или экспорт --}}
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted small">Show</span>
                                        <select class="form-select form-select-sm mx-2" wire:model.live="perPage" style="width: auto;">
                                            <option value="12">12</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                        </select>
                                        <span class="text-muted small">of {{ $tours->total() }} results</span>
                                    </div>
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
                                <th>Title</th> <!-- Заголовок оставлен для будущего использования -->
                                <th>Category</th>
                                <th>Base Price</th>
                                <th>Duration (Days)</th>
                                <th style="width: 120px" class="text-center">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($tours as $tour)
                                <tr>
                                    <td>{{ $tour->id }}</td>
                                    <td>
                                        <span class="font-weight-semibold">
                                            {{ $tour->title }}
                                        </span>

                                    </td>
                                    <td>
                                         <span class="font-weight-semibold">
                                            @if($tour->getFirstMediaUrl())
                                                <img src="{{ $tour->getFirstMediaUrl() }}" alt="{{ $tour->title }}" class="img-fluid rounded w-25">
                                            @else
                                                 <img src="{{ asset('images/default-tour.jpg') }}" alt="Default image" class="img-fluid">
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                            <span class="text-muted">
                                                {{ $tour->category->title ?? 'N/A' }} <!-- Обновляем связь -->
                                            </span>
                                    </td>
                                    <td>
                                            <span class="text-muted">
                                                {{ number_format($tour->base_price_cents / 100, 2) }}
                                            </span>
                                    </td>
                                    <td>
                                            <span class="text-muted">
                                                {{ $tour->duration_days }}
                                            </span>
                                    </td>

                                    {{-- Кнопки действий --}}
                                    <td class="text-center">
                                        <a href="{{ route('tours.edit', $tour->id) }}"
                                           class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                           data-toggle="tooltip" title="Edit">
                                            {{--<i class="bx bx-pencil font-size-14"></i>--}} <!-- Заменим иконку -->
                                            <i class="fas fa-edit font-size-14"></i> <!-- Используем Font Awesome -->
                                        </a>

                                        <button wire:click="delete({{ $tour->id }})" class="btn btn-sm btn-outline-danger waves-effect waves-light">
                                            {{--<i class="bx bx-trash font-size-14"></i>--}} <!-- Заменим иконку -->
                                            <i class="fas fa-trash-alt font-size-14"></i> <!-- Используем Font Awesome -->
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4"> <!-- Обновлено colspan -->
                                        No tours found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>{{-- /.table-responsive --}}

                    {{-- 2.3 Пагинация --}}
                    @if($tours->hasPages())
                        <div class="pt-3">
                            {{ $tours->links('pagination::bootstrap-4') }}
                        </div>
                    @endif

                </div>{{-- /.card-body --}}
            </div>{{-- /.card --}}
        </div>{{-- /.col-12 --}}
    </div>{{-- /.row --}}

</div>{{-- container-fluid --}}
</div>
