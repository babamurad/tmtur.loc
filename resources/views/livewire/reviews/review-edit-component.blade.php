
<form wire:submit.prevent="save">
    <div class="form-group">
        <label>Пользователь <span class="text-danger">*</span></label>
        <select class="form-control" wire:model.defer="user_id">
            <option value="0">-- Выберите --</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
        </select>
        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Тур <span class="text-danger">*</span></label>
        <select class="form-control" wire:model.defer="tour_id">
            <option value="0">-- Выберите --</option>
            @foreach($tours as $t)
                <option value="{{ $t->id }}">{{ $t->title }}</option>
            @endforeach
        </select>
        @error('tour_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Рейтинг <span class="text-danger">*</span></label>
        <select class="form-control" wire:model.defer="rating">
            @for($i=1;$i<=5;$i++)
                <option value="{{ $i }}">{{ $i }} ★</option>
            @endfor
        </select>
        @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Комментарий</label>
        <textarea class="form-control" rows="4" wire:model.defer="comment"></textarea>
        @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="form-group mb-0">
        <button type="submit" class="btn btn-success">
            <i class="bx bx-check-double"></i> Сохранить
        </button>
        <a href="{{ route('reviews.index') }}" class="btn btn-secondary ml-2">
            <i class="bx bx-x"></i> Отмена
        </a>
    </div>
</form>

