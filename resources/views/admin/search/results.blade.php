@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Результаты поиска</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Дашборд</a></li>
                                <li class="breadcrumb-item active">Поиск</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">По запросу: "{{ $query }}"</h5>

                    @if($tours->isEmpty() && $users->isEmpty() && $referrals->isEmpty() && $posts->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            Ничего не найдено.
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                @if($tours->isNotEmpty())
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Туры ({{ $tours->count() }})</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <tbody>
                                            @foreach($tours as $tour)
                                                <tr>
                                                    <td>
                                                        <h5 class="font-size-14 mb-1"><a
                                                                href="{{ route('admin.tours.edit', $tour->id) }}"
                                                                class="text-dark">{{ $tour->title }}</a></h5>
                                                        <small
                                                            class="text-muted">{{ Str::limit($tour->short_description, 50) }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($users->isNotEmpty())
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Пользователи ({{ $users->count() }})</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>
                                                        <h5 class="font-size-14 mb-1"><a href="{{ route('users.edit', $user->id) }}"
                                                                class="text-dark">{{ $user->name }}</a></h5>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($referrals->isNotEmpty())
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Рефералы ({{ $referrals->count() }})</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <tbody>
                                            @foreach($referrals as $referral)
                                                <tr>
                                                    <td>
                                                        <h5 class="font-size-14 mb-1"><a
                                                                href="{{ route('users.edit', $referral->id) }}"
                                                                class="text-dark">{{ $referral->name }}</a></h5>
                                                        <small class="text-muted">{{ $referral->email }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($posts->isNotEmpty())
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Статьи ({{ $posts->count() }})</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <tbody>
                                            @foreach($posts as $post)
                                                <tr>
                                                    <td>
                                                        <h5 class="font-size-14 mb-1"><a href="{{ route('posts.edit', $post->id) }}"
                                                                class="text-dark">{{ $post->title }}</a></h5>
                                                        <small
                                                            class="text-muted">{{ Str::limit(strip_tags($post->content), 50) }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div> <!-- container-fluid -->
    </div>
@endsection