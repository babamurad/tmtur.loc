<div class="page-content">
    <div class="container-fluid">

        {{-- Заголовок страницы и хлебные крошки --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Редактировать отзыв</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('reviews.index') }}">Отзывы</a></li>
                        <li class="breadcrumb-item active">Редактирование</li>
                    </ol>
                </div>
            </div>
        </div>

        <form wire:submit="save">
            <div class="row">
                {{-- Main Content Column --}}
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Данные отзыва</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userSelect">Пользователь <span class="text-danger">*</span></label>
                                        <select class="form-control @error('user_id') is-invalid @enderror"
                                            id="userSelect" wire:model="user_id">
                                            <option value="">-- Выберите --</option>
                                            @foreach($users as $u)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tourSelect">Тур <span class="text-danger">*</span></label>
                                        <select class="form-control @error('tour_id') is-invalid @enderror"
                                            id="tourSelect" wire:model="tour_id">
                                            <option value="">-- Выберите --</option>
                                            @foreach($tours as $t)
                                                <option value="{{ $t->id }}">{{ $t->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('tour_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Рейтинг <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="rating-{{ $i }}" name="rating"
                                                class="custom-control-input" value="{{ $i }}" wire:model="rating">
                                            <label class="custom-control-label" for="rating-{{ $i }}">{{ $i }} <i
                                                    class="fas fa-star text-warning small"></i></label>
                                        </div>
                                    @endfor
                                </div>
                                @error('rating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label for="commentTextarea">Комментарий</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror"
                                    id="commentTextarea" rows="5" wire:model="comment"></textarea>
                                @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="col-lg-4">
                    {{-- Settings Section --}}
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Настройки</h5>
                            <div class="form-group mb-0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="isActiveSwitch"
                                        wire:model="is_active">
                                    <label class="custom-control-label" for="isActiveSwitch">
                                        <strong>Активен</strong>
                                        <br>
                                        <small class="text-muted">Опубликован на сайте</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-success btn-block waves-effect waves-light">
                                <i class="fas fa-check-double font-size-16 align-middle mr-1"></i> Сохранить
                            </button>
                            <a href="{{ route('reviews.index') }}"
                                class="btn btn-secondary btn-block waves-effect waves-light mt-2">
                                <i class="fas fa-times font-size-16 align-middle mr-1"></i> Отмена
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>