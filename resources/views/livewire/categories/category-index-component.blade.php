<div class="page-content">
    <div class="container-fluid">

        @php
            use Carbon\Carbon;
        @endphp

        <!-- заголовок + кнопка -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-size-18">Категории</h4>
                    <a href="{{ route('categories.create') }}" class="btn btn-success">
                        <i class="bx bx-plus-circle"></i> Создать
                    </a>
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
                                <span class="text-muted">Показано: {{ $categories->count() }} из {{ $categories->total() }}</span>
                            </div>
                        </div>

                        <!-- таблица -->
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th width="60">#</th>
                                    <th>Название</th>
                                    <th>Публикация</th>
                                    <th>Опубликовано</th>
                                    <th width="120" class="text-center">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($categories as $cat)
                                    <tr>
                                        <td>{{ $cat->id }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $cat->id) }}">
                                                <img src="{{ asset($cat->image_url) }}" alt="{{ $cat->tr('title') }}"
                                                    style="height:32px;" class="rounded me-2"/>
                                                <span class="ml-2">{{ $cat->tr('title') }}</span>
                                            </a>
                                        </td>

                                        <td>
                                                <span
                                                    class="badge badge-{{ $cat->is_published?'success':'secondary' }}">
                                                    {{ $cat->is_published?'Да':'Нет' }}
                                                </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light">{{ Carbon::create($cat->created_at)->format('d.m.Y ') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('categories.edit', $cat->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger"
                                                    wire:click="deleteConfirm({{ $cat->id }})">
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
                        @if($categories->hasPages())
                            <div class="pt-3">
                                {{ $categories->links() }}
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
