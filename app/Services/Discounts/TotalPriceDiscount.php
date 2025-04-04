<?php

namespace App\Services\Discounts;

use App\Models\Order;

class TotalPriceDiscount implements DiscountInterface
{
    /**
     * Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, 
     * siparişin tamamından %10 indirim kazanır.
     */
    public function calculate(Order $order): array
    {
        $discountAmount = 0;
        
        if ($order->total >= 1000) {
            $discountAmount = $order->total * 0.10;
        }
        
        return [
            'discountReason' => '10_PERCENT_OVER_1000',
            'amount' => $discountAmount,
        ];
    }
} 