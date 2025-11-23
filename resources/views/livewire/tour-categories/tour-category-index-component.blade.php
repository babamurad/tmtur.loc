<div class="page-content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 1. Заголовок + кнопка «Создать» на одной строке --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Категории туров</h4>

                    <a href="{{ route('tour-categories.create') }}"
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
                                <form method="GET" action="{{ route('tour-categories.index') }}" class="form-inline">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                               name="search"
                                               value="{{ request('search') }}"
                                               class="form-control"
                                               placeholder="Поиск категорий туров…"
                                               aria-label="Поиск">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="submit">
                                                Найти
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- можно сюда добавить фильтры или экспорт --}}
                            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                                <span class="text-muted font-size-12">
                                    Найдено: <strong>{{ $tourCategories->total() }}</strong>
                                </span>
                            </div>
                        </div>{{-- /.row --}}

                        {{-- 2.2 Таблица --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th>Название</th>
                                        <th>Slug</th>
                                        <th style="width: 120px" class="text-center">Действия</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($tourCategories as $tourCategory)
                                    <tr>
                                        <td>{{ $tourCategory->id }}</td>
                                        <td>
                                            <a href="{{ route('tour-categories.edit', $tourCategory->id) }}">
                                                <span class="font-weight-semibold">
                                                    {{ $tourCategory->title }}
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $tourCategory->slug }}
                                            </span>
                                        </td>

                                        {{-- Кнопки действий --}}
                                        <td class="text-center">
                                            <a href="{{ route('tour-categories.edit', $tourCategory->id) }}"
                                               class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                               data-toggle="tooltip" title="Редактировать">
                                                <i class="bx bx-pencil font-size-14"></i>
                                            </a>

                                            <button wire:click="delete({{ $tourCategory->id }})" class="btn btn-sm btn-outline-danger waves-effect waves-light">
                                                <i class="bx bx-trash font-size-14"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Категории туров не найдены.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>{{-- /.table-responsive --}}

                        {{-- 2.3 Пагинация --}}
                        @if($tourCategories->hasPages())
                        <div class="pt-3">
                            {{ $tourCategories->links('pagination::bootstrap-4') }}
                        </div>
                        @endif

                    </div>{{-- /.card-body --}}
                </div>{{-- /.card --}}
            </div>{{-- /.col-12 --}}
        </div>{{-- /.row --}}

    </div>{{-- container-fluid --}}
</div>
