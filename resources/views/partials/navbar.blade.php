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
            
            <!-- Desktop User Dropdown -->
            <div class="relative hidden md:block group">
                <a href="{{ route('login') }}" class="nav-icon-btn" data-tippy-content="Tài khoản">
                    <span class="material-symbols-outlined">person</span>
                </a>
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-stone-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50">
                    <div class="py-2">
                        @guest
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 hover:text-primary">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 hover:text-primary">Đăng ký mới</a>
                        @else
                            <div class="px-4 py-2 border-b border-stone-100">
                                <p class="text-xs text-stone-500">Xin chào,</p>
                                <p class="text-sm font-bold text-stone-800">{{ auth()->user()->name }}</p>
                            </div>
                            <a href="/admin" class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50 hover:text-primary flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span> Quản trị Admin
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-stone-50 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[16px]">logout</span> Đăng xuất
                                </button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <button class="md:hidden nav-icon-btn" onclick="openMobileMenu()">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </div>
    
    <!-- Mobile Sidebar Menu (Drawer) -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[60] hidden transition-opacity duration-300 opacity-0" onclick="closeMobileMenu()"></div>
    <div id="mobile-menu-drawer" class="fixed top-0 right-0 h-full w-80 bg-white z-[70] shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
        <div class="p-6 border-b flex justify-between items-center bg-stone-50">
            <span class="text-xl font-bold tracking-tighter" style="font-family: 'Playfair Display', serif; color: #061b0e;">VERDANT</span>
            <button onclick="closeMobileMenu()" class="w-8 h-8 flex items-center justify-center rounded-full bg-stone-200 text-stone-600 hover:bg-stone-300 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        
        <!-- Auth Section for Mobile -->
        <div class="p-6 bg-stone-50/50 border-b border-stone-100">
            @guest
                <p class="text-sm text-stone-500 mb-3">Đăng nhập để nhận nhiều ưu đãi</p>
                <div class="flex gap-2">
                    <a href="{{ route('login') }}" class="flex-1 text-center py-2 bg-primary text-white rounded-lg font-bold hover:bg-emerald-800 transition-colors">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="flex-1 text-center py-2 bg-white text-primary border border-primary rounded-lg font-bold hover:bg-stone-50 transition-colors">Đăng ký</a>
                </div>
            @else
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-xs text-stone-500">Xin chào,</p>
                        <p class="text-sm font-bold text-stone-800">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="/admin" class="flex-1 text-center py-2 bg-stone-800 text-white rounded-lg font-bold hover:bg-stone-900 transition-colors flex justify-center items-center gap-1 text-sm">
                        <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span> Admin
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="flex-1 m-0">
                        @csrf
                        <button type="submit" class="w-full text-center py-2 bg-red-50 text-red-600 rounded-lg font-bold hover:bg-red-100 transition-colors flex justify-center items-center gap-1 text-sm">
                            <span class="material-symbols-outlined text-[16px]">logout</span> Thoát
                        </button>
                    </form>
                </div>
            @endguest
        </div>

        <div class="flex-grow overflow-y-auto py-4 px-6 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-4 py-3 text-stone-700 hover:text-primary font-medium border-b border-stone-100">
                <span class="material-symbols-outlined text-primary/80">home</span> Trang Chủ
            </a>
            <a href="{{ route('category') }}" class="flex items-center gap-4 py-3 text-stone-700 hover:text-primary font-medium border-b border-stone-100">
                <span class="material-symbols-outlined text-primary/80">local_florist</span> Danh Mục Cây
            </a>
            <a href="{{ route('search') }}" class="flex items-center gap-4 py-3 text-stone-700 hover:text-primary font-medium border-b border-stone-100">
                <span class="material-symbols-outlined text-primary/80">search</span> Tìm Kiếm
            </a>
            <a href="{{ route('cart') }}" class="flex items-center gap-4 py-3 text-stone-700 hover:text-primary font-medium border-b border-stone-100">
                <span class="material-symbols-outlined text-primary/80">shopping_cart</span> Giỏ Hàng
            </a>
        </div>
        <div class="p-6 bg-stone-50 border-t">
            <p class="text-sm text-stone-500 mb-4">Cần hỗ trợ? Hãy liên hệ với chúng tôi.</p>
            <a href="tel:19001234" class="flex items-center justify-center gap-2 w-full py-3 bg-primary text-white rounded-xl font-bold hover:bg-emerald-800 transition-colors">
                <span class="material-symbols-outlined text-sm">call</span> 1900 1234
            </a>
        </div>
    </div>

    <script>
        function openMobileMenu() {
            const overlay = document.getElementById('mobile-menu-overlay');
            const drawer = document.getElementById('mobile-menu-drawer');
            overlay.classList.remove('hidden');
            // Trigger reflow
            void overlay.offsetWidth;
            overlay.classList.remove('opacity-0');
            drawer.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closeMobileMenu() {
            const overlay = document.getElementById('mobile-menu-overlay');
            const drawer = document.getElementById('mobile-menu-drawer');
            overlay.classList.add('opacity-0');
            drawer.classList.add('translate-x-full');
            document.body.style.overflow = '';
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }
    </script>
</nav>