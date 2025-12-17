@php
    // Обработка смены языка через POST
    if (request()->isMethod('post') && request()->has('locale')) {
        $locale = request()->input('locale');
        if (in_array($locale, config('app.available_locales'))) {
            session()->put('locale', $locale);
            app()->setLocale($locale);
        }
        return redirect(request()->url());
    }
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-C5C6D1TJJW"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-C5C6D1TJJW');
    </script>

    <!-- Start cookieyes banner -->
    @if(config('app.env') === 'production')
        <script id="cookieyes" type="text/javascript"
            src="https://cdn-cookieyes.com/client_data/bfb64a58994c32d4e86c363b60b99a9e/script.js"></script>
    @endif
    <!-- End cookieyes banner -->

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TJZ6LF4Z');</script>
    <!-- End Google Tag Manager -->

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TJZ6LF4Z" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <meta charset="utf-8">
    <title>{{ __('layout.404_title') }} | TmTourism</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🐪</text></svg>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 4.6 CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mdb-pro.min.css') }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(99, 102, 241, 0.06), transparent 30%),
                radial-gradient(circle at 80% 0%, rgba(45, 212, 191, 0.08), transparent 32%),
                linear-gradient(180deg, #f7f8fb 0%, #f0f4ff 100%);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin: 0;
        }

        .error-container {
            text-align: center;
            max-width: 700px;
            width: 100%;
        }

        .error-code {
            font-size: 150px;
            font-weight: 700;
            line-height: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
            text-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .error-title {
            font-size: 36px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .error-message {
            font-size: 18px;
            color: #6b7280;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .error-illustration {
            width: 300px;
            height: 300px;
            margin: 0 auto 40px;
            position: relative;
        }

        .error-illustration svg {
            width: 100%;
            height: 100%;
            animation: fadeInUp 1s ease-out;
        }

        .btn-home {
            padding: 14px 32px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            color: white;
            text-decoration: none;
        }

        .btn-home:active {
            transform: translateY(0);
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: floatAround 15s infinite ease-in-out;
        }

        .floating-element:nth-child(1) {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatAround {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            25% {
                transform: translate(30px, -30px) rotate(90deg);
            }
            50% {
                transform: translate(-20px, 20px) rotate(180deg);
            }
            75% {
                transform: translate(20px, 30px) rotate(270deg);
            }
        }

        .language-switcher {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .language-switcher .dropdown-toggle {
            padding: 8px 16px;
            font-weight: 600;
            border-radius: 8px;
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.2);
            color: #667eea;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .language-switcher .dropdown-toggle:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .language-switcher .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: none;
            padding: 8px;
        }

        .language-switcher .dropdown-item {
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .language-switcher .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .language-switcher .dropdown-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 100px;
            }

            .error-title {
                font-size: 28px;
            }

            .error-message {
                font-size: 16px;
            }

            .error-illustration {
                width: 200px;
                height: 200px;
            }

            .language-switcher {
                top: 15px;
                right: 15px;
            }

            .language-switcher .dropdown-toggle {
                padding: 6px 12px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- Language Switcher -->
    <div class="language-switcher">
        <form method="POST" action="{{ request()->url() }}" id="locale-form">
            @csrf
            <input type="hidden" name="locale" id="locale-input">
        </form>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ strtoupper(app()->getLocale()) }}
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
                @foreach(config('app.available_locales') as $locale)
                    <button type="button" 
                            class="dropdown-item text-center {{ app()->getLocale() === $locale ? 'active' : '' }}"
                            onclick="document.getElementById('locale-input').value='{{ $locale }}'; document.getElementById('locale-form').submit();">
                        {{ strtoupper($locale) }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="error-container">
        <div class="error-illustration">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Background circle -->
                <circle cx="100" cy="100" r="90" fill="none" stroke="rgba(102, 126, 234, 0.1)" stroke-width="2"/>
                
                <!-- Central 404 text -->
                <text x="100" y="110" font-family="Inter, sans-serif" font-size="60" font-weight="700" 
                      fill="url(#gradient)" text-anchor="middle">404</text>
                
                <!-- Gradient definition -->
                <defs>
                    <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                        <stop offset="50%" style="stop-color:#764ba2;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#f093fb;stop-opacity:1" />
                    </linearGradient>
                </defs>
                
                <!-- Decorative elements -->
                <circle cx="50" cy="50" r="8" fill="#667eea" opacity="0.3">
                    <animate attributeName="opacity" values="0.3;0.7;0.3" dur="2s" repeatCount="indefinite"/>
                </circle>
                <circle cx="150" cy="60" r="6" fill="#764ba2" opacity="0.3">
                    <animate attributeName="opacity" values="0.3;0.7;0.3" dur="2.5s" repeatCount="indefinite"/>
                </circle>
                <circle cx="40" cy="150" r="7" fill="#f093fb" opacity="0.3">
                    <animate attributeName="opacity" values="0.3;0.7;0.3" dur="3s" repeatCount="indefinite"/>
                </circle>
                <circle cx="160" cy="150" r="9" fill="#4facfe" opacity="0.3">
                    <animate attributeName="opacity" values="0.3;0.7;0.3" dur="2.2s" repeatCount="indefinite"/>
                </circle>
            </svg>
        </div>

        <div class="error-code">404</div>
        
        <h1 class="error-title">{{ __('layout.404_title') }}</h1>
        
        <p class="error-message">{{ __('layout.404_message') }}</p>
        
        <a href="{{ route('home') }}" class="btn-home">
            <i class="fas fa-home mr-2"></i>{{ __('layout.404_back_home') }}
        </a>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/mdb.min.js') }}"></script>
</body>

</html>

