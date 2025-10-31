<section id="contact" class="py-5 bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-5">Contact us</h2>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg form-card p-3">
                    @if(session()->has('contact_success'))
                        <div class="alert alert-success">{{ session('contact_success') }}</div>
                    @endif
                    @if(session()->has('contact_error'))
                        <div class="alert alert-danger">{{ session('contact_error') }}</div>
                    @endif

                    <form wire:submit.prevent="submit" class="needs-validation" novalidate>
                        @csrf

                        {{-- Honeypot: скрытое поле для ловли ботов --}}
                        <div style="position:absolute; left:-9999px; top:auto; width:1px; height:1px; overflow:hidden;">
                            <label>Leave this field empty</label>
                            <input type="text" wire:model.defer="hp" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name" placeholder="Your name" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email" placeholder="Your email" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" wire:model.defer="phone" placeholder="Your phone">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <textarea class="form-control @error('message') is-invalid @enderror" wire:model.defer="message" rows="5" placeholder="Your message" required></textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-send btn-lg w-100" type="submit" @if($sending) disabled @endif>
                            <span wire:loading.remove>Send message</span>
                            <span wire:loading>Sending...</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow contact-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Our contacts</h5>

                        @php
                            $contacts = \App\Models\ContactInfo::where('is_active', 1)->orderBy('sort_order')->get();
                            $socials = \App\Models\SocialLink::where('is_active', 1)->orderBy('sort_order')->get();
                        @endphp

                        @foreach($contacts as $item)
                            <div class="d-flex align-items-start mb-3">
                                <i class="{{ $item->icon }} contact-icon mr-3"></i>
                                <div>
                                    <div class="font-weight-bold">{{ $item->label }}</div>
                                    <span>{!! nl2br(e($item->value)) !!}</span>
                                </div>
                            </div>
                        @endforeach

                        <div>
                            <div class="text-center mb-2 font-weight-bold">Follow us</div>
                            <div class="d-flex justify-content-center flex-wrap">
                                @foreach($socials as $soc)
                                    <a href="{{ $soc->url }}"
                                       target="_blank"
                                       rel="noopener"
                                       class="btn btn-primary soc-btn mx-1 {{ $soc->btn_class }}">
                                        <i class="fab fa-{{ Str::lower($soc->name) }}"></i>
                                    </a>
                                @endforeach
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="about" class="py-5"></section>
</section>
