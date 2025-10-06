<div>
    <h1>Edit Service</h1>
    <form wire:submit.prevent="update">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" wire:model="name">
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" wire:model="description"></textarea>
            @error('description') <span>{{ $message }}</span> @enderror
        </div>

        <button type="submit">Update</button>
    </form>
</div>
