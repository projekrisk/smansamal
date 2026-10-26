<x-layouts.warga title="Pengaturan Profil - Dasbor Warga" headerTitle="Profil Akun">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="font-serif text-xl sm:text-2xl font-bold text-stone-900">Pengaturan Akun</h1>
                <span class="px-2 py-0.5 rounded-full text-[11px] font-bold tracking-wider bg-forest/10 text-forest border border-forest/20">
                    {{ ucfirst($user->role_type ?? 'Warga') }}
                </span>
            </div>
        </div>

        @if($user->username)
            <a href="{{ route('warga.profile', $user->username) }}" target="_blank" class="px-3.5 py-1.5 rounded-xl border border-stone-300 text-stone-700 hover:bg-stone-100 hover:text-stone-900 text-sm font-bold tracking-wider transition-colors inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                <svg class="w-3.5 h-3.5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                <span>Lihat Profil Publik</span>
            </a>
        @endif
    </div>

    @if (session('status') === 'profile-updated')
        <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm sm:text-sm font-medium flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Profil akun Anda berhasil diperbarui.</span>
            </div>
            <span class="text-[11px] text-emerald-600 font-bold tracking-wider">Tersimpan</span>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm sm:text-sm font-medium flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Kata sandi Anda telah berhasil diubah.</span>
            </div>
            <span class="text-[11px] text-emerald-600 font-bold tracking-wider">Berhasil</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm sm:text-sm shadow-2xs">
            <div class="flex items-start gap-2.5">
                <svg class="w-4 h-4 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <h5 class="font-bold text-rose-900 leading-snug">Perhatian: Penyimpanan belum berhasil!</h5>
                    <ul class="mt-1 list-disc list-inside text-rose-700 space-y-0.5 text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 pb-6">

        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-xl border border-stone-200/90 shadow-2xs p-4 sm:p-5">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-stone-100">
                    <div class="flex items-center gap-2.5">
                        <div>
                            <h3 class="font-serif text-base sm:text-lg font-bold text-stone-900">Informasi Pribadi</h3>
                        </div>
                    </div>
                    <span class="text-[11px] font-semibold text-stone-400 hidden sm:inline-block">* Wajib diisi</span>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-3.5">
                    @csrf
                    @method('PATCH')

                    <div class="p-3 rounded-xl bg-stone-50/70 border border-stone-100">
                        <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-2">Foto Profil</label>
                        <div class="flex items-center gap-3.5">
                            <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-2xs flex-shrink-0">
                            <div class="flex-grow">
                                <input type="file" name="avatar" id="avatar-input" accept="image/*" class="w-full text-sm text-stone-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-white file:text-stone-700 hover:file:bg-forest hover:file:text-white file:transition-colors cursor-pointer border border-stone-200 rounded-lg p-1 bg-white">
                                <span class="text-[11px] text-stone-400 block mt-1">Format JPG, PNG, atau WebP (Maks. 4MB). Otomatis dikonversi ke WebP.</span>
                            </div>
                        </div>
                        @error('avatar')
                            <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                        <div>
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input text-sm sm:text-sm py-2 @error('name') border-rose-500 ring-1 ring-rose-500 @enderror">
                            @error('name')
                                <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider">
                                    Username (Slug) <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-[10px] text-stone-400 font-mono">Unik</span>
                            </div>
                            <div class="relative flex items-center">
                                <span class="absolute left-2.5 text-sm text-stone-400 font-mono select-none pointer-events-none">/warga/</span>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" placeholder="username-anda" class="form-input pl-16 text-sm sm:text-sm py-2 font-mono @error('username') border-rose-500 bg-rose-50/40 ring-1 ring-rose-500 text-rose-900 @enderror">
                            </div>
                            @error('username')
                                <p class="text-sm text-rose-600 font-bold mt-1.5 flex items-start gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0 mt-0.5 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @else
                                <p class="text-[11px] text-stone-400 mt-1">Tautan publik profil Anda.</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider">
                                    Alamat Email
                                </label>
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold tracking-wider text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Terkunci
                                </span>
                            </div>
                            <div class="relative flex items-center">
                                <span class="absolute left-2.5 text-stone-400 pointer-events-none select-none">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </span>
                                <input type="email" value="{{ $user->email }}" readonly tabindex="-1" class="form-input pl-8 text-sm sm:text-sm py-2 bg-stone-100/90 text-stone-500 border-stone-200 cursor-not-allowed select-none font-mono" title="Email akun terkunci dan tidak dapat diubah demi keamanan.">
                            </div>
                            <p class="text-[11px] text-stone-400 mt-1">Terkunci demi keamanan akun sekolah.</p>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider">Bio Singkat</label>
                            <span class="text-[10px] text-stone-400">Maks. 1000 karakter</span>
                        </div>
                        <textarea name="bio" rows="2" placeholder="Tuliskan minat literasi, ketertarikan akademis, atau perkenalan singkat tentang Anda..." class="form-input text-sm sm:text-sm py-2 resize-none">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-3.5 rounded-xl bg-stone-50 border border-stone-200/80 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-bold tracking-wider text-forest flex items-center gap-1.5">
                                Status Warga: {{ ucfirst($user->role_type ?? 'Warga') }}
                            </span>
                            <span class="text-[10px] text-stone-400">Terdaftar</span>
                        </div>

                        @if($user->role_type === 'siswa')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-sans text-[11px] font-bold text-stone-600 tracking-wider mb-1">NISN</label>
                                    <input type="text" name="nisn" value="{{ old('nisn', $user->nisn) }}" placeholder="Contoh: 0071238945" class="form-input text-sm sm:text-sm py-1.5">
                                </div>
                                <div>
                                    <label class="block font-sans text-[11px] font-bold text-stone-600 tracking-wider mb-1">Kelas</label>
                                    <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}" placeholder="Contoh: XII MIPA 1" class="form-input text-sm sm:text-sm py-1.5">
                                </div>
                            </div>
                        @elseif($user->role_type === 'guru')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-sans text-[11px] font-bold text-stone-600 tracking-wider mb-1">NIP (Opsional)</label>
                                    <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" placeholder="1982..." class="form-input text-sm sm:text-sm py-1.5">
                                </div>
                                <div>
                                    <label class="block font-sans text-[11px] font-bold text-stone-600 tracking-wider mb-1">Mata Pelajaran</label>
                                    <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran', $user->mata_pelajaran) }}" placeholder="Biologi" class="form-input text-sm sm:text-sm py-1.5">
                                </div>
                            </div>
                        @elseif($user->role_type === 'alumni')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-sans text-[11px] font-bold text-stone-600 tracking-wider mb-1">Tahun Lulus</label>
                                    <input type="text" name="tahun_lulus" value="{{ old('tahun_lulus', $user->tahun_lulus) }}" placeholder="Contoh: 2022" class="form-input text-sm sm:text-sm py-1.5">
                                </div>
                                <div>
                                    <label class="block font-sans text-[11px] font-bold text-stone-600 tracking-wider mb-1">Pekerjaan / Kampus</label>
                                    <input type="text" name="pekerjaan_kampus" value="{{ old('pekerjaan_kampus', $user->pekerjaan_kampus) }}" placeholder="Mahasiswa UI / PT..." class="form-input text-sm sm:text-sm py-1.5">
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="bg-forest text-white px-5 py-2 rounded-xl text-sm sm:text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-2xs inline-flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan Profil</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl border border-stone-200/90 shadow-2xs p-4 sm:p-5" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
                <div class="flex items-center justify-between pb-3 mb-4 border-b border-stone-100">
                    <div class="flex items-center gap-2.5">
                        <div>
                            <h3 class="font-serif text-base sm:text-lg font-bold text-stone-900">Keamanan Sandi</h3>
                        </div>
                    </div>
                    <span class="text-[11px] text-stone-400">Min. 8 karakter</span>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-3.5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1">
                            Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <input :type="showCurrent ? 'text' : 'password'" name="current_password" required placeholder="••••••••" class="form-input pr-10 text-sm sm:text-sm py-2 @error('current_password', 'updatePassword') border-rose-500 ring-1 ring-rose-500 @enderror">
                            <button type="button" @click="showCurrent = !showCurrent" class="absolute right-2.5 text-stone-400 hover:text-stone-700 p-1 focus:outline-none transition-colors cursor-pointer" :title="showCurrent ? 'Sembunyikan sandi' : 'Lihat sandi'" tabindex="-1">

                                <svg x-show="!showCurrent" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>

                                <svg x-show="showCurrent" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                        @error('current_password', 'updatePassword')
                            <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        <div>
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1">
                                Kata Sandi Baru <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <input :type="showNew ? 'text' : 'password'" name="password" required placeholder="Min. 8 karakter" class="form-input pr-10 text-sm sm:text-sm py-2 @error('password', 'updatePassword') border-rose-500 ring-1 ring-rose-500 @enderror">
                                <button type="button" @click="showNew = !showNew" class="absolute right-2.5 text-stone-400 hover:text-stone-700 p-1 focus:outline-none transition-colors cursor-pointer" :title="showNew ? 'Sembunyikan sandi' : 'Lihat sandi'" tabindex="-1">
                                    <svg x-show="!showNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showNew" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block font-sans text-sm font-bold text-stone-700 tracking-wider mb-1">
                                Ulangi Sandi Baru <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required placeholder="Ulangi sandi baru" class="form-input pr-10 text-sm sm:text-sm py-2 @error('password_confirmation', 'updatePassword') border-rose-500 ring-1 ring-rose-500 @enderror">
                                <button type="button" @click="showConfirm = !showConfirm" class="absolute right-2.5 text-stone-400 hover:text-stone-700 p-1 focus:outline-none transition-colors cursor-pointer" :title="showConfirm ? 'Sembunyikan sandi' : 'Lihat sandi'" tabindex="-1">
                                    <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                            @error('password_confirmation', 'updatePassword')
                                <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="bg-stone-900 text-white px-5 py-2 rounded-xl text-sm sm:text-sm font-bold tracking-wider hover:bg-forest transition-colors shadow-2xs inline-flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            <span>Perbarui Sandi</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <div class="space-y-4">

            <div class="bg-white rounded-xl border border-stone-200/90 shadow-2xs p-4 text-center">
                <div class="relative w-14 h-14 mx-auto mb-2.5">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover border-2 border-stone-100 shadow-2xs">
                    @if($user->is_active)
                        <span class="absolute bottom-0 right-0 w-3.5 h-3.5 rounded-full bg-emerald-500 border-2 border-white" title="Aktif & Terverifikasi"></span>
                    @endif
                </div>

                <h4 class="font-serif text-base text-stone-900 font-bold leading-tight">{{ $user->name }}</h4>
                <p class="text-sm text-forest font-semibold mt-0.5">{{ $user->role_detail ?? ucfirst($user->role_type) }}</p>

                @if($user->username)
                    <div class="mt-2 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-stone-100 text-stone-600 font-mono text-[11px]">
                        <span>@</span><span>{{ $user->username }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-3 gap-1.5 mt-3 pt-3 border-t border-stone-100 text-center">
                    <div class="p-1.5 rounded-lg bg-stone-50">
                        <span class="block text-stone-900 font-bold text-sm sm:text-sm leading-tight">{{ $totalArticles ?? $user->articles()->count() }}</span>
                        <span class="block text-[12px] text-stone-400 tracking-wider font-semibold">Karya</span>
                    </div>
                    <div class="p-1.5 rounded-lg bg-stone-50">
                        <span class="block text-stone-900 font-bold text-sm sm:text-sm leading-tight">{{ $totalLikes ?? (int)$user->articles()->published()->sum('likes_count') }}</span>
                        <span class="block text-[12px] text-stone-400 tracking-wider font-semibold">Suka</span>
                    </div>
                    <div class="p-1.5 rounded-lg bg-stone-50">
                        <span class="block text-stone-900 font-bold text-sm sm:text-sm leading-tight">{{ $totalViews ?? (int)$user->articles()->published()->sum('views_count') }}</span>
                        <span class="block text-[12px] text-stone-400 tracking-wider font-semibold">Dilihat</span>
                    </div>
                </div>

                <div class="mt-3 pt-3 border-t border-stone-100 flex items-center justify-center gap-2">
                    @if($user->is_active)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Akun Terverifikasi
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 text-sm font-semibold border border-amber-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Tahap Verifikasi
                        </span>
                    @endif
                </div>
            </div>

            <div class="bg-rose-50/70 rounded-xl border border-rose-200/80 p-4 shadow-2xs" x-data="{ showDel: false }">
                <div class="flex items-center gap-2 mb-1.5">
                    <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    <h4 class="font-serif text-sm text-rose-900 font-bold">Hapus Akun</h4>
                </div>
                <p class="text-sm text-rose-700 leading-relaxed mb-3">
                    Setelah akun dihapus, seluruh data artikel dan interaksi Anda akan dinonaktifkan secara permanen.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Peringatan: Apakah Anda yakin ingin menghapus akun Anda secara permanen? Seluruh data artikel tidak dapat dipulihkan.');">
                    @csrf
                    @method('DELETE')
                    <div class="mb-2.5">
                        <label class="block font-sans text-[11px] font-bold text-rose-800 tracking-wider mb-1">Konfirmasi Sandi Anda</label>
                        <div class="relative flex items-center">
                            <input :type="showDel ? 'text' : 'password'" name="password" required placeholder="Masukkan kata sandi konfirmasi" class="form-input pr-9 text-sm py-1.5 border-rose-200 focus:border-rose-500 focus:ring-rose-200 bg-white">
                            <button type="button" @click="showDel = !showDel" class="absolute right-2 text-rose-400 hover:text-rose-700 p-0.5 focus:outline-none transition-colors cursor-pointer" :title="showDel ? 'Sembunyikan sandi' : 'Lihat sandi'" tabindex="-1">
                                <svg x-show="!showDel" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showDel" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                        @error('password', 'userDeletion')
                            <p class="text-sm text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white py-2 rounded-xl font-sans text-sm font-bold tracking-wider transition-colors shadow-2xs cursor-pointer">
                        Hapus Akun Permanen
                    </button>
                </form>
            </div>

        </div>

    </div>

    <script>
        const avatarInput = document.getElementById('avatar-input');
        const avatarPreview = document.getElementById('avatar-preview');
        if (avatarInput && avatarPreview) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        avatarPreview.src = evt.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    </script>

</x-layouts.warga>
