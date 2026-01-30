<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container py-5">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ config('app.name') }}</h1>
            <nav>
                @if (Route::has('login'))
                    <div class="d-flex">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary shadow-sm">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary shadow-sm mr-2">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary shadow-sm">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </nav>
        </header>

        <main>
            <div class="jumbotron p-5 rounded">
                <h1 class="display-4 font-weight-bold">Welcome to {{ config('app.name') }}</h1>
                <p class="lead">This project is configured to use Bootstrap 4.</p>
                <hr class="my-4">
                <p>Tailwind CSS has been removed.</p>
            </div>
        </main>

        <footer class="pt-3 mt-4 text-muted border-top">
            &copy; {{ date('Y') }}
        </footer>
    </div>
</body>

</html>