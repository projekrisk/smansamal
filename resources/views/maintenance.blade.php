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
    <main class="flex-1 flex items-center justify-center px-4 sm:px-6 py-12 md:py-16">
        <div class="w-full max-w-2xl mx-auto">

            <div class="text-center relative overflow-hidden">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-forest/10 text-forest mx-auto flex items-center justify-center mb-6 shadow-2xs">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>

                <span class="inline-block text-[11px] sm:text-xs font-bold font-sans uppercase tracking-widest text-forest bg-forest/10 px-3.5 py-1 rounded-full mb-3.5">
                    Informasi Sistem
                </span>

                <h1 class="font-serif text-2xl sm:text-3xl md:text-4xl text-stone-900 font-bold leading-tight mb-4">
                    {{ $title ?? 'Situs Sedang Dalam Pemeliharaan' }}
                </h1>

                <p class="font-sans text-stone-600 text-sm sm:text-base leading-relaxed max-w-lg mx-auto mb-6">
                    {{ $message ?? 'Kami sedang melakukan pemeliharaan rutin dan peningkatan performa sistem demi kenyamanan Anda. Silakan kembali dalam beberapa saat.' }}
                </p>

                @if(!empty($end_time))
                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-stone-50 border border-stone-200/80 text-stone-700 text-xs sm:text-sm font-sans mb-8">
                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Perkiraan Waktu Selesai: <strong class="text-stone-900 font-mono">{{ $end_time }}</strong></span>
                    </div>
                @endif
            </div>

        </div>
    </main>
</body>
</html>
