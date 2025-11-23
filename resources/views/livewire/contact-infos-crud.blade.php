<div class="page-content">
    <div class="container-fluid">
        <div class="card card-animate">
            <div class="card-body">

                <h4 class="card-title">Конакты</h4>
                <p class="card-subtitle mb-4">Общая контактная информация.</p>

                <div class="row">
                    <div class="col-sm-3 mb-2 mb-sm-0">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link {{ $activeTab === 'contact-tab' ? 'active show' : '' }} "
                               id="contact-tab"
                               data-toggle="pill"
                               href="#contact"
                               role="tab"
                               aria-controls="contact"
                               aria-selected="{{ $activeTab === 'contact-tab' ? 'true' : 'false' }}"
                               wire:click="selectActiveTab('contact-tab')"
                            >
                                <i class="mdi mdi-home-variant d-lg-none d-block"></i>
                                <span class="d-none d-lg-block">Контактная информация</span>
                            </a>
                            <a class="nav-link {{ $activeTab === 'social_links-tab' ? 'active show' : '' }}"
                               id="social_links-tab"
                               data-toggle="pill"
                               href="#social_links"
                               role="tab"
                               aria-controls="social_links"
                               aria-selected="{{ $activeTab === 'social_links-tab' ? 'true' : 'false' }}"
                               wire:click="selectActiveTab('social_links-tab')"
                            >
                                <i class="mdi mdi-account-circle d-lg-none d-block"></i>
                                <span class="d-none d-lg-block">Ссылки на соцсети</span>
                            </a>
                        </div>
                    </div> <!-- end col-->

                    <div class="col-sm-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade {{ $activeTab === 'contact-tab' ? 'active show' : '' }} show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <form wire:submit.prevent="store">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label>Type</label>
                                                    <input type="text" wire:model.defer="type" class="form-control" placeholder="type (address, phone)" required>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label>Icon (bx ...)</label>
                                                    <input type="text" wire:model.defer="icon" class="form-control">
                                                </div>
                                            </div>

                                            <div class="card border mb-3">
                                                <div class="card-header p-0 border-bottom-0">
                                                    <ul class="nav nav-tabs" id="langTab" role="tablist">
                                                        @foreach(config('app.available_locales') as $locale)
                                                            <li class="nav-item">
                                                                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                                   id="lang-{{ $locale }}-tab"
                                                                   data-toggle="tab"
                                                                   href="#lang-{{ $locale }}"
                                                                   role="tab"
                                                                   aria-controls="lang-{{ $locale }}"
                                                                   aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                                    {{ strtoupper($locale) }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <div class="tab-content" id="langTabContent">
                                                        @foreach(config('app.available_locales') as $locale)
                                                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                                 id="lang-{{ $locale }}"
                                                                 role="tabpanel"
                                                                 aria-labelledby="lang-{{ $locale }}-tab">

                                                                <div class="form-group">
                                                                    <label>Label ({{ strtoupper($locale) }})</label>
                                                                    <input type="text" wire:model.defer="trans.{{ $locale }}.label" class="form-control">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Value ({{ strtoupper($locale) }})</label>
                                                                    <textarea wire:model.defer="trans.{{ $locale }}.value" class="form-control" rows="3"></textarea>
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
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
                                                    <td>{{ $it->tr('label') }}</td>
                                                    <td>{{ $it->type }}</td>
                                                    <td style="white-space:pre-wrap;">{{ $it->tr('value') }}</td>
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
                            <div class="tab-pane fade {{ $activeTab === 'social_links-tab' ? 'active show' : '' }}" id="social_links" role="tabpanel" aria-labelledby="social_links-tab">
                                @livewire('social-links-crud')
                            </div>
                        </div> <!-- end tab-content-->
                    </div> <!-- end col-->
                </div>
                <!-- end row-->
            </div> <!-- end card-body-->
        </div>

    </div>


    <ul>
        @foreach($icons as $icon)
            <li>
                {!!$icon!!}
            </li>
        @endforeach
    </ul>
</div>



