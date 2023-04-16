<?php

use App\Http\Controllers\SubscriberApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

/*
Subscriber API Routes
 */
Route::get('/v1/subscribers', [SubscriberApiController::class, "getSubscribers"]);
Route::delete('/v1/subscribers/{id}', [SubscriberApiController::class, "deleteSubscriber"]);
