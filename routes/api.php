<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\ApiOrderController;
use App\Http\Controllers\Api\ApiCartController;
use App\Http\Controllers\Api\ApiReviewController;

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

// Public API routes
Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/login', [ApiAuthController::class, 'login']);
    
    // Public product routes
    Route::get('/products', [ApiProductController::class, 'index']);
    Route::get('/products/featured', [ApiProductController::class, 'featured']);
    Route::get('/products/{product}', [ApiProductController::class, 'show']);
    Route::get('/categories', [ApiProductController::class, 'categories']);
});

// Protected API routes (require authentication)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // User profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::put('/profile', [ApiAuthController::class, 'updateProfile']);
    Route::put('/password', [ApiAuthController::class, 'updatePassword']);
    
    // Cart management
    Route::get('/cart', [ApiCartController::class, 'index']);
    Route::post('/cart', [ApiCartController::class, 'store']);
    Route::put('/cart/{item}', [ApiCartController::class, 'update']);
    Route::delete('/cart/{item}', [ApiCartController::class, 'destroy']);
    Route::delete('/cart', [ApiCartController::class, 'clear']);
    
    // Order management
    Route::get('/orders', [ApiOrderController::class, 'index']);
    Route::post('/orders', [ApiOrderController::class, 'store']);
    Route::get('/orders/{order}', [ApiOrderController::class, 'show']);
    
    // Reviews
    Route::post('/reviews', [ApiReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ApiReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ApiReviewController::class, 'destroy']);
    Route::get('/reviews/my-reviews', [ApiReviewController::class, 'myReviews']);
});
