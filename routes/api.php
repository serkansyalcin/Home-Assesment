<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Sipariş Rotaları
Route::apiResource('orders', OrderController::class)->except(['update']);

// İndirim Rotaları
Route::get('orders/{order}/discounts', [DiscountController::class, 'calculateDiscounts']); 