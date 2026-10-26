<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - SMAN 1 Malingping</title>

    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Manrope', 'sans-serif'],
                        serif: ['Fraunces', 'serif'],
                    },
                    colors: {
                        stone: {
                            50: '#F9F8F6',
                            100: '#EFEBE4',
                            200: '#E2DDD5',
                            300: '#C7C2B8',
                            400: '#8E8A82',
                            500: '#68655E',
                            600: '#4D4A45',
                            700: '#3D3935',
                            800: '#2F2C29',
                            900: '#2A2724',
                        },
                        forest: '#2A5C43',
                        terracotta: '#CC7A6B',
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white sm:bg-gradient-to-b sm:from-stone-50 sm:via-emerald-50/25 sm:to-stone-100 text-stone-900 min-h-screen flex flex-col justify-between selection:bg-forest selection:text-white antialiased font-sans">

    <header class="w-full px-5 py-4 sm:px-10 sm:py-5 border-b border-stone-200/60 bg-white/80 backdrop-blur-md sticky top-0 z-20">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-9 h-9 sm:w-10 sm:h-10 transition-transform group-hover:scale-105">
                <div class="text-left">
                    <span class="block font-serif text-base sm:text-lg font-bold text-stone-900 leading-tight">SMAN 1 <span class="text-terracotta">Malingping</span></span>
                    <span class="block text-[11px] sm:text-xs text-stone-500 font-sans">Suara Warga Sekolah</span>
                </div>
            </a>

            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-stone-600 hover:text-forest transition-colors py-1.5 px-3 sm:py-2 sm:px-3.5 rounded-xl hover:bg-stone-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="hidden sm:inline">Kembali ke Beranda</span>
                <span class="sm:hidden">Beranda</span>
            </a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 py-6 sm:py-14">
        <div class="w-full max-w-xl bg-transparent sm:bg-white border-0 sm:border sm:border-stone-200/80 rounded-none sm:rounded-3xl p-0 sm:p-10 shadow-none sm:shadow-xl sm:shadow-stone-200/40 text-center relative sm:overflow-hidden">

            <div class="hidden sm:block absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-forest via-emerald-500 to-terracotta"></div>

            <div class="relative mx-auto w-16 h-16 sm:w-20 sm:h-20 mb-5 sm:mb-6 flex items-center justify-center">
                <div class="absolute inset-0 rounded-2xl sm:rounded-3xl bg-forest/10 rotate-6 transition-transform"></div>
                <div class="relative w-16 h-16 sm:w-20 sm:h-20 rounded-2xl sm:rounded-3xl bg-emerald-50 border border-emerald-200/70 flex items-center justify-center text-forest shadow-xs">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>

            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 tracking-tight mb-3">
                Verifikasi Alamat Email Anda
            </h1>

            @if(auth()->check() && auth()->user()->email)
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-stone-100 border border-stone-200/70 text-stone-700 text-xs sm:text-sm font-semibold mb-4 sm:mb-5 max-w-full">
                    <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    <span class="truncate">{{ auth()->user()->email }}</span>
                </div>
            @endif

            <p class="font-sans text-stone-600 text-sm sm:text-base leading-relaxed mb-6">
                Terima kasih telah bergabung dengan portal <strong>Suara Warga Sekolah SMAN 1 Malingping</strong>. Sebelum mulai berpartisipasi, silakan buka email Anda dan tekan tombol atau tautan verifikasi yang telah kami kirimkan.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-left flex items-start gap-3 shadow-xs">
                    <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-sans text-sm font-bold text-forest">Tautan Verifikasi Baru Terkirim!</h4>
                        <p class="font-sans text-sm text-stone-600 mt-0.5">
                            Tautan verifikasi telah kami kirimkan ulang ke alamat email Anda. Silakan periksa kembali kotak masuk atau folder spam.
                        </p>
                    </div>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3 pt-1 sm:pt-2">
                <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2.5 px-6 py-3.5 bg-forest hover:bg-stone-900 text-white font-sans text-sm font-bold rounded-xl shadow-xs hover:shadow-md transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span>Kirim Ulang Email</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-white hover:bg-stone-100 text-stone-700 hover:text-stone-900 border border-stone-200 font-sans text-sm font-semibold rounded-xl transition-all cursor-pointer">
                        <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>

            <div class="mt-8 pt-5 sm:pt-6 border border-stone-200/70 sm:border-t sm:border-x-0 sm:border-b-0 text-left bg-stone-50/70 rounded-2xl sm:rounded-none sm:rounded-b-3xl mx-0 sm:-mx-10 sm:-mb-10 p-5 sm:p-8">
                <div class="flex items-center gap-2 text-stone-800 font-sans text-sm font-bold mb-2">
                    <svg class="w-4 h-4 text-forest flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Belum menerima email verifikasi?</span>
                </div>
                <ul class="font-sans text-xs sm:text-sm text-stone-600 space-y-1.5 list-disc list-outside pl-5 leading-relaxed">
                    <li>Periksa folder <strong>Spam</strong>, <strong>Junk</strong>, atau tab <strong>Promosi</strong> di akun email Anda.</li>
                    <li>Pastikan alamat email yang terdaftar di atas sudah benar.</li>
                    <li>Tunggu sekitar 1–2 menit sebelum meminta pengiriman ulang.</li>
                </ul>
            </div>

        </div>
    </main>

    <footer class="w-full py-5 sm:py-6 text-center text-xs sm:text-sm font-sans text-stone-500 border-t border-stone-200/50 bg-white sm:bg-white/50">
        <p>&copy; {{ date('Y') }} SMAN 1 Malingping. Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
