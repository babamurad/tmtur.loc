<?php

use App\Livewire\Front\HomeComponent;
use App\Livewire\Posts\PostCreateComponent;
use App\Livewire\Posts\PostEditComponent;
use App\Livewire\Posts\PostIndexComponent;
use Illuminate\Support\Facades\Route;
use App\Livewire\Tours\TourIndexComponent;
use App\Livewire\Tours\TourCreateComponent;
use App\Livewire\Tours\TourEditComponent;
use App\Livewire\Guides\GuideIndexComponent;
use App\Livewire\Guides\GuideEditComponent;
use App\Livewire\Guides\GuideCreateComponent;
use App\Livewire\Carousel\CarouselIndexComponent;
use App\Livewire\Carousel\CarouselCreateComponent;
use App\Livewire\Carousel\CarouselEditComponent;
use App\Livewire\ContactInfos\ContactInfoIndexComponent;
use App\Livewire\ContactInfos\ContactInfoCreateComponent;
use App\Livewire\ContactInfos\ContactInfoEditComponent;
use App\Livewire\Bookings\BookingIndexComponent;
use App\Livewire\Bookings\BookingCreateComponent;
use App\Livewire\Bookings\BookingEditComponent;
use App\Livewire\BookingServices\BookingServiceIndexComponent;
use App\Livewire\BookingServices\BookingServiceCreateComponent;
use App\Livewire\BookingServices\BookingServiceEditComponent;
use App\Livewire\Categories\CategoryIndexComponent;
use App\Livewire\Categories\CategoryCreateComponent;
use App\Livewire\Categories\CategoryEditComponent;
use App\Livewire\CultureItems\CultureItemIndexComponent;
use App\Livewire\CultureItems\CultureItemCreateComponent;
use App\Livewire\CultureItems\CultureItemEditComponent;
use App\Livewire\Customers\CustomerIndexComponent;
use App\Livewire\Customers\CustomerCreateComponent;
use App\Livewire\Customers\CustomerEditComponent;
use App\Livewire\Reviews\ReviewIndexComponent;
use App\Livewire\Reviews\ReviewCreateComponent;
use App\Livewire\Reviews\ReviewEditComponent;
// use App\Http\Livewire\RouteIndexComponent;
// use App\Http\Livewire\RouteShowComponent;

Route::get('/', HomeComponent::class)->name('home');

Route::get('/dashboard', \App\Livewire\DashboardComponent::class)->name('dashboard');

Route::get('guides', GuideIndexComponent::class)->name('guides.index');
Route::get('guides/create', GuideCreateComponent::class)->name('guides.create');
Route::get('guides/edit/{id}', GuideEditComponent::class)->name('guides.edit');

Route::get('carousels', CarouselIndexComponent::class)->name('carousels.index');
Route::get('carousels/create', CarouselCreateComponent::class)->name('carousels.create');
Route::get('carousels/edit/{id}', CarouselEditComponent::class)->name('carousels.edit');

Route::get('contact-infos', ContactInfoIndexComponent::class)->name('contact-infos.index');
Route::get('contact-infos/create', ContactInfoCreateComponent::class)->name('contact-infos.create');
Route::get('contact-infos/edit/{id}', ContactInfoEditComponent::class)->name('contact-infos.edit');

Route::get('bookings', BookingIndexComponent::class)->name('bookings.index');
Route::get('bookings/create', BookingCreateComponent::class)->name('bookings.create');
Route::get('bookings/edit/{id}', BookingEditComponent::class)->name('bookings.edit');

Route::get('booking-services', BookingServiceIndexComponent::class)->name('booking-services.index');
Route::get('booking-services/create', BookingServiceCreateComponent::class)->name('booking-services.create');
Route::get('booking-services/edit/{id}', BookingServiceEditComponent::class)->name('booking-services.edit');

Route::get('categories', CategoryIndexComponent::class)->name('categories.index');
Route::get('categories/create', CategoryCreateComponent::class)->name('categories.create');
Route::get('categories/edit/{id}', CategoryEditComponent::class)->name('categories.edit');

Route::get('culture-items', CultureItemIndexComponent::class)->name('culture-items.index');
Route::get('culture-items/create', CultureItemCreateComponent::class)->name('culture-items.create');
Route::get('culture-items/edit/{id}', CultureItemEditComponent::class)->name('culture-items.edit');

Route::get('customers', CustomerIndexComponent::class)->name('customers.index');
Route::get('customers/create', CustomerCreateComponent::class)->name('customers.create');
Route::get('customers/edit/{id}', CustomerEditComponent::class)->name('customers.edit');


Route::get('tour-categories', App\Livewire\TourCategories\TourCategoryIndexComponent::class)->name('tour-categories.index');
Route::get('tour-categories/create', App\Livewire\TourCategories\TourCategoryCreateComponent::class)->name('tour-categories.create');
Route::get('tour-categories/edit/{id}', App\Livewire\TourCategories\TourCategoryEditComponent::class)->name('tour-categories.edit');

Route::get('/tours', TourIndexComponent::class)->name('tours.index');
Route::get('/tours/create', TourCreateComponent::class)->name('tours.create');
Route::get('/tours/edit/{id}', TourEditComponent::class)->name('tours.edit');

Route::get('tour-groups', App\Livewire\TourGroups\TourGroupIndexComponent::class)->name('tour-groups.index');
Route::get('tour-groups/create', App\Livewire\TourGroups\TourGroupCreateComponent::class)->name('tour-groups.create');
Route::get('tour-groups/edit/{tourGroup}', App\Livewire\TourGroups\TourGroupEditComponent::class)->name('tour-groups.edit');
Route::get('tour-groups/delete/{tourGroup}', App\Livewire\TourGroups\TourGroupIndexComponent::class)->name('tour-groups.delete');

Route::get('services', App\Livewire\Services\ServiceIndexComponent::class)->name('services.index');
Route::get('services/create', App\Livewire\Services\ServiceCreateComponent::class)->name('services.create');
Route::get('services/edit/{service}', App\Livewire\Services\ServiceEditComponent::class)->name('services.edit');

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/',             PostIndexComponent::class)->name('index');
    Route::get('/create',       PostCreateComponent::class)->name('create');
    Route::get('/edit/{post}',  PostEditComponent::class)->name('edit');
});

Route::prefix('reviews')->name('reviews.')->group(function () {
    Route::get('/',                ReviewIndexComponent::class)->name('index');
    Route::get('/create',          ReviewCreateComponent::class)->name('create');
    Route::get('/edit/{review}',   ReviewEditComponent::class)->name('edit');
});
