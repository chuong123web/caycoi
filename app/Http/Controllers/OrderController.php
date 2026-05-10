<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\GiftCode;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'gift_code_id' => 'nullable|exists:gift_codes,id',
            'discount_amount' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.plant_slug' => 'required|string',
            'items.*.plant_name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount' => $request->total_amount,
            'gift_code_id' => $request->gift_code_id,
            'discount_amount' => $request->discount_amount ?: 0,
            'status' => 'pending',
            'notes' => 'Tạo từ frontend',
        ]);

        // Save order items
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'plant_slug' => $item['plant_slug'],
                'plant_name' => $item['plant_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        if ($request->gift_code_id) {
            $giftCode = GiftCode::find($request->gift_code_id);
            if ($giftCode) {
                $giftCode->increment('used_count');
            }
        }

        return response()->json(['success' => true, 'order_number' => $order->order_number]);
    }
}
