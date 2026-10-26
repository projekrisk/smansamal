<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
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
                            600: '#57534E',
                            800: '#3D3935',
                            900: '#2A2724',
                            950: '#1A1816',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#F9F8F6] text-stone-900 min-h-screen flex flex-col justify-between selection:bg-forest selection:text-white font-sans antialiased">

    <!-- Top Navigation Bar -->
    <header class="w-full pt-6 md:pt-8 px-4 sm:px-6">
        <div class="max-w-[1200px] mx-auto flex items-center justify-between bg-white/95 backdrop-blur-md px-6 md:px-8 py-4 rounded-full border border-stone-200/80 shadow-xs">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-10 h-10 md:w-11 md:h-11 object-contain">
                <span class="font-serif text-xl md:text-2xl font-semibold text-forest leading-none">
                    SMAN 1<span class="text-terracotta"> Malingping</span>
                </span>
            </a>

            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-800 text-xs font-semibold">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                </span>
                <span>Mode Pemeliharaan</span>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 py-12 md:py-16">
        <div class="w-full max-w-2xl mx-auto">

            <div class="bg-white p-8 sm:p-12 md:p-14 rounded-2xl md:rounded-[1.75rem] shadow-sm border border-stone-200/80 text-center relative overflow-hidden">
                <!-- Top subtle brand accent line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-forest via-emerald-600 to-terracotta"></div>

                <!-- Icon Badge -->
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-forest/10 text-forest mx-auto flex items-center justify-center mb-6 shadow-2xs">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>

                <!-- Tag & Headline -->
                <span class="inline-block text-[11px] sm:text-xs font-bold font-sans uppercase tracking-widest text-forest bg-forest/10 px-3.5 py-1 rounded-full mb-3.5">
                    Informasi Sistem
                </span>

                <h1 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-900 font-bold leading-tight mb-4">
                    {{ $title ?? 'Situs Sedang Dalam Pemeliharaan' }}
                </h1>

                <p class="font-sans text-stone-600 text-sm sm:text-base leading-relaxed max-w-lg mx-auto mb-6">
                    {{ $message ?? 'Kami sedang melakukan pemeliharaan rutin dan peningkatan performa sistem demi kenyamanan Anda. Silakan kembali dalam beberapa saat.' }}
                </p>

                <!-- Estimated Completion Time (if specified) -->
                @if(!empty($end_time))
                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-stone-50 border border-stone-200/80 text-stone-700 text-xs sm:text-sm font-sans mb-8">
                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Perkiraan Waktu Selesai: <strong class="text-stone-900 font-mono">{{ $end_time }}</strong></span>
                    </div>
                @endif

                <!-- School Motto / Subtext -->
                <div class="pt-6 border-t border-stone-100 flex items-center justify-center gap-2 text-xs text-stone-500 font-sans">
                    <span class="w-1.5 h-1.5 rounded-full bg-forest"></span>
                    <span class="tracking-wide">Cageur, Bageur, Bener, Pinter.</span>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer matching website style -->
    <footer class="w-full bg-stone-900 text-stone-400 py-6 mt-auto border-t border-stone-800">
        <div class="max-w-[1200px] mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-3 font-sans text-xs sm:text-sm text-center sm:text-left">
            <div class="flex items-center gap-2">
                <span class="font-serif font-semibold text-white tracking-wide">SMAN 1 Malingping</span>
                <span class="text-stone-600">&bull;</span>
                <p>&copy; {{ date('Y') }}</p>
            </div>
            <p class="text-stone-400 text-xs">Jl. Beyeh - Simpang, Malingping, Lebak, Banten 42392</p>
        </div>
    </footer>

</body>
</html>
