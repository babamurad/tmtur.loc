<section id="contact" class="py-5 bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-5">{{ __('messages.contact_us') }}</h2>



        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg form-card p-3">
                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <div class="mb-3"><input name="name" type="text" class="form-control" placeholder="{{ __('messages.your_name') }}" required></div>
                        <div class="mb-3"><input name="email" type="email" class="form-control" placeholder="{{ __('messages.your_email') }}" required></div>
                        <div class="mb-3"><input name="phone" type="tel" class="form-control" placeholder="{{ __('messages.your_phone') }}" required></div>
                        <div class="mb-3"><textarea name="message" class="form-control" rows="5" placeholder="{{ __('messages.your_message') }}" required></textarea></div>
                        <button class="btn btn-send btn-lg w-100">{{ __('messages.send_message') }}</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-lg contact-card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">{{ __('messages.our_contacts') }}</h5>

                        @php
                            $contacts = \App\Models\ContactInfo::where('is_active',1)->orderBy('sort_order')->get();
                            $socials = \App\Models\SocialLink::where('is_active',1)->orderBy('sort_order')->get();
                        @endphp

                        @foreach($contacts as $item)
                            <div class="d-flex align-items-start mb-3">
                                <i class="{{ $item->icon }} contact-icon me-3"></i>
                                <div>
                                    <div class="fw-bold">{{ $item->tr('label') }}</div>
                                    <span>{!! nl2br(e($item->tr('value'))) !!}</span>
                                </div>
                            </div>
                        @endforeach

                        <div>
                            <div class="fw-bold mb-2">{{ __('messages.follow_us') }}</div>
                            <div class="d-flex gap-2">
                                @foreach($socials as $soc)
                                    <a href="{{ $soc->url }}" target="_blank" class="btn btn-lg {{ $soc->btn_class }} soc-btn">
                                        @if($soc->icon)
                                            <i class="bx {{ $soc->icon }}"></i>
                                        @else
                                            <i class="bx bxl-{{ Str::lower($soc->name) }}"></i>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
