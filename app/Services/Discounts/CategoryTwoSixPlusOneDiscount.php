<?php

namespace App\Services\Discounts;

use App\Models\Order;

class CategoryTwoSixPlusOneDiscount implements DiscountInterface
{
    /**
     * 2 ID'li kategoriye ait bir üründen 6 adet satın alındığında, 
     * bir tanesi ücretsiz olarak verilir.
     */
    public function calculate(Order $order): array
    {
        $discountAmount = 0;
        
        // Kategori 2'ye ait ürünleri grupla
        $categoryTwoItems = $order->items->filter(function ($item) {
            return $item->product->category_id === 2;
        })->groupBy('product_id');
        
        // Her ürün için kontrol et
        foreach ($categoryTwoItems as $productItems) {
            foreach ($productItems as $item) {
                $freeItems = intval($item->quantity / 6);
                if ($freeItems > 0) {
                    $discountAmount += $freeItems * $item->unit_price;
                }
            }
        }
        
        return [
            'discountReason' => 'BUY_6_GET_1_FREE_CATEGORY_2',
            'amount' => $discountAmount,
        ];
    }
} 