<x-layouts.admin title="Testimoni Alumni - Dasbor Pengelola" headerTitle="Testimoni Alumni">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3.5 mb-5">
        <div>
            <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Testimoni Alumni</h1>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5 font-sans">
        <div class="bg-white p-3.5 rounded-xl border border-stone-200 shadow-2xs">
            <span class="text-xs text-stone-400 font-medium block">Total Testimoni</span>
            <div class="text-xl font-bold text-stone-900 mt-0.5">{{ number_format($totalCount) }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-emerald-200/80 shadow-2xs bg-emerald-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs text-emerald-700 font-bold block">Ditayangkan</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-xl font-bold text-emerald-900 mt-0.5">{{ number_format($approvedCount) }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-amber-200/80 shadow-2xs bg-amber-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs text-amber-700 font-bold block">Menunggu Kurasi</span>
                @if($pendingCount > 0)
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                @endif
            </div>
            <div class="text-xl font-bold text-amber-900 mt-0.5">{{ number_format($pendingCount) }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-rose-200/80 shadow-2xs bg-rose-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs text-rose-700 font-bold block">Perlu Revisi</span>
                @if($rejectedCount > 0)
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                @endif
            </div>
            <div class="text-xl font-bold text-rose-900 mt-0.5">{{ number_format($rejectedCount) }}</div>
        </div>
    </div>

    <div class="bg-white p-2.5 sm:p-3 rounded-xl border border-stone-200 shadow-2xs mb-4 flex flex-col md:flex-row gap-2.5 items-center justify-between font-sans">

        <div class="flex flex-wrap gap-1.5 text-xs xs:text-xs font-semibold w-full md:w-auto">
            <a href="{{ route('admin.testimonials.index', array_filter(['q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ empty($status) ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.testimonials.index', array_filter(['status' => 'approved', 'q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'approved') ? 'bg-emerald-600 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Ditayangkan ({{ $approvedCount }})
            </a>
            <a href="{{ route('admin.testimonials.index', array_filter(['status' => 'pending', 'q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'pending') ? 'bg-amber-500 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Menunggu ({{ $pendingCount }})
            </a>
            <a href="{{ route('admin.testimonials.index', array_filter(['status' => 'rejected', 'q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'rejected') ? 'bg-rose-600 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Perlu Revisi ({{ $rejectedCount }})
            </a>
        </div>

        <form action="{{ route('admin.testimonials.index') }}" method="GET" class="w-full md:w-72">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, peran, isi, catatan..." class="w-full pl-9 pr-3.5 py-2 rounded-lg border border-stone-200 text-sm sm:text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 focus:bg-white transition-colors">
                <svg class="w-4 h-4 text-stone-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                @if($search)
                    <a href="{{ route('admin.testimonials.index', array_filter(['status' => $status])) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600" title="Hapus pencarian">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden font-sans" x-data="{ allOpenTestimonials: false }">

        <div class="md:hidden px-4 py-2.5 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-xs">
            <span class="font-medium text-stone-500">
                Total: <strong class="text-stone-900">{{ $testimonials->total() }} Testimoni</strong>
            </span>
            @if($testimonials->isNotEmpty())
                <button type="button" @click="allOpenTestimonials = !allOpenTestimonials; $dispatch('toggle-admin-testimonials', { open: allOpenTestimonials })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                    <span x-text="allOpenTestimonials ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenTestimonials ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            @endif
        </div>

        <div class="md:hidden divide-y divide-stone-200">
            @forelse($testimonials as $testi)
                <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors {{ $testi->status === 'rejected' ? 'bg-rose-50/15' : (!$testi->is_approved ? 'bg-amber-50/15' : '') }}" x-data="{ isOpen: false }" @toggle-admin-testimonials.window="isOpen = $event.detail.open">

                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                        <div class="flex items-start gap-3 min-w-0 flex-1">
                            <img src="{{ $testi->avatar_url }}" alt="{{ $testi->name }}" class="w-9 h-9 rounded-full object-cover border border-stone-200 flex-shrink-0 mt-0.5 shadow-2xs">

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                    @if($testi->is_approved || $testi->status === 'approved')
                                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-200 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Ditayangkan
                                        </span>
                                    @elseif($testi->status === 'rejected' || !empty($testi->rejection_reason))
                                        <span class="bg-rose-50 text-rose-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-rose-200 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            Perlu Revisi
                                        </span>
                                    @else
                                        <span class="bg-amber-50 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-full border border-amber-200 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Menunggu Kurasi
                                        </span>
                                    @endif
                                </div>

                                <h4 class="font-bold text-sm text-stone-900 leading-snug truncate">
                                    {{ $testi->name }}
                                </h4>
                                <p class="text-sm text-stone-500 truncate">
                                    {{ $testi->role_subtitle }}
                                </p>
                                <p class="text-sm text-stone-600 line-clamp-1 italic mt-1 font-serif">
                                    "{{ $testi->content }}"
                                </p>
                            </div>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-1" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">

                        <div class="bg-stone-50 p-3 rounded-xl border border-stone-200/70 text-stone-700 italic font-serif leading-relaxed">
                            "{{ $testi->content }}"
                        </div>

                        @if($testi->rejection_reason)
                            <div class="bg-rose-50 p-3 rounded-xl border border-rose-200 text-rose-800 text-xs">
                                <div class="flex items-center gap-1.5 font-bold text-rose-900 mb-1">
                                    <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>Catatan untuk Revisi:</span>
                                </div>
                                <p class="leading-relaxed pl-5">{{ $testi->rejection_reason }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-2 text-[11px] bg-stone-50 p-2.5 rounded-xl border border-stone-100">
                            <div>
                                <span class="text-stone-400 block font-medium">Akun Pengirim:</span>
                                @if($testi->user)
                                    <span class="font-semibold text-stone-800 block truncate">{{ $testi->user->name }}</span>
                                    <span class="text-stone-400 text-[10px] block truncate">{{ $testi->user->email }}</span>
                                @else
                                    <span class="text-stone-500 italic">Alumni Terverifikasi</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-stone-400 block font-medium">Tanggal Diajukan:</span>
                                <span class="font-semibold text-stone-800">{{ $testi->created_at->format('d M Y, H:i') }}</span>
                                <span class="text-stone-400 text-[10px] block">({{ $testi->created_at->diffForHumans() }})</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center justify-end gap-2 pt-1 border-t border-stone-100">

                            <button type="button"
                                onclick="openViewTestimonialModalFromEl(this)"
                                data-name="{{ $testi->name }}"
                                data-role="{{ $testi->role_subtitle }}"
                                data-avatar="{{ $testi->avatar_url }}"
                                data-content="{{ $testi->content }}"
                                data-rejection="{{ $testi->rejection_reason ?? '' }}"
                                data-status-label="{{ ($testi->is_approved || $testi->status === 'approved') ? 'Ditayangkan' : (($testi->status === 'rejected' || !empty($testi->rejection_reason)) ? 'Perlu Revisi' : 'Menunggu Kurasi') }}"
                                data-status-class="{{ ($testi->is_approved || $testi->status === 'approved') ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : (($testi->status === 'rejected' || !empty($testi->rejection_reason)) ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-amber-50 text-amber-800 border border-amber-200') }}"
                                data-user-email="{{ $testi->user ? $testi->user->email : 'Alumni Terverifikasi' }}"
                                data-date="{{ $testi->created_at->translatedFormat('d M Y, H:i') }}"
                                class="py-1.5 px-3 rounded-lg border border-stone-200 text-stone-700 bg-white hover:bg-stone-50 font-bold text-center inline-flex items-center gap-1.5 transition-colors shadow-2xs cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>Lihat Isi</span>
                            </button>

                            <form action="{{ route('admin.testimonials.toggle-approval', $testi->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                @if(!$testi->is_approved)
                                    <button type="submit" class="py-1.5 px-3 rounded-lg bg-emerald-600 text-white font-bold text-center inline-flex items-center gap-1.5 hover:bg-emerald-700 transition-colors shadow-2xs cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>Setujui & Tayangkan</span>
                                    </button>
                                @else
                                    <button type="submit" class="py-1.5 px-3 rounded-lg border border-amber-300 text-amber-800 bg-amber-50 hover:bg-amber-100 font-bold text-center inline-flex items-center gap-1.5 transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                        <span>Tarik dari Beranda</span>
                                    </button>
                                @endif
                            </form>

                            <button type="button" onclick="openRejectTestimonialModal('{{ route('admin.testimonials.reject', $testi->id) }}', '{{ addslashes($testi->name) }}', '{{ addslashes($testi->rejection_reason ?? '') }}')" class="py-1.5 px-3 rounded-lg border border-amber-300 text-amber-800 bg-amber-50 hover:bg-amber-100 font-bold text-center inline-flex items-center gap-1.5 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>{{ $testi->status === 'rejected' ? 'Ubah Catatan' : 'Tolak & Catatan' }}</span>
                            </button>

                            <button type="button" onclick="window.confirmDelete('{{ route('admin.testimonials.destroy', $testi->id) }}', 'Yakin ingin menghapus testimoni dari {{ addslashes($testi->name) }}?')" class="py-1.5 px-3 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center gap-1.5 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center text-stone-400 text-sm">
                    <svg class="w-10 h-10 text-stone-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <p class="font-semibold text-stone-600">Tidak ada testimoni yang ditemukan.</p>
                    <p class="text-sm text-stone-400 mt-0.5">Gunakan filter atau kata kunci pencarian yang lain.</p>
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left font-sans text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                    <tr>
                        <th class="py-3 px-4">Alumni</th>
                        <th class="py-3 px-4">Status Tayang</th>
                        <th class="py-3 px-4">Tanggal Pengajuan</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($testimonials as $testi)
                        <tr class="hover:bg-stone-50/70 transition-colors {{ $testi->status === 'rejected' ? 'bg-rose-50/15' : (!$testi->is_approved ? 'bg-amber-50/15' : '') }}">

                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $testi->avatar_url }}" alt="{{ $testi->name }}" class="w-9 h-9 rounded-full object-cover border border-stone-200 flex-shrink-0 shadow-2xs">
                                    <div class="min-w-0">
                                        <span class="font-bold text-stone-900 block leading-snug">{{ $testi->name }}</span>
                                        <span class="text-sm text-stone-500 block truncate max-w-[180px]">{{ $testi->role_subtitle }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3 px-4 whitespace-nowrap">
                                @if($testi->is_approved || $testi->status === 'approved')
                                    <span class="inline-flex items-center gap-1 text-sm font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Ditayangkan
                                    </span>
                                @elseif($testi->status === 'rejected' || !empty($testi->rejection_reason))
                                    <span class="inline-flex items-center gap-1 text-sm font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-200" title="{{ $testi->rejection_reason }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        Perlu Revisi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-sm font-bold text-amber-800 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Menunggu Kurasi
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 whitespace-nowrap text-xs">
                                <span class="font-semibold text-stone-800 block">{{ $testi->created_at->format('d M Y') }}</span>
                                <span class="text-stone-400 text-[11px] block">{{ $testi->created_at->format('H:i') }} ({{ $testi->created_at->diffForHumans() }})</span>
                            </td>

                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">

                                    <button type="button"
                                        onclick="openViewTestimonialModalFromEl(this)"
                                        data-name="{{ $testi->name }}"
                                        data-role="{{ $testi->role_subtitle }}"
                                        data-avatar="{{ $testi->avatar_url }}"
                                        data-content="{{ $testi->content }}"
                                        data-rejection="{{ $testi->rejection_reason ?? '' }}"
                                        data-status-label="{{ ($testi->is_approved || $testi->status === 'approved') ? 'Ditayangkan' : (($testi->status === 'rejected' || !empty($testi->rejection_reason)) ? 'Perlu Revisi' : 'Menunggu Kurasi') }}"
                                        data-status-class="{{ ($testi->is_approved || $testi->status === 'approved') ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : (($testi->status === 'rejected' || !empty($testi->rejection_reason)) ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-amber-50 text-amber-800 border border-amber-200') }}"
                                        data-user-email="{{ $testi->user ? $testi->user->email : 'Alumni Terverifikasi' }}"
                                        data-date="{{ $testi->created_at->translatedFormat('d M Y, H:i') }}"
                                        title="Lihat Isi Testimoni"
                                        class="p-1.5 text-stone-600 hover:text-white hover:bg-forest border border-stone-200 bg-white rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer shadow-2xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="sr-only">Lihat Isi</span>
                                    </button>

                                    <form action="{{ route('admin.testimonials.toggle-approval', $testi->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        @if(!$testi->is_approved)
                                            <button type="submit" title="Setujui & Tayangkan di Beranda" class="p-1.5 text-emerald-700 hover:text-white hover:bg-emerald-600 border border-emerald-200 bg-emerald-50/50 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer shadow-2xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <span class="sr-only">Setujui</span>
                                            </button>
                                        @else
                                            <button type="submit" title="Tarik dari Beranda (Ubah ke Menunggu)" class="p-1.5 text-amber-700 hover:text-white hover:bg-amber-600 border border-amber-200 bg-amber-50/50 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer shadow-2xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                                <span class="sr-only">Tarik dari Beranda</span>
                                            </button>
                                        @endif
                                    </form>

                                    <button type="button" onclick="openRejectTestimonialModal('{{ route('admin.testimonials.reject', $testi->id) }}', '{{ addslashes($testi->name) }}', '{{ addslashes($testi->rejection_reason ?? '') }}')" title="{{ $testi->status === 'rejected' ? 'Perbarui Catatan Revisi' : 'Tolak & Berikan Catatan Revisi' }}" class="p-1.5 text-amber-700 hover:text-white hover:bg-amber-600 border border-amber-300 bg-amber-50/50 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer shadow-2xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span class="sr-only">Tolak & Revisi</span>
                                    </button>

                                    <button type="button" onclick="window.confirmDelete('{{ route('admin.testimonials.destroy', $testi->id) }}', 'Yakin ingin menghapus testimoni dari {{ addslashes($testi->name) }}?')" title="Hapus Testimoni" class="p-1.5 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 bg-rose-50/50 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer shadow-2xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-stone-400 text-sm">
                                <svg class="w-10 h-10 text-stone-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                <p class="font-semibold text-stone-600">Tidak ada testimoni yang ditemukan.</p>
                                <p class="text-sm text-stone-400 mt-0.5">Gunakan filter atau kata kunci pencarian yang lain.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-stone-100 bg-stone-50/50">
            {{ $testimonials->links() }}
        </div>
    </div>

    <div id="view-testimonial-modal" class="fixed inset-0 z-[300] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 font-sans p-4">
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm" onclick="closeViewTestimonialModal()"></div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 max-w-lg w-full relative z-10 shadow-2xl transform scale-95 transition-transform duration-300 border border-stone-200 max-h-[90vh] overflow-y-auto">
            <div class="flex items-start justify-between gap-3 mb-4 pb-3 border-b border-stone-100">
                <div class="flex items-center gap-3">
                    <img id="view-testi-avatar" src="" alt="" class="w-11 h-11 rounded-full object-cover border border-stone-200 shadow-2xs">
                    <div>
                        <h4 id="view-testi-name" class="font-bold text-base text-stone-900 leading-snug"></h4>
                        <p id="view-testi-role" class="text-xs text-stone-500"></p>
                    </div>
                </div>
                <button type="button" onclick="closeViewTestimonialModal()" class="text-stone-400 hover:text-stone-700 p-1.5 rounded-lg hover:bg-stone-100 transition-colors cursor-pointer" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex items-center justify-between mb-4 text-xs font-sans">
                <span id="view-testi-status" class="inline-flex items-center gap-1 font-bold px-2.5 py-0.5 rounded-full"></span>
                <span id="view-testi-date" class="text-stone-400"></span>
            </div>

            <div class="mb-4">
                <label class="block text-[11px] font-bold text-stone-400 tracking-wider mb-1.5 font-sans">Isi Testimoni</label>
                <div class="bg-stone-50 p-4 rounded-xl border border-stone-200/80 text-stone-800 italic font-serif leading-relaxed text-sm sm:text-base">
                    "<span id="view-testi-content"></span>"
                </div>
            </div>

            <div id="view-testi-rejection-box" class="hidden mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 font-sans">
                <div class="flex items-center gap-1.5 font-bold text-rose-900 mb-1">
                    <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Catatan Revisi / Redaksi:</span>
                </div>
                <p id="view-testi-rejection" class="leading-relaxed pl-5"></p>
            </div>

            <div class="mb-4 text-xs bg-stone-50 p-2.5 rounded-xl border border-stone-100 flex items-center justify-between font-sans">
                <span class="text-stone-400 font-medium">Akun Pengirim:</span>
                <span id="view-testi-email" class="font-mono text-stone-700"></span>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-stone-100 font-sans">
                <button type="button" onclick="closeViewTestimonialModal()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 text-xs sm:text-sm font-semibold transition-colors cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="reject-testimonial-modal" class="fixed inset-0 z-[300] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 font-sans">
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm" onclick="closeRejectTestimonialModal()"></div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 max-w-md w-[92%] relative z-10 shadow-xl transform scale-95 transition-transform duration-300 border border-stone-200">
            <div class="flex items-start gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h4 class="font-serif text-lg text-stone-900 font-bold leading-snug">Tolak & Beri Catatan Revisi</h4>
                    <p id="reject-testimonial-alumni" class="text-sm text-stone-500 line-clamp-1 mt-0.5"></p>
                </div>
            </div>

            <form id="reject-testimonial-form" action="" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Catatan Revisi untuk Alumni <span class="text-terracotta">*</span>
                    </label>
                    <textarea id="reject-testimonial-reason" name="rejection_reason" rows="4" placeholder="Tuliskan catatan revisi secara santun (contoh: mohon perbaiki keterangan tahun lulus/kampus, atau gunakan kalimat yang lebih jelas)..." required class="w-full text-sm sm:text-sm p-3 rounded-xl border border-stone-200 focus:border-terracotta focus:ring-1 focus:ring-terracotta font-sans leading-relaxed"></textarea>
                    <span class="text-[11px] text-stone-400 block mt-1">Catatan ini akan tampil di dasbor alumni dan mereka dapat memperbarui testimoni sebelum diajukan kembali.</span>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" onclick="closeRejectTestimonialModal()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 text-sm sm:text-sm font-semibold transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-sm sm:text-sm font-bold px-4 py-2 rounded-xl transition-colors shadow-xs cursor-pointer">
                        Simpan & Kirim Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openViewTestimonialModalFromEl(btn) {
            const data = btn.dataset;
            const modal = document.getElementById('view-testimonial-modal');
            const card = modal.querySelector('div.bg-white');

            document.getElementById('view-testi-avatar').src = data.avatar;
            document.getElementById('view-testi-avatar').alt = data.name;
            document.getElementById('view-testi-name').innerText = data.name;
            document.getElementById('view-testi-role').innerText = data.role;
            document.getElementById('view-testi-content').innerText = data.content;
            document.getElementById('view-testi-date').innerText = data.date;
            document.getElementById('view-testi-email').innerText = data.userEmail || 'Alumni Terverifikasi';

            const statusEl = document.getElementById('view-testi-status');
            statusEl.className = 'inline-flex items-center gap-1 font-bold px-2.5 py-0.5 rounded-full text-xs ' + data.statusClass;
            statusEl.innerText = data.statusLabel;

            const rejectBox = document.getElementById('view-testi-rejection-box');
            if (data.rejection) {
                rejectBox.classList.remove('hidden');
                document.getElementById('view-testi-rejection').innerText = data.rejection;
            } else {
                rejectBox.classList.add('hidden');
                document.getElementById('view-testi-rejection').innerText = '';
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeViewTestimonialModal() {
            const modal = document.getElementById('view-testimonial-modal');
            const card = modal.querySelector('div.bg-white');

            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }

        function openRejectTestimonialModal(actionUrl, alumniName, existingReason = '') {
            const modal = document.getElementById('reject-testimonial-modal');
            const form = document.getElementById('reject-testimonial-form');
            const alumniEl = document.getElementById('reject-testimonial-alumni');
            const reasonInput = document.getElementById('reject-testimonial-reason');
            const card = modal.querySelector('div.bg-white');

            form.action = actionUrl;
            alumniEl.innerText = 'Alumni: ' + alumniName;
            reasonInput.value = existingReason || '';

            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
            setTimeout(() => reasonInput.focus(), 150);
        }

        function closeRejectTestimonialModal() {
            const modal = document.getElementById('reject-testimonial-modal');
            const card = modal.querySelector('div.bg-white');

            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }
    </script>
    @endpush

</x-layouts.admin>
