<?php

use App\Http\Controllers\AccountController;
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
Frontend Routes
 */
Route::get('/', [AccountController::class, 'showOrRedirect']);
Route::get('/subscribers', [AccountController::class, 'showSubscribers']);
Route::get('/create-subscriber', [AccountController::class, 'showAddSubscriber']);

/*
Backend Routes
 */
Route::post('/', [AccountController::class, 'addApiKey']);
Route::post('/create-subscriber', [AccountController::class, 'addSubscriber']);
