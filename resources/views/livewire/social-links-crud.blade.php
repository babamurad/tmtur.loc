<div>
    {{-- форма --}}
    <div class="card mb-3">
        <div class="card-body">
            <form wire:submit.prevent="store">

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Name</label>
                        <input type="text" wire:model.defer="name" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>URL</label>
                        <input type="url" wire:model.defer="url" class="form-control" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Sort</label>
                        <input type="number" wire:model.defer="sort_order" class="form-control">
                    </div>
                    <div class="form-group col-md-2 align-self-end">
                        <button class="btn btn-primary btn-block" type="submit">
                            {{ $editId ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label>Icon</label>
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle btn-block text-left"
                                    data-toggle="dropdown">
                                @if($icon)
                                    {!! $icons[$icon] !!}
                                @else
                                    Choose icon
                                @endif
                            </button>
                            <div class="dropdown-menu w-100" style="max-height:220px;overflow:auto">
                                <a class="dropdown-item" href="#" wire:click.prevent="$set('icon','')">— none —</a>
                                @foreach($icons as $class => $html)
                                    <a class="dropdown-item d-flex align-items-center" href="#"
                                       wire:click.prevent="$set('icon','{{ $class }}')">
                                        <span class="mr-2">{!! $html !!}</span>
                                        <span>{{ explode(' ',trim(strip_tags($html)))[1] ?? $class }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @error('icon') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Button CSS class</label>
                        <input type="text" wire:model.defer="btn_class" class="form-control" placeholder="btn-fb">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Active?</label>
                        <select wire:model.defer="is_active" class="form-control">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- таблица --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Icon</th>
                    <th>CSS-Class</th>
                    <th>Order</th>
                    <th>Active</th>
                    <th width="120"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $sl)
                    <tr>
                        <td>{{ $sl->name }}</td>
                        <td><a href="{{ $sl->url }}" target="_blank">{{ Str::limit($sl->url,30) }}</a></td>
                        <td><i class="{{$sl->icon}}"></i> {!! $sl->icon !!}</td>
                        <td><code>{{ $sl->btn_class }}</code></td>
                        <td>{{ $sl->sort_order }}</td>
                        <td>{{ $sl->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            <button class="btn btn-sm btn-secondary" wire:click="edit({{ $sl->id }})">Edit</button>
                            <button class="btn btn-sm btn-danger" wire:click="delete({{ $sl->id }})">Del</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No links yet</td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="p-3">{{ $items->links() }}</div>
        </div>
    </div>
</div>
