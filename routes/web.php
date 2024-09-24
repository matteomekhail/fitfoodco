<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeWebhookController;

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

Route::view('/', 'welcome');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);

Route::get('/admin/{filter?}', function ($filter = null) {
    return view('admin', ['filter' => $filter]);
})->middleware('admin');

Route::view('/meals', 'selectionMeals');

Route::view('/success', 'success');




require __DIR__ . '/auth.php';
