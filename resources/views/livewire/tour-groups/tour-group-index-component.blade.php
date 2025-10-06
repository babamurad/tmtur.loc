<div class="page-content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 1. Заголовок + кнопка «Создать» на одной строке --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Tour Groups</h4>

                    <a href="{{ route('tour-groups.create') }}"
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
                                <form method="GET" action="{{ route('tour-groups.index') }}" class="form-inline">
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
                                               placeholder="Search tour groups…"
                                               aria-label="Search">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="submit">
                                                Find
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- можно сюда добавить фильтры или экспорт --}}
                            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                                <span class="text-muted font-size-12">
                                    Found: <strong>{{ $tourGroups->total() }}</strong>
                                </span>
                            </div>
                        </div>{{-- /.row --}}

                        {{-- 2.2 Таблица --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th>Tour</th>
                                        <th>Starts At</th>
                                        <th>Max People</th>
                                        <th>Current People</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th style="width: 120px" class="text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($tourGroups as $tourGroup)
                                    <tr>
                                        <td>{{ $tourGroup->id }}</td>
                                        <td>
                                            <span class="font-weight-semibold">
                                                {{ $tourGroup->tour->title ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $tourGroup->starts_at }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $tourGroup->max_people }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $tourGroup->current_people }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $tourGroup->price_cents / 100 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $tourGroup->status }}
                                            </span>
                                        </td>

                                        {{-- Кнопки действий --}}
                                        <td class="text-center">
                                            <a href="{{ route('tour-groups.edit', $tourGroup) }}"
                                               class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                               data-toggle="tooltip" title="Edit">
                                                <i class="bx bx-pencil font-size-14"></i>
                                            </a>

                                            <button wire:click="delete({{ $tourGroup->id }})" class="btn btn-sm btn-outline-danger waves-effect waves-light">
                                                <i class="bx bx-trash font-size-14"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No tour groups found.
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