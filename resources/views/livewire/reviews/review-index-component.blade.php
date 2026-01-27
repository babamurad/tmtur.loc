<div class="page-content">
    <div class="container-fluid">

        {{-- 1. Заголовок + кнопка «Создать» (если нужна) --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Отзывы</h4>

                    {{-- Если кнопка создания не нужна концептуально, можно убрать. Но если нужна: --}}
                    <a href="{{ route('admin.reviews.create') }}" class="btn btn-success waves-effect waves-light">
                        <i class="fas fa-plus-circle font-size-16 align-middle mr-1"></i>
                        Добавить
                    </a>
                </div>
            </div>
        </div>

        {{-- 2. Панель «поиск + таблица» --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- 2.1 Поисковая строка и фильтры --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                                        placeholder="Поиск по тексту...">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted small">Показать</span>
                                        <select class="form-select form-select-sm mx-2" wire:model.live="perPage"
                                            style="width: auto;">
                                            <option value="12">12</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                        </select>
                                        <span class="text-muted small">из {{ $reviews->total() }} результатов</span>
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
                                        <th>Пользователь</th>
                                        <th>Тур</th>
                                        <th>Рейтинг</th>
                                        <th>Статус</th>
                                        <th>Комментарий</th>
                                        <th style="width: 120px" class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $r)
                                        <tr>
                                            <td>{{ $r->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $r->user->avatar_url }}" class="rounded-circle me-2"
                                                        alt="Avatar" width="30" height="30">
                                                    <span>{{ $r->user->name ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($r->tour)
                                                    <a href="{{ route('tours.show', $r->tour->slug ?? $r->tour->id) }}"
                                                        target="_blank" class="text-body fw-bold">
                                                        {{ \Illuminate\Support\Str::limit($r->tour->tr('title'), 30) }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    {{ $r->rating }} <i class="fas fa-star small"></i>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch" wire:click="toggleActive({{ $r->id }})"
                                                    style="cursor: pointer;">
                                                    <input class="form-check-input" type="checkbox" role="switch" {{ $r->is_active ? 'checked' : '' }} style="cursor: pointer;">
                                                    <label class="form-check-label"
                                                        style="cursor: pointer;">{{ $r->is_active ? 'Активен' : 'Скрыт' }}</label>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted d-block text-wrap"
                                                    style="max-width: 300px; line-height: 1.4;">
                                                    {{ \Illuminate\Support\Str::limit($r->comment ?? '—', 100) }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.reviews.edit', $r) }}"
                                                    class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                                    data-toggle="tooltip" title="Редактировать">
                                                    <i class="fas fa-edit font-size-14"></i>
                                                </a>
                                                <button wire:click="delete({{ $r->id }})"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    data-toggle="tooltip" title="Удалить">
                                                    <i class="fas fa-trash-alt font-size-14"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Ничего не найдено
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- 2.3 Пагинация --}}
                        @if($reviews->hasPages())
                            <div class="pt-3">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>