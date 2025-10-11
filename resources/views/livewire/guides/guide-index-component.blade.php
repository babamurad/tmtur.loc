<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Гиды</h4>
                        <a href="{{ route('guides.create') }}" class="btn btn-success waves-effect waves-light">
                            <i class="bx bx-plus-circle font-size-16 align-middle mr-1"></i>
                            Добавить гида
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">

                                <div class="col-md-6">
                                    <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                        <input type="text" wire:model.debounce.300ms="search" class="form-control" placeholder="Поиск по имени или специализации…">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center justify-content-md-end gap-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="text-muted small">Show</span>
                                            <select class="form-select form-select-sm mx-2" wire:model.live="perPage" style="width: auto;">
                                                <option value="8">8</option>
                                                <option value="15">15</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                            </select>
                                            <span class="text-muted small">of {{ $guides->total() }} results</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th>ID</th><th>Фото</th><th>Имя</th><th>Языки</th>
                                        <th>Специализация</th><th>Стаж</th><th>Активен</th><th width="120"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($guides as $g)
                                        <tr>
                                            <td>{{ $g->id }}</td>
                                            <td>
                                                @if($g->image)
                                                    <img src="{{ Storage::url($g->image) }}" class="rounded" width="40" height="40" alt="">
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>{{ $g->name }}</td>
                                            <td>{{ implode(', ', $g->languages) }}</td>
                                            <td>{{ $g->specialization ?: '—' }}</td>
                                            <td>{{ $g->experience_years }} лет</td>
                                            <td>
                                                <span class="badge badge-{{ $g->is_active ? 'success' : 'secondary' }}">
                                                    {{ $g->is_active ? 'Да' : 'Нет' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('guides.edit', $g) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <button class="btn btn-sm btn-danger"
                                                        onclick="confirm('Удалить?') || event.stopImmediatePropagation()"
                                                        wire:click="deleteGuide({{ $g->id }})">Del</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="text-center text-muted">Нет записей</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="pt-2">
                                {{ $guides->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
