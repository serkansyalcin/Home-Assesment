<?php

namespace App\Services\Discounts;

use App\Models\Order;

class CategoryOneCheapestDiscount implements DiscountInterface
{
    /**
     * 1 ID'li kategoriden iki veya daha fazla ürün satın alındığında, 
     * en ucuz ürüne %20 indirim yapılır.
     */
    public function calculate(Order $order): array
    {
        $discountAmount = 0;
        
        // Kategori 1'e ait ürünleri filtrele
        $categoryOneItems = $order->items->filter(function ($item) {
            return $item->product->category_id === 1;
        });
        
        // Kategori 1'den en az 2 ürün alınmış mı kontrol et
        if ($categoryOneItems->count() >= 2) {
            // En ucuz ürünü bul
            $cheapestItem = $categoryOneItems->sortBy('unit_price')->first();
            
            if ($cheapestItem) {
                $discountAmount = $cheapestItem->unit_price * 0.20;
            }
        }
        
        return [
            'discountReason' => '20_PERCENT_OFF_CATEGORY_1',
            'amount' => $discountAmount,
        ];
    }
} 