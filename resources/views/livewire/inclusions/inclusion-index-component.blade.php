<div class="page-content">
    <div class="container-fluid">
        <div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Включения туров</h2>
                <a href="{{ route('inclusions.create') }}" class="btn btn-primary">Создать включение</a>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название (RU)</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inclusions as $inclusion)
                                <tr>
                                    <td>{{ $inclusion->id }}</td>
                                    <td>{{ $inclusion->tr('title') }}</td>
                                    <td>
                                        <a href="{{ route('inclusions.edit', $inclusion->id) }}"
                                            class="btn btn-sm btn-info">Редактировать</a>
                                        <button wire:click="delete({{ $inclusion->id }})" class="btn btn-sm btn-danger"
                                            onclick="confirm('Вы уверены?') || event.stopImmediatePropagation()">Удалить</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $inclusions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>