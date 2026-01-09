<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Достопримечательности</h4>
                    <a href="{{ route('admin.places.create') }}" class="btn btn-success waves-effect waves-light">
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
                                        <th>Тип</th>
                                        <th>Стоимость</th>
                                        <th>Локация</th>
                                        <th style="width: 120px" class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($places as $place)
                                        <tr>
                                            <td>{{ $place->id }}</td>
                                            <td>
                                                <a href="{{ route('admin.places.edit', ['place_id' => $place->id]) }}">
                                                    <span class="font-weight-semibold">{{ $place->name }}</span>
                                                </a>
                                            </td>
                                            <td>{{ $place->type->label() }}</td>
                                            <td>{{ $place->cost }}</td>
                                            <td>{{ $place->location->name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.places.edit', ['place_id' => $place->id]) }}"
                                                    class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                                    data-toggle="tooltip" title="Редактировать">
                                                    <i class="bx bx-pencil font-size-14"></i>
                                                </a>
                                                <button wire:click.prevent="delete({{ $place->id }})"
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
                            {{ $places->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>