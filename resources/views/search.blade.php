@extends('layouts.app')
@section('title', 'Verdant - Tìm Kiếm')
@section('description', 'Tìm kiếm cây cảnh, chậu cây, phụ kiện tại Verdant Botanical Boutique.')

@section('content')
<div class="w-full max-w-7xl mx-auto px-6 py-12 md:py-16" style="background-color: #f8faf8;">
    <!-- Search Header -->
    <section class="flex flex-col items-center text-center mb-12 max-w-3xl mx-auto" data-aos="fade-down">
        <h1 class="text-4xl md:text-5xl font-bold mb-6" style="color:#061b0e;font-family:'Playfair Display','Noto Serif',serif;font-style:italic;">Tìm Kiếm</h1>
        <div class="section-divider mx-auto mb-8"></div>
        <!-- Search Bar -->
        <div class="w-full relative mb-8 group">
            <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 transition-colors" style="color:#72796f;">search</span>
            <input id="search-input" class="w-full rounded-full py-4 pl-14 pr-6 text-lg shadow-sm transition-all focus:shadow-md" style="background:#fff;border:2px solid #e1e3e1;color:#191c1b;font-family:'Manrope',sans-serif;outline:none;" placeholder="Tìm kiếm cây, chậu, phụ kiện..." type="text" value="{{ $query ?? '' }}"/>
        </div>
        <!-- Quick Filters -->
        <div class="flex flex-wrap justify-center gap-2">
            <button onclick="document.getElementById('search-input').value='dễ chăm sóc';document.getElementById('search-input').dispatchEvent(new Event('input'))" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all hover:scale-105 hover:shadow-md flex items-center gap-1.5" style="background:#c9e7d7;color:#061b0e;">
                <span class="material-symbols-outlined text-[16px]">eco</span> Dễ chăm sóc
            </button>
            <button onclick="document.getElementById('search-input').value='ít ánh sáng';document.getElementById('search-input').dispatchEvent(new Event('input'))" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all hover:scale-105 hover:shadow-md flex items-center gap-1.5" style="background:#fff;color:#434843;border:1px solid #c3c8c1;">
                <span class="material-symbols-outlined text-[16px]">dark_mode</span> Ít ánh sáng
            </button>
            <button onclick="document.getElementById('search-input').value='lọc không khí';document.getElementById('search-input').dispatchEvent(new Event('input'))" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all hover:scale-105 hover:shadow-md flex items-center gap-1.5" style="background:#fff;color:#434843;border:1px solid #c3c8c1;">
                <span class="material-symbols-outlined text-[16px]">air</span> Lọc không khí
            </button>
            <button onclick="document.getElementById('search-input').value='cây treo';document.getElementById('search-input').dispatchEvent(new Event('input'))" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all hover:scale-105 hover:shadow-md flex items-center gap-1.5" style="background:#fff;color:#434843;border:1px solid #c3c8c1;">
                <span class="material-symbols-outlined text-[16px]">potted_plant</span> Cây treo
            </button>
            <button onclick="document.getElementById('search-input').value='để bàn';document.getElementById('search-input').dispatchEvent(new Event('input'))" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all hover:scale-105 hover:shadow-md flex items-center gap-1.5" style="background:#fff;color:#434843;border:1px solid #c3c8c1;">
                <span class="material-symbols-outlined text-[16px]">desk</span> Để bàn
            </button>
            <button onclick="document.getElementById('search-input').value='phong thủy';document.getElementById('search-input').dispatchEvent(new Event('input'))" class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all hover:scale-105 hover:shadow-md flex items-center gap-1.5" style="background:#fff;color:#434843;border:1px solid #c3c8c1;">
                <span class="material-symbols-outlined text-[16px]">spa</span> Phong thủy
            </button>
        </div>
    </section>

    <!-- Results Info & Sorting -->
    <div class="flex justify-between items-end mb-8 pb-3" style="border-bottom:2px solid #e6e9e7;" data-aos="fade-up">
        <p class="text-sm" style="color:#72796f;">Tìm thấy <span class="font-bold" style="color:#191c1b;" id="search-count">0</span> kết quả</p>
        <select id="search-sort" class="text-sm font-semibold px-3 py-2 rounded-lg cursor-pointer" style="background:#fff;border:1px solid #c3c8c1;color:#061b0e;outline:none;">
            <option value="popular">Phổ biến nhất</option>
            <option value="price-asc">Giá tăng dần</option>
            <option value="price-desc">Giá giảm dần</option>
            <option value="name">Tên A-Z</option>
        </select>
    </div>

    <!-- Results Grid (rendered by JS) -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="search-results"></section>
</div>
@endsection
