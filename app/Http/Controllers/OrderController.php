<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\GiftCode;

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

        // Note: For a real app, you would also save the order items here in an `order_items` table.
        // For now, we are just storing the main order record as per current schema.

        if ($request->gift_code_id) {
            $giftCode = GiftCode::find($request->gift_code_id);
            if ($giftCode) {
                $giftCode->increment('used_count');
            }
        }

        return response()->json(['success' => true, 'order_number' => $order->order_number]);
    }
}
