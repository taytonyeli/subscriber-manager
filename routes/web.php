<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*
Accounts Routes
 */
Route::get('/', [AccountController::class, 'showOrRedirect']);
Route::post('/', [AccountController::class, 'addApiKey']);

/*
Subscriber Routes
 */
Route::get('/subscribers', [SubscriberController::class, 'showSubscribers']);
Route::get('/create-subscriber', [SubscriberController::class, 'showAddSubscriber']);
Route::post('/create-subscriber', [SubscriberController::class, 'addSubscriber']);
Route::get('/edit-subscriber/{id}', [SubscriberController::class, 'showEditSubscriber']);

