<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\ReferralController;

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

// Coming soon page
Route::view('/coming-soon', 'coming-soon')->name('coming-soon');

// Admin route - keep this accessible
Route::get('/admin/{filter?}', function ($filter = null) {
    return view('admin', ['filter' => $filter]);
})->middleware('admin');

// Stripe webhook - keep this accessible for payment processing
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

// Admin referral links - keep this accessible for admins
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/referral-links', \App\Livewire\Admin\ReferralLinks::class)
        ->name('admin.referral-links');
});

// Auth routes - keep these accessible
require __DIR__ . '/auth.php';

// Redirect all other routes to the coming soon page
// This must be the last route to catch everything else
Route::any('/{any?}', function () {
    return redirect()->route('coming-soon');
})->where('any', '.*');
