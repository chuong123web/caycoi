@extends('layouts.app')
@section('title', 'VERDANT - Cửa hàng cây cảnh cao cấp')
@section('description', 'Khám phá bộ sưu tập cây cảnh cao cấp tại Verdant Botanical Boutique.')

@section('content')
<!-- Hero Section -->
<section class="relative w-full flex items-center justify-center overflow-hidden" style="height:85vh;min-height:600px;">
    <div class="absolute inset-0 z-0">
        <img alt="Monstera plant in sunlit living room" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPonfGCvXVr6_7whQVX22kYrQWstNOGqg54cyoWw2YF3mWbN7QHCDAxYQKhcbUjLcLOeHl-mGgrsYZx5AlvZ1RngohcgYFSD91lKDZqjM_FQKFZqQzS9EzGpBqtK9j9Zapb5LGeUp5951iwwjq3KtkZSV6i6CuTgUBacyuP_KgdtM07wrnc8_q1A3MyXo6_okPR9sDdyAklmMAC_esJECDcqy3gSYHrJocUwSTOhv3a9ti8WW-gFn4Bc8nP6lqMl6ZgfXfIIT8EnfH"/>
        <div class="absolute inset-0" style="background:linear-gradient(to bottom,rgba(6,27,14,0.1),rgba(6,27,14,0.5));"></div>
    </div>
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto flex flex-col items-center gap-6">
        <h1 class="hero-title text-5xl md:text-7xl font-bold drop-shadow-lg" style="color:#fff;font-family:'Playfair Display','Noto Serif',serif;line-height:1.1;">
            Mang thiên nhiên vào<br><em>không gian sống</em>
        </h1>
        <p class="hero-subtitle text-lg md:text-xl max-w-2xl drop-shadow" style="color:rgba(255,255,255,0.9);font-family:'Manrope',sans-serif;">
            Bộ sưu tập cây cảnh cao cấp được tuyển chọn tỉ mỉ, mang đến sự tươi mát cho ngôi nhà bạn.
        </p>
        <a href="{{ route('category') }}" class="hero-cta btn-verdant mt-4" style="background:rgba(255,255,255,0.95);color:#061b0e;font-size:16px;padding:1rem 2.5rem;">
            Khám Phá Ngay
            <span class="material-symbols-outlined">arrow_forward</span>
        </a>
    </div>
    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce" style="color:rgba(255,255,255,0.7);">
        <span class="material-symbols-outlined text-3xl">expand_more</span>
    </div>
</section>

<!-- Stats Bar -->
<section class="py-8 px-6" style="background:#061b0e;">
    <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        <div data-aos="fade-up" data-aos-delay="0">
            <p class="text-3xl font-bold mb-1" style="color:#b4cdb8;font-family:'Playfair Display',serif;">200+</p>
            <p class="text-xs uppercase tracking-widest" style="color:#819986;">Loại cây</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="100">
            <p class="text-3xl font-bold mb-1" style="color:#b4cdb8;font-family:'Playfair Display',serif;">5000+</p>
            <p class="text-xs uppercase tracking-widest" style="color:#819986;">Khách hàng</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="200">
            <p class="text-3xl font-bold mb-1" style="color:#b4cdb8;font-family:'Playfair Display',serif;">98%</p>
            <p class="text-xs uppercase tracking-widest" style="color:#819986;">Hài lòng</p>
        </div>
        <div data-aos="fade-up" data-aos-delay="300">
            <p class="text-3xl font-bold mb-1" style="color:#b4cdb8;font-family:'Playfair Display',serif;">24h</p>
            <p class="text-xs uppercase tracking-widest" style="color:#819986;">Giao hàng</p>
        </div>
    </div>
</section>

