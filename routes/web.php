<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminVideosurlController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
*/

// Language switch (English / Tamil) — stored in the session, read by SetLocale middleware
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ta'], true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back(fallback: '/');
})->name('lang.switch');

Route::get('/', [BlogController::class, 'latest'])->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');
Route::view('/contact', 'contact')->name('contact');
Route::get('/donate', fn () => redirect(url('/pay'), 301))->name('donate');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

Route::get('/gallery', [GalleryController::class, 'viewindex'])->name('gallery.view');
Route::get('/videos', [AdminVideosurlController::class, 'viewindex'])->name('videos.view');

// Forms — rate limited to stop spam / abuse
Route::post('/contact-submit', [ContactController::class, 'submit'])
    ->middleware('throttle:5,1')
    ->name('contact.submit');

Route::get('/pay', [PaymentController::class, 'pay'])->name('donate.page');
Route::post('/create-order', [PaymentController::class, 'createOrder'])
    ->middleware('throttle:10,1')
    ->name('create.order');
Route::post('/verify-payment', [PaymentController::class, 'paymentSuccess'])
    ->middleware('throttle:20,1')
    ->name('payment.success');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    // /admin itself: logged-in admins land on the dashboard, everyone else is sent to the login page
    // (the auth:admin middleware on the dashboard does that redirect).
    Route::get('/', fn () => redirect()->route('admin.dashboard'))->name('admin.home');

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [AdminAuthController::class, 'login'])
            ->middleware('throttle:20,1') // per-IP backstop; per-account lockout is in the controller
            ->name('admin.login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        Route::get('dashboard', AdminDashboardController::class)->name('admin.dashboard');

        // Gallery
        Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('gallery', [GalleryController::class, 'store'])->name('gallery.store');
        Route::put('gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

        // Videos
        Route::get('videos', [AdminVideosurlController::class, 'index'])->name('videos.index');
        Route::post('videos', [AdminVideosurlController::class, 'store'])->name('videos.store');
        Route::put('videos/{video}', [AdminVideosurlController::class, 'update'])->name('videos.update');
        Route::delete('videos/{video}', [AdminVideosurlController::class, 'destroy'])->name('videos.destroy');

        // Blogs (previously these reused the "videos.*" names, which sent video forms to the blog controller)
        Route::get('blog', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
        Route::post('blog', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
        Route::put('blog/{blog}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
        Route::delete('blog/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');

        // Payments & contacts
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/export', [PaymentController::class, 'export'])->name('payments.export');
        Route::get('customers', [ContactController::class, 'index'])->name('contacts.index');
        Route::delete('customers/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::post('customers/{contact}/email', [ContactController::class, 'sendEmail'])
            ->middleware('throttle:30,1')
            ->name('contacts.email');
        Route::post('customers/{contact}/whatsapp', [ContactController::class, 'markWhatsapp'])->name('contacts.whatsapp');
    });
});
