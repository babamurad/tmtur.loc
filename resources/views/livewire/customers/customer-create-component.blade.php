<div class="page-content">
    <div class="container-fluid">

        {{-- Заголовок --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Создать клиента</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Клиенты</a></li>
                            <li class="breadcrumb-item active">Создание</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="save">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="full_name" class="form-label">ФИО <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="full_name" class="form-control" wire:model="full_name"
                                            placeholder="Иванов Иван Иванович">
                                        @error('full_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control" wire:model="email"
                                            placeholder="client@example.com">
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Телефон</label>
                                        <input type="text" id="phone" class="form-control" wire:model="phone"
                                            placeholder="+993...">
                                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="passport" class="form-label">Паспортные данные</label>
                                        <input type="text" id="passport" class="form-control" wire:model="passport"
                                            placeholder="I-AŞ 123456">
                                        @error('passport') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gdpr_consent_at" class="form-label">Дата согласия (GDPR)</label>
                                        <input type="date" id="gdpr_consent_at" class="form-control"
                                            wire:model="gdpr_consent_at">
                                        @error('gdpr_consent_at') <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Отмена</a>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>