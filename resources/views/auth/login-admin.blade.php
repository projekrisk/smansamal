<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - SMAN 1 Malingping</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-900 text-stone-100 min-h-screen flex flex-col justify-between selection:bg-forest selection:text-white antialiased">

    <header class="p-6 md:p-8 flex justify-center sm:justify-start max-w-6xl mx-auto w-full">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-10 h-10 rounded-full border-2 border-forest object-cover">
            <span class="font-serif text-xl font-semibold text-white">SMAN 1<span class="text-terracotta"> Malingping</span></span>
        </a>
    </header>

    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 py-4 sm:py-12">
        <div class="w-full max-w-md bg-transparent sm:bg-stone-800/90 border-0 sm:border sm:border-stone-700/80 rounded-none sm:rounded-3xl p-2 sm:p-8 md:p-10 shadow-none sm:shadow-2xl backdrop-blur-none sm:backdrop-blur-md">

            <div class="text-center mb-8">
                <div class="w-14 h-14 rounded-2xl bg-forest/20 text-forest mx-auto flex items-center justify-center mb-4 border border-forest/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h1 class="font-serif text-3xl text-white mb-2">Portal Pengelola</h1>
                <p class="font-sans text-xs text-stone-400">Masuk khusus Super Admin dan Dewan Guru Moderator</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-900/30 border border-red-700/50 text-xs text-red-300 font-sans">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-red-900/30 border border-red-700/50 text-xs text-red-300 font-sans">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block font-sans text-xs font-bold text-stone-300 uppercase tracking-wider mb-2">Email Administrator</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@sman1malingping.sch.id" class="w-full px-4 py-3 rounded-xl bg-stone-900/80 border border-stone-700 text-stone-100 font-sans text-sm focus:border-forest focus:ring-1 focus:ring-forest placeholder-stone-500">
                </div>

                <div>
                    <label class="block font-sans text-xs font-bold text-stone-300 uppercase tracking-wider mb-2">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="admin_password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 pr-10 rounded-xl bg-stone-900/80 border border-stone-700 text-stone-100 font-sans text-sm focus:border-forest focus:ring-1 focus:ring-forest placeholder-stone-500">
                        <button type="button" onclick="toggleAdminPass(this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-stone-400 hover:text-stone-200 focus:outline-none cursor-pointer" title="Lihat kata sandi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="remember" name="remember" class="rounded border-stone-700 bg-stone-900 text-forest focus:ring-forest">
                    <label for="remember" class="font-sans text-xs text-stone-400">Ingat sesi ini</label>
                </div>

                <script>
                    function toggleAdminPass(btn) {
                        const input = document.getElementById('admin_password');
                        if (!input) return;
                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';
                        const eyeOpenSvg = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
                        const eyeSlashSvg = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;
                        const svg = btn.querySelector('svg');
                        if (svg) svg.innerHTML = isPassword ? eyeSlashSvg : eyeOpenSvg;
                    }
                </script>

                <button type="submit" class="w-full bg-forest text-white py-3.5 rounded-full font-sans text-sm font-bold hover:bg-forest/80 transition-colors shadow-lg mt-2 cursor-pointer">
                    Masuk ke Dashboard Admin
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-stone-700/60 text-center font-sans text-xs text-stone-400">
                Bukan pengelola?
                <a href="{{ route('login') }}" class="text-terracotta hover:underline">Masuk sebagai Siswa / Alumni</a>
            </div>

        </div>
    </main>

    <footer class="p-6 text-center font-sans text-xs text-stone-500">
        &copy; {{ date('Y') }} SMAN 1 Malingping. Sistem Otorisasi Terenkripsi.
    </footer>

</body>
</html>
