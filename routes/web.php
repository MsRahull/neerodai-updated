<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminVideosurlController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ta'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
});

Route::get('/', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/blog', function () {
    return view('blog');
});
// Route::get('/gallery', function () {
//     return view('gallery');
// });

Route::get('/gallery', [GalleryController::class, 'viewindex'])->name('gallery.view');

Route::get('/donate', function () {
    return view('donate');
});

// Route::get('/pay', [PaymentController::class, 'pay'])->name('pay');
// Route::post('/create-order', [PaymentController::class, 'createOrder'])->name('create.order');
// Route::post('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

Route::get('/pay', [PaymentController::class, 'pay'])->name('donate.page');
Route::post('/create-order', [PaymentController::class, 'createOrder'])->name('create.order');
Route::post('/verify-payment', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

// Route::get('/videos', function () {
//     return view('videos');
// });

Route::get('/videos', [AdminVideosurlController::class, 'viewindex'])->name('videos.view');

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

// In web.php
Route::get('/donate/redirect', function () {
    return redirect()->away('https://rzp.io/l/rahul5022');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Route::middleware(['auth:admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('admin.main');
//     })->name('admin.main');
// });

Route::middleware('auth:admin')->get('/admin/dashboard', function () {
    return view('admin.main');
});
// Route::middleware('auth:admin')->get('/admin/gallery', function () {
//     return view('admin.admingallery');
// });
// routes/web.php
Route::middleware(['auth:admin'])->group(function () {
    Route::get('admin/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::post('admin/gallery', [GalleryController::class, 'store'])->name('gallery.store');

    Route::put('admin/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('admin/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
   
});

Route::middleware(['auth:admin'])->group(function () {
    // Videos management
    Route::get('admin/videos', [AdminVideosurlController::class, 'index'])->name('videos.index');

    Route::get('admin/videos', [AdminVideosurlController::class, 'index'])->name('videos.index');
    Route::post('admin/videos', [AdminVideosurlController::class, 'store'])->name('videos.store');
    Route::put('admin/videos/{video}', [AdminVideosurlController::class, 'update'])->name('videos.update');
    Route::delete('admin/videos/{video}', [AdminVideosurlController::class, 'destroy'])->name('videos.destroy');
});

// Route::middleware('auth:admin')->get('/admin/videos', function () {
//     return view('admin.adminvideos');
// });
Route::middleware('auth:admin')->get('/admin/payments', function () {
    return view('admin.adminpayments');
});
Route::middleware(['auth:admin'])->group(function () {
    Route::get('admin/payments', [PaymentController::class, 'index'])->name('payments.index');
});
// Route::middleware('auth:admin')->get('/admin/customers', function () {
//     return view('admin.admincustomers');
// });

Route::middleware(['auth:admin'])->group(function () {
    Route::get('admin/customers', [ContactController::class, 'index'])->name('contacts.index');
    Route::delete('admin/customers/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});