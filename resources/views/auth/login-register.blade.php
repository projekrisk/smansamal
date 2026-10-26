<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar - SMAN 1 Malingping</title>

    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                            800: '#3D3935',
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

    <style>
        body {
            background-color: #F9F8F6;
            color: #2A2724;
        }

        .form-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border-radius: 0.625rem;
            border: 1px solid #EFEBE4;
            background-color: #ffffff;
            font-family: 'Manrope', sans-serif;
            font-size: 0.875rem;
            line-height: 1.25rem;
            transition: all 0.25s ease;
            color: #2A2724;
        }
        .form-input:focus {
            outline: none;
            border-color: #2A5C43;
            box-shadow: 0 0 0 2px rgba(42, 92, 67, 0.1);
        }
        .form-input::placeholder {
            color: #a8a29e;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-content-scroll {
            max-height: 100vh;
            overflow-y: auto;
        }
        @media (min-width: 640px) {
            .modal-content-scroll {
                max-height: 90vh;
            }
        }

        .modal-content-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .modal-content-scroll::-webkit-scrollbar-thumb {
            background-color: #d6d3d1;
            border-radius: 10px;
        }
    </style>
</head>
<body class="antialiased selection:bg-forest selection:text-white flex min-h-screen relative overflow-hidden md:overflow-auto">

    <div class="hidden lg:flex w-1/2 relative bg-stone-900 overflow-hidden items-center justify-center p-12">
        <img src="{{ asset('images/bg.jpg') }}" alt="Kampus SMAN 1 Malingping" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60">

        <div class="relative z-10 text-center text-white max-w-lg">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-3 mb-10 group">
                <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-12 h-12 transition-transform group-hover:scale-105">
            </a>

            <h1 class="font-serif text-4xl leading-tight mb-6">Suara Warga Sekolah</h1>
            <p class="font-sans text-stone-200 text-base leading-relaxed mb-8">Platform khusus untuk siswa, guru, dan alumni SMAN 1 Malingping berdiskusi, berbagi opini, dan mempublikasikan karya tulis yang menginspirasi.</p>

            <div class="flex items-center justify-center gap-4 text-sm font-sans font-medium text-white/80">
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-terracotta" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Terverifikasi</span>
                <span>&bull;</span>
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-terracotta" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Aman</span>
                <span>&bull;</span>
                <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-terracotta" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Internal</span>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex flex-col justify-center relative bg-stone-50 h-screen lg:h-auto overflow-y-auto px-6 py-12 md:px-16 lg:px-24">

        <a href="{{ route('home') }}" class="absolute top-6 left-6 lg:left-8 flex items-center gap-2 text-sm font-sans font-semibold text-stone-500 hover:text-forest transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <div class="w-full max-w-sm mx-auto my-auto text-center fade-in">

            <div class="flex lg:hidden justify-center mb-6">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-16 h-16 rounded-full border-4 border-white shadow-sm object-cover">
                </a>
            </div>

            <div class="mb-10">
                <h2 class="font-serif text-3xl md:text-4xl text-stone-900 mb-3">Selamat Datang</h2>
                <p class="font-sans text-stone-500 text-sm md:text-base">Silakan pilih akses untuk melanjutkan ke portal SMAN 1 Malingping.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-forest/10 border border-forest/20 text-sm text-forest font-sans text-left">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex flex-col gap-4">
                <button onclick="openModal('login-modal')" class="w-full bg-forest text-white py-4 rounded-2xl font-sans text-base font-bold hover:bg-stone-900 transition-colors shadow-sm hover:shadow-md flex items-center justify-center gap-3 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Masuk ke Akun
                </button>
                <div class="relative flex items-center py-2">
                    <div class="flex-grow border-t border-stone-200"></div>
                    <span class="flex-shrink-0 mx-4 text-stone-400 text-sm font-semibold uppercase tracking-widest">Atau</span>
                    <div class="flex-grow border-t border-stone-200"></div>
                </div>
                <button onclick="openModal('register-modal')" class="w-full bg-white text-stone-800 border border-stone-200 py-4 rounded-2xl font-sans text-base font-bold hover:border-forest hover:text-forest transition-colors shadow-sm hover:shadow-md flex items-center justify-center gap-3 group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Daftar Akun Baru
                </button>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('admin.login') }}" class="font-sans text-sm text-stone-500 hover:text-forest transition-colors inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Akses Login Administrator Portal
                </a>
            </div>

            <div class="mt-8 text-center border-t border-stone-200/80 pt-6">
                <p class="font-sans text-sm text-stone-400">&copy; {{ date('Y') }} SMAN 1 Malingping, Lebak - Banten.</p>
            </div>
        </div>
    </div>

    <div id="login-modal" class="fixed inset-0 z-[100] bg-white opacity-0 pointer-events-none transition-opacity duration-300 overflow-y-auto">

        <div class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-stone-200/70 px-6 py-4">
            <div class="max-w-5xl mx-auto flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-9 h-9">
                    <span class="font-serif text-lg font-semibold text-stone-900">SMAN 1<span class="text-terracotta"> Malingping</span></span>
                </a>
                <button onclick="closeModal('login-modal')" class="text-stone-400 hover:text-stone-900 transition-colors focus:outline-none bg-stone-100 hover:bg-stone-200 rounded-full p-2 cursor-pointer" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <div class="min-h-[calc(100vh-80px)] flex flex-col justify-center items-center px-4 sm:px-6 py-10">
            <div class="w-full max-w-md mx-auto">
                <div class="mb-6 text-center">
                    <h3 class="font-serif text-3xl md:text-4xl text-stone-900 mb-2">Masuk ke Akun</h3>
                    <p class="font-sans text-stone-500 text-sm">Silakan masukkan email dan kata sandi Anda untuk mengakses portal.</p>
                </div>

                @if ($errors->any() && !old('role_type'))
                    <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-600 font-sans">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4 text-left">
                    @csrf
                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@sman1malingping.sch.id" class="form-input text-sm" required autofocus>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label for="login_password" class="block font-sans text-sm font-semibold text-stone-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="font-sans text-sm font-semibold text-terracotta hover:text-forest transition-colors">Lupa sandi?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <input type="password" id="login_password" name="password" placeholder="Masukkan kata sandi Anda" class="form-input pr-11 text-sm" required>
                            <button type="button" onclick="togglePasswordVisibility('login_password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-700 focus:outline-none cursor-pointer" title="Lihat kata sandi" aria-label="Lihat kata sandi">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 pt-1">
                        <input type="checkbox" id="remember_me" name="remember" class="accent-forest w-4 h-4 rounded border-stone-300 cursor-pointer">
                        <label for="remember_me" class="font-sans text-sm text-stone-600 cursor-pointer">Ingat saya di perangkat ini</label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-forest text-white py-3.5 rounded-xl font-sans text-sm font-bold hover:bg-stone-900 transition-colors shadow-sm cursor-pointer">
                            Masuk ke Akun
                        </button>
                    </div>
                    <div class="text-center pt-3 border-t border-stone-200/70 mt-6">
                        <p class="font-sans text-sm text-stone-500">Belum punya akun? <button type="button" onclick="switchModal('login-modal', 'register-modal')" class="text-forest font-semibold hover:underline cursor-pointer">Daftar sekarang di sini</button></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="register-modal" class="fixed inset-0 z-[100] bg-white opacity-0 pointer-events-none transition-opacity duration-300 overflow-y-auto">

        <div class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-stone-200/70 px-6 py-4">
            <div class="max-w-5xl mx-auto flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-9 h-9">
                    <span class="font-serif text-lg font-semibold text-stone-900">SMAN 1<span class="text-terracotta"> Malingping</span></span>
                </a>
                <button onclick="closeModal('register-modal')" class="text-stone-400 hover:text-stone-900 transition-colors focus:outline-none bg-stone-100 hover:bg-stone-200 rounded-full p-2 cursor-pointer" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <div class="min-h-[calc(100vh-80px)] flex flex-col justify-center items-center px-4 sm:px-6 py-10">
            <div class="w-full max-w-xl mx-auto">
                <div class="mb-6 text-center">
                    <h3 class="font-serif text-3xl md:text-4xl text-stone-900 mb-2">Daftar Akun Baru</h3>
                    <p class="font-sans text-stone-500 text-sm">Lengkapi data diri Anda sesuai dengan identitas sekolah resmi.</p>
                </div>

                @if ($errors->any() && (old('role_type') || $errors->has('name') || $errors->has('nisn') || $errors->has('kelas') || $errors->has('nip') || $errors->has('mata_pelajaran') || $errors->has('tahun_lulus') || $errors->has('pekerjaan_kampus') || $errors->has('password_confirmation')))
                    <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-600 font-sans text-left">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4 text-left">
                    @csrf

                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-2">Status Anda di Sekolah</label>
                        <div class="grid grid-cols-3 gap-2.5">
                            <label class="cursor-pointer">
                                <input type="radio" name="role_type" value="siswa" class="peer sr-only" {{ old('role_type', 'siswa') === 'siswa' ? 'checked' : '' }} onchange="updateRegisterFields()">
                                <div class="text-center py-2.5 rounded-xl border border-stone-200 bg-white font-sans text-sm font-semibold text-stone-500 peer-checked:border-forest peer-checked:bg-forest/5 peer-checked:text-forest transition-all">
                                    Siswa
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="role_type" value="guru" class="peer sr-only" {{ in_array(old('role_type'), ['guru', 'staf', 'pegawai']) ? 'checked' : '' }} onchange="updateRegisterFields()">
                                <div class="text-center py-2.5 rounded-xl border border-stone-200 bg-white font-sans text-xs sm:text-sm font-semibold text-stone-500 peer-checked:border-terracotta peer-checked:bg-terracotta/5 peer-checked:text-terracotta transition-all flex items-center justify-center min-h-[42px] px-1">
                                    Guru / Staf
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="role_type" value="alumni" class="peer sr-only" {{ old('role_type') === 'alumni' ? 'checked' : '' }} onchange="updateRegisterFields()">
                                <div class="text-center py-2.5 rounded-xl border border-stone-200 bg-white font-sans text-sm font-semibold text-stone-500 peer-checked:border-stone-800 peer-checked:bg-stone-100 peer-checked:text-stone-900 transition-all">
                                    Alumni
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Sesuai ijazah atau KTP" class="form-input text-sm" required>
                    </div>

                    <div id="dynamic-fields-container" class="bg-stone-100/50 p-3.5 rounded-xl border border-stone-200/60 min-h-[76px] flex flex-col justify-center">

                    </div>

                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email aktif" class="form-input text-sm" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label for="reg_password" class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Buat Kata Sandi</label>
                            <div class="relative">
                                <input type="password" id="reg_password" name="password" placeholder="Min. 8 karakter" class="form-input pr-11 text-sm" required>
                                <button type="button" onclick="togglePasswordVisibility('reg_password', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-700 focus:outline-none cursor-pointer" title="Lihat kata sandi" aria-label="Lihat kata sandi">
                                    <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label for="reg_password_confirmation" class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Konfirmasi Sandi</label>
                            <div class="relative">
                                <input type="password" id="reg_password_confirmation" name="password_confirmation" placeholder="Ulangi sandi" class="form-input pr-11 text-sm" required>
                                <button type="button" onclick="togglePasswordVisibility('reg_password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-700 focus:outline-none cursor-pointer" title="Lihat kata sandi" aria-label="Lihat kata sandi">
                                    <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 bg-stone-50 p-4 rounded-xl border border-stone-200/80 space-y-3">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="terms" name="terms" class="mt-1 accent-forest w-4 h-4 border-stone-300 rounded cursor-pointer" required checked>
                            <label for="terms" class="font-sans text-sm text-stone-600 leading-relaxed cursor-pointer">
                                Saya menyetujui <a href="{{ route('terms') }}" target="_blank" class="text-forest font-semibold hover:underline">Syarat & Ketentuan</a> dan <a href="{{ route('privacy') }}" target="_blank" class="text-forest font-semibold hover:underline">Kebijakan Privasi</a>.
                            </label>
                        </div>

                        <div class="text-sm text-stone-600 bg-white/90 p-3 rounded-lg border border-stone-200/60 flex items-start gap-2.5 leading-snug">
                            <svg class="w-4 h-4 text-forest flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span><strong>Catatan Verifikasi:</strong> Data pendaftaran alumni (tahun lulus) dan siswa (NISN & kelas) akan dilakukan pengecekan atau validasi resmi oleh sekolah.</span>
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" class="w-full bg-stone-900 text-white py-3.5 rounded-xl font-sans text-sm font-bold hover:bg-forest transition-colors shadow-sm cursor-pointer">
                            Buat Akun Baru
                        </button>
                    </div>
                    <div class="text-center pt-3 border-t border-stone-200/70 mt-6">
                        <p class="font-sans text-sm text-stone-500">Sudah punya akun? <button type="button" onclick="switchModal('register-modal', 'login-modal')" class="text-forest font-semibold hover:underline cursor-pointer">Masuk di sini</button></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
            modal.scrollTop = 0;
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        }

        function switchModal(closeId, openId) {
            closeModal(closeId);
            setTimeout(() => {
                openModal(openId);
            }, 200);
        }

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const eyeOpenSvg = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            const eyeSlashSvg = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>`;

            const svg = btn.querySelector('svg');
            if (svg) {
                svg.innerHTML = isPassword ? eyeSlashSvg : eyeOpenSvg;
                btn.title = isPassword ? 'Sembunyikan kata sandi' : 'Lihat kata sandi';
                btn.setAttribute('aria-label', btn.title);
            }
        }

        const oldNisn = @json(old('nisn', ''));
        const oldKelas = @json(old('kelas', ''));
        const oldNip = @json(old('nip', ''));
        const oldMataPelajaran = @json(old('mata_pelajaran', ''));
        const oldTahunLulus = @json(old('tahun_lulus', ''));
        const oldPekerjaanKampus = @json(old('pekerjaan_kampus', ''));

        function getFieldsSiswa() {
            return `
                <div class="grid grid-cols-2 gap-3.5 fade-in w-full">
                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">NISN</label>
                        <input type="number" name="nisn" value="${oldNisn}" placeholder="Nomor Induk" class="form-input text-sm" required>
                    </div>
                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Tingkat Kelas</label>
                        <input type="hidden" name="kelas" id="input_reg_kelas" value="${oldKelas || '10'}" required>
                        <div class="grid grid-cols-3 gap-2" id="reg_kelas_btns">
                            <button type="button" onclick="selectRegKelas('10', this)" class="kelas-btn py-2 px-2 rounded-xl border text-sm font-bold text-center transition-all ${(!oldKelas || oldKelas === '10') ? 'border-forest bg-forest/5 text-forest ring-1 ring-forest' : 'border-stone-200 text-stone-600 bg-white'} cursor-pointer">X</button>
                            <button type="button" onclick="selectRegKelas('11', this)" class="kelas-btn py-2 px-2 rounded-xl border text-sm font-bold text-center transition-all ${oldKelas === '11' ? 'border-forest bg-forest/5 text-forest ring-1 ring-forest' : 'border-stone-200 text-stone-600 bg-white'} cursor-pointer">XI</button>
                            <button type="button" onclick="selectRegKelas('12', this)" class="kelas-btn py-2 px-2 rounded-xl border text-sm font-bold text-center transition-all ${oldKelas === '12' ? 'border-forest bg-forest/5 text-forest ring-1 ring-forest' : 'border-stone-200 text-stone-600 bg-white'} cursor-pointer">XII</button>
                        </div>
                    </div>
                </div>
            `;
        }

        function getFieldsGuru() {
            return `
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 fade-in w-full">
                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">NIP / NUPTK (Opsional)</label>
                        <input type="text" name="nip" value="${oldNip}" placeholder="Nomor Pegawai / NIP" class="form-input text-sm">
                    </div>
                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Mapel / Bidang Tugas</label>
                        <input type="text" name="mata_pelajaran" value="${oldMataPelajaran}" placeholder="Cth: Biologi / Tata Usaha / IT" class="form-input text-sm" required>
                    </div>
                </div>
                <p class="text-[11px] text-stone-500 mt-2">Untuk Guru: isi mata pelajaran. Untuk Staf/Pegawai: isi bidang tugas atau unit kerja.</p>
            `;
        }

        function getFieldsAlumni() {
            return `
                <div class="grid grid-cols-2 gap-3.5 fade-in w-full">
                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Tahun Lulus</label>
                        <input type="number" name="tahun_lulus" value="${oldTahunLulus}" placeholder="Cth: 2022" class="form-input text-sm" required min="1980" max="{{ date('Y') }}">
                    </div>
                    <div>
                        <label class="block font-sans text-sm font-semibold text-stone-700 mb-1.5">Pekerjaan / Kampus</label>
                        <input type="text" name="pekerjaan_kampus" value="${oldPekerjaanKampus}" placeholder="Aktivitas saat ini" class="form-input text-sm" required>
                    </div>
                </div>
            `;
        }

        function selectRegKelas(val, btn) {
            document.getElementById('input_reg_kelas').value = val;
            document.querySelectorAll('.kelas-btn').forEach(b => {
                b.className = 'kelas-btn py-2 px-2 rounded-xl border text-sm font-bold text-center transition-all border-stone-200 text-stone-600 bg-white cursor-pointer';
            });
            btn.className = 'kelas-btn py-2 px-2 rounded-xl border text-sm font-bold text-center transition-all border-forest bg-forest/5 text-forest ring-1 ring-forest cursor-pointer';
        }

        function updateRegisterFields() {
            const dynamicContainer = document.getElementById('dynamic-fields-container');
            const checkedInput = document.querySelector('input[name="role_type"]:checked');
            const selectedRole = checkedInput ? checkedInput.value : 'siswa';

            dynamicContainer.innerHTML = '';

            setTimeout(() => {
                if (selectedRole === 'siswa') {
                    dynamicContainer.innerHTML = getFieldsSiswa();
                } else if (['guru', 'staf', 'pegawai'].includes(selectedRole)) {
                    dynamicContainer.innerHTML = getFieldsGuru();
                } else if (selectedRole === 'alumni') {
                    dynamicContainer.innerHTML = getFieldsAlumni();
                }
            }, 30);
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateRegisterFields();

            const shouldOpenRegister = @json(
                ($activeTab ?? '') === 'register' ||
                request()->routeIs('register') ||
                request()->query('tab') === 'register' ||
                ($errors->any() && (old('role_type') || $errors->has('name') || $errors->has('nisn') || $errors->has('kelas') || $errors->has('nip') || $errors->has('mata_pelajaran') || $errors->has('tahun_lulus') || $errors->has('pekerjaan_kampus') || $errors->has('password_confirmation')))
            );

            const shouldOpenLogin = @json(
                ($activeTab ?? '') === 'login' ||
                request()->routeIs('login') ||
                request()->query('tab') === 'login' ||
                request()->query('action') === 'login' ||
                ($errors->any() && !old('role_type') && !$errors->has('name'))
            );

            if (shouldOpenRegister) {
                openModal('register-modal');
            } else if (shouldOpenLogin) {
                openModal('login-modal');
            }
        });
    </script>
</body>
</html>
