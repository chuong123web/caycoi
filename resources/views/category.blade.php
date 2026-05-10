@extends('layouts.app')
@section('title', 'Danh Mục Cây Cảnh - Verdant')
@section('description', 'Khám phá bộ sưu tập cây cảnh đa dạng tại Verdant.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 md:py-16" style="background-color: #f8faf8;">
    <!-- Page Header -->
    <div class="mb-12 flex flex-col items-center text-center" data-aos="fade-down">
        <h1 class="text-4xl md:text-5xl font-bold mb-3" style="color:#061b0e;font-family:'Playfair Display','Noto Serif',serif;font-style:italic;">Bộ Sưu Tập</h1>
        <div class="section-divider mx-auto mb-4"></div>
        <p class="text-lg max-w-2xl" style="color:#72796f;font-family:'Manrope',sans-serif;">Curated greenery to transform your indoor spaces into serene conservatories.</p>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
        <!-- Sidebar Filters -->
        <aside class="md:col-span-3 sticky top-28 hidden md:block" data-aos="fade-right">
            <div class="rounded-2xl p-6" style="background:#fff;border:1px solid #e1e3e1;">
                <!-- Category Filter -->
                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider mb-4 pb-2" style="color:#061b0e;border-bottom:2px solid #c9e7d7;">Loại Cây</h3>
                    <ul class="space-y-3">
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-cat h-4 w-4 rounded" type="checkbox" value="desk" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Cây để bàn</span></label></li>
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-cat h-4 w-4 rounded" type="checkbox" value="large" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Cây lớn</span></label></li>
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-cat h-4 w-4 rounded" type="checkbox" value="hanging" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Cây treo</span></label></li>
                    </ul>
                </div>
                <!-- Light Filter -->
                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider mb-4 pb-2" style="color:#061b0e;border-bottom:2px solid #c9e7d7;">Nhu Cầu Ánh Sáng</h3>
                    <ul class="space-y-3">
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-light h-4 w-4 rounded" type="checkbox" value="low" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Thấp</span></label></li>
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-light h-4 w-4 rounded" type="checkbox" value="medium" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Trung bình</span></label></li>
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-light h-4 w-4 rounded" type="checkbox" value="high" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Cao</span></label></li>
                    </ul>
                </div>
                <!-- Tag Filter -->
                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider mb-4 pb-2" style="color:#061b0e;border-bottom:2px solid #c9e7d7;">Đặc Điểm</h3>
                    <ul class="space-y-3">
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-tag h-4 w-4 rounded" type="checkbox" value="Bán chạy" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Bán chạy nhất</span></label></li>
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-tag h-4 w-4 rounded" type="checkbox" value="Dễ chăm sóc" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Dễ chăm sóc</span></label></li>
                        <li><label class="flex items-center cursor-pointer group"><input class="filter-checkbox filter-tag h-4 w-4 rounded" type="checkbox" value="Lọc khí" style="accent-color:#061b0e;"/><span class="ml-3 text-sm group-hover:font-semibold transition-all" style="color:#434843;">Lọc không khí</span></label></li>
                    </ul>
                </div>
                <!-- Reset -->
                <button onclick="document.querySelectorAll('.filter-checkbox').forEach(c=>{c.checked=false});VerdantCategory.applyFilters();" class="w-full py-2 rounded-lg text-sm font-semibold transition-colors" style="background:#eceeec;color:#061b0e;">Xóa bộ lọc</button>
            </div>
        </aside>

        <!-- Product Grid -->
        <section class="md:col-span-9">
            <div class="flex justify-between items-center mb-6" data-aos="fade-up">
                <span class="text-sm" style="color:#72796f;" id="category-count">Showing 0 plants</span>
                <select id="category-sort" class="text-sm font-semibold px-3 py-2 rounded-lg cursor-pointer" style="background:#fff;border:1px solid #c3c8c1;color:#061b0e;outline:none;">
                    <option value="popular">Phổ biến nhất</option>
                    <option value="price-asc">Giá tăng dần</option>
                    <option value="price-desc">Giá giảm dần</option>
                    <option value="name">Tên A-Z</option>
                </select>
            </div>
            <!-- Grid rendered by JS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="category-grid"></div>
        </section>
    </div>
</div>
@endsection
