<?php

use App\Http\Controllers\SubscriberController;
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

Route::get('/v1/subscribers', [SubscriberController::class, "getSubscribers"]);
Route::delete('/v1/subscribers/{id}', [SubscriberController::class, "deleteSubscriber"]);
