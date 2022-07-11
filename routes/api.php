<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(
    function () {
        Route::post('/signup', [AuthController::class, 'signUp']);
        Route::post('/login', [AuthController::class, 'login']);
    }
);


Route::prefix('orders')->group(
    function () {
        Route::middleware('auth:sanctum')->get('/', [OrderController::class, 'index']);
        Route::middleware('auth:sanctum')->post('/', [OrderController::class, 'store']);
        Route::middleware('auth:sanctum')->get('/{order_id}', [OrderController::class, 'show']);
        Route::middleware('auth:sanctum')->put('/{order_id}', [OrderController::class, 'update']);
        Route::middleware('auth:sanctum')->delete('/{order_id}', [OrderController::class, 'destroy']);
        Route::middleware('auth:sanctum')->get('/user/{order_id}', [OrderController::class, 'returnUserForOrder']);
    }
);

Route::middleware('auth:sanctum')->get('/current_user/', [OrderController::class, 'returnOrdersForCurrentUser']);
