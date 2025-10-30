<div class="page-content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-body">
                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <form wire:submit.prevent="store">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Type</label>
                            <input type="text" wire:model.defer="type" class="form-control" placeholder="type (address, phone)" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Label</label>
                            <input type="text" wire:model.defer="label" class="form-control" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Icon (bx ...)</label>
                            <input type="text" wire:model.defer="icon" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Value</label>
                        <textarea wire:model.defer="value" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Input type</label>
                            <select wire:model.defer="input_type" class="form-control">
                                <option value="">text</option>
                                <option value="text">text</option>
                                <option value="textarea">textarea</option>
                                <option value="email">email</option>
                                <option value="url">url</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Sort order</label>
                            <input type="number" wire:model.defer="sort_order" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Is active</label>
                            <select wire:model.defer="is_active" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2 align-self-end">
                            <button class="btn btn-primary btn-block" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- table --}}
        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>Label</th><th>Type</th><th>Value</th><th>Icon</th><th>Order</th><th>Active</th><th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $it)
                        <tr>
                            <td>{{ $it->label }}</td>
                            <td>{{ $it->type }}</td>
                            <td style="white-space:pre-wrap;">{{ $it->value }}</td>
                            <td><i class="bx {{ $it->icon }}"></i> {{ $it->icon }}</td>
                            <td>{{ $it->sort_order }}</td>
                            <td>{{ $it->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                                <button class="btn btn-sm btn-secondary" wire:click="editContact({{ $it->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $it->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="p-3">{{ $items->links() }}</div>
            </div>
        </div>
    </div>
    </div>
</div>



