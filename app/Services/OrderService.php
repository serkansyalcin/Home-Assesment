<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Yeni sipariş oluştur
     */
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $total = 0;
            
            // Stok kontrolü
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Ürün {$product->name} için yeterli stok bulunmamaktadır.");
                }
                
                $total += $product->price * $item['quantity'];
            }
            
            // Sipariş oluştur
            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'total' => $total,
                'created_at' => now(),
            ]);
            
            // Sipariş öğelerini oluştur ve stokları güncelle
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                ]);
                
                // Stok güncelleme
                $product->stock -= $item['quantity'];
                $product->save();
            }
            
            return $order->load(['customer', 'items.product']);
        });
    }
    
    /**
     * Siparişi sil
     */
    public function deleteOrder(Order $order): void
    {
        DB::transaction(function () use ($order) {
            // Stokları geri yükle
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
            }
            
            // Sipariş öğelerini sil
            $order->items()->delete();
            
            // Siparişi sil
            $order->delete();
        });
    }
} 