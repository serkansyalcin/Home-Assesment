<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DiscountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected DiscountService $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * Sipariş için indirimleri hesapla
     */
    public function calculateDiscounts(Order $order): JsonResponse
    {
        $order->load(['items.product', 'customer']);
        $discountResult = $this->discountService->calculateDiscounts($order);
        
        return response()->json($discountResult);
    }
} 