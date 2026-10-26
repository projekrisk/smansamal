<x-layouts.admin title="Manajemen Pengumuman - Dasbor Pengelola" headerTitle="Pengumuman">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3.5 mb-5 font-sans">
        <div>
            <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Pengumuman</h1>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center gap-2 bg-forest text-white px-4 py-2.5 rounded-xl text-sm sm:text-sm font-bold hover:bg-stone-900 transition-colors shadow-2xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Pengumuman Baru</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5 font-sans">
        <div class="bg-white p-3.5 rounded-xl border border-stone-200 shadow-2xs">
            <span class="text-xs text-stone-400 font-medium block">Total Pengumuman</span>
            <div class="text-xl font-bold text-stone-900 mt-0.5">{{ number_format($totalCount) }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-emerald-200/80 shadow-2xs bg-emerald-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs text-emerald-700 font-bold block">Pengumuman Aktif (Tayang)</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-xl font-bold text-emerald-900 mt-0.5">{{ number_format($activeCount) }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-amber-200/80 shadow-2xs bg-amber-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs text-amber-700 font-bold block">Nonaktif / Kadaluarsa</span>
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <div class="text-xl font-bold text-amber-900 mt-0.5">{{ number_format($inactiveCount) }}</div>
        </div>
    </div>

    <div class="bg-white p-2.5 sm:p-3 rounded-xl border border-stone-200 shadow-2xs mb-4 flex flex-col md:flex-row gap-2.5 items-center justify-between font-sans">
        <div class="flex flex-wrap gap-1.5 text-xs xs:text-xs font-semibold w-full md:w-auto">
            <a href="{{ route('admin.announcements.index', array_filter(['q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ empty($status) ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.announcements.index', array_filter(['status' => 'active', 'q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'active') ? 'bg-emerald-600 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Aktif ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.announcements.index', array_filter(['status' => 'inactive', 'q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'inactive') ? 'bg-amber-500 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Nonaktif ({{ $inactiveCount }})
            </a>
        </div>

        <form action="{{ route('admin.announcements.index') }}" method="GET" class="w-full md:w-72">
            @if(!empty($status))
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul atau isi..." class="w-full pl-9 pr-3 py-1.5 text-sm sm:text-sm bg-stone-50 border border-stone-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-forest focus:bg-white transition-all">
                <svg class="w-4 h-4 text-stone-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 shadow-2xs overflow-hidden font-sans" x-data="{ allOpen: false }">

        <div class="md:hidden px-4 py-2.5 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-sm">
            <span class="font-medium text-stone-500">
                Total: <strong class="text-stone-900">{{ $announcements->total() }} Pengumuman</strong>
            </span>
            @if($announcements->isNotEmpty())
                <button type="button" @click="allOpen = !allOpen; $dispatch('toggle-all-announcement-cards', { open: allOpen })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                    <span x-text="allOpen ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            @endif
        </div>

        <div class="md:hidden divide-y divide-stone-200">
            @forelse($announcements as $announcement)
                <div class="p-4 bg-white hover:bg-stone-50/70 transition-colors" x-data="{ isOpen: false }" @toggle-all-announcement-cards.window="isOpen = $event.detail.open">
                    
                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-3 focus:outline-none cursor-pointer">
                        <div class="flex items-start gap-3 min-w-0 flex-1">
                            @if($announcement->image_url)
                                <img src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}" class="w-12 h-12 rounded-xl object-cover border border-stone-200 flex-shrink-0 mt-0.5 shadow-2xs">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-stone-100 border border-stone-200 text-stone-400 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full border {{ $announcement->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-stone-100 text-stone-600 border-stone-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $announcement->is_active ? 'bg-emerald-500' : 'bg-stone-400' }}"></span>
                                        {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                    <span class="inline-flex items-center text-[10px] font-semibold px-2 py-0.5 rounded-full border {{ $announcement->type === 'floating' ? 'bg-purple-50 text-purple-700 border-purple-200' : ($announcement->type === 'both' ? 'bg-teal-50 text-teal-700 border-teal-200' : 'bg-blue-50 text-blue-700 border-blue-200') }}">
                                        {{ $announcement->type_label }}
                                    </span>
                                    <span class="text-[11px] text-stone-400">&bull; {{ number_format($announcement->views_count) }} views</span>
                                </div>

                                <h4 class="font-bold text-sm text-stone-900 leading-snug line-clamp-2">
                                    {{ $announcement->title }}
                                </h4>

                                @if($announcement->content)
                                    <p class="text-sm text-stone-500 line-clamp-1 mt-1" x-show="!isOpen">
                                        {{ strip_tags($announcement->content) }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-1" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" style="display: none;" class="mt-3 pt-3 border-t border-stone-100 space-y-3 text-sm">
                        
                        @if($announcement->content)
                            <div class="bg-stone-50 p-3 rounded-xl border border-stone-200 text-stone-700 text-sm leading-relaxed whitespace-pre-line">
                                <span class="text-[10px] font-bold tracking-wider text-stone-400 block mb-1">Isi Pesan Pengumuman:</span>
                                {{ $announcement->content }}
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-2 bg-stone-50 p-2.5 rounded-xl border border-stone-200 text-[11px]">
                            <div>
                                <span class="text-stone-400 block mb-0.5">Tombol Link Aksi</span>
                                @if($announcement->button_url && $announcement->button_text)
                                    <a href="{{ $announcement->button_url }}" target="_blank" class="font-bold text-forest hover:underline inline-flex items-center gap-1">
                                        <span>{{ $announcement->button_text }}</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @else
                                    <span class="text-stone-400">Tidak ada tautan</span>
                                @endif
                            </div>

                            <div>
                                <span class="text-stone-400 block mb-0.5">Jadwal Penayangan</span>
                                @if($announcement->start_at || $announcement->end_at)
                                    <span class="font-semibold text-stone-700 block">{{ $announcement->start_at ? $announcement->start_at->translatedFormat('d M Y') : 'Sekarang' }}</span>
                                    <span class="text-stone-500">s/d {{ $announcement->end_at ? $announcement->end_at->translatedFormat('d M Y') : 'Seterusnya' }}</span>
                                @else
                                    <span class="text-stone-600 font-medium">Selalu Aktif</span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2 pt-1">
                            <form action="{{ route('admin.announcements.toggle-status', $announcement) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full py-2 px-2 rounded-xl text-center font-bold text-sm border transition-colors cursor-pointer {{ $announcement->is_active ? 'bg-amber-50 text-amber-800 border-amber-200 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-800 border-emerald-200 hover:bg-emerald-100' }}">
                                    {{ $announcement->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="py-2 px-2 rounded-xl bg-forest text-white font-bold text-center inline-flex items-center justify-center gap-1 hover:bg-stone-900 transition-colors shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Edit</span>
                            </a>

                            <button
                                type="button"
                                onclick="window.confirmDelete('{{ route('admin.announcements.destroy', $announcement) }}', 'Yakin ingin menghapus pengumuman \'{{ addslashes($announcement->title) }}\'? Pengumuman ini tidak akan lagi ditampilkan pada modal publik.')"
                                class="py-2 px-2 rounded-xl border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center justify-center gap-1 transition-colors cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-stone-500">
                    <div class="font-bold text-stone-700">Belum ada data pengumuman</div>
                    <div class="text-sm text-stone-400 mt-0.5">Tambahkan pengumuman baru untuk ditampilkan pada modal publik.</div>
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm sm:text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 tracking-wider font-semibold">
                    <tr>
                        <th class="py-3 px-4">Pengumuman</th>
                        <th class="py-3 px-4">Tombol / Link</th>
                        <th class="py-3 px-4">Periode Tayang</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100 text-stone-700">
                    @forelse($announcements as $announcement)
                        <tr x-data="{ expanded: false }" class="hover:bg-stone-50/60 transition-colors">
                            <td class="py-3.5 px-4 align-top">
                                <div class="flex items-start gap-3">
                                    @if($announcement->image_url)
                                        <img src="{{ $announcement->image_url }}" alt="{{ $announcement->title }}" class="w-12 h-12 rounded-lg object-cover border border-stone-200 flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-stone-100 border border-stone-200 text-stone-400 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-bold text-stone-900 leading-snug">{{ $announcement->title }}</span>
                                            <span class="inline-flex items-center text-[10px] font-semibold px-2 py-0.5 rounded-full border {{ $announcement->type === 'floating' ? 'bg-purple-50 text-purple-700 border-purple-200' : ($announcement->type === 'both' ? 'bg-teal-50 text-teal-700 border-teal-200' : 'bg-blue-50 text-blue-700 border-blue-200') }}">
                                                {{ $announcement->type_label }}
                                            </span>
                                        </div>

                                        @if($announcement->content)
                                            <div class="mt-1">
                                                <div x-show="!expanded" class="text-sm text-stone-500 line-clamp-1">
                                                    {{ strip_tags($announcement->content) }}
                                                </div>
                                                <div x-show="expanded" style="display: none;" class="text-sm text-stone-600 bg-stone-50 p-2.5 rounded-lg border border-stone-200 mt-1.5 whitespace-pre-line leading-relaxed">
                                                    {{ $announcement->content }}
                                                </div>
                                                <button
                                                    type="button"
                                                    @click="expanded = !expanded"
                                                    class="inline-flex items-center gap-1 text-[11px] font-semibold text-forest hover:text-stone-900 mt-1 cursor-pointer focus:outline-none"
                                                >
                                                    <span x-text="expanded ? 'Sembunyikan Rincian' : 'Lihat Selengkapnya'">Lihat Selengkapnya</span>
                                                    <svg class="w-3 h-3 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </button>
                                            </div>
                                        @endif

                                        <div class="text-[11px] text-stone-400 mt-1">Dilihat: {{ number_format($announcement->views_count) }} kali</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap align-top">
                                @if($announcement->button_url && $announcement->button_text)
                                    <a href="{{ $announcement->button_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm text-forest hover:underline font-semibold bg-forest/5 px-2.5 py-1 rounded-md border border-forest/15">
                                        <span>{{ $announcement->button_text }}</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @else
                                    <span class="text-stone-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-sm text-stone-600 align-top">
                                @if($announcement->start_at || $announcement->end_at)
                                    <div>{{ $announcement->start_at ? $announcement->start_at->translatedFormat('d M Y') : 'Sekarang' }}</div>
                                    <div class="text-stone-400">s/d {{ $announcement->end_at ? $announcement->end_at->translatedFormat('d M Y H:i') : 'Seterusnya' }}</div>
                                @else
                                    <span class="text-stone-500">Selalu Aktif</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap align-top">
                                <form action="{{ route('admin.announcements.toggle-status', $announcement) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-sm font-semibold cursor-pointer transition-colors {{ $announcement->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' : 'bg-stone-100 text-stone-600 hover:bg-stone-200 border border-stone-200' }}" title="Klik untuk mengubah status">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $announcement->is_active ? 'bg-emerald-500' : 'bg-stone-400' }}"></span>
                                        <span>{{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap align-top">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="p-1.5 text-stone-600 hover:text-forest hover:bg-stone-100 rounded-lg transition-colors" title="Edit Pengumuman">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button
                                        type="button"
                                        onclick="window.confirmDelete('{{ route('admin.announcements.destroy', $announcement) }}', 'Yakin ingin menghapus pengumuman \'{{ addslashes($announcement->title) }}\'? Pengumuman ini tidak akan lagi ditampilkan pada modal publik.')"
                                        class="p-1.5 text-stone-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                                        title="Hapus Pengumuman"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-stone-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center mb-2.5">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                    </div>
                                    <div class="font-bold text-stone-700">Belum ada data pengumuman</div>
                                    <div class="text-sm text-stone-400 mt-0.5">Tambahkan pengumuman baru untuk ditampilkan pada modal publik.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($announcements->hasPages())
            <div class="p-3 border-t border-stone-200 bg-stone-50/50">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>

</x-layouts.admin>
