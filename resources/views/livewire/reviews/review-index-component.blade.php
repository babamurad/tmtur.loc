<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-size-18">Отзывы</h4>
                    <a href="{{ route('reviews.create') }}" class="btn btn-success">
                        <i class="bx bx-plus-circle"></i> Добавить
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Поиск по тексту..."
                                    wire:model.live.debounce.300ms="search">
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="text-muted">Показано: {{ $reviews->count() }} из
                                    {{ $reviews->total() }}</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Пользователь</th>
                                        <th>Тур</th>
                                        <th>Рейтинг</th>
                                        <th>Статус</th>
                                        <th>Комментарий</th>
                                        <th width="120" class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $r)
                                        <tr>
                                            <td>{{ $r->id }}</td>
                                            <td>{{ $r->user->name ?? '-' }}</td>
                                            <td>{{ $r->tour->title ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">{{ $r->rating }} ★</span>
                                            </td>
                                            <td>
                                                <div class="form-check form-switch" wire:click="toggleActive({{ $r->id }})" style="cursor: pointer;">
                                                    <input class="form-check-input" type="checkbox" role="switch" {{ $r->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $r->is_active ? 'Активен' : 'Скрыт' }}</label>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-truncate d-block" style="max-width:300px;">
                                                    {{ $r->comment ?? '—' }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('reviews.edit', $r) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-pencil"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete({{ $r->id }})">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                Ничего не найдено
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($reviews->hasPages())
                            <div class="pt-3">{{ $reviews->links() }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Удалить отзыв?',
            text: 'Восстановление невозможно',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Да',
            cancelButtonText: 'Отмена'
        }).then((r) => {
            if (r.isConfirmed) Livewire.dispatch('delete', { id });
        });
    }
</script>
@endscript