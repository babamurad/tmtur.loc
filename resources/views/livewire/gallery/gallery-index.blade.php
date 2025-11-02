<div class="page-content">
    <div class="container-fluid">

        {{-- Заголовок + кнопка «Добавить» --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Галерея</h4>
                    <a href="{{ route('gallery.create') }}" class="btn btn-success waves-effect waves-light">
                        <i class="bx bx-plus-circle font-size-16 align-middle mr-1"></i> Добавить
                    </a>
                </div>
            </div>
        </div>

        {{-- Панель поиска и таблица --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Поиск и per-page --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text"
                                           wire:model.live.debounce.300ms="search"
                                           class="form-control"
                                           placeholder="Поиск по названию, местоположению, фотографу...">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <span class="text-muted small px-1">Show</span>
                                    <select class="form-select form-select-sm"
                                            wire:model.live="perPage"
                                            style="width: auto;">
                                        <option value="8">8</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    <span class="text-muted small px-1">of {{ $galleries->total() }} results</span>
                                </div>
                            </div>
                        </div>

                        {{-- Таблица --}}
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th style="width: 60px">#</th>
                                    <th>Фото</th>
                                    <th>Название</th>
                                    <th>Местоположение</th>
                                    <th>Фотограф</th>
                                    <th>Избранное</th>
                                    <th style="width: 120px" class="text-center">Действия</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($galleries as $photo)
                                    <tr>
                                        <td>{{ $photo->order }}</td>

                                        {{-- Превью --}}
                                        <td>
                                            @if($photo->file_path)
                                                <img src="{{ asset('uploads/'.$photo->file_path) }}"
                                                     class="rounded"
                                                     width="40" height="40" alt="{{ $photo->alt_text }}">
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td>{{ $photo->title ?: 'Без названия' }}</td>
                                        <td>{{ $photo->location ?: '—' }}</td>
                                        <td>{{ $photo->photographer ?: '—' }}</td>

                                        <td>
                        <span class="badge badge-soft-{{ $photo->is_featured ? 'success' : 'secondary' }}">
                          {{ $photo->is_featured ? 'Да' : 'Нет' }}
                        </span>
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('gallery.edit', $photo->id) }}"
                                               class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    wire:click="delete({{ $photo->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            Нет фотографий
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Пагинация --}}
                        @if($galleries->hasPages())
                            <div class="pt-3">
                                {{ $galleries->links('pagination::bootstrap-4') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
