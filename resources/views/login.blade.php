@extends('layouts.app')
@section('title', 'Verdant - Đăng nhập')
@section('description', 'Đăng nhập vào tài khoản Verdant.')
@section('custom-layout', true)

@section('content')
<div class="flex w-full" style="min-height:100vh;">
    <!-- Left: Botanical Image -->
    <div class="hidden md:block md:w-1/2 relative" style="background:#eceeec;">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('https://lh3.googleusercontent.com/aida-public/AB6AXuCIXsWEVRmWTrntrYfgNANWjuUc8ThAflvGXMR33FNL0b3Mid9MBRW9sRiTe1xfee-46h9-JfZQgUNTOWcaNyfmaa5Jb95uztLYB45OrHFuI8izZvJ2LEasamrWOppfMczkyOa--0kwfynq_-0Sm5TW9OIs5mHMeR1WywOERuvD4ipwPUk_oudmyyjGeIkuQysVYsD6Oj2QtgYthI8jp_moIF75eMt8MG7VSVtutDHN8l3Foyc1ZVcV_dsUkFYFrlRFa10y_j0cPVSo');"></div>
        <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(6,27,14,0.4),transparent);"></div>
    </div>
    <!-- Right: Login Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center" style="min-height:100vh;padding:2rem;background:#ffffff;">
        <div style="width:100%;max-width:28rem;">
            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl text-sm font-semibold" style="background:#c9e7d7;color:#061b0e;">
                <span class="material-symbols-outlined text-sm align-middle mr-1">check_circle</span>{{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="mb-6 p-4 rounded-xl text-sm font-semibold" style="background:#ffdad6;color:#ba1a1a;">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <div class="mb-10 text-center md:text-left" data-aos="fade-up">
                <h1 class="text-4xl mb-3" style="color:#061b0e;font-family:'Playfair Display','Noto Serif',serif;font-style:italic;font-weight:700;">Verdant</h1>
                <p class="text-base" style="color:#72796f;">Chào mừng trở lại. Đăng nhập để tiếp tục.</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" data-aos="fade-up" data-aos-delay="100">
                @csrf
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color:#434843;" for="login_email">Email</label>
                    <input style="width:100%;border:1.5px solid #c3c8c1;border-radius:0.75rem;padding:0.875rem 1rem;font-size:16px;color:#191c1b;background:#fff;outline:none;transition:border-color 0.2s;" id="login_email" name="email" required type="email" placeholder="email@example.com" onfocus="this.style.borderColor='#061b0e'" onblur="this.style.borderColor='#c3c8c1'"/>
                </div>
                <div class="mb-5">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-bold uppercase tracking-wider" style="color:#434843;" for="login_password">Mật khẩu</label>
                        <a class="text-xs font-semibold underline" style="color:#291100;" href="#">Quên mật khẩu?</a>
                    </div>
                    <input style="width:100%;border:1.5px solid #c3c8c1;border-radius:0.75rem;padding:0.875rem 1rem;font-size:16px;color:#191c1b;background:#fff;outline:none;transition:border-color 0.2s;" id="login_password" name="password" required type="password" placeholder="••••••••" onfocus="this.style.borderColor='#061b0e'" onblur="this.style.borderColor='#c3c8c1'"/>
                </div>
                <button type="submit" class="btn-verdant w-full mt-4">
                    Đăng nhập
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </button>
            </form>

            <div class="mt-10 pt-6 text-center md:text-left" style="border-top:1px solid #e1e3e1;" data-aos="fade-up" data-aos-delay="200">
                <p class="text-sm" style="color:#72796f;">
                    Chưa có tài khoản?
                    <a class="font-bold underline ml-1" style="color:#291100;" href="{{ route('register') }}">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
