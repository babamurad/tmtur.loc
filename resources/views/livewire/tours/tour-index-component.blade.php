<div class="page-content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 1. Заголовок + кнопка «Создать» на одной строке --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Туры</h4>

                    <a href="{{ route('admin.tours.create') }}" class="btn btn-success waves-effect waves-light">
                        <i class="fas fa-plus-circle font-size-16 align-middle mr-1"></i>
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
                                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                                        placeholder="Поиск туров…">
                                </div>
                            </div>




                            {{-- можно сюда добавить фильтры или экспорт --}}
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <button class="btn btn-outline-secondary waves-effect waves-light btn-sm me-2"
                                        wire:click="toggleTrashed">
                                        <i class="fas fa-trash-alt me-1"></i>
                                        {{ $showTrashed ? 'Назад к списку' : 'Корзина (' . \App\Models\Tour::onlyTrashed()->count() . ')' }}
                                    </button>

                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted small">Показать</span>
                                        <select class="form-select form-select-sm mx-2" wire:model.live="perPage"
                                            style="width: auto;">
                                            <option value="12">12</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                        </select>
                                        <span class="text-muted small">из {{ $tours->total() }} результатов</span>
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
                                    <th>Название</th>
                                    <th>Статус</th>
                                    <th>Категория</th>
                                    <th>Базовая цена</th>
                                    <th>Длительность (дней)</th>
                                    <th style="width: 120px" class="text-center">Действия</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($tours as $tour)
                                    <tr>
                                        <td>{{ $tour->id }}</td>
                                        <td style="width: 20%;">
                                            <div>
                                                <a href="{{ url('admin/tours/edit/' . $tour->id) }}">
                                                    @if($tour->first_media_url)
                                                        <img src="{{ $tour->first_media_url }}" alt="{{ $tour->title }}"
                                                            class="img-fluid rounded mb-2" style="width: 150px; height: auto;">
                                                    @else
                                                        <img src="{{ asset('assets/images/media/sm-5.jpg') }}"
                                                            alt="Изображение по умолчанию" class="img-fluid rounded mb-2"
                                                            style="width: 150px; height: auto;">
                                                    @endif
                                                </a>
                                            </div>

                                            <div style="white-space: normal; word-break: break-word; max-width: 100%;">
                                                <a href="{{ url('admin/tours/edit/' . $tour->id) }}">
                                                    {{ $tour->title }}
                                                </a>
                                            </div>
                                        </td>

                                        <td>
                                            @if($tour->is_published)
                                                <span class="badge badge-soft-success">Опубликовано</span>
                                            @else
                                                <span class="badge badge-soft-danger">Не опубликовано</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-secondary">
                                                {!! $tour->categories->pluck('title')->implode(',<br>') !!}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                ${{ number_format($tour->base_price_cents, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $tour->duration_days }} дней
                                            </span>
                                        </td>

                                        {{-- Кнопки действий --}}
                                        <td class="text-center">
                                            @if($showTrashed)
                                                <button wire:click="restore({{ $tour->id }})"
                                                    class="btn btn-sm btn-outline-success waves-effect waves-light mx-1"
                                                    data-toggle="tooltip" title="Восстановить">
                                                    <i class="fas fa-trash-restore font-size-14"></i>
                                                </button>

                                                <button wire:click="delete({{ $tour->id }})"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    data-toggle="tooltip" title="Удалить навсегда">
                                                    <i class="fas fa-times font-size-14"></i>
                                                </button>
                                            @else
                                                <a href="{{ url('admin/tours/edit/' . $tour->id) }}"
                                                    class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                                    data-toggle="tooltip" title="Редактировать">
                                                    <i class="fas fa-edit font-size-14"></i>
                                                </a>

                                                <button wire:click="delete({{ $tour->id }})"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    data-toggle="tooltip" title="Удалить">
                                                    <i class="fas fa-trash-alt font-size-14"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4"> <!-- Обновлено colspan -->
                                            Туры не найдены.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>{{-- /.table-responsive --}}

                    {{-- 2.3 Пагинация --}}
                    @if($tours->hasPages())
                        <div class="pt-3">
                            {{ $tours->links() }}
                        </div>
                    @endif

                </div>{{-- /.card-body --}}
            </div>{{-- /.card --}}
        </div>{{-- /.col-12 --}}
    </div>{{-- /.row --}}

</div>{{-- container-fluid --}}
</div>