<!DOCTYPE html>
<html lang="vi" style="color-scheme: light;">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="color-scheme" content="light only">
    <title>@yield('title', 'VERDANT - Cửa hàng cây cảnh cao cấp')</title>
    <meta name="description" content="@yield('description', 'Verdant Botanical Boutique - Cửa hàng cây cảnh cao cấp.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.INITIAL_PRODUCTS = @json($globalPlants);
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600;700&family=Manrope:wght@300;400;500;600;700&family=Noto+Serif:ital,wght@0,400;0,500;0,600;1,400;1,600&display=swap" rel="stylesheet"/>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- [1] AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- [2] Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
    <!-- [3] Swiper -->
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet"/>
    <!-- [4] GLightbox -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/css/glightbox.min.css" rel="stylesheet"/>
    <!-- [5] Notyf - Toast Notifications -->
    <link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet"/>
    <!-- [6] SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"/>
    <!-- [7] Tippy.js -->
    <link href="https://unpkg.com/tippy.js@6/dist/tippy.css" rel="stylesheet"/>
    <link href="https://unpkg.com/tippy.js@6/animations/shift-away.css" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        /* Force light mode globally */
        html, body { background-color: #f8faf8 !important; color: #191c1b !important; color-scheme: light !important; }
        /* Pace.js custom style */
        .pace { pointer-events: none; user-select: none; }
        .pace-inactive { display: none; }
        .pace .pace-progress { background: linear-gradient(90deg, #061b0e, #496458, #b4cdb8); position: fixed; z-index: 9999; top: 0; right: 100%; width: 100%; height: 3px; }
        /* Lenis smooth scroll */
        html.lenis, html.lenis body { height: auto; }
        .lenis.lenis-smooth { scroll-behavior: auto !important; }
        .lenis.lenis-smooth [data-lenis-prevent] { overscroll-behavior: contain; }
        .lenis.lenis-stopped { overflow: hidden; }
        /* Page loading transition */
        .page-transition { opacity: 0; transform: translateY(20px); transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .page-transition.loaded { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="bg-background text-on-background font-body-md text-body-md antialiased min-h-screen flex flex-col" style="background-color: #f8faf8 !important;">
    @hasSection('custom-layout')
        @yield('content')
    @else
        @include('partials.navbar')
        <main class="flex-grow page-transition">
            @yield('content')
        </main>
        @include('partials.footer')
    @endif

    <!-- [8] GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <!-- [9] AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <!-- [10] Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- [11] GLightbox -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/js/glightbox.min.js"></script>
    <!-- [12] CountUp.js -->
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.8.0/dist/countUp.umd.min.js"></script>
    <!-- [13] Typed.js -->
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <!-- [14] Vanilla Tilt -->
    <script src="https://unpkg.com/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js"></script>
    <!-- [15] Notyf -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- [16] SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- [17] ScrollReveal -->
    <script src="https://unpkg.com/scrollreveal@4.0.9/dist/scrollreveal.min.js"></script>
    <!-- [18] Rellax - Parallax -->
    <script src="https://cdn.jsdelivr.net/npm/rellax@1.12.1/rellax.min.js"></script>
    <!-- [19] Tippy.js -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <!-- [20] Lenis - Smooth Scroll -->
    <script src="https://unpkg.com/lenis@1.1.18/dist/lenis.min.js"></script>
    <!-- [21] Pace.js - Loading Bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@1.2.4/pace.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 60 });
        // Initialize Lenis smooth scroll
        const lenis = new Lenis({ duration: 1.2, easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)) });
        function raf(time) { lenis.raf(time); requestAnimationFrame(raf); }
        requestAnimationFrame(raf);
        // Page transition
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.page-transition').forEach(el => el.classList.add('loaded'));
            // Initialize Tippy tooltips
            if (typeof tippy !== 'undefined') { tippy('[data-tippy-content]', { animation: 'shift-away', theme: 'light' }); }
            // Initialize GLightbox
            if (typeof GLightbox !== 'undefined') { GLightbox({ selector: '.glightbox' }); }
        });
        // Notyf instance
        const notyf = new Notyf({ duration: 3000, position: { x: 'right', y: 'top' }, types: [
            { type: 'success', background: '#061b0e', icon: { className: 'material-symbols-outlined', tagName: 'span', text: 'check_circle' } },
            { type: 'error', background: '#ba1a1a' },
            { type: 'info', background: '#496458', icon: false }
        ]});
    </script>
    @stack('scripts')
</body>
</html>
