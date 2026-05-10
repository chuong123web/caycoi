@extends('layouts.app')
@section('title', 'Verdant - Đăng ký')
@section('description', 'Tạo tài khoản tại Verdant Botanical Boutique.')
@section('custom-layout', true)

@section('content')
<div class="flex w-full" style="min-height:100vh;">
    <!-- Left: Botanical Image -->
    <div class="hidden lg:block lg:w-1/2 relative overflow-hidden" style="background:#eceeec;">
        <img alt="Indoor plant collection" class="absolute inset-0 w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDkkprDnnZd_7bjj6FyLBX1NQs9aOPCIdWDOIP1rd51kVXSojIwd--A7Urn22rJb9rkfS9eCnOOhz6zB5ga2PyMp53mUIn3m1-rhojxMITlfYI0w6WUCNeJnwTmYoP9zzIa3m7hfgrUoiQKB4n-k9iSq2kDTFOU54KGVFbq1kD-7keYK6lmRq6SQWwvvtBNHfgszPuNYl_2qujIh_OeJQiCHVgCIO2UX2ng9GZwxAlOFtFn9r8hC2XV4yDD8-nevQjP3B2aHONqtUDh"/>
        <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(6,27,14,0.75),rgba(6,27,14,0.15),transparent);"></div>
        <div class="absolute" style="bottom:4rem;left:4rem;right:4rem;">
            <span class="block text-3xl font-bold mb-2" style="color:#fff;font-family:'Playfair Display','Noto Serif',serif;font-style:italic;">Verdant</span>
            <p class="text-base" style="color:#e6e9e7;max-width:28rem;">Curating nature for modern living. Step into a quieter, greener space.</p>
        </div>
    </div>
    <!-- Right: Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center" style="min-height:100vh;padding:1.5rem;background:#f8faf8;">
        <div style="width:100%;max-width:28rem;">
            @if($errors->any())
            <div class="mb-6 p-4 rounded-xl text-sm font-semibold" style="background:#ffdad6;color:#ba1a1a;">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <div class="lg:hidden text-center mb-8">
                <span class="text-3xl font-bold" style="color:#061b0e;font-family:'Playfair Display','Noto Serif',serif;font-style:italic;">Verdant</span>
            </div>

            <div class="mb-8 text-center lg:text-left" data-aos="fade-up">
                <h1 class="text-3xl font-bold mb-1" style="color:#061b0e;font-family:'Noto Serif',serif;">Bắt đầu hành trình xanh</h1>
                <p class="text-sm" style="color:#72796f;">Tạo tài khoản để lưu trữ không gian của bạn.</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" data-aos="fade-up" data-aos-delay="100" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color:#434843;" for="fullName">Họ tên</label>
                    <input style="width:100%;border:1.5px solid #c3c8c1;border-radius:0.75rem;padding:0.75rem 1rem;font-size:16px;color:#191c1b;background:#fff;outline:none;transition:border-color 0.2s;" id="fullName" name="fullName" placeholder="Nhập họ và tên" required type="text" onfocus="this.style.borderColor='#061b0e'" onblur="this.style.borderColor='#c3c8c1'"/>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color:#434843;" for="reg_email">Email</label>
                    <input style="width:100%;border:1.5px solid #c3c8c1;border-radius:0.75rem;padding:0.75rem 1rem;font-size:16px;color:#191c1b;background:#fff;outline:none;transition:border-color 0.2s;" id="reg_email" name="email" placeholder="email@example.com" required type="email" onfocus="this.style.borderColor='#061b0e'" onblur="this.style.borderColor='#c3c8c1'"/>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1.5" style="color:#434843;" for="reg_password">Mật khẩu</label>
                    <input style="width:100%;border:1.5px solid #c3c8c1;border-radius:0.75rem;padding:0.75rem 1rem;font-size:16px;color:#191c1b;background:#fff;outline:none;transition:border-color 0.2s;" id="reg_password" name="password" placeholder="••••••••" required type="password" onfocus="this.style.borderColor='#061b0e'" onblur="this.style.borderColor='#c3c8c1'"/>
                </div>
                <button type="submit" class="btn-verdant w-full mt-2">
                    Đăng ký
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
            </form>

            <div class="mt-8 text-center" data-aos="fade-up" data-aos-delay="200">
                <p class="text-sm" style="color:#72796f;">
                    Đã có tài khoản?
                    <a class="font-bold underline ml-1" style="color:#291100;" href="{{ route('login') }}">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
