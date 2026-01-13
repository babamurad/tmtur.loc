<?php

use App\Livewire\ContactInfosCrud;
use App\Livewire\Front\CategoryIndex;
use App\Livewire\Front\CategoryShowTour;
use App\Livewire\Front\HomeComponent;
use App\Livewire\Front\TourGroupsIndexComponent;
use App\Livewire\Front\Auth\LoginComponent as FrontLoginComponent;
use App\Livewire\Front\Auth\RegisterComponent as FrontRegisterComponent;
use App\Livewire\Gallery\GalleryCreate;
use App\Livewire\Gallery\GalleryEdit;
use App\Livewire\Gallery\GalleryIndex;
use App\Livewire\Posts\PostCreateComponent;
use App\Livewire\Posts\PostEditComponent;
use App\Livewire\Posts\PostIndexComponent;
use App\Livewire\ProfileEdit;
use Illuminate\Support\Facades\Auth;
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
use App\Livewire\Front\Privacy;
use App\Livewire\Front\Terms;


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', \App\Livewire\DashboardComponent::class)->name('dashboard');
    Route::get('guides', GuideIndexComponent::class)->name('guides.index');
    Route::get('guides/create', GuideCreateComponent::class)->name('guides.create');
    Route::get('guides/edit/{id}', GuideEditComponent::class)->name('guides.edit');

    Route::get('carousels', CarouselIndexComponent::class)->name('carousels.index');
    Route::get('carousels/create', CarouselCreateComponent::class)->name('carousels.create');
    Route::get('carousels/edit/{id}', CarouselEditComponent::class)->name('carousels.edit');

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

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/tours', TourIndexComponent::class)->name('tours.index');
        Route::get('/tours/create', TourCreateComponent::class)->name('tours.create');
        Route::get('/tours/edit/{id}', TourEditComponent::class)->name('tours.edit');
    });

    Route::get('tour-groups', App\Livewire\TourGroups\TourGroupIndexComponent::class)->name('tour-groups.index');
    Route::get('tour-groups/create', App\Livewire\TourGroups\TourGroupCreateComponent::class)->name('tour-groups.create');
    Route::get('tour-groups/edit/{tourGroup}', App\Livewire\TourGroups\TourGroupEditComponent::class)->name('tour-groups.edit');
    Route::get('tour-groups/delete/{tourGroup}', App\Livewire\TourGroups\TourGroupIndexComponent::class)->name('tour-groups.delete');

    Route::get('inclusions', App\Livewire\Inclusions\InclusionIndexComponent::class)->name('inclusions.index');
    Route::get('inclusions/create', App\Livewire\Inclusions\InclusionCreateComponent::class)->name('inclusions.create');
    Route::get('inclusions/edit/{id}', App\Livewire\Inclusions\InclusionEditComponent::class)->name('inclusions.edit');

    Route::get('tags', App\Livewire\Tags\TagIndexComponent::class)->name('admin.tags.index');
    Route::get('tags/create', App\Livewire\Tags\TagCreateComponent::class)->name('admin.tags.create');
    Route::get('tags/edit/{id}', App\Livewire\Tags\TagEditComponent::class)->name('admin.tags.edit');

    Route::get('services', App\Livewire\Services\ServiceIndexComponent::class)->name('services.index');
    Route::get('services/create', App\Livewire\Services\ServiceCreateComponent::class)->name('services.create');
    Route::get('services/edit/{service}', App\Livewire\Services\ServiceEditComponent::class)->name('services.edit');

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', PostIndexComponent::class)->name('index');
        Route::get('/create', PostCreateComponent::class)->name('create');
        Route::get('/edit/{id}', PostEditComponent::class)->name('edit');
    });

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', ReviewIndexComponent::class)->name('index');
        Route::get('/create', ReviewCreateComponent::class)->name('create');
        Route::get('/edit/{review:id}', ReviewEditComponent::class)->name('edit');
    });

    Route::get('contact-infos', ContactInfosCrud::class)->name('admin.contact-infos');
    Route::get('profile-edit', ProfileEdit::class)->name('admin.profile-edit');
    Route::get('contact-messages', \App\Livewire\ContactMessagesTable::class)->name('admin.contact-messages-table');

    Route::prefix('gallery.')->name('gallery.')->group(function () {
        Route::get('/', GalleryIndex::class)->name('index');
        Route::get('/create', GalleryCreate::class)->name('create');
        Route::get('/edit/{id}', GalleryEdit::class)->name('edit');
    });

    Route::get('newsletter-subscribers', \App\Livewire\Admin\NewsletterSubscribersCrud::class)->name('admin.newsletter-subscribers');

    Route::get('link-generator', \App\Livewire\Admin\LinkGeneratorComponent::class)->name('admin.link-generator');
    Route::get('link-generator/{id}/stats', \App\Livewire\Admin\LinkStatsComponent::class)->name('admin.link-generator.stats');

    Route::get('locations', \App\Livewire\Admin\Location\LocationIndexComponent::class)->name('admin.locations.index');
    Route::get('locations/create', \App\Livewire\Admin\Location\LocationCreateComponent::class)->name('admin.locations.create');
    Route::get('locations/edit/{location_id}', \App\Livewire\Admin\Location\LocationEditComponent::class)->name('admin.locations.edit');

    Route::get('hotels', \App\Livewire\Admin\Hotel\HotelIndexComponent::class)->name('admin.hotels.index');
    Route::get('hotels/create', \App\Livewire\Admin\Hotel\HotelCreateComponent::class)->name('admin.hotels.create');
    Route::get('hotels/edit/{hotel_id}', \App\Livewire\Admin\Hotel\HotelEditComponent::class)->name('admin.hotels.edit');

    Route::get('places', \App\Livewire\Admin\Place\PlaceIndexComponent::class)->name('admin.places.index');
    Route::get('places/create', \App\Livewire\Admin\Place\PlaceCreateComponent::class)->name('admin.places.create');
    Route::get('places/edit/{place_id}', \App\Livewire\Admin\Place\PlaceEditComponent::class)->name('admin.places.edit');

    Route::get('routes', \App\Livewire\Admin\Routes\RouteIndexComponent::class)->name('admin.routes.index');
    Route::get('routes/create', \App\Livewire\Admin\Routes\RouteCreateComponent::class)->name('admin.routes.create');
    Route::get('routes/edit/{id}', \App\Livewire\Admin\Routes\RouteEditComponent::class)->name('admin.routes.edit');

    Route::get('pages', \App\Livewire\Admin\Pages\PagesIndexComponent::class)->name('admin.pages.index');
    Route::get('pages/create', \App\Livewire\Admin\Pages\PagesCreateComponent::class)->name('admin.pages.create');
    Route::get('pages/edit/{id}', \App\Livewire\Admin\Pages\PagesEditComponent::class)->name('admin.pages.edit');

    //    Route::get('social-links', SocialLinksCrud::class)->name('admin.social-links');
});

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
});

Route::get('cart', \App\Livewire\Front\CartComponent::class)->name('cart.index');
Route::post('checkout', [\App\Livewire\Front\CartComponent::class, 'checkout'])->name('cart.checkout');

Route::middleware('guest')->group(function () {
    Route::get('auth/register', FrontRegisterComponent::class)->name('front.register');
    Route::get('auth/login', FrontLoginComponent::class)->name('front.login');
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