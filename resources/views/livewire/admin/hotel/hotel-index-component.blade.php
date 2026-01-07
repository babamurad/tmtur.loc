<div class="page-content">
    <div class="container-fluid">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Отели</h4>
                    <a href="{{ route('admin.hotels.create') }}" class="btn btn-success waves-effect waves-light">
                        <i class="bx bx-plus-circle font-size-16 align-middle mr-1"></i>
                        Создать
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">ID</th>
                                        <th>Название</th>
                                        <th>Категория</th>
                                        <th>Локация</th>
                                        <th style="width: 120px" class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotels as $hotel)
                                        <tr>
                                            <td>{{ $hotel->id }}</td>
                                            <td>
                                                <a href="{{ route('admin.hotels.edit', ['hotel_id' => $hotel->id]) }}">
                                                    <span class="font-weight-semibold">{{ $hotel->name }}</span>
                                                </a>
                                            </td>
                                            <td>{{ $hotel->category->label() }}</td>
                                            <td>{{ $hotel->location->name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.hotels.edit', ['hotel_id' => $hotel->id]) }}"
                                                    class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                                    data-toggle="tooltip" title="Редактировать">
                                                    <i class="bx bx-pencil font-size-14"></i>
                                                </a>
                                                <button wire:click.prevent="delete({{ $hotel->id }})"
                                                    onclick="confirm('Вы уверены, что хотите удалить этот отель?') || event.stopImmediatePropagation()"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    data-toggle="tooltip" title="Удалить">
                                                    <i class="bx bx-trash font-size-14"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="pt-3">
                            {{ $hotels->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>