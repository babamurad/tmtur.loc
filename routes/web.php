<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomeComponent;
use App\Http\Livewire\TourIndexComponent;
use App\Http\Livewire\TourCreateComponent;
use App\Http\Livewire\TourEditComponent;
use App\Http\Livewire\GuideIndexComponent;
use App\Http\Livewire\GuideEditComponent;
use App\Http\Livewire\GuideCreateComponent;
// use App\Http\Livewire\RouteIndexComponent;
// use App\Http\Livewire\RouteShowComponent;

Route::get('/', HomeComponent::class)->name('home');
Route::get('/tours', TourIndexComponent::class)->name('tours.index');
Route::get('/tours/create', TourCreateComponent::class)->name('tours.create');
Route::get('/tours/edit/{id}', TourEditComponent::class)->name('tours.edit');

Route::get('guides', GuideIndexComponent::class)->name('guides.index');
Route::get('guides/edit/{id}', GuideEditComponent::class)->name('guides.edit');
Route::get('guides/create', RouteCreateComponent::class)->name('routes.create');

// Route::get('/guides', GuideIndexComponent::class)->name('guides.index');
// Route::get('/guides/{guide}', GuideShowComponent::class)->name('guides.show');
// Route::get('/routes', RouteIndexComponent::class)->name('routes.index');
// Route::get('/routes/{route}', RouteShowComponent::class)->name('routes.show');
