<div class="page-content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 1. Заголовок + кнопка «Создать» на одной строке --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Группы туров</h4>

                    <a href="{{ route('tour-groups.create') }}"
                       class="btn btn-success waves-effect waves-light">
                        <i class="bx bx-plus-circle font-size-16 align-middle mr-1"></i>
                        Создать
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
                                        id="searchInput"
                                        class="form-control"
                                        placeholder="Поиск групп туров…"
                                    >
                                    <!-- Кнопка очистки -->
                                    @if($search)
                                        <button
                                            wire:click="clearSearch"
                                            type="button"
                                            class="btn btn-outline-secondary border-start-0"
                                            style="margin-left: -1px;"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <script>
                                document.addEventListener('livewire:initialized', () => {
                                    Livewire.on('search-cleared', () => {
                                        document.getElementById('searchInput').value = '';
                                    });
                                });
                            </script>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted small">Показать</span>
                                        <select class="form-select form-select-sm mx-2" wire:model.live="perPage"
                                                style="width: auto;">
                                            <option value="8">8</option>
                                            <option value="15">15</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                        <span class="text-muted small">из {{ $tourGroups->total() }} результатов</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button wire:click="toggleTrash" class="btn btn-sm {{ $showTrash ? 'btn-danger' : 'btn-outline-secondary' }}">
                                            <i class="fas fa-trash"></i> {{ $showTrash ? 'Назад' : 'Корзина' }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- можно сюда добавить фильтры или экспорт --}}
                    </div>

                    {{-- 2.2 Таблица --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-nowrap mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th style="width: 60px">#</th>
                                <th wire:click="sortBy('tour_title')" style="cursor: pointer;">
                                    Тур
                                    @if ($sortColumn === 'tour_title')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort text-muted"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('starts_at')" style="cursor: pointer;">
                                    Начало
                                    @if ($sortColumn === 'starts_at')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort text-muted"></i>
                                    @endif
                                </th>
                                <th>Категория</th>                                
                                <th>Кол-во людей <br> текущее|максимум</th>
                                <th>Цена <br> min|max</th>
                                <th>Статус</th>
                                <th style="width: 120px" class="text-center">Действия</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($tourGroups as $tourGroup)
                                <tr>
                                    <td>{{ $tourGroup->id }}</td>
                                    <td>
                                        <a href="{{ route('tour-groups.edit', $tourGroup) }}">
                                            <span class="font-weight-semibold">
                                                {{ $tourGroup->tour->title ?? 'N/A' }}
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                            <span class="badge badge-soft-primary font-size-12">
                                                {{ \Carbon\Carbon::parse($tourGroup->starts_at)->format('d.m.Y') }}
                                            </span>
                                    </td>
                                    <td>
                                        @if($tourGroup->tour)
                                            @foreach($tourGroup->tour->categories as $category)
                                                <span class="badge badge-soft-info font-size-12">
                                                    {{ $category->title }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </td>                                    
                                    <td>
                                            <span class="badge badge-soft-primary font-size-12">
                                                {{ $tourGroup->current_people }}/{{ $tourGroup->max_people }}
                                            </span>
                                    </td>
                                    <td>
                                            <span class="badge badge-soft-primary font-size-12">
                                                ${{ $tourGroup->price_min }} | ${{ $tourGroup->price_max }}
                                            </span>
                                    </td>
                                    <td>
                                        @switch($tourGroup->status)
                                            @case('draft')
                                                <span
                                                    class="badge badge-soft-info font-size-12">Черновик</span>
                                                @break
                                            @case('open')
                                                <span
                                                    class="badge badge-soft-success font-size-12">Открыто</span>
                                                @break
                                            @case('closed')
                                                <span
                                                    class="badge badge-soft-warning font-size-12">Закрыто</span>
                                                @break
                                            @case('cancelled')
                                                <span
                                                    class="badge badge-soft-danger font-size-12">Отменено</span>
                                                @break
                                            @default
                                                <span
                                                    class="badge badge-soft-secondary font-size-12">{{ $tourGroup->status }}</span>
                                        @endswitch
                                    </td>

                                    <td class="text-center">
                                        @if($showTrash)
                                            <button wire:click="restore({{ $tourGroup->id }})"
                                                    class="btn btn-sm btn-outline-success waves-effect waves-light mx-1"
                                                    data-toggle="tooltip" title="Восстановить">
                                                <i class="bx bx-undo font-size-14"></i>
                                            </button>

                                            <button wire:click="forceDelete({{ $tourGroup->id }})"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    data-toggle="tooltip" title="Удалить навсегда">
                                                <i class="bx bx-trash font-size-14"></i>
                                            </button>
                                        @else
                                            <a href="{{ route('tour-groups.edit', $tourGroup) }}"
                                               class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                               data-toggle="tooltip" title="Редактировать">
                                                <i class="bx bx-pencil font-size-14"></i>
                                            </a>

                                            <button wire:click="delete({{ $tourGroup->id }})"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    data-toggle="tooltip" title="Удалить">
                                                <i class="bx bx-trash font-size-14"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Группы туров не найдены.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>{{-- /.table-responsive --}}

                    {{-- 2.3 Пагинация --}}
                    @if($tourGroups->hasPages())
                        <div class="pt-3">
                            {{ $tourGroups->links('pagination::bootstrap-4') }}
                        </div>
                    @endif

                </div>{{-- /.card-body --}}
            </div>{{-- /.card --}}
        </div>{{-- /.col-12 --}}
    </div>{{-- /.row --}}

</div>{{-- container-fluid --}}
</div>
