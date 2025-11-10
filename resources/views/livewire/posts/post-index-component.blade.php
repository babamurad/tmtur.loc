<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-size-18">Посты</h4>
                    <a href="{{ route('posts.create') }}" class="btn btn-success">
                        <i class="bx bx-plus-circle"></i> Создать
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
                                <input type="text" class="form-control" placeholder="Поиск..."
                                       wire:model.live.debounce.300ms="search">
                            </div>
                            <div class="col-md-6 text-end">
                                <span class="text-muted">Показано: {{ $posts->count() }} из {{ $posts->total() }}</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Изображение</th>
                                    <th>Заголовок</th>
                                    <th>Категория</th>
                                    <th>Статус</th>
                                    <th width="120" class="text-center">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($posts as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                        <td>
                                            <img src="{{ $p->image_url }}" alt="{{ $p->title }}"
                                                 style="height:40px;" class="rounded">
                                        </td>
                                        <td>{{ $p->title }}</td>
                                        <td>{{ $p->category->title ?? '-' }}</td>
                                        <td>
                                                <span class="badge badge-{{ $p->status ? 'success' : 'secondary' }}">
                                                    {{ $p->status ? 'Опубликован' : 'Черновик' }}
                                                </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('posts.edit', $p->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                            <button wire:click="deleteConfirm({{ $p->id }})"
                                                    class="btn btn-sm btn-outline-danger">
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

                        @if($posts->hasPages())
                            <div class="pt-3">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
