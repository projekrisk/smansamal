@props([
    'title' => 'SMAN 1 Malingping - Cageur, Bageur, Bener, Pinter.',
    'description' => 'Portal resmi SMAN 1 Malingping, Lebak Banten. Membentuk generasi cerdas dan berkarakter dengan 4 pilar Cageur, Bageur, Bener, Pinter.',
    'image' => asset('images/og-default.jpg'),
    'type' => 'website',
    'isHome' => false,
    'twitterCard' => 'summary_large_image',
    'author' => 'SMAN 1 Malingping',
    'publishedTime' => null,
])

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <x-seo-meta :title="$title" :description="$description" :image="$image" :type="$type" :twitterCard="$twitterCard" :author="$author" :publishedTime="$publishedTime" />

    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="dns-prefetch" href="//images.unsplash.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if(\App\Models\Setting::getBool('adsense_header_enabled') && \App\Models\Setting::get('adsense_header_code'))
        {!! \App\Models\Setting::get('adsense_header_code') !!}
    @endif

    @stack('styles')
</head>
<body class="antialiased selection:bg-forest selection:text-white flex flex-col min-h-screen">

    @if(auth()->check() && auth()->user()->isAdmin() && \App\Http\Middleware\CheckMaintenanceMode::isMaintenanceActive())
        <div class="bg-amber-500 text-stone-950 px-4 py-2 text-xs md:text-sm font-semibold sticky top-0 z-50 border-b border-amber-600 shadow-sm">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-stone-950 animate-ping"></span>
                    <span><strong>Mode Pemeliharaan Aktif:</strong> Pengunjung umum saat ini dialihkan ke halaman pemeliharaan. Anda dapat mengakses halaman ini sebagai Administrator.</span>
                </div>
                <a href="{{ route('admin.maintenance.index') }}" class="underline font-bold hover:text-white transition-colors flex-shrink-0">
                    Pengaturan Mode Pemeliharaan &rarr;
                </a>
            </div>
        </div>
    @endif

    <x-header :isHome="$isHome" />

    {{ $slot }}

    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuOpen = document.getElementById('menu-open');
            const menuClose = document.getElementById('menu-close');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileOverlay = document.getElementById('mobile-overlay');
            const mobileLinks = document.querySelectorAll('.mobile-link');

            function openMobileMenu() {
                if (mobileMenu && mobileOverlay) {
                    mobileMenu.classList.remove('translate-x-full');
                    mobileOverlay.classList.remove('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeMobileMenu() {
                if (mobileMenu && mobileOverlay) {
                    mobileMenu.classList.add('translate-x-full');
                    mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = '';
                }
            }

            if (menuOpen) menuOpen.addEventListener('click', openMobileMenu);
            if (menuClose) menuClose.addEventListener('click', closeMobileMenu);
            if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);
            mobileLinks.forEach(link => link.addEventListener('click', closeMobileMenu));

            // Dynamic Sticky & Expanding Header on Scroll for All Pages
            const headerWrapper = document.getElementById('header-wrapper');
            const mainHeader = document.getElementById('main-header');

            function updateHeaderOnScroll() {
                if (!headerWrapper || !mainHeader) return;
                if (window.scrollY > 50) {
                    headerWrapper.classList.remove('pt-4', 'md:pt-8', 'px-4', 'sm:px-6', 'px-6');
                    headerWrapper.classList.add('pt-0', 'px-0');

                    mainHeader.classList.remove('max-w-[1200px]', 'rounded-full', 'border');
                    mainHeader.classList.add('max-w-full', 'rounded-none', 'border-b', 'border-white', 'shadow-md');
                } else {
                    headerWrapper.classList.remove('pt-0', 'px-0');
                    headerWrapper.classList.add('pt-4', 'md:pt-8', 'px-4', 'sm:px-6');

                    mainHeader.classList.remove('max-w-full', 'rounded-none', 'border-b', 'shadow-md');
                    mainHeader.classList.add('max-w-[1200px]', 'rounded-full', 'border', 'border-white');
                }
            }

            window.addEventListener('scroll', updateHeaderOnScroll, { passive: true });
            updateHeaderOnScroll();
        });
    </script>

    <x-announcement-modal />

    <x-toast />

    @stack('scripts')
</body>
</html>
