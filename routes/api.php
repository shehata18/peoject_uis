<?php

use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Services\WebhookNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/products/{id}', [ProductController::class, 'show']); // Retrieve product details


Route::put('/orders/{order}', [OrderController::class, 'updateStatus']);

Route::middleware('auth:api')->get('/orders', [OrderController::class, 'getUserOrders']);
Route::middleware('auth:api')->post('/orders', [OrderController::class, 'store'])->name('api.orders.store');


//Route::get('/test-webhook', function (WebhookNotificationService $service) {
//    $result = $service->sendOrderStatusUpdate(1, 'shipped');
//    return $result ? 'Webhook sent successfully.' : 'Failed to send webhook.';
//});



Route::get('/test-webhook', function () {

    event(new OrderStatusUpdated(1, 'shipped'));
    return 'Webhook event fired successfully.';
});

