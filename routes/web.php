<?php

use League\Config\Configuration;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConfigurationController;


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

Route::get('/admin/config', [ConfigurationController::class, 'redirectConfigLayout'])->name('platform.settings');

Route::get('/admin/config/create', [ConfigurationController::class, 'index'])->middleware('admin')->name('platform.config.index');

Route::get('/admin/config/update', [ConfigurationController::class, 'update'])->middleware('admin')->name('platform.config.update');

Route::post('/admin/config/save', [ConfigurationController::class, 'save'])->middleware('admin')->name('platform.config.save');

Route::put('/admin/config/update/{id}', [ConfigurationController::class, 'updateConfig'])->middleware('admin')->name('platform.config.update-config');


// Route::screen('/app/admin/config/app', AppSettings::class)->name('platform.settings.config');



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

    Route::get('/dashboard/payout', [PaymentsController::class, 'payoutinfo'])->name('dashboard.withdrawal');

    Route::post('/dashboard/payout/create', [PaymentsController::class, 'storeWithdrawalAccount'])->name('withdrawal.accounts.store');

    Route::get('dashboard/payout/accounts/{id}/edit', [PaymentsController::class, 'editWithdrawalAccount'])->name('withdrawal.accounts.edit');

    Route::put('dashboard/payout/accounts/{id}', [PaymentsController::class, 'updateWithdrawalAccount'])->name('withdrawal.accounts.update');

    Route::delete('dashboard/payout/accounts/{id}', [PaymentsController::class, 'destroyWithdrawalAccount'])->name('withdrawal.accounts.destroy');

    Route::get('/dashboard/payment/retry/{id}', [PaymentsController::class, 'retryPayment'])->name('dashboard.payments.retry');

    Route::put('/dashboard/payment/update/{id}', [PaymentsController::class, 'updatePayment'])->name('dashboard.payments.update');

    //Auth Subscription Endpoints

    Route::get('/dashboard/plans', [DashboardController::class, 'subscriptions'])->name('dashboard.subscriptions');

    Route::post('/dashboard/subscription/cache/{plan}', [DashboardController::class, 'subscribeStore'])->name('plan.store');

    Route::get('/dashboard/subscription/{plan}', [DashboardController::class, 'getPreferedSubscription'])->name('plan.checkout');

    Route::post('/dashboard/subscription/checkout', [DashboardController::class, 'checkoutSubscription'])->name('plan.checkout.store');

    Route::put('dashboard/subscription/switch', [DashboardController::class, 'switchPackage'])->name('subscription.switch');

    Route::get('/dashboard/contribution', [DashboardController::class, 'contribution'])->name('dashboard.contribution');

    Route::post('/dashboard/contribution/store', [PaymentsController::class, 'makeContribution'])->name('dashboard.contribution.store');

    Route::get('/dashboard/fund', [PaymentsController::class, 'walletfund'])->name('dashboard.fund');

    Route::post('/dashboard/fund/checkout', [PaymentsController::class, 'walletfundCheckout'])->name('dashboard.fund.store');


   Route::get('/dashboard/plan/debt', [DashboardController::class, 'defaultedPayment'])->name('dashboard.defaulted-payment');

   Route::get('/dashboard/withdrawal', [DashboardController::class, 'withdrawal'])->name('dashboard.make-withdrawal');

   Route::post('/dashboard/plan/debt/store', [PaymentsController::class, 'clearDefaultStore'])->name('dashboard.defaulted-payment.store');


    Route::put('/dashboard/contribtion/claim/{sub_id}', [PaymentsController::class, 'claimContribution'])->name('dashboard.contribution.claim');

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
