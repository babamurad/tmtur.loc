<div class="page-content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- 1. Заголовок + кнопка «Создать» --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Клиенты</h4>

                    <a href="{{ route('customers.create') }}" class="btn btn-success waves-effect waves-light">
                        <i class="bx bx-plus-circle font-size-16 align-middle mr-1"></i>
                        Создать
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
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" wire:model.live.debounce.300ms="search" id="searchInput"
                                        class="form-control" placeholder="Поиск клиентов...">
                                    <!-- Кнопка очистки -->
                                    @if($search)
                                        <button wire:click="clearSearch" type="button"
                                            class="btn btn-outline-secondary border-start-0" style="margin-left: -1px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <script>
                                document.addEventListener('livewire:initialized', () => {
                                    Livewire.on('search-cleared', () => {
                                        document.getElementById('searchInput').value = '';
                                    });
                                });
                            </script>

                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-md-end gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted small">Показать</span>
                                        <select class="form-select form-select-sm mx-2" wire:model.live="perPage"
                                            style="width: auto;">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                        <span class="text-muted small">из {{ $customers->total() }} результатов</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2.2 Таблица --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th>Имя</th>
                                        <th>Email</th>
                                        <th>Телефон</th>
                                        <th>Паспорт</th>
                                        <th>Дата согласия</th>
                                        <th style="width: 120px" class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $customer)
                                        <tr>
                                            <td>{{ $customer->id }}</td>
                                            <td>
                                                <span class="font-weight-semibold">{{ $customer->full_name }}</span>
                                            </td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->passport }}</td>
                                            <td>
                                                @if($customer->gdpr_consent_at)
                                                    <span class="badge badge-soft-success font-size-12">
                                                        {{ \Carbon\Carbon::parse($customer->gdpr_consent_at)->format('d.m.Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-soft-warning font-size-12">Нет</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('customers.edit', $customer->id) }}"
                                                    class="btn btn-sm btn-outline-primary waves-effect waves-light mx-1"
                                                    data-toggle="tooltip" title="Редактировать">
                                                    <i class="bx bx-pencil font-size-14"></i>
                                                </a>

                                                <button wire:click="delete({{ $customer->id }})"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light"
                                                    data-toggle="tooltip" title="Удалить">
                                                    <i class="bx bx-trash font-size-14"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                Клиенты не найдены.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- 2.3 Пагинация --}}
                        @if($customers->hasPages())
                            <div class="pt-3">
                                {{ $customers->links('pagination::bootstrap-4') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>