<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Tüm siparişleri listele
     */
    public function index(): JsonResponse
    {
        $orders = Order::with(['customer', 'items.product'])->get();
        return response()->json($orders);
    }

    /**
     * Yeni sipariş oluştur
     */
    public function store(OrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated());
            return response()->json($order, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Belirli bir siparişi göster
     */
    public function show(Order $order): JsonResponse
    {
        $order->load(['customer', 'items.product']);
        return response()->json($order);
    }

    /**
     * Siparişi sil
     */
    public function destroy(Order $order): JsonResponse
    {
        $this->orderService->deleteOrder($order);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
} 