<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomeComponent;
use App\Livewire\Tours\TourIndexComponent;
use App\Livewire\Tours\TourCreateComponent;
use App\Livewire\Tours\TourEditComponent;
use App\Livewire\Guides\GuideIndexComponent;
use App\Livewire\Guides\GuideEditComponent;
use App\Livewire\Guides\GuideCreateComponent;
use App\Livewire\CarouselSlides\CarouselSlideIndexComponent;
use App\Livewire\CarouselSlides\CarouselSlideCreateComponent;
use App\Livewire\CarouselSlides\CarouselSlideEditComponent;
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
// use App\Http\Livewire\RouteIndexComponent;
// use App\Http\Livewire\RouteShowComponent;

Route::get('/', HomeComponent::class)->name('home');

Route::get('/tours', TourIndexComponent::class)->name('tours.index');
Route::get('/tours/create', TourCreateComponent::class)->name('tours.create');
Route::get('/tours/edit/{id}', TourEditComponent::class)->name('tours.edit');

Route::get('guides', GuideIndexComponent::class)->name('guides.index');
Route::get('guides/create', GuideCreateComponent::class)->name('guides.create');
Route::get('guides/edit/{id}', GuideEditComponent::class)->name('guides.edit');

Route::get('carousel-slides', CarouselSlideIndexComponent::class)->name('carousel-slides.index');
Route::get('carousel-slides/create', CarouselSlideCreateComponent::class)->name('carousel-slides.create');
Route::get('carousel-slides/edit/{id}', CarouselSlideEditComponent::class)->name('carousel-slides.edit');

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

Route::get('tour-groups', App\Livewire\TourGroups\TourGroupIndexComponent::class)->name('tour-groups.index');
