<?php

use App\Http\Controllers\PaymentsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
})->name('index');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how');

Route::get('/contact-us', function () {
    return view('contact');
})->name('contact');

// Public route for subscription plans
Route::get('/dashboard/plan', [DashboardController::class, 'subscribe'])->name('plan');



Route::middleware('user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    //Auth KYC Endpoints

    Route::get('/dashboard/kyc', [DashboardController::class, 'kyc'])->middleware(['auth', 'verified'])->name('dashboard.kyc');

    Route::post('/dashboard/kyc/store', [DashboardController::class, 'kycStore'])->name('dashboard.kyc.store');

    Route::put('/dashboard/kyc/update/{id}', [DashboardController::class, 'kycUpdate'])->name('dashboard.kyc.update');

    Route::get('/dashboard/kyc/status', [DashboardController::class, 'kycStatus'])->middleware(['auth', 'verified'])->name('dashboard.kyc.status');

    //Auth Account Dashoard Activation Endpoints

    Route::get('/dashboard/account', [DashboardController::class, 'account'])->name('dashboard.account');

    Route::post('/dashboard/account/store', [DashboardController::class, 'accountStore'])->name('dashboard.account.store');

    Route::put('/dashboard/account/update/{id}', [DashboardController::class, 'retryAccountStore'])->name('dashboard.account.update');

    Route::get('/dashboard/account/retry', [DashboardController::class, 'account'])->name('dashboard.account.retry');

    //Auth Payment Endpoints

    Route::get('/dashboard/payments', [PaymentsController::class, 'index'])->name('dashboard.payments');

    Route::get('/dashboard/payment/retry', [PaymentsController::class, 'retryPayment'])->name('dashboard.payments.retry');

    //Auth Subscription Endpoints

    Route::get('/dashboard/plans', [DashboardController::class, 'subscriptions'])->name('dashboard.subscriptions');

    Route::post('/dashboard/subscription/cache/{plan}', [DashboardController::class, 'subscribeStore'])->name('plan.store');

    Route::get('/dashboard/subscription/{plan}', [DashboardController::class, 'getPreferedSubscription'])->name('plan.checkout');

    Route::post('/dashboard/subscription/checkout', [DashboardController::class, 'checkoutSubscription'])->name('plan.checkout.store');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
