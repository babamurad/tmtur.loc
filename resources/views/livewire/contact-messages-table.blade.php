<div class="page-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Contact messages</h5>

                {{-- поиск --}}
                <div>
                    <input wire:model.debounce.300ms="search" type="text" class="form-control form-control-sm"
                           placeholder="Search…" style="max-width:220px">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0" wire:poll.5s>
                    <thead class="thead-light">
                    <tr>
                        <th style="width:50px">#</th>
                        <th wire:click="sortBy('name')" class="cursor-pointer">
                            Name
                            @include('livewire.partials.sort-icon', ['field' => 'name'])
                        </th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th wire:click="sortBy('created_at')" class="cursor-pointer">
                            Received
                            @include('livewire.partials.sort-icon', ['field' => 'created_at'])
                        </th>
                        <th class="text-center">Read</th>
                        <th class="text-center">Actions</th>
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
                                    <span class="badge badge-success">read</span>
                                @else
                                    <span class="badge badge-warning">new</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!$msg->is_read)
                                    <button class="btn btn-sm btn-outline-success"
                                            wire:click="markAsRead({{ $msg->id }})">
                                        Mark read
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary"
                                            wire:click="markAsUnread({{ $msg->id }})">
                                        Mark unread
                                    </button>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal с полным текстом -->
                        <div class="modal fade" id="msgModal{{ $msg->id }}" tabindex="-1" role="dialog" wire:ignore.self>
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Message #{{ $msg->id }}</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Name:</strong> {{ $msg->name }}</p>
                                        <p><strong>Email:</strong> {{ $msg->email }}</p>
                                        <p><strong>Phone:</strong> {{ $msg->phone ?? '-' }}</p>
                                        <p><strong>Date:</strong> {{ $msg->created_at->format('d.m.Y H:i') }}</p>
                                        <hr>
                                        <p>{{ $msg->message }}</p>
                                        <hr>
                                        <small class="text-muted">
                                            IP: {{ $msg->ip }} / UA: {{ $msg->user_agent }}
                                        </small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No messages yet</td>
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
