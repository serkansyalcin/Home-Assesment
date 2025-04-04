<?php

namespace App\Services;

use App\Models\Order;
use App\Services\Discounts\DiscountInterface;
use App\Services\Discounts\TotalPriceDiscount;
use App\Services\Discounts\CategoryTwoSixPlusOneDiscount;
use App\Services\Discounts\CategoryOneCheapestDiscount;

class DiscountService
{
    /**
     * @var array<DiscountInterface>
     */
    protected array $discounts = [];

    public function __construct()
    {
        // İndirim kurallarını kaydet
        $this->discounts = [
            new TotalPriceDiscount(),
            new CategoryTwoSixPlusOneDiscount(),
            new CategoryOneCheapestDiscount(),
        ];
    }

    /**
     * Sipariş için tüm indirimleri hesapla
     */
    public function calculateDiscounts(Order $order): array
    {
        $discounts = [];
        $totalDiscount = 0;
        $subtotal = $order->total;
        
        foreach ($this->discounts as $discount) {
            $result = $discount->calculate($order);
            
            if ($result['amount'] > 0) {
                $discounts[] = $result;
                $totalDiscount += $result['amount'];
            }
        }
        
        return [
            'orderId' => $order->id,
            'discounts' => $discounts,
            'totalDiscount' => $totalDiscount,
            'discountedTotal' => $subtotal - $totalDiscount,
        ];
    }
} 