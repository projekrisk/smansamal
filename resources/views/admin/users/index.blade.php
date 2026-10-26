<x-layouts.admin title="Warga & Aktivasi - SMAN 1 Malingping" headerTitle="Manajemen Warga">

    <div class="mb-5">
        <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Warga Sekolah</h1>
    </div>

    <div class="bg-white p-2.5 sm:p-3 rounded-xl border border-stone-200 shadow-2xs mb-4 flex flex-col md:flex-row gap-2.5 items-center justify-between font-sans">
        <div class="flex flex-wrap gap-1.5 text-xs font-semibold w-full md:w-auto">
            <a href="{{ route('admin.users.index') }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ empty($role) && empty($status) ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Semua
            </a>
            <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'pending') ? 'bg-amber-500 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Menunggu
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'siswa']) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($role === 'siswa') ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Siswa
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'guru']) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($role === 'guru') ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Guru
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'alumni']) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($role === 'alumni') ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Alumni
            </a>
        </div>

        <form action="{{ route('admin.users.index') }}" method="GET" class="w-full md:w-72">
            @if($role) <input type="hidden" name="role" value="{{ $role }}"> @endif
            @if($status) <input type="hidden" name="status" value="{{ $status }}"> @endif
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, email, NISN, NIP..." class="w-full pl-9 pr-3.5 py-2 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 focus:bg-white outline-none">
                <svg class="w-4 h-4 text-stone-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden font-sans" x-data="{ allOpenUsers: false }">
        <div class="px-4 py-3 border-b border-stone-100 flex justify-between items-center bg-stone-50/70">
            <h2 class="font-serif text-base text-stone-900 font-bold">Daftar Warga Sekolah</h2>
            <div class="flex items-center gap-3">
                <span class="text-sm text-stone-500 font-semibold">{{ $users->total() }} Warga</span>
                @if($users->isNotEmpty())
                    <button type="button" @click="allOpenUsers = !allOpenUsers; $dispatch('toggle-admin-users', { open: allOpenUsers })" class="md:hidden text-forest hover:text-stone-900 text-xs font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                        <span x-text="allOpenUsers ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenUsers ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                @endif
            </div>
        </div>

        <div class="md:hidden divide-y divide-stone-200">
            @forelse($users as $user)
                @php
                    $userData = [
                        'id' => $user->id,
                        'username' => $user->username,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role_type' => $user->role_type,
                        'role_label' => $user->role_badge['label'],
                        'role_class' => $user->role_badge['class'],
                        'role_detail' => $user->role_detail,
                        'nisn' => $user->nisn,
                        'kelas' => $user->kelas,
                        'nip' => $user->nip,
                        'mata_pelajaran' => $user->mata_pelajaran,
                        'tahun_lulus' => $user->tahun_lulus,
                        'pekerjaan_kampus' => $user->pekerjaan_kampus,
                        'bio' => $user->bio,
                        'is_active' => (bool) $user->is_active,
                        'email_verified' => !is_null($user->email_verified_at),
                        'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->translatedFormat('d M Y, H:i') : null,
                        'created_at' => $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-',
                        'activated_at' => $user->activated_at ? $user->activated_at->translatedFormat('d M Y, H:i') : '-',
                        'avatar_url' => $user->avatar_url,
                        'profile_url' => route('warga.profile', $user->username ?? $user->id),
                        'articles_count' => $user->articles_count ?? 0,
                        'update_url' => route('admin.users.update', $user),
                        'activation_url' => route('admin.users.activation', $user),
                        'verify_url' => route('admin.users.verify-email', $user),
                        'delete_url' => route('admin.users.destroy', $user),
                        'can_edit' => auth()->user()->isSuperAdmin() || ! $user->isSuperAdmin(),
                        'can_delete' => (auth()->id() !== $user->id) && (auth()->user()->isSuperAdmin() || (! $user->isAdmin() && ! $user->isSuperAdmin())),
                    ];
                @endphp
                <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors" x-data="{ isOpen: false }" @toggle-admin-users.window="isOpen = $event.detail.open">
                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                        <div class="flex items-start gap-3 min-w-0 flex-1">
                            <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-stone-200 flex-shrink-0 mt-0.5">
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('warga.profile', $user->username ?? $user->id) }}" target="_blank" @click.stop class="font-bold text-stone-900 text-sm hover:text-forest transition-colors block truncate">
                                    {{ $user->name }}
                                </a>
                                <div class="text-xs text-stone-400 font-mono truncate mb-1.5">{{ $user->email }}</div>

                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="{{ $user->role_badge['class'] }} text-[10px] font-bold px-2 py-0.5 rounded">
                                        {{ $user->role_badge['label'] }}
                                    </span>

                                    @if($user->is_active)
                                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                            <svg class="w-2.5 h-2.5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                            <svg class="w-2.5 h-2.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                            Perlu Aktivasi
                                        </span>
                                    @endif

                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center gap-1 text-[10px] text-green-700 font-semibold bg-green-50/60 border border-green-100 px-1.5 py-0.5 rounded-full">
                                            <svg class="w-2.5 h-2.5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Email Verif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="p-2 rounded-lg bg-stone-50 border border-stone-100">
                                <span class="text-stone-400 block text-[11px]">Identitas Khusus</span>
                                <span class="font-semibold text-stone-700">
                                    @if($user->role_type === 'siswa')
                                        NISN: {{ $user->nisn ?: '-' }} &bull; Kelas: {{ $user->kelas ?: '-' }}
                                    @elseif($user->role_type === 'guru')
                                        NIP: {{ $user->nip ?: '-' }} &bull; Mapel: {{ $user->mata_pelajaran ?: '-' }}
                                    @elseif($user->role_type === 'alumni')
                                        Lulus: {{ $user->tahun_lulus ?: '-' }}
                                    @else
                                        Pengelola Sistem
                                    @endif
                                </span>
                            </div>
                            <div class="p-2 rounded-lg bg-stone-50 border border-stone-100">
                                <span class="text-stone-400 block text-[11px]">Bergabung</span>
                                <span class="font-semibold text-stone-700">{{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-2.5 rounded-lg bg-stone-50 border border-stone-100 text-xs">
                            <div class="flex items-center gap-1.5">
                                <span class="text-stone-500 font-medium">Verifikasi Email:</span>
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-green-700 font-semibold" title="{{ $user->email_verified_at->translatedFormat('d M Y H:i') }}">
                                        <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-amber-700 font-medium">
                                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        Belum Verifikasi
                                    </span>
                                @endif
                            </div>
                            @if($userData['can_edit'])
                                <form action="{{ route('admin.users.verify-email', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->email_verified_at)
                                        <button type="submit" title="Batalkan verifikasi email" class="text-xs text-stone-500 hover:text-amber-700 font-medium underline px-1 py-0.5 cursor-pointer">
                                            Batal Verif
                                        </button>
                                    @else
                                        <button type="submit" title="Verifikasi email sekarang secara manual" class="inline-flex items-center gap-1 text-xs text-forest font-bold px-2 py-1 rounded border border-forest/30 bg-forest/5 hover:bg-forest hover:text-white transition-colors cursor-pointer">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Verifikasi
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-1">
                            <button type="button" onclick='openUserDetailModal(@json($userData))' class="py-2 px-2.5 rounded-lg border border-stone-200 bg-white hover:bg-forest/10 hover:text-forest text-stone-700 font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors shadow-2xs cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>Detail</span>
                            </button>

                            @if($userData['can_edit'])
                                <button type="button" onclick='openUserEditModal(@json($userData))' class="py-2 px-2.5 rounded-lg border border-stone-200 bg-white hover:bg-amber-50 hover:text-amber-700 text-stone-700 font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors shadow-2xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Edit</span>
                                </button>

                                <form action="{{ route('admin.users.activation', $user) }}" method="POST" class="inline-block w-full">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->is_active)
                                        <button type="submit" class="w-full py-2 px-2.5 rounded-lg border border-amber-200 bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors shadow-2xs cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            <span>Nonaktif</span>
                                        </button>
                                    @else
                                        <button type="submit" class="w-full py-2 px-2.5 rounded-lg border border-forest/30 bg-forest text-white hover:bg-stone-900 font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors shadow-2xs cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>Aktifkan</span>
                                        </button>
                                    @endif
                                </form>
                            @endif

                            @if($userData['can_delete'])
                                <button type="button" onclick="window.confirmDelete('{{ route('admin.users.destroy', $user) }}', 'Yakin ingin menghapus akun warga {{ addslashes($user->name) }}? Semua karya suara warga dan komentarnya akan dihapus permanen.')" class="py-2 px-2.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors shadow-2xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Hapus</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-stone-400 text-sm">
                    Tidak ada data warga yang ditemukan.
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                    <tr>
                        <th class="py-2.5 px-4">Nama & Email</th>
                        <th class="py-2.5 px-4">Peran</th>
                        <th class="py-2.5 px-4">Identitas Khusus</th>
                        <th class="py-2.5 px-4">Status Aktivasi</th>
                        <th class="py-2.5 px-4">Verifikasi Email</th>
                        <th class="py-2.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($users as $user)
                        @php
                            $userData = [
                                'id' => $user->id,
                                'username' => $user->username,
                                'name' => $user->name,
                                'email' => $user->email,
                                'role_type' => $user->role_type,
                                'role_label' => $user->role_badge['label'],
                                'role_class' => $user->role_badge['class'],
                                'role_detail' => $user->role_detail,
                                'nisn' => $user->nisn,
                                'kelas' => $user->kelas,
                                'nip' => $user->nip,
                                'mata_pelajaran' => $user->mata_pelajaran,
                                'tahun_lulus' => $user->tahun_lulus,
                                'pekerjaan_kampus' => $user->pekerjaan_kampus,
                                'bio' => $user->bio,
                                'is_active' => (bool) $user->is_active,
                                'email_verified' => !is_null($user->email_verified_at),
                                'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->translatedFormat('d M Y, H:i') : null,
                                'created_at' => $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-',
                                'activated_at' => $user->activated_at ? $user->activated_at->translatedFormat('d M Y, H:i') : '-',
                                'avatar_url' => $user->avatar_url,
                                'profile_url' => route('warga.profile', $user->username ?? $user->id),
                                'articles_count' => $user->articles_count ?? 0,
                                'update_url' => route('admin.users.update', $user),
                                'activation_url' => route('admin.users.activation', $user),
                                'verify_url' => route('admin.users.verify-email', $user),
                                'delete_url' => route('admin.users.destroy', $user),
                                'can_edit' => auth()->user()->isSuperAdmin() || ! $user->isSuperAdmin(),
                                'can_delete' => (auth()->id() !== $user->id) && (auth()->user()->isSuperAdmin() || (! $user->isAdmin() && ! $user->isSuperAdmin())),
                            ];
                        @endphp
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="py-2.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ $user->avatar_url }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-stone-200 flex-shrink-0">
                                    <div>
                                        <a href="{{ route('warga.profile', $user->username ?? $user->id) }}" target="_blank" class="font-bold text-stone-900 block text-sm hover:text-forest transition-colors">
                                            {{ $user->name }}
                                        </a>
                                        <span class="text-sm text-stone-400 font-mono">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="{{ $user->role_badge['class'] }} text-xs font-bold px-2.5 py-2 rounded">
                                    {{ $user->role_badge['label'] }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4 text-stone-600 whitespace-nowrap text-sm">
                                @if($user->role_type === 'siswa')
                                    <span>NISN: {{ $user->nisn ?: '-' }}</span> &bull;
                                    <span class="text-stone-400">Kelas: {{ $user->kelas ?: '-' }}</span>
                                @elseif($user->role_type === 'guru')
                                    <span>NIP: {{ $user->nip ?: '-' }}</span> &bull;
                                    <span class="text-stone-400">Mapel: {{ $user->mata_pelajaran ?: '-' }}</span>
                                @elseif($user->role_type === 'alumni')
                                    <span>Lulus: {{ $user->tahun_lulus ?: '-' }}</span>
                                @else
                                    <span class="text-stone-400">Pengelola</span>
                                @endif
                            </td>

                            <td class="py-2.5 px-4 whitespace-nowrap">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-xs font-bold px-2.5 py-0.5 rounded-full" title="Akun aktif dan dapat menulis">
                                        <svg class="w-3.5 h-3.5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold px-2.5 py-0.5 rounded-full" title="Akun belum diaktifkan oleh admin">
                                        <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                        Perlu Aktivasi
                                    </span>
                                @endif
                            </td>

                            <td class="py-2.5 px-4 whitespace-nowrap text-xs">
                                <div class="flex items-center gap-2">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center gap-1 text-green-600 font-semibold" title="Terverifikasi pada {{ $user->email_verified_at->translatedFormat('d M Y H:i') }}">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Terverifikasi
                                        </span>
                                        @if($userData['can_edit'])
                                            <form action="{{ route('admin.users.verify-email', $user) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="Batalkan verifikasi email" class="text-stone-300 hover:text-amber-600 transition-colors p-1 rounded hover:bg-amber-50">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center gap-1 text-amber-600 font-medium" title="Email belum diverifikasi">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            Belum
                                        </span>
                                        @if($userData['can_edit'])
                                            <form action="{{ route('admin.users.verify-email', $user) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="Verifikasi email sekarang secara manual" class="inline-flex items-center gap-1 text-xs text-forest font-bold px-2 py-0.5 rounded border border-forest/30 bg-forest/5 hover:bg-forest hover:text-white transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    Verifikasi
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>

                            <td class="py-2.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5">

                                    <button type="button" onclick='openUserDetailModal(@json($userData))' title="Lihat Detail Warga" class="p-1.5 text-stone-500 hover:text-forest hover:bg-forest/10 border border-stone-200 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    @if($userData['can_edit'])
                                        <button type="button" onclick='openUserEditModal(@json($userData))' title="Edit Data & Peran Warga" class="p-1.5 text-stone-500 hover:text-amber-700 hover:bg-amber-50 border border-stone-200 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>

                                        <form action="{{ route('admin.users.activation', $user) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            @if($user->is_active)
                                                <button type="submit" title="Nonaktifkan Akun Warga" class="p-1.5 text-green-700 bg-green-50 hover:bg-amber-50 hover:text-amber-700 border border-green-200 hover:border-amber-300 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </button>
                                            @else
                                                <button type="submit" title="Aktifkan Akun Warga Sekarang" class="p-1.5 text-amber-700 bg-amber-50 hover:bg-forest hover:text-white border border-amber-300 hover:border-forest rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                </button>
                                            @endif
                                        </form>
                                    @endif

                                    @if($userData['can_delete'])
                                        <button type="button" onclick="window.confirmDelete('{{ route('admin.users.destroy', $user) }}', 'Yakin ingin menghapus akun warga {{ addslashes($user->name) }}? Semua karya suara warga dan komentarnya akan dihapus permanen.')" title="Hapus Akun Warga" class="p-1.5 text-stone-400 hover:text-red-600 hover:bg-red-50 border border-stone-200 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-stone-400 text-sm">
                                Tidak ada data warga yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-stone-100">
            {{ $users->links() }}
        </div>
    </div>

    <div id="detail_user_modal" class="fixed inset-0 z-[400] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 font-sans p-4">
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm" onclick="closeUserDetailModal()"></div>
        <div class="bg-white rounded-2xl p-5 max-w-lg w-full relative z-10 shadow-xl transform scale-95 transition-transform duration-300">

            <div class="flex items-start justify-between pb-3.5 border-b border-stone-100 mb-4">
                <div class="flex items-center gap-3">
                    <img id="detail_avatar" src="" alt="Avatar" class="w-12 h-12 rounded-full object-cover border-2 border-forest/30 flex-shrink-0">
                    <div>
                        <h3 id="detail_name" class="font-serif text-lg font-bold text-stone-900 leading-tight">Nama Warga</h3>
                        <p id="detail_email" class="text-sm text-stone-400 font-mono">email@sekolah.sch.id</p>
                    </div>
                </div>
                <button type="button" onclick="closeUserDetailModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-3.5 text-sm">

                <div class="flex flex-wrap gap-2">
                    <span id="detail_role_badge" class="px-2.5 py-0.5 rounded text-sm font-bold"></span>
                    <span id="detail_active_badge" class="px-2.5 py-0.5 rounded-full text-sm font-bold"></span>
                    <span id="detail_verified_badge" class="px-2.5 py-0.5 rounded-full text-sm font-bold"></span>
                </div>

                <div class="bg-stone-50 rounded-xl p-3.5 border border-stone-200/80 space-y-2.5">
                    <div class="grid grid-cols-2 gap-2 text-stone-600">
                        <div>
                            <span class="block text-xs text-stone-400 font-bold tracking-wider">Peran & Posisi</span>
                            <span id="detail_role_detail" class="font-medium text-stone-800 text-sm">-</span>
                        </div>
                        <div>
                            <span class="block text-xs text-stone-400 font-bold tracking-wider">Karya Ditulis</span>
                            <span id="detail_articles_count" class="font-semibold text-forest text-sm">0 Artikel</span>
                        </div>
                    </div>

                    <div id="detail_identity_section" class="pt-2 border-t border-stone-200/60 grid grid-cols-2 gap-2 text-stone-600">
                        <div>
                            <span id="detail_id_label_1" class="block text-xs text-stone-400 font-bold tracking-wider">NISN / NIP</span>
                            <span id="detail_id_val_1" class="font-mono text-stone-800 text-sm">-</span>
                        </div>
                        <div>
                            <span id="detail_id_label_2" class="block text-xs text-stone-400 font-bold tracking-wider">Kelas / Mapel</span>
                            <span id="detail_id_val_2" class="font-medium text-stone-800 text-sm">-</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-stone-200/60 grid grid-cols-2 gap-2 text-stone-600">
                        <div>
                            <span class="block text-xs text-stone-400 font-bold tracking-wider">Bergabung Sejak</span>
                            <span id="detail_created_at" class="font-medium text-stone-800 text-sm">-</span>
                        </div>
                        <div>
                            <span class="block text-xs text-stone-400 font-bold tracking-wider">Diaktifkan Pada</span>
                            <span id="detail_activated_at" class="font-medium text-stone-800 text-sm">-</span>
                        </div>
                    </div>

                    <div id="detail_bio_container" class="pt-2 border-t border-stone-200/60">
                        <span class="block text-xs text-stone-400 font-bold tracking-wider mb-0.5">Bio / Keterangan</span>
                        <p id="detail_bio" class="text-stone-700 italic text-sm">-</p>
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <a id="detail_profile_link" href="#" target="_blank" class="inline-flex items-center gap-1.5 text-forest font-bold text-sm hover:underline">
                        <span>Kunjungi Profil Publik Warga</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>

            <div class="mt-5 pt-3.5 border-t border-stone-100 flex items-center justify-between">
                <button type="button" onclick="closeUserDetailModal()" class="px-4 py-2 rounded-xl bg-stone-100 text-stone-600 text-sm font-semibold hover:bg-stone-200 transition-colors">
                    Tutup
                </button>
                <button type="button" id="btn_switch_to_edit" onclick="switchDetailToEdit()" class="px-4 py-2 rounded-xl bg-forest text-white text-sm font-bold hover:bg-stone-900 transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Data Warga
                </button>
            </div>
        </div>
    </div>

    <div id="edit_user_modal" class="fixed inset-0 z-[400] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 font-sans p-4">
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm" onclick="closeUserEditModal()"></div>
        <div class="bg-white rounded-2xl p-5 max-w-lg w-full relative z-10 shadow-xl transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between pb-3.5 border-b border-stone-100 mb-4">
                <div>
                    <h3 class="font-serif text-lg font-bold text-stone-900">Edit Data</h3>
                </div>
                <button type="button" onclick="closeUserEditModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="edit_user_form" action="" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1">
                        Nama Lengkap <span class="text-terracotta">*</span>
                    </label>
                    <input type="text" id="edit_name" name="name" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1">
                        Alamat Email <span class="text-terracotta">*</span>
                    </label>
                    <input type="email" id="edit_email" name="email" required class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1">
                        Peran Warga Sekolah <span class="text-terracotta">*</span>
                    </label>
                    <select id="edit_role_type" name="role_type" onchange="handleRoleChange(this.value)" class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest outline-none font-medium bg-stone-50 focus:bg-white">
                        <option value="siswa">Siswa Aktif</option>
                        <option value="guru">Guru / Tenaga Pendidik</option>
                        <option value="alumni">Alumni SMAN 1 Malingping</option>
                        <option value="admin">Administrator</option>
                        @if(auth()->user()->isSuperAdmin())
                            <option value="super_admin">Super Admin</option>
                        @endif
                    </select>
                </div>

                <div id="fields_siswa" class="grid grid-cols-2 gap-3 p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                    <div>
                        <label class="block text-xs font-bold text-stone-600 tracking-wider mb-1">NISN</label>
                        <input type="text" id="edit_nisn" name="nisn" placeholder="0012345678" class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-sm bg-white outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-600 tracking-wider mb-1">Kelas</label>
                        <input type="text" id="edit_kelas" name="kelas" placeholder="XII MIPA 1" class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-sm bg-white outline-none">
                    </div>
                </div>

                <div id="fields_guru" class="grid grid-cols-2 gap-3 p-3 bg-stone-50 rounded-xl border border-stone-200/80 hidden">
                    <div>
                        <label class="block text-xs font-bold text-stone-600 tracking-wider mb-1">NIP (Opsional)</label>
                        <input type="text" id="edit_nip" name="nip" placeholder="198001..." class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-sm bg-white outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-600 tracking-wider mb-1">Mata Pelajaran</label>
                        <input type="text" id="edit_mata_pelajaran" name="mata_pelajaran" placeholder="Matematika / Fisika..." class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-sm bg-white outline-none">
                    </div>
                </div>

                <div id="fields_alumni" class="grid grid-cols-2 gap-3 p-3 bg-stone-50 rounded-xl border border-stone-200/80 hidden">
                    <div>
                        <label class="block text-xs font-bold text-stone-600 tracking-wider mb-1">Tahun Lulus</label>
                        <input type="text" id="edit_tahun_lulus" name="tahun_lulus" placeholder="2023" class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-sm bg-white outline-none font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-stone-600 tracking-wider mb-1">Pekerjaan / Kampus</label>
                        <input type="text" id="edit_pekerjaan_kampus" name="pekerjaan_kampus" placeholder="Universitas Indonesia..." class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-sm bg-white outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1">Bio / Keterangan (Opsional)</label>
                    <textarea id="edit_bio" name="bio" rows="2" placeholder="Keterangan singkat warga..." class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest outline-none resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1">
                        Password Baru <span class="text-stone-400 font-normal lowercase">(kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" id="edit_password" name="password" placeholder="Minimal 6 karakter..." class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest outline-none">
                </div>

                <div class="pt-2 border-t border-stone-100 space-y-2.5">
                    <label class="flex items-center gap-3 p-2.5 rounded-xl border border-stone-200 hover:border-stone-300 cursor-pointer transition-colors bg-stone-50/50">
                        <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="w-4 h-4 text-forest rounded border-stone-300 focus:ring-forest">
                        <div>
                            <span class="block text-sm font-bold text-stone-800">Akun Aktif</span>
                            <span class="block text-xs text-stone-400">Izinkan pengguna login dan mempublikasikan karya suara warga</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-2.5 rounded-xl border border-stone-200 hover:border-stone-300 cursor-pointer transition-colors bg-stone-50/50">
                        <input type="checkbox" id="edit_is_verified" name="is_verified" value="1" class="w-4 h-4 text-forest rounded border-stone-300 focus:ring-forest">
                        <div>
                            <span class="block text-sm font-bold text-stone-800">Email Terverifikasi</span>
                            <span class="block text-xs text-stone-400">Tandai bahwa email akun ini sudah valid dan diverifikasi</span>
                        </div>
                    </label>
                </div>

                <div class="mt-5 pt-3.5 border-t border-stone-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeUserEditModal()" class="px-4 py-2 rounded-xl bg-stone-100 text-stone-600 text-sm font-semibold hover:bg-stone-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-forest text-white text-sm font-bold hover:bg-stone-900 transition-colors shadow-xs flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentUserData = null;

        function openUserDetailModal(user) {
            currentUserData = user;
            const modal = document.getElementById('detail_user_modal');
            const card = modal.querySelector('div.bg-white');

            document.getElementById('detail_avatar').src = user.avatar_url;
            document.getElementById('detail_name').innerText = user.name;
            document.getElementById('detail_email').innerText = user.email;

            const roleBadge = document.getElementById('detail_role_badge');
            roleBadge.className = user.role_class + ' px-2.5 py-0.5 rounded text-sm font-bold';
            roleBadge.innerText = user.role_label;

            const activeBadge = document.getElementById('detail_active_badge');
            if (user.is_active) {
                activeBadge.className = 'px-2.5 py-0.5 rounded-full text-sm font-bold bg-green-50 text-green-700 border border-green-200';
                activeBadge.innerText = 'Akun Aktif';
            } else {
                activeBadge.className = 'px-2.5 py-0.5 rounded-full text-sm font-bold bg-amber-50 text-amber-700 border border-amber-200';
                activeBadge.innerText = 'Perlu Aktivasi';
            }

            const verifiedBadge = document.getElementById('detail_verified_badge');
            if (user.email_verified) {
                verifiedBadge.className = 'px-2.5 py-0.5 rounded-full text-sm font-bold bg-green-50 text-green-700 border border-green-200';
                verifiedBadge.innerText = 'Email Terverifikasi';
            } else {
                verifiedBadge.className = 'px-2.5 py-0.5 rounded-full text-sm font-bold bg-amber-50 text-amber-700 border border-amber-200';
                verifiedBadge.innerText = 'Email Belum Diverifikasi';
            }

            document.getElementById('detail_role_detail').innerText = user.role_detail || '-';
            document.getElementById('detail_articles_count').innerText = user.articles_count + ' Artikel';
            document.getElementById('detail_created_at').innerText = user.created_at;
            document.getElementById('detail_activated_at').innerText = user.activated_at;

            const idSection = document.getElementById('detail_identity_section');
            if (user.role_type === 'siswa') {
                idSection.classList.remove('hidden');
                document.getElementById('detail_id_label_1').innerText = 'NISN';
                document.getElementById('detail_id_val_1').innerText = user.nisn || '-';
                document.getElementById('detail_id_label_2').innerText = 'Kelas';
                document.getElementById('detail_id_val_2').innerText = user.kelas || '-';
            } else if (user.role_type === 'guru') {
                idSection.classList.remove('hidden');
                document.getElementById('detail_id_label_1').innerText = 'NIP';
                document.getElementById('detail_id_val_1').innerText = user.nip || '-';
                document.getElementById('detail_id_label_2').innerText = 'Mata Pelajaran';
                document.getElementById('detail_id_val_2').innerText = user.mata_pelajaran || '-';
            } else if (user.role_type === 'alumni') {
                idSection.classList.remove('hidden');
                document.getElementById('detail_id_label_1').innerText = 'Tahun Lulus';
                document.getElementById('detail_id_val_1').innerText = user.tahun_lulus || '-';
                document.getElementById('detail_id_label_2').innerText = 'Pekerjaan / Kampus';
                document.getElementById('detail_id_val_2').innerText = user.pekerjaan_kampus || '-';
            } else {
                idSection.classList.add('hidden');
            }

            const bioContainer = document.getElementById('detail_bio_container');
            if (user.bio && user.bio.trim().length > 0) {
                bioContainer.classList.remove('hidden');
                document.getElementById('detail_bio').innerText = user.bio;
            } else {
                bioContainer.classList.add('hidden');
            }

            document.getElementById('detail_profile_link').href = user.profile_url;

            const btnSwitchEdit = document.getElementById('btn_switch_to_edit');
            if (btnSwitchEdit) {
                if (user.can_edit) {
                    btnSwitchEdit.classList.remove('hidden');
                } else {
                    btnSwitchEdit.classList.add('hidden');
                }
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeUserDetailModal() {
            const modal = document.getElementById('detail_user_modal');
            const card = modal.querySelector('div.bg-white');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }

        function switchDetailToEdit() {
            if (currentUserData) {
                closeUserDetailModal();
                setTimeout(() => {
                    openUserEditModal(currentUserData);
                }, 150);
            }
        }

        function openUserEditModal(user) {
            currentUserData = user;
            const modal = document.getElementById('edit_user_modal');
            const card = modal.querySelector('div.bg-white');
            const form = document.getElementById('edit_user_form');

            form.action = user.update_url;
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_role_type').value = user.role_type || 'siswa';
            document.getElementById('edit_nisn').value = user.nisn || '';
            document.getElementById('edit_kelas').value = user.kelas || '';
            document.getElementById('edit_nip').value = user.nip || '';
            document.getElementById('edit_mata_pelajaran').value = user.mata_pelajaran || '';
            document.getElementById('edit_tahun_lulus').value = user.tahun_lulus || '';
            document.getElementById('edit_pekerjaan_kampus').value = user.pekerjaan_kampus || '';
            document.getElementById('edit_bio').value = user.bio || '';
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_is_active').checked = !!user.is_active;
            document.getElementById('edit_is_verified').checked = !!user.email_verified;

            handleRoleChange(user.role_type);

            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeUserEditModal() {
            const modal = document.getElementById('edit_user_modal');
            const card = modal.querySelector('div.bg-white');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }

        function handleRoleChange(role) {
            const siswaSection = document.getElementById('fields_siswa');
            const guruSection = document.getElementById('fields_guru');
            const alumniSection = document.getElementById('fields_alumni');

            siswaSection.classList.add('hidden');
            guruSection.classList.add('hidden');
            alumniSection.classList.add('hidden');

            if (role === 'siswa') {
                siswaSection.classList.remove('hidden');
            } else if (role === 'guru') {
                guruSection.classList.remove('hidden');
            } else if (role === 'alumni') {
                alumniSection.classList.remove('hidden');
            }
        }
    </script>
    @endpush

</x-layouts.admin>
