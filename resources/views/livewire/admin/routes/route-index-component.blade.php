<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Программа тура (Маршруты)</h4>
                    <div class="page-title-right">
                        <a href="{{ route('admin.routes.create') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="bx bx-plus font-size-16 align-middle mr-2"></i> Создать маршрут
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Поиск..."
                                    wire:model.live.debounce.300ms="search">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>День №</th>
                                        <th>Локация</th>
                                        <th>Заголовок</th>
                                        <th>Статус</th>
                                        <th class="text-right">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($routes as $route)
                                        <tr>
                                            <td>{{ $route->id }}</td>
                                            <td>{{ $route->days->count() }} дней</td>
                                            <td>{{ $route->route_string }}</td>
                                            <td>{{ $route->title }}</td>
                                            <td>
                                                @if($route->is_active)
                                                    <span class="badge badge-success">Активен</span>
                                                @else
                                                    <span class="badge badge-danger">Не активен</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('admin.routes.edit', $route->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <button wire:click="delete({{ $route->id }})" wire:confirm="Вы уверены?"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Маршруты не найдены</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $routes->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>