<div class="page-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Сообщения</h5>

                {{-- поиск --}}
                <div class="d-flex align-items-center">
                    <div class="btn-group btn-group-sm mr-3" role="group">
                        <button type="button" class="btn btn-{{ $filter === 'active' ? 'primary' : 'outline-primary' }} d-flex align-items-center"
                            wire:click="setFilter('active')">
                            Входящие
                        </button>
                        <button type="button" class="btn btn-{{ $filter === 'trash' ? 'primary' : 'outline-primary' }} d-flex align-items-center"
                            wire:click="setFilter('trash')">
                            <i class="fa fa-trash mr-1"></i> Корзина
                            <span class="badge badge-light ml-1">{{ $this->trashCount }}</span>
                        </button>
                    </div>

                    <input wire:model.debounce.300ms="search" type="text" class="form-control form-control-sm"
                        placeholder="Поиск…" style="max-width:220px">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0" wire:poll.5s>
                    <thead class="thead-light">
                        <tr>
                            <th style="width:50px">#</th>
                            <th wire:click="sortBy('name')" class="cursor-pointer">
                                Имя
                                @include('livewire.partials.sort-icon', ['field' => 'name'])
                            </th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Сообщение</th>
                            <th wire:click="sortBy('created_at')" class="cursor-pointer">
                                Получено
                                @include('livewire.partials.sort-icon', ['field' => 'created_at'])
                            </th>
                            <th class="text-center">Прочитано</th>
                            <th class="text-center" style="width: 140px;">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $msg)
                            <tr class="{{ $msg->is_read ? '' : 'table-primary' }}" wire:key="msg-{{ $msg->id }}">
                                <td>{{ $msg->id }}</td>
                                <td>{{ $msg->name }}</td>
                                <td>{{ $msg->email }}</td>
                                <td>{{ $msg->phone ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-link p-0" data-toggle="modal"
                                        data-target="#msgModal{{ $msg->id }}">
                                        {{ Str::limit($msg->message, 40) }}
                                    </button>
                                </td>
                                <td>{{ $msg->created_at->format('d.m.Y H:i') }}</td>
                                <td class="text-center">
                                    @if($msg->is_read)
                                        <span class="badge badge-success">прочитано</span>
                                    @else
                                        <span class="badge badge-warning">новое</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                    @if($filter === 'active')
                                        @if(!$msg->is_read)
                                            <button class="btn btn-outline-success" wire:click="markAsRead({{ $msg->id }})" title="Пометить как прочитанное">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary"
                                                wire:click="markAsUnread({{ $msg->id }})" title="Пометить как непрочитанное">
                                                <i class="fa fa-envelope"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-outline-danger" wire:click="delete({{ $msg->id }})"
                                            wire:confirm="Вы уверены, что хотите удалить это сообщение?" title="В корзину">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @else
                                        @if(!$msg->is_read)
                                            <button class="btn btn-outline-success" wire:click="markAsRead({{ $msg->id }})" title="Пометить как прочитанное">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary"
                                                wire:click="markAsUnread({{ $msg->id }})" title="Пометить как непрочитанное">
                                                <i class="fa fa-envelope"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-outline-info" wire:click="restore({{ $msg->id }})" title="Восстановить">
                                            <i class="fa fa-undo"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" wire:click="forceDelete({{ $msg->id }})"
                                            wire:confirm="Вы уверены, что хотите удалить это сообщение НАВСЕГДА?" title="Удалить навсегда">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    @endif
                                    </div>
                                </td>
                            </tr>


                            <!-- Modal с полным текстом -->
                            <div class="modal fade" id="msgModal{{ $msg->id }}" tabindex="-1" role="dialog"
                                wire:ignore.self>
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Сообщение #{{ $msg->id }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Имя:</strong> {{ $msg->name }}</p>
                                            <p><strong>Email:</strong> {{ $msg->email }}</p>
                                            <p><strong>Телефон:</strong> {{ $msg->phone ?? '-' }}</p>
                                            <p><strong>Дата:</strong> {{ $msg->created_at->format('d.m.Y H:i') }}</p>
                                            <hr>
                                            <p>{{ $msg->message }}</p>
                                            <hr>
                                            <small class="text-muted">
                                                IP: {{ $msg->ip }} / UA: {{ $msg->user_agent }}
                                            </small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Закрыть</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Сообщений пока нет</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
                <div class="card-footer">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</div>