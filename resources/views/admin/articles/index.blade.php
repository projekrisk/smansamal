<x-layouts.admin title="Artikel & Jurnal - SMAN 1 Malingping">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
        <div>
            <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Artikel & Berita</h1>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="bg-forest text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-stone-900 transition-colors shadow-xs inline-flex items-center gap-1.5 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Tulis Artikel / Berita</span>
        </a>
    </div>

    <div class="bg-white p-2.5 sm:p-3 rounded-xl border border-stone-200 shadow-2xs mb-4 flex flex-col md:flex-row gap-2.5 items-center justify-between">
        <div class="flex flex-wrap gap-1.5 text-xs sm:text-xs font-semibold w-full md:w-auto">
            <a href="{{ route('admin.articles.index') }}" class="px-3 py-1.5 rounded-lg transition-colors {{ empty($type) && empty($status) ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Semua
            </a>
            <a href="{{ route('admin.articles.index', ['type' => 'jurnal']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ ($type === 'jurnal') ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Berita
            </a>
            <a href="{{ route('admin.articles.index', ['type' => 'suara_warga']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ ($type === 'suara_warga') ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Suara Warga
            </a>
            <a href="{{ route('admin.articles.index', ['status' => 'pending_review']) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ ($status === 'pending_review') ? 'bg-amber-500 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Menunggu
            </a>
        </div>

        <form action="{{ route('admin.articles.index') }}" method="GET" class="w-full md:w-72">
            @if($type) <input type="hidden" name="type" value="{{ $type }}"> @endif
            @if($status) <input type="hidden" name="status" value="{{ $status }}"> @endif
            <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul atau penulis..." class="w-full px-3.5 py-2 rounded-lg border border-stone-200 text-xs sm:text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 focus:bg-white">
        </form>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden" x-data="{ allOpen: false }">

        <div class="md:hidden px-4 py-2.5 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-xs">
            <span class="font-medium text-stone-500">
                Total: <strong class="text-stone-900">{{ $articles->total() }} Artikel</strong>
            </span>
            @if($articles->isNotEmpty())
                <button type="button" @click="allOpen = !allOpen; $dispatch('toggle-all-admin-cards', { open: allOpen })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                    <span x-text="allOpen ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            @endif
        </div>

        <div class="md:hidden divide-y divide-stone-200">
            @forelse($articles as $art)
                <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors" x-data="{ isOpen: false }" @toggle-all-admin-cards.window="isOpen = $event.detail.open">

                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                <span class="text-[10px] font-bold tracking-wider px-2 py-0.5 rounded {{ $art->type === 'jurnal' ? 'bg-forest/10 text-forest' : 'bg-terracotta/10 text-terracotta' }}">
                                    {{ $art->type === 'jurnal' ? 'Jurnal' : 'Suara Warga' }}
                                </span>

                                <span class="bg-stone-100 text-stone-600 text-[10px] px-2 py-0.5 rounded font-medium truncate max-w-[120px]">
                                    {{ $art->category->name ?? '-' }}
                                </span>

                                @if($art->status === 'published')
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Terbit
                                    </span>
                                @elseif($art->status === 'pending_review')
                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Review
                                    </span>
                                @elseif($art->status === 'rejected')
                                    <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-stone-100 text-stone-700 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-stone-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                                        Draf
                                    </span>
                                @endif
                            </div>

                            <h4 class="font-bold text-sm text-stone-900 leading-snug line-clamp-2">
                                {{ $art->title }}
                            </h4>

                            <div class="flex items-center gap-2 text-xs text-stone-400 mt-1">
                                <span class="font-medium text-stone-600 truncate max-w-[140px]">{{ $art->user->name }}</span>
                                <span>&bull;</span>
                                <span>{{ $art->formatted_date }}</span>
                            </div>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2 text-xs">
                        <div class="grid grid-cols-2 gap-2 bg-stone-50 p-2.5 rounded-lg border border-stone-100 text-[11px]">
                            <div>
                                <span class="text-stone-400 block mb-0.5">Penulis & Peran</span>
                                <span class="font-bold text-stone-800 block">{{ $art->user->name }}</span>
                                <span class="text-stone-500">{{ $art->user->role_badge['label'] ?? 'Warga' }}</span>
                            </div>
                            <div>
                                <span class="text-stone-400 block mb-0.5">Statistik Pembaca</span>
                                <span class="font-bold text-stone-800 block">{{ $art->views_count }} views</span>
                                <span class="text-terracotta font-semibold">{{ $art->likes_count }} apresiasi suka</span>
                            </div>
                        </div>

                        @if($art->status === 'rejected' && $art->rejection_reason)
                            <div class="p-2.5 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                                <span class="font-bold block mb-0.5">Alasan Penolakan:</span>
                                {{ $art->rejection_reason }}
                            </div>
                        @endif

                        <div class="grid grid-cols-3 gap-2 pt-1">
                            <a href="{{ $art->url }}" target="_blank" class="py-2 px-3 rounded-lg border border-stone-200 text-stone-700 hover:bg-stone-50 font-bold text-center inline-flex items-center justify-center gap-1 transition-colors">
                                <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                <span>Lihat</span>
                            </a>

                            <a href="{{ route('admin.articles.edit', $art->id) }}" class="py-2 px-3 rounded-lg bg-forest text-white font-bold text-center inline-flex items-center justify-center gap-1 hover:bg-stone-900 transition-colors shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Edit</span>
                            </a>

                            <button type="button" onclick="window.confirmDelete('{{ route('admin.articles.destroy', $art->id) }}', 'Yakin ingin menghapus artikel: {{ addslashes($art->title) }}?')" class="py-2 px-3 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center justify-center gap-1 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 px-4 text-stone-400 text-sm">
                    Tidak ada artikel yang sesuai kriteria.
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left font-sans text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                    <tr>
                        <th class="py-2.5 px-4">Judul</th>
                        <th class="py-2.5 px-4">Tipe & Kategori</th>
                        <th class="py-2.5 px-4">Penulis</th>
                        <th class="py-2.5 px-4">Status</th>
                        <th class="py-2.5 px-4">Statistik</th>
                        <th class="py-2.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($articles as $art)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="py-2.5 px-4 max-w-xs">
                                <span class="font-bold text-stone-900 block line-clamp-1 hover:text-forest">{{ $art->title }}</span>
                                <span class="text-sm text-stone-400">{{ $art->formatted_date }}</span>
                            </td>
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="block text-sm font-bold {{ $art->type === 'jurnal' ? 'text-forest' : 'text-terracotta' }}">
                                    {{ $art->type === 'jurnal' ? 'Jurnal' : 'Suara Warga' }}
                                </span>
                                <span class="text-sm text-stone-500">{{ $art->category->name ?? '-' }}</span>
                            </td>
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="font-semibold text-stone-800 block text-sm">{{ $art->user->name }}</span>
                                <span class="text-sm text-stone-400">{{ $art->user->role_badge['label'] }}</span>
                            </td>
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                @if($art->status === 'published')
                                    <span class="bg-green-100 text-green-800 text-sm font-bold px-2.5 py-0.5 rounded-full">Terbit</span>
                                @elseif($art->status === 'pending_review')
                                    <span class="bg-amber-100 text-amber-800 text-sm font-bold px-2.5 py-0.5 rounded-full">Pending Review</span>
                                @elseif($art->status === 'rejected')
                                    <span class="bg-red-100 text-red-800 text-sm font-bold px-2.5 py-0.5 rounded-full" title="{{ $art->rejection_reason }}">Ditolak</span>
                                @else
                                    <span class="bg-stone-200 text-stone-700 text-sm font-bold px-2.5 py-0.5 rounded-full">Draft</span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 text-stone-500 whitespace-nowrap text-sm">
                                {{ $art->views_count }} views &bull; {{ $art->likes_count }} suka
                            </td>
                            <td class="py-2.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">

                                    <a href="{{ $art->url }}" target="_blank" title="Lihat Artikel" class="p-1.5 text-stone-500 hover:text-stone-800 hover:bg-stone-100 border border-stone-200 rounded-lg transition-colors inline-flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span class="sr-only">Lihat</span>
                                    </a>

                                    <a href="{{ route('admin.articles.edit', $art->id) }}" title="Edit Artikel" class="p-1.5 text-forest hover:text-white hover:bg-forest border border-forest/20 rounded-lg transition-colors inline-flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span class="sr-only">Edit</span>
                                    </a>

                                    <button type="button" onclick="window.confirmDelete('{{ route('admin.articles.destroy', $art->id) }}', 'Yakin ingin menghapus artikel: {{ addslashes($art->title) }}?')" title="Hapus Artikel" class="p-1.5 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-stone-400 text-sm">
                                Tidak ada artikel yang sesuai kriteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-stone-100">
            {{ $articles->links() }}
        </div>
    </div>

</x-layouts.admin>
