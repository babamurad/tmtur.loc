<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>Edit Location</h3>
                        <a href="{{ route('admin.locations.index') }}" class="btn btn-primary">All Locations</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif
                    <form wire:submit.prevent="updateLocation">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" placeholder="Enter location name" wire:model="name"
                                wire:keyup="generateSlug">
                            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" class="form-control" placeholder="Enter location slug" wire:model="slug">
                            @error('slug') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" placeholder="Enter location description"
                                wire:model="description"></textarea>
                            @error('description') <p class="text-danger">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>