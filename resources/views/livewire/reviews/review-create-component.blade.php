<div class="page-content">
    <div class="container-fluid">

        <!-- page-title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Создать отзыв</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('reviews.index') }}">Отзывы</a></li>
                        <li class="breadcrumb-item active">Создать</li>
                    </ol>
                </div>
            </div>
        </div>


        <!-- форма -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Основные данные</h5>

                        <form wire:submit.prevent="save">
                            <div class="form-group">
                                <label>Пользователь <span class="text-danger">*</span></label>
                                <select class="form-control" wire:model.defer="user_id">
                                    <option value="0">-- Выберите --</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group">
                                <label>Тур <span class="text-danger">*</span></label>
                                <select class="form-control" wire:model.defer="tour_id">
                                    <option value="0">-- Выберите --</option>
                                    @foreach($tours as $t)
                                        <option value="{{ $t->id }}">{{ $t->title }}</option>
                                    @endforeach
                                </select>
                                @error('tour_id')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

{{--                            <div class="form-group">--}}
{{--                                <label>Рейтинг <span class="text-danger">*</span></label>--}}
{{--                                <select class="form-control" wire:model.defer="rating">--}}
{{--                                    @for($i=1;$i<=5;$i++)--}}
{{--                                        <option value="{{ $i }}">{{ $i }} ★</option>--}}
{{--                                    @endfor--}}
{{--                                </select>--}}
{{--                                @error('rating')--}}
{{--                                <div class="invalid-feedback">{{ $message }}</div> @enderror--}}
{{--                            </div>--}}

                            <div class="star-rating mb-3">
                                {{-- Радиокнопки расположены в обратном порядке для удобства CSS --}}
                                <input wire:model.defer="rating" type="radio" id="star5" name="rating" value="5" required />
                                <label for="star5" title="Отлично"></label>

                                <input wire:model.defer="rating" type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="Хорошо"></label>

                                <input wire:model.defer="rating" type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="Удовлетворительно"></label>

                                <input wire:model.defer="rating" type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="Плохо"></label>

                                <input wire:model.defer="rating" type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="Ужасно"></label>
                            </div>

                            <div class="form-group">
                                <label>Комментарий</label>
                                <textarea class="form-control" rows="4" wire:model.defer="comment"></textarea>
                                @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