<!-- Featured Collections -->
<section class="py-20 px-6 max-w-7xl mx-auto" style="background-color:#f8faf8;">
    <div class="flex justify-between items-end mb-10" data-aos="fade-up">
        <div>
            <p class="text-xs uppercase tracking-widest mb-2" style="color:#496458;font-weight:600;">Collections</p>
            <h2 class="text-3xl md:text-4xl font-bold" style="color:#061b0e;font-family:'Playfair Display','Noto Serif',serif;">Bộ sưu tập nổi bật</h2>
        </div>
        <a class="text-sm font-semibold underline hidden md:inline" style="color:#291100;" href="{{ route('category') }}">Xem tất cả →</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5" style="grid-auto-rows:280px;">
        @php
        $collections = [
            ['title'=>'Cây Trồng Sàn','desc'=>'Tạo điểm nhấn với tán lá lớn','span'=>'md:col-span-2','img'=>'https://lh3.googleusercontent.com/aida-public/AB6AXuBwODj1-6WKaznB5Ex1z71JNmhM9k4DxHN5YUcxDfBf4CxbhqYnyU9h6mJfB4NMV6pBW69U47BRHFrW9qDasWXmIuOR8vqQiYywARXBTTDM0jDPmpUMxedrhbl-gHJ6Ox76mJ-oWohOv6UN6vilg5xwfSsLIqG4TdCbNkgqtUAhWH-hrP3-Gd-KcqJhk8nUmS6iHx8-XEe21bQgfVpWgF11XbUPb1SwzaIax1lDiL7b3j0Zd_0cqQm6rp2zZTwnA5h378X0HP-c16G_'],
            ['title'=>'Cây Để Bàn','desc'=>'Nhỏ gọn & Tinh tế','span'=>'','img'=>'https://lh3.googleusercontent.com/aida-public/AB6AXuDCXUPNes__Sczx4g7g18KHurg1mqSlXJtJegN7KMHqWuwzD9B-EOKQSl7rkXue0EzA-Ljgw6RMs--JSw91aojwpsbXwDvrPe0bHF4XKNkl4ZeM-2voPniSyM1l5dveR7ZzbUp9PRXNZ4n4Of2zwlr6Glh9ogPFIWxhrgY_grcd3Vqst0r6CnA6B2K2FIWc-ciNS8jjzK7lA9_zg7tYEhhrktzBRjZjRgYo3ry2UlfNJru5TgDfqrk1dAO-D8JyR-m-F58X4cNoaqBn'],
            ['title'=>'Cây Dây Leo','desc'=>'Phủ xanh không gian dọc','span'=>'','img'=>'https://lh3.googleusercontent.com/aida-public/AB6AXuCi7djed81q58dTXWUJF0qFLIlQ0HKSY9JBIo71zKSezi_GpoDXzn8cDEQBN4vrVyyONhtExQR8x8Vd8Ku2QogbRfsskox5A9b2QFp1DBtr8qVdZpdhM-NtDKJHkoF2jzFWMdL0AGmHOIUzGtadCT4LN5RjGN6I02WC_D_TJlGG_SLpvEnUyMRTN6zTaETZQDL1CjLRBs6RieJeXhB5u9fX7-EFSzlT3mDw6P6JNDD_g9NEuaXkQ25ZI-2LcWPycvI7wRruE8vzwIE_'],
            ['title'=>'Dễ Chăm Sóc','desc'=>'Hoàn hảo cho người mới','span'=>'md:col-span-2','img'=>'https://lh3.googleusercontent.com/aida-public/AB6AXuArURynQx7O_j-u0qYVB6M_-evgZkCeSsw1RHunSVc1wajN6Ygt43d2IZZ1V4bmYhEmpuAb9yuVBC1JezIF8p1hMjncPEBecEjFct4RONWKkVp3glGo7otlO6Ie8PLETSas41QiloeAP2__1BRDRfx2Dog2W5fuWryYc3kgKwnaK2ZKqFAdkV5M8o3ADIfT4wkkZsB1xut5Rl7D4IBIKCFvGtTuezIxnMxY4gtmikhxhLHsmO-8qKz_0Dp1iMQIaxGs50_sdSfuWPfO'],
        ];
        @endphp
        @foreach($collections as $i => $col)
        <div class="relative {{ $col['span'] }} rounded-2xl overflow-hidden group cursor-pointer card-hover" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
            <img alt="{{ $col['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="{{ $col['img'] }}"/>
            <div class="absolute inset-0 flex flex-col justify-end p-6" style="background:linear-gradient(to top,rgba(6,27,14,0.75),rgba(6,27,14,0.1),transparent);">
                <h3 class="text-xl font-bold mb-1" style="color:#fff;font-family:'Noto Serif',serif;">{{ $col['title'] }}</h3>
                <p class="text-sm" style="color:rgba(255,255,255,0.8);">{{ $col['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Best Sellers -->
<section class="py-20 px-6" style="background-color:#f2f4f2;border-top:1px solid #e1e3e1;border-bottom:1px solid #e1e3e1;">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12" data-aos="fade-up">
            <p class="text-xs uppercase tracking-widest mb-2" style="color:#496458;font-weight:600;">Best Sellers</p>
            <h2 class="text-3xl md:text-4xl font-bold" style="color:#061b0e;font-family:'Playfair Display','Noto Serif',serif;">Cây bán chạy nhất</h2>
            <div class="section-divider mx-auto mt-4"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $bestsellers = collect($globalPlants)->filter(function($p) {
                return str_contains($p['tag'], 'Bán chạy') || str_contains($p['tag'], 'Lọc') || str_contains($p['tag'], 'Cây lớn');
            })->take(4)->values();
            @endphp
            @foreach($bestsellers as $i => $p)
            <div class="group cursor-pointer card-hover" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <a href="{{ route('product') }}?id={{ $p['id'] }}" class="block">
                    <div class="aspect-[4/5] rounded-xl overflow-hidden mb-3 relative" style="background:#eceeec;">
                        <img alt="{{ $p['name'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $p['img'] }}"/>
                        @if($p['tag'])
                        <span class="absolute top-3 left-3 px-3 py-1.5 rounded-full text-xs font-semibold" style="background:rgba(180,205,184,0.9);color:#061b0e;">{{ $p['tag'] }}</span>
                        @endif
                        <button onclick="event.preventDefault(); event.stopPropagation(); VerdantCart.add({id:'{{ $p['id'] }}',name:'{{ $p['name'] }}',price:{{ $p['price'] }},img:'{{ $p['img'] }}',variant:'{{ $p['vn'] }}'})" class="absolute bottom-3 right-3 w-11 h-11 rounded-full flex items-center justify-center opacity-0 translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 shadow-lg" style="background:#061b0e;color:#fff;">
                            <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                        </button>
                    </div>
                </a>
                <h3 class="font-semibold mb-0.5" style="color:#061b0e;font-family:'Noto Serif',serif;">{{ $p['name'] }}</h3>
                <p class="text-sm mb-1" style="color:#72796f;">{{ $p['vn'] }}</p>
                <p class="text-sm font-bold" style="color:#061b0e;">{{ number_format($p['price'],0,',','.') }} ₫</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Verdant -->
<section class="py-20 px-6 max-w-7xl mx-auto" style="background-color:#f8faf8;">
    <div class="text-center mb-12" data-aos="fade-up">
        <p class="text-xs uppercase tracking-widest mb-2" style="color:#496458;font-weight:600;">Why Verdant</p>
        <h2 class="text-3xl md:text-4xl font-bold" style="color:#061b0e;font-family:'Playfair Display','Noto Serif',serif;">Tại sao chọn chúng tôi</h2>
        <div class="section-divider mx-auto mt-4"></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @php
        $features = [
            ['icon'=>'eco','title'=>'Cây khỏe mạnh 100%','desc'=>'Mỗi cây đều được kiểm tra sức khỏe kỹ lưỡng trước khi đến tay bạn.'],
            ['icon'=>'local_shipping','title'=>'Giao hàng an toàn','desc'=>'Đóng gói chuyên biệt cho cây, đảm bảo cây đến tay bạn nguyên vẹn.'],
            ['icon'=>'support_agent','title'=>'Tư vấn chăm sóc','desc'=>'Đội ngũ chuyên gia sẵn sàng hỗ trợ bạn chăm sóc cây 24/7.'],
        ];
        @endphp
        @foreach($features as $i => $f)
        <div class="text-center p-8 rounded-2xl card-hover" data-aos="fade-up" data-aos-delay="{{ $i * 120 }}" style="background:#fff;border:1px solid #e1e3e1;">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5" style="background:#c9e7d7;">
                <span class="material-symbols-outlined text-2xl" style="color:#061b0e;">{{ $f['icon'] }}</span>
            </div>
            <h3 class="text-lg font-bold mb-2" style="color:#061b0e;font-family:'Noto Serif',serif;">{{ $f['title'] }}</h3>
            <p class="text-sm" style="color:#72796f;">{{ $f['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>

<!-- Newsletter CTA -->
<section class="py-20 px-6" style="background:linear-gradient(135deg,#061b0e 0%,#1b3022 50%,#364c3c 100%);">
    <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl font-bold mb-4" style="color:#fff;font-family:'Playfair Display','Noto Serif',serif;">Nhận ưu đãi độc quyền</h2>
        <p class="text-base mb-8" style="color:#b4cdb8;">Đăng ký nhận tin để không bỏ lỡ những ưu đãi đặc biệt và bộ sưu tập mới nhất.</p>
        <form class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto" onsubmit="event.preventDefault();notyf.success('Cảm ơn bạn đã đăng ký!');">
            <input class="flex-grow rounded-full px-6 py-3.5 text-base" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.3);color:#fff;outline:none;" placeholder="Email của bạn" type="email" required/>
            <button type="submit" class="btn-verdant shrink-0" style="background:#b4cdb8;color:#061b0e;">
                Đăng ký
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </button>
        </form>
    </div>
</section>
@endsection
