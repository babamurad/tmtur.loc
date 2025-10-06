@script
<script>
    // hereai
        function deleteService(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    alert(id);
                }
            });
        }
    </script>
@endscript
<div class="page-content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 1. Заголовок + кнопка «Создать» на одной строке --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Services</h4>

                    <a href="{{ route('services.create') }}"
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
                                <form method="GET" action="{{ route('services.index') }}" class="form-inline">
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
                                               placeholder="Search services…"
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
                                    Found: <strong>{{ $services->total() }}</strong>
                                </span>
                            </div>
                        </div>{{-- /.row --}}

                        {{-- 2.2 Таблица --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th style="width: 120px" class="text-center">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($services as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>
                                            <span class="font-weight-semibold">
                                                {{ $service->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $service->type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ $service->default_price_cents }}
                                            </span>
                                        </td>

                                        {{-- Кнопки действий --}}
                                        <td class="text-center">
                                            <a href="{{ route('services.edit', $service) }}"
                                               class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                               data-toggle="tooltip" title="Edit">
                                                <i class="bx bx-pencil font-size-14"></i>
                                            </a>

                                            <button  onclick="deleteService({{ $service->id }})" class="btn btn-sm btn-outline-danger waves-effect waves-light">
                                                <i class="bx bx-trash font-size-14"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No services found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>{{-- /.table-responsive --}}

                        {{-- 2.3 Пагинация --}}
                        @if($services->hasPages())
                        <div class="pt-3">
                            {{ $services->links('pagination::bootstrap-4') }}                        
                        </div>
                        @endif

                    </div>{{-- /.card-body --}}
                </div>{{-- /.card --}}
            </div>{{-- /.col-12 --}}
        </div>{{-- /.row --}}

    </div>{{-- container-fluid --}}
</div>

