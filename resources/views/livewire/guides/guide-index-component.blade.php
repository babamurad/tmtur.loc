<div class="page-content">
    <div class="container-fluid">

        {{-- заголовок + кнопка «Добавить» --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Гиды</h4>
                    <a href="{{ route('guides.create') }}" class="btn btn-success waves-effect waves-light">
                        <i class="bx bx-plus-circle font-size-16 align-middle mr-1"></i> Добавить
                    </a>
                </div>
            </div>
        </div>

        {{-- панель поиска и таблица --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- поиск и per-page --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" wire:model.live.debounce.300ms="search"
                                           class="form-control" placeholder="Поиск по имени, специализации, языку…">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <button class="btn btn-outline-secondary waves-effect waves-light btn-sm me-2" wire:click="toggleTrashed">
                                        <i class="fas fa-trash-alt me-1"></i> 
                                        {{ $showTrashed ? 'Назад к списку' : 'Корзина (' . \App\Models\Guide::onlyTrashed()->count() . ')' }}
                                    </button>

                                    <span class="text-muted small px-1">Показать</span>
                                    <select class="form-select form-select-sm" wire:model.live="perPage" style="width: auto;">
                                        <option value="8">8</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    <span class="text-muted small px-1">из {{ $guides->total() }} результатов</span>
                                </div>
                            </div>
                        </div>

                        {{-- таблица --}}
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th style="width: 60px">#</th>
                                    <th>Фото</th>
                                    <th>Имя</th>
                                    <th>Языки</th>
                                    <th>Специализация</th>
                                    <th>Стаж</th>
                                    <th>Активен</th>
                                    <th style="width: 120px" class="text-center">Действия</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($guides as $g)
                                    <tr>
                                        <td>{{ $g->id }}</td>
                                        <td>
                                            @if($g->image)
                                                <img src="{{ asset('uploads/' . $g->image) }}" class="rounded" width="40" height="40" alt="">
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $g->name }}</td>
                                        <td>{{ implode(', ', $g->languages) }}</td>
                                        <td>{{ $g->specialization ?: '—' }}</td>
                                        <td>{{ $g->experience_years }} лет</td>
                                        <td>
                        <span class="badge badge-soft-{{ $g->is_active ? 'success' : 'secondary' }}">
                          {{ $g->is_active ? 'Да' : 'Нет' }}
                        </span>
                                        </td>
                                        <td class="text-center">
                                            @if($showTrashed)
                                                <button class="btn btn-sm btn-outline-success waves-effect waves-light"
                                                        wire:click="restore({{ $g->id }})" title="Восстановить">
                                                    <i class="fas fa-trash-restore"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                        wire:click="delete({{ $g->id }})" title="Удалить навсегда">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @else
                                                <a href="{{ route('guides.edit', $g->id) }}"
                                                   class="btn btn-sm btn-outline-primary waves-effect waves-light">
                                                    <i class="bx bx-pencil"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                        wire:click="delete({{ $g->id }})">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">Нет записей</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- пагинация --}}
                        @if($guides->hasPages())
                            <div class="pt-3">
                                {{ $guides->links('pagination::bootstrap-4') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
