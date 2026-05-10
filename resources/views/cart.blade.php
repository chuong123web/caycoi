@extends('layouts.app')
@section('title', 'Giỏ hàng - VERDANT')
@section('description', 'Xem giỏ hàng của bạn tại Verdant Botanical Boutique.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 md:py-16 w-full" style="background-color: #f8faf8;">
    <div class="mb-8" data-aos="fade-up">
        <h1 class="text-4xl font-bold" style="color:#061b0e;font-family:'Noto Serif',serif;">Giỏ hàng</h1>
        <p class="text-lg mt-2" style="color:#72796f;" id="cart-count">0 sản phẩm</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Cart Items (dynamic) -->
        <div class="lg:col-span-8 flex flex-col gap-4" id="cart-items"></div>

        <!-- Empty cart message -->
        <div id="cart-empty" class="lg:col-span-8 flex flex-col items-center justify-center py-20 text-center" style="display:none;">
            <span class="material-symbols-outlined text-6xl mb-4" style="color:#c3c8c1;">shopping_cart</span>
            <h2 class="text-2xl font-semibold mb-2" style="color:#061b0e;font-family:'Noto Serif',serif;">Giỏ hàng trống</h2>
            <p class="mb-6" style="color:#72796f;">Hãy khám phá bộ sưu tập cây cảnh của chúng tôi!</p>
            <a href="{{ route('category') }}" class="btn-verdant">
                Khám phá ngay
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </a>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-4" id="cart-summary" style="display:none;">
            <div class="rounded-2xl p-6 lg:p-8 sticky top-24" style="background:#fff;border:1px solid #e1e3e1;" data-aos="fade-left">
                <h2 class="text-xl font-bold mb-6 pb-4" style="color:#061b0e;font-family:'Noto Serif',serif;border-bottom:1px solid #e1e3e1;">Tóm tắt đơn hàng</h2>
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm" style="color:#72796f;">
                        <span>Tạm tính</span>
                        <span id="cart-subtotal" style="color:#191c1b;font-weight:600;">0 ₫</span>
                    </div>
                    <div class="flex justify-between text-sm" style="color:#72796f;">
                        <span>Vận chuyển</span>
                        <span style="color:#496458;">Miễn phí</span>
                    </div>
                </div>
                <div class="pt-4 mb-6" style="border-top:2px solid #e1e3e1;">
                    <div class="flex justify-between items-end">
                        <span class="text-base font-semibold" style="color:#061b0e;">Tổng cộng</span>
                        <span class="text-2xl font-bold" id="cart-total" style="color:#061b0e;font-family:'Noto Serif',serif;">0 ₫</span>
                    </div>
                    <p class="text-xs text-right mt-1" style="color:#72796f;">Đã bao gồm thuế</p>
                </div>
                <a href="{{ route('checkout') }}" class="btn-verdant w-full">
                    Thanh toán
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
                <div class="mt-4 flex items-center justify-center gap-1 text-xs" style="color:#72796f;">
                    <span class="material-symbols-outlined text-sm">lock</span>
                    Thanh toán an toàn & bảo mật
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
