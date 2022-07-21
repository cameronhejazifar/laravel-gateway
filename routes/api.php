<?php

use App\Http\Controllers\LaravelGatewayController;
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

Route::get('{slug?}', [LaravelGatewayController::class, 'get'])->where('slug', '.*');
Route::post('{slug?}', [LaravelGatewayController::class, 'post'])->where('slug', '.*');
Route::put('{slug?}', [LaravelGatewayController::class, 'put'])->where('slug', '.*');
Route::patch('{slug?}', [LaravelGatewayController::class, 'patch'])->where('slug', '.*');
Route::delete('{slug?}', [LaravelGatewayController::class, 'delete'])->where('slug', '.*');
Route::options('{slug?}', [LaravelGatewayController::class, 'options'])->where('slug', '.*');
