<?php

namespace App\Services\Discounts;

use App\Models\Order;

interface DiscountInterface
{
    /**
     * İndirim hesapla
     * 
     * @return array{discountReason: string, amount: float}
     */
    public function calculate(Order $order): array;
} 