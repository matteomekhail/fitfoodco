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

Route::view('/', 'welcome')->name('home');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

Route::get('/admin/{filter?}', function ($filter = null) {
    return view('admin', ['filter' => $filter]);
})->middleware('admin');

Route::view('/meals', 'selectionMeals');

Route::view('/success', 'success');

Route::get('/ref/{code}', [ReferralController::class, 'handleReferral'])->name('referral.handle');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/referral-links', App\Livewire\Admin\ReferralLinks::class)->name('admin.referral-links');
});

require __DIR__ . '/auth.php';
