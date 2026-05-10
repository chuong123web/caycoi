<!-- TopNavBar -->
<nav class="sticky top-0 z-50 w-full border-b border-stone-200/80 backdrop-blur-xl" style="background-color: rgba(255,255,255,0.97);">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        <div class="flex items-center gap-8">
            <a class="text-2xl font-bold tracking-tighter" href="{{ route('home') }}" style="font-family: 'Playfair Display', 'Noto Serif', serif; color: #061b0e;">VERDANT</a>
            <div class="hidden md:flex gap-1">
                <a class="{{ request()->routeIs('home') ? 'nav-link-active' : 'nav-link' }}" href="{{ route('home') }}">Trang Chủ</a>
                <a class="{{ request()->routeIs('category') ? 'nav-link-active' : 'nav-link' }}" href="{{ route('category') }}">Danh Mục</a>
                <a class="{{ request()->routeIs('search') ? 'nav-link-active' : 'nav-link' }}" href="{{ route('search') }}">Tìm Kiếm</a>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('search') }}" method="GET" class="relative flex items-center h-10 w-10 z-20" id="nav-search-container" onsubmit="if(!this.q.value) return false;">
                <input type="text" name="q" id="nav-search-input" placeholder="Bạn đang tìm cây gì?" class="absolute right-0 h-10 w-10 opacity-0 pointer-events-none bg-white border-2 border-primary rounded-full pl-5 pr-11 text-sm outline-none focus:border-primary focus:ring-4 focus:ring-primary/20 shadow-md text-stone-800 font-medium" style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);" onblur="setTimeout(() => { if(!this.value) { this.style.width = '40px'; this.style.opacity = '0'; this.style.pointerEvents = 'none'; } }, 200);">
                <button type="button" class="absolute right-0 top-0 w-10 h-10 rounded-full flex items-center justify-center text-stone-600 hover:text-primary transition-colors z-10" onclick="const input = document.getElementById('nav-search-input'); if(input.style.opacity === '1') { if(input.value) this.parentElement.submit(); else { input.style.width = '40px'; input.style.opacity = '0'; input.style.pointerEvents = 'none'; } } else { input.style.width = '300px'; input.style.opacity = '1'; input.style.pointerEvents = 'auto'; input.focus(); }">
                    <span class="material-symbols-outlined text-[22px]">search</span>
                </button>
            </form>
            <a href="{{ route('cart') }}" class="nav-icon-btn relative" data-tippy-content="Giỏ hàng" id="nav-cart-btn">
                <span class="material-symbols-outlined">shopping_cart</span>
                <span id="cart-badge" class="absolute -top-1 -right-1 w-5 h-5 rounded-full text-xs font-bold flex items-center justify-center" style="background-color: #c4451c; color: #fff; display: none;">0</span>
            </a>
            <a href="{{ route('login') }}" class="nav-icon-btn" data-tippy-content="Tài khoản">
                <span class="material-symbols-outlined">person</span>
            </a>
            <!-- Mobile menu button -->
            <button class="md:hidden nav-icon-btn" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden border-t px-6 py-4 space-y-3 absolute w-full left-0 top-[100%] shadow-lg" style="border-color: #e1e3e1; background-color: #ffffff;">
        <a class="block py-2 text-stone-600 hover:text-emerald-800 font-medium transition-colors" href="{{ route('home') }}">Trang Chủ</a>
        <a class="block py-2 text-stone-600 hover:text-emerald-800 font-medium transition-colors" href="{{ route('category') }}">Danh Mục</a>
        <a class="block py-2 text-stone-600 hover:text-emerald-800 font-medium transition-colors" href="{{ route('search') }}">Tìm Kiếm</a>
        
        <!-- Các chức năng yêu cầu -->
        <div class="border-t pt-3 mt-3" style="border-color: #e1e3e1;">
            <a class="block py-2 text-stone-600 hover:text-emerald-800 font-medium transition-colors flex items-center gap-2" href="/admin/users">
                <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span> Admin
            </a>
            @auth
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="block w-full text-left py-2 text-red-600 hover:text-red-800 font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">logout</span> Đăng xuất
                    </button>
                </form>
            @else
                <a class="block py-2 text-stone-600 hover:text-emerald-800 font-medium transition-colors flex items-center gap-2" href="{{ route('login') }}">
                    <span class="material-symbols-outlined text-[18px]">login</span> Đăng nhập
                </a>
            @endauth
        </div>
    </div>
</nav>
