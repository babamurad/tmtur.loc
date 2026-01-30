<?php

use App\Livewire\Front\CategoryIndex;
use App\Livewire\Front\CategoryShowTour;
use App\Livewire\Front\HomeComponent;
use App\Livewire\Front\TourGroupsIndexComponent;
use App\Livewire\Front\Auth\LoginComponent as FrontLoginComponent;
use App\Livewire\Front\Auth\RegisterComponent as FrontRegisterComponent;
use App\Livewire\Front\Privacy;
use App\Livewire\Front\Terms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




// Admin routes are now in routes/admin.php


//Route::middleware(['auth', 'role:admin,manager'])->group(function () {
//    Route::get('/', HomeComponent::class);
//});
//
//Route::middleware(['auth'])->group(function () {
//    Route::get('/', HomeComponent::class);
//});

Route::middleware(['cache.response:3600'])->group(function () {
    Route::get('/', HomeComponent::class)->name('home');

    Route::get('tours/{tour:slug}', \App\Livewire\Front\ToursShow::class)->name('tours.show');
    Route::get('tours/category/{slug}', CategoryShowTour::class)->name('tours.category.show');
    Route::get('tours/tag/{id}', \App\Livewire\Front\TagShowTour::class)->name('tours.tag.show');
    Route::get('/all-categories', CategoryIndex::class)->name('tours.category.index');

    // Тур-группы (публичная страница)
    Route::get('tour-groups-date', TourGroupsIndexComponent::class)->name('front.tour-groups');

    Route::get('blog', \App\Livewire\Front\PostsIndex::class)->name('blog.index');
    Route::get('blog/category/{categorySlug}', \App\Livewire\Front\PostsIndex::class)->name('blog.category');
    Route::get('blog/{post:slug}', \App\Livewire\Front\PostShow::class)->name('blog.show');

    Route::get('gallery', \App\Livewire\Front\ProductGallery::class)->name('gallery');

    Route::get('visa', \App\Livewire\Front\VisaComponent::class)->name('visa');
    Route::get('about', \App\Livewire\Front\AboutComponent::class)->name('about');
    Route::get('reviews', \App\Livewire\Front\ReviewsIndex::class)->name('reviews.index');

    // User Profile
    Route::get('profile', \App\Livewire\Front\UserProfile::class)->name('front.profile');
});

Route::get('cart', \App\Livewire\Front\CartComponent::class)->name('cart.index');
Route::post('checkout', [\App\Livewire\Front\CartComponent::class, 'checkout'])->name('cart.checkout');

Route::middleware('guest')->group(function () {
    Route::get('auth/register', FrontRegisterComponent::class)->name('front.register');
    Route::get('auth/login', FrontLoginComponent::class)->name('front.login');

    Route::get('auth/google', [\App\Http\Controllers\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [\App\Http\Controllers\SocialAuthController::class, 'handleGoogleCallback']);
});

Route::get('register', \App\Livewire\Auth\RegisterComponent::class)->name('register');
Route::get('login', \App\Livewire\Auth\LoginComponent::class)->name('login');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('privacy', Privacy::class)->name('privacy');
Route::get('terms', Terms::class)->name('terms');

Route::get('sitemap.xml', fn() => response()->file(public_path('sitemap.xml')));