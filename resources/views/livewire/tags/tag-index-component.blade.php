<div class="page-content">
    <div class="container-fluid">

        <!-- заголовок -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-size-18">Теги</h4>
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-success">
                        <i class="bx bx-plus-circle"></i> Создать
                    </a>
                    {{-- Creation happens usually via Tour, but we could add a modal here. --}}
                </div>
            </div>
        </div>

        <!-- карточка таблицы -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <!-- поиск -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Поиск..."
                                       wire:model.live.debounce.300ms="search">
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="text-muted">Показано: {{ $tags->count() }} из {{ $tags->total() }}</span>
                            </div>
                        </div>

                        <!-- таблица -->
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th width="60">#</th>
                                    <th>Название</th>
                                    <th>Используется в турах</th>
                                    <th width="120" class="text-center">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($tags as $tag)
                                    <tr>
                                        <td>{{ $tag->id }}</td>
                                        <td>
                                            <span class="badge badge-info font-size-12">{{ $tag->tr('name') }}</span>
                                        </td>
                                        <td>
                                            {{ $tag->tours()->count() }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.tags.edit', $tag->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger"
                                                    wire:click="delete({{ $tag->id }})"
                                                    wire:confirm="Вы уверены? Это удалит тег у всех туров.">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>                                        
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Ничего не найдено
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- пагинация -->
                        @if($tags->hasPages())
                            <div class="pt-3">
                                {{ $tags->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    Livewire.on('swal:confirm', data => {
        Swal.fire({
            title: data.title,
            text: data.text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Да',
            cancelButtonText: 'Отмена'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch(data.event, {id: data.id});
            }
        })
    });
</script>
@endscript
