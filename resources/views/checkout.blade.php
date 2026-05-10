@extends('layouts.app')
@section('title', 'Checkout - Verdant')
@section('description', 'Hoàn tất đơn hàng tại Verdant Botanical Boutique.')
@section('custom-layout', true)

@section('content')
<!-- Minimal Secure Header -->
<header class="w-full bg-surface-container-lowest border-b border-surface-container py-md px-margin flex items-center justify-center sticky top-0 z-50">
    <a class="flex items-center gap-sm group" href="{{ route('home') }}">
        <span class="font-headline-md text-headline-md text-primary italic font-bold tracking-wide">Verdant</span>
    </a>
    <div class="absolute right-margin flex items-center gap-xs text-outline hidden sm:flex">
        <span class="material-symbols-outlined text-[18px]">lock</span>
        <span class="font-label-sm text-label-sm uppercase">Secure Checkout</span>
    </div>
</header>

<!-- Main Checkout Canvas -->
<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-margin py-xl lg:py-xxl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-sm mb-lg text-outline font-label-sm text-label-sm uppercase tracking-wider">
        <a class="hover:text-primary transition-colors" href="{{ route('cart') }}">Cart</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-primary font-bold">Information</span>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span>Shipping</span>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span>Payment</span>
    </nav>
    <div class="flex flex-col-reverse lg:flex-row gap-xl lg:gap-[64px]">
        <!-- Left Column: Forms -->
        <section class="w-full lg:w-7/12 flex flex-col gap-xl">
            <!-- Contact Information -->
            <div class="flex flex-col gap-md bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-outline-variant/30 p-6 lg:p-8 relative overflow-hidden" data-aos="fade-up">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-tertiary"></div>
                <div class="flex justify-between items-end mb-2">
                    <h2 class="font-headline-sm text-[22px] text-primary font-medium" style="font-family: 'Noto Serif', serif;">Contact Information</h2>
                    <a class="font-label-sm text-sm text-on-surface-variant hover:text-primary underline underline-offset-4 transition-colors" href="{{ route('login') }}">Log in</a>
                </div>
                <div class="flex flex-col gap-xs mt-1">
                    <label class="sr-only" for="email">Email address</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline/60 text-[20px]">mail</span>
                        <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl pl-11 pr-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-outline/50 hover:border-primary/40" id="email" placeholder="Email address" type="email"/>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-2">
                    <input class="w-5 h-5 rounded-[6px] border-outline-variant/60 text-primary focus:ring-primary focus:ring-offset-0 bg-[#fcfdfc] transition-colors cursor-pointer" id="newsletter" type="checkbox"/>
                    <label class="font-body-md text-sm text-on-surface-variant cursor-pointer select-none" for="newsletter">Email me with news and exclusive botanical offers</label>
                </div>
            </div>
            <!-- Shipping Address -->
            <div class="flex flex-col gap-md bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-outline-variant/30 p-6 lg:p-8 relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <h2 class="font-headline-sm text-[22px] text-primary font-medium mb-3" style="font-family: 'Noto Serif', serif;">Shipping Address</h2>
                <div class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="font-label-sm text-xs text-on-surface-variant uppercase tracking-wider font-semibold ml-1" for="firstName">First Name</label>
                            <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all hover:border-primary/40" id="firstName" type="text"/>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="font-label-sm text-xs text-on-surface-variant uppercase tracking-wider font-semibold ml-1" for="lastName">Last Name</label>
                            <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all hover:border-primary/40" id="lastName" type="text"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="font-label-sm text-xs text-on-surface-variant uppercase tracking-wider font-semibold ml-1" for="address">Address</label>
                        <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-outline/40 hover:border-primary/40" id="address" placeholder="Street address or P.O. Box" type="text"/>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-outline/40 hover:border-primary/40" id="apartment" placeholder="Apartment, suite, unit, etc. (optional)" type="text"/>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="flex flex-col gap-1.5 sm:col-span-1">
                            <label class="font-label-sm text-xs text-on-surface-variant uppercase tracking-wider font-semibold ml-1" for="country">Country</label>
                            <select class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all hover:border-primary/40 cursor-pointer" id="country">
                                <option>Việt Nam</option>
                                <option>United States</option>
                                <option>Japan</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-1.5 sm:col-span-1">
                            <label class="font-label-sm text-xs text-on-surface-variant uppercase tracking-wider font-semibold ml-1" for="city">City</label>
                            <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all hover:border-primary/40" id="city" type="text"/>
                        </div>
                        <div class="flex flex-col gap-1.5 sm:col-span-1">
                            <label class="font-label-sm text-xs text-on-surface-variant uppercase tracking-wider font-semibold ml-1" for="zip">ZIP Code</label>
                            <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all hover:border-primary/40" id="zip" type="text"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="font-label-sm text-xs text-on-surface-variant uppercase tracking-wider font-semibold ml-1" for="phone">Phone</label>
                        <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-outline/40 hover:border-primary/40" id="phone" placeholder="For delivery updates" type="tel"/>
                    </div>
                </div>
            </div>
            <!-- Shipping Method -->
            <div class="flex flex-col gap-md bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-outline-variant/30 p-6 lg:p-8 relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <h2 class="font-headline-sm text-[22px] text-primary font-medium mb-1" style="font-family: 'Noto Serif', serif;">Shipping Method</h2>
                <div class="border border-outline-variant/60 rounded-xl overflow-hidden bg-[#fcfdfc] flex flex-col">
                    <label class="flex items-center justify-between p-4 sm:p-5 border-b border-outline-variant/50 cursor-pointer hover:bg-surface-container transition-colors group">
                        <div class="flex items-center gap-4">
                            <input checked class="w-5 h-5 text-primary focus:ring-primary border-outline-variant/60 shipping-method-radio cursor-pointer" name="shipping_method" type="radio" value="standard" onchange="VerdantCart.renderCheckout()"/>
                            <div class="flex flex-col">
                                <span class="font-label-md text-base text-on-surface group-hover:text-primary transition-colors">Standard White Glove</span>
                                <span class="font-body-md text-sm text-on-surface-variant mt-0.5">3-5 Business Days. Hand-delivered.</span>
                            </div>
                        </div>
                        <span class="font-label-md text-base text-primary font-bold">Free</span>
                    </label>
                    <label class="flex items-center justify-between p-4 sm:p-5 cursor-pointer hover:bg-surface-container transition-colors group">
                        <div class="flex items-center gap-4">
                            <input class="w-5 h-5 text-primary focus:ring-primary border-outline-variant/60 shipping-method-radio cursor-pointer" name="shipping_method" type="radio" value="express" onchange="VerdantCart.renderCheckout()"/>
                            <div class="flex flex-col">
                                <span class="font-label-md text-base text-on-surface group-hover:text-primary transition-colors">Express Botanical Courier</span>
                                <span class="font-body-md text-sm text-on-surface-variant mt-0.5">1-2 Business Days. Priority handling.</span>
                            </div>
                        </div>
                        <span class="font-label-md text-base text-primary font-bold">250.000 ₫</span>
                    </label>
                </div>
            </div>
            <!-- Payment -->
            <div class="flex flex-col gap-md mb-xl bg-white rounded-2xl shadow-[0_2px_12px_rgba(0,0,0,0.03)] border border-outline-variant/30 p-6 lg:p-8 relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                <div class="flex flex-col mb-3">
                    <h2 class="font-headline-sm text-[22px] text-primary font-medium" style="font-family: 'Noto Serif', serif;">Payment</h2>
                    <span class="font-body-md text-sm text-on-surface-variant mt-1">All transactions are secure and encrypted.</span>
                </div>
                <div class="border border-outline-variant/60 rounded-xl overflow-hidden bg-[#fcfdfc] flex flex-col">
                    <div class="flex items-center justify-between p-4 sm:p-5 border-b border-outline-variant/50 bg-[#f4f7f4] cursor-pointer">
                        <div class="flex items-center gap-4">
                            <input checked class="w-5 h-5 text-primary focus:ring-primary border-outline-variant/60 cursor-pointer" id="pay_cc" name="payment_method" type="radio"/>
                            <label class="font-label-md text-base text-on-surface font-semibold cursor-pointer" for="pay_cc">Credit Card</label>
                        </div>
                        <div class="flex gap-2 text-primary">
                            <span class="material-symbols-outlined text-[24px]">credit_card</span>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 bg-white border-b border-outline-variant/50 flex flex-col gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="sr-only" for="cc_number">Card number</label>
                            <div class="relative">
                                <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-outline/40 hover:border-primary/40" id="cc_number" placeholder="Card number" type="text"/>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline/60 text-[20px]">lock</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-outline/40 hover:border-primary/40" placeholder="MM / YY" type="text"/>
                            </div>
                            <div class="flex flex-col gap-1.5 relative">
                                <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 pr-10 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-outline/40 hover:border-primary/40" placeholder="Security code" type="text"/>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline/60 text-[20px] cursor-help" title="3 digit code on back of card">help</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <input class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all placeholder:text-outline/40 hover:border-primary/40" placeholder="Name on card" type="text"/>
                        </div>
                    </div>
                    <label class="flex items-center justify-between p-4 sm:p-5 cursor-pointer hover:bg-surface-container transition-colors group">
                        <div class="flex items-center gap-4">
                            <input class="w-5 h-5 text-primary focus:ring-primary border-outline-variant/60 cursor-pointer" name="payment_method" type="radio"/>
                            <span class="font-label-md text-base text-on-surface group-hover:text-primary transition-colors">PayPal</span>
                        </div>
                        <div class="text-[#003087] font-bold italic tracking-tighter text-lg">PayPal</div>
                    </label>
                </div>
            </div>
            <button type="button" onclick="VerdantCart.processPayment(event)" class="hidden lg:flex w-full py-[20px] bg-gradient-to-r from-primary to-tertiary text-white font-label-md text-[18px] tracking-wide rounded-xl hover:shadow-[0_8px_24px_rgba(27,48,34,0.3)] transition-all hover:-translate-y-1 items-center justify-center gap-2 mt-2 font-semibold">
                <span class="material-symbols-outlined text-[20px]">lock</span>
                Pay <span class="checkout-total-price">0 ₫</span>
            </button>
        </section>
        <!-- Right Column: Order Summary -->
        <aside class="w-full lg:w-5/12">
            <div class="bg-white border border-outline-variant/30 rounded-2xl p-6 lg:p-8 lg:sticky lg:top-8 shadow-[0_8px_30px_rgba(0,0,0,0.04)] relative overflow-hidden" data-aos="fade-left">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-tertiary to-primary"></div>
                <h2 class="font-headline-sm text-2xl text-primary mb-6 pb-4 border-b border-outline-variant/30 font-medium" style="font-family: 'Noto Serif', serif;">Order Summary</h2>
                <div class="flex flex-col gap-5 mb-8" id="checkout-items">
                </div>
                <div class="flex gap-2 mb-8 border-b border-outline-variant/30 pb-8">
                    <div class="relative w-full">
                        <select id="checkout-discount-select" class="w-full bg-[#fcfdfc] border border-outline-variant/60 rounded-xl px-4 py-3.5 pr-10 font-body-md text-on-surface focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all cursor-pointer appearance-none" onchange="VerdantCart.renderCheckout()">
                            <option value="0">🎁 Chọn Gift Card / Mã giảm giá</option>
                            <option value="50000" data-name="GIFT50K">GIFT50K - Giảm 50.000 ₫</option>
                            <option value="100000" data-name="GIFT100K">GIFT100K - Giảm 100.000 ₫</option>
                            <option value="200000" data-name="VIP200K">VIP200K - Giảm 200.000 ₫</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline/60 pointer-events-none">expand_more</span>
                    </div>
                </div>
                <div class="flex flex-col gap-3 font-body-md text-base mb-6">
                    <div class="flex justify-between items-center text-on-surface-variant">
                        <span>Subtotal</span>
                        <span class="font-semibold text-on-surface" id="checkout-subtotal">0 ₫</span>
                    </div>
                    <div class="flex justify-between items-center text-on-surface-variant">
                        <span>Shipping</span>
                        <span class="font-semibold text-on-surface" id="checkout-shipping-cost">Free</span>
                    </div>
                    <div class="justify-between items-center text-primary hidden" id="checkout-discount-row" style="display: none;">
                        <span>Discount (<span id="checkout-discount-name"></span>)</span>
                        <span class="font-semibold" id="checkout-discount-amount">-0 ₫</span>
                    </div>
                    <div class="flex justify-between items-center text-on-surface-variant">
                        <span>Estimated Taxes</span>
                        <span class="font-semibold text-on-surface">Calculated at next step</span>
                    </div>
                </div>
                <div class="flex justify-between items-end pt-6 border-t border-outline-variant/30 mt-4">
                    <span class="font-body-lg text-xl text-on-surface font-medium">Total</span>
                    <div class="flex items-baseline gap-2">
                        <span class="font-label-sm text-outline uppercase font-semibold">VND</span>
                        <span class="font-headline-md text-3xl text-primary font-bold checkout-total-price">0 ₫</span>
                    </div>
                </div>
            </div>
            <button type="button" onclick="VerdantCart.processPayment(event)" class="flex lg:hidden w-full py-[20px] bg-gradient-to-r from-primary to-tertiary text-white font-label-md text-[18px] tracking-wide rounded-xl hover:shadow-[0_8px_24px_rgba(27,48,34,0.3)] transition-all items-center justify-center gap-2 mt-8 font-semibold">
                <span class="material-symbols-outlined text-[20px]">lock</span>
                Pay <span class="checkout-total-price">0 ₫</span>
            </button>
        </aside>
    </div>
</main>

<!-- Simple Footer for Checkout -->
<footer class="w-full py-xl text-center border-t border-surface-container mt-auto">
    <div class="flex justify-center gap-md mb-sm text-outline">
        <span class="font-label-sm hover:text-primary cursor-pointer transition-colors">Refund policy</span>
        <span class="font-label-sm hover:text-primary cursor-pointer transition-colors">Privacy policy</span>
        <span class="font-label-sm hover:text-primary cursor-pointer transition-colors">Terms of service</span>
    </div>
    <p class="font-body-md text-sm text-on-surface-variant">© 2024 Verdant Botanical Boutique</p>
</footer>
@endsection
