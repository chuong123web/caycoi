@extends('layouts.app')
@section('title', 'Chi Tiết Sản Phẩm - VERDANT')
@section('description', 'Xem chi tiết sản phẩm và hướng dẫn chăm sóc tại Verdant Botanical Boutique.')

@section('content')
<div class="flex-grow flex flex-col items-center pt-xxl pb-xxl px-gutter max-w-7xl mx-auto w-full">
    <!-- Product Detail Section -->
    <section id="product-detail-container" class="w-full grid grid-cols-1 lg:grid-cols-2 gap-xxl mb-xxl">
        <div class="flex items-center justify-center w-full h-[50vh] col-span-1 lg:col-span-2">
            <div class="animate-pulse flex flex-col items-center">
                <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
    </section>
    <!-- Related Products -->
    <section class="w-full mt-xxl border-t-2 border-surface-container-high pt-xxl">
        <h2 class="font-headline-md text-headline-md text-on-background mb-xl text-center">Sản Phẩm Gợi Ý</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-gutter">
            @php
            $related = collect($globalPlants)->shuffle()->take(3)->values();
            @endphp
            @foreach($related as $rp)
            <a class="group flex flex-col gap-4" href="{{ route('product') }}?id={{ $rp['id'] }}">
                <div class="w-full bg-surface-container-lowest aspect-[4/5] rounded-lg overflow-hidden relative">
                    <img alt="{{ $rp['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out" src="{{ $rp['img'] }}"/>
                    <button onclick="event.preventDefault(); event.stopPropagation(); VerdantCart.add({id:'{{ $rp['id'] }}',name:'{{ $rp['name'] }}',price:{{ $rp['price'] }},img:'{{ $rp['img'] }}',variant:''})" class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded shadow-sm text-center">
                        <span class="font-label-md text-label-md text-primary">Thêm Nhanh</span>
                    </button>
                </div>
                <div>
                    <h3 class="font-headline-sm text-headline-sm text-on-background mb-1">{{ $rp['name'] }}</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant">{{ number_format($rp['price'], 0, ',', '.') }} ₫</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
</div>
@endsection
