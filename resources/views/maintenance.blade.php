<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pemeliharaan Sistem - SMAN 1 Malingping' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Fraunces', 'serif'],
                    },
                    colors: {
                        forest: '#2A5C43',
                        forestDark: '#1E4331',
                        terracotta: '#CC7A6B',
                        stone: {
                            50: '#F9F8F6',
                            100: '#EFEBE4',
                            200: '#E2DCD5',
                            800: '#3D3935',
                            900: '#2A2724',
                            950: '#1A1816',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.15); opacity: 0.4; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        .pulse-ring {
            animation: pulse-ring 2.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .pattern-bg {
            background-color: #1A1816;
            background-image: radial-gradient(rgba(42, 92, 67, 0.18) 1px, transparent 1px), radial-gradient(rgba(204, 122, 107, 0.12) 1px, #1A1816 1px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }
    </style>
</head>
<body class="pattern-bg text-stone-100 min-h-screen flex flex-col justify-between selection:bg-forest selection:text-white font-sans antialiased">

    <!-- Top Bar Navigation -->
    <header class="w-full px-6 py-6 border-b border-stone-800/80 backdrop-blur-md bg-stone-950/60 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-10 h-10 object-contain drop-shadow-md">
                <div>
                    <span class="block font-serif text-lg font-bold text-white tracking-wide leading-tight">SMAN 1 MALINGPING</span>
                    <span class="block text-xs font-medium text-stone-400 tracking-wider">KABUPATEN LEBAK • BANTEN</span>
                </div>
            </div>

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold tracking-wide">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                </span>
                <span>Mode Pemeliharaan</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 py-12 md:py-16">
        <div class="max-w-3xl w-full mx-auto text-center">

            <!-- Hero Illustration / Icon Badge -->
            <div class="relative inline-flex items-center justify-center mb-8">
                <div class="absolute -inset-4 rounded-3xl bg-forest/20 blur-xl pulse-ring"></div>
                <div class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-forest via-stone-800 to-stone-900 border border-forest/40 flex items-center justify-center shadow-2xl">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            <!-- Title & Notice -->
            <div class="space-y-4 mb-8">
                <span class="inline-block text-xs uppercase tracking-widest font-bold text-terracotta bg-terracotta/10 border border-terracotta/20 px-3 py-1 rounded-full">
                    Sistem Sedang Ditingkatkan
                </span>
                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                    {{ $title ?? 'Situs Sedang Dalam Pemeliharaan' }}
                </h1>
                <p class="text-stone-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                    {{ $message ?? 'Kami sedang melakukan pemeliharaan rutin dan peningkatan performa sistem demi kenyamanan Anda. Silakan kembali dalam beberapa saat.' }}
                </p>
            </div>

            <!-- Estimated Time Card (if set) -->
            @if(!empty($end_time))
                <div class="mb-10 inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-stone-900/90 border border-stone-800 shadow-xl backdrop-blur-sm">
                    <svg class="w-5 h-5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-left text-xs sm:text-sm">
                        <span class="text-stone-400 block font-medium">Perkiraan Waktu Selesai:</span>
                        <span class="font-bold text-white font-mono tracking-wide">{{ $end_time }}</span>
                    </div>
                </div>
            @endif

            <!-- Info Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left mb-10 max-w-2xl mx-auto">
                <div class="p-5 rounded-2xl bg-stone-900/60 border border-stone-800 hover:border-forest/40 transition-colors">
                    <div class="w-8 h-8 rounded-xl bg-forest/20 text-emerald-400 flex items-center justify-center mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h2 class="font-bold text-white text-sm mb-1">Pembaruan & Keamanan</h2>
                    <p class="text-stone-400 text-xs leading-relaxed">
                        Kami sedang menyegarkan basis data dan mengoptimalkan kecepatan server agar akses informasi sekolah tetap cepat dan aman.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-stone-900/60 border border-stone-800 hover:border-forest/40 transition-colors">
                    <div class="w-8 h-8 rounded-xl bg-terracotta/20 text-terracotta flex items-center justify-center mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h2 class="font-bold text-white text-sm mb-1">Layanan Tatap Muka</h2>
                    <p class="text-stone-400 text-xs leading-relaxed">
                        Layanan administrasi, tata usaha, dan kegiatan pembelajaran di kampus SMAN 1 Malingping tetap berjalan normal sesuai jam operasional.
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <button onclick="window.location.reload()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-forest hover:bg-forestDark text-white font-sans text-sm font-semibold transition-all shadow-lg shadow-forest/20 hover:scale-[1.02] active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Muat Ulang Halaman</span>
                </button>

                <a href="{{ route('admin.login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-stone-900 hover:bg-stone-800 text-stone-300 hover:text-white border border-stone-800 font-sans text-sm font-semibold transition-all hover:scale-[1.02]">
                    <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>Akses Pengelola Portal</span>
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full px-6 py-6 border-t border-stone-800/80 bg-stone-950/70 text-center text-xs text-stone-500">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>&copy; {{ date('Y') }} SMAN 1 Malingping. Cageur, Bageur, Bener, Pinter.</p>
            <p class="text-stone-400">Jl. Beyeh - Simpang, Malingping, Lebak, Banten 42392</p>
        </div>
    </footer>

</body>
</html>
