<x-layouts.warga title="Karya Saya - Dasbor Warga" headerTitle="Karya Saya">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3.5 mb-5">
        <div>
            <h1 class="font-serif text-2xl font-bold text-stone-900">Karya Tulis Saya</h1>
        </div>
        @if(auth()->user()->is_active)
            <a href="{{ route('warga.articles.create') }}" class="bg-forest text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-stone-900 transition-colors shadow-xs inline-flex items-center gap-2 flex-shrink-0 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Karya Baru</span>
            </a>
        @endif
    </div>

    <div class="bg-white border border-stone-200 rounded-xl shadow-2xs overflow-hidden mb-6" x-data="{ allOpen: false }">

        <div class="md:hidden px-4 py-2.5 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-xs">
            <span class="font-medium text-stone-500">
                Total: <strong class="text-stone-900">{{ $articles->total() }} Karya</strong>
            </span>
            @if($articles->isNotEmpty())
                <button type="button" @click="allOpen = !allOpen; $dispatch('toggle-all-cards', { open: allOpen })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                    <span x-text="allOpen ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            @endif
        </div>

        <div class="md:hidden divide-y divide-stone-200">
            @forelse($articles as $art)
                <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors" x-data="{ isOpen: false }" @toggle-all-cards.window="isOpen = $event.detail.open">

                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                @if($art->status === 'published')
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Terbit
                                    </span>
                                @elseif($art->status === 'pending_review')
                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 text-[11px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Review
                                    </span>
                                @elseif($art->status === 'rejected')
                                    <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-700 text-[11px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-stone-100 text-stone-700 text-[11px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-stone-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                                        Draf
                                    </span>
                                @endif

                                <span class="bg-stone-100 text-stone-600 text-[11px] px-2 py-0.5 rounded font-medium">
                                    {{ $art->category->name ?? 'Suara Warga' }}
                                </span>
                            </div>

                            <h4 class="font-serif text-sm font-bold text-stone-900 leading-snug line-clamp-2">
                                {{ $art->title }}
                            </h4>

                            <div class="flex items-center gap-3 text-xs text-stone-400 mt-1">
                                <span>{{ $art->created_at->format('d M Y') }}</span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    {{ $art->views_count }}
                                </span>
                                <span class="inline-flex items-center gap-1 text-terracotta">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    {{ $art->likes_count }}
                                </span>
                            </div>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">
                        @if(!empty($art->excerpt))
                            <p class="text-stone-600 bg-stone-50 p-2.5 rounded-lg border border-stone-100 leading-relaxed italic">
                                "{{ $art->excerpt }}"
                            </p>
                        @endif

                        @if($art->tags && $art->tags->isNotEmpty())
                            <div class="flex flex-wrap gap-1">
                                @foreach($art->tags as $t)
                                    <span class="inline-flex items-center text-[11px] font-mono font-medium text-forest bg-forest/5 px-2 py-0.5 rounded">
                                        #{{ $t->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        @if($art->status === 'rejected' && $art->rejection_reason)
                            <div class="p-2.5 rounded-lg bg-rose-50 border border-rose-200 text-rose-800">
                                <span class="font-bold block mb-0.5">Catatan Moderator:</span>
                                {{ $art->rejection_reason }}
                            </div>
                        @endif

                        <div class="flex items-center justify-between text-stone-500 py-1 border-y border-stone-100 text-[11px]">
                            <span>Waktu Diajukan:</span>
                            <span class="font-semibold text-stone-700">{{ $art->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>

                        <div class="grid grid-cols-{{ $art->status === 'published' ? '3' : '2' }} gap-2 pt-1">
                            @if($art->status === 'published')
                                <a href="{{ $art->url }}" target="_blank" class="py-2 px-3 rounded-lg border border-stone-200 text-stone-700 hover:bg-stone-50 font-bold text-center inline-flex items-center justify-center gap-1.5 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Lihat</span>
                                </a>
                            @endif

                            <a href="{{ route('warga.articles.edit', $art->id) }}" class="py-2 px-3 rounded-lg bg-forest text-white font-bold text-center inline-flex items-center justify-center gap-1.5 hover:bg-stone-900 transition-colors shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Edit</span>
                            </a>

                            <button type="button" onclick="window.confirmDelete('{{ route('warga.articles.destroy', $art->id) }}', 'Yakin ingin menghapus karya: {{ addslashes($art->title) }}?')" class="py-2 px-3 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-10 text-center text-stone-400 text-sm">
                    <svg class="w-9 h-9 text-stone-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="font-semibold text-stone-600">Belum ada karya tulis.</p>
                    <p class="text-xs text-stone-400 mt-0.5">Mulai tulis opini, ide, atau cerita inspiratif Anda hari ini.</p>
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left font-sans text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                    <tr>
                        <th class="px-4 py-2.5">Artikel</th>
                        <th class="px-4 py-2.5">Kategori</th>
                        <th class="px-4 py-2.5">Statistik</th>
                        <th class="px-4 py-2.5">Status</th>
                        <th class="px-4 py-2.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($articles as $art)
                        <tr class="hover:bg-stone-50/70 transition-colors group">

                            <td class="px-4 py-3 max-w-md">
                                <h4 class="font-bold text-sm text-stone-900 group-hover:text-forest transition-colors line-clamp-1 leading-snug">
                                    {{ $art->title }}
                                </h4>
                                <p class="text-sm text-stone-500 mt-0.5 line-clamp-1">{{ $art->excerpt }}</p>
                                <span class="text-sm text-stone-400 mt-1 block">
                                    Diajukan: {{ $art->created_at->format('d M Y, H:i') }}
                                </span>

                                @if($art->tags && $art->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-1 mt-1.5">
                                        @foreach($art->tags as $t)
                                            <span class="inline-flex items-center text-[11px] font-mono font-medium text-forest bg-forest/5 px-2 py-0.5 rounded">
                                                #{{ $t->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                @if($art->status === 'rejected' && $art->rejection_reason)
                                    <div class="mt-2 p-2.5 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">
                                        <span class="font-bold">Catatan Moderator:</span> {{ $art->rejection_reason }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-block bg-stone-100 text-stone-700 text-sm px-2.5 py-0.5 rounded font-medium">
                                    {{ $art->category->name ?? 'Suara Warga' }}
                                </span>
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap text-sm text-stone-500">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center gap-1.5" title="Jumlah Pembaca">
                                        <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        {{ $art->views_count }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-terracotta" title="Apresiasi Suka">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        {{ $art->likes_count }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($art->status === 'published')
                                    <span class="bg-forest/10 text-forest text-sm font-semibold tracking-wider px-2.5 py-0.5 rounded inline-block">
                                        Terbit
                                    </span>
                                @elseif($art->status === 'pending_review')
                                    <span class="bg-amber-100 text-amber-800 text-sm font-semibold tracking-wider px-2.5 py-0.5 rounded inline-block">
                                        Menunggu Review
                                    </span>
                                @elseif($art->status === 'rejected')
                                    <span class="bg-red-100 text-red-800 text-sm font-semibold tracking-wider px-2.5 py-0.5 rounded inline-block">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="bg-stone-200 text-stone-700 text-sm font-semibold tracking-wider px-2.5 py-0.5 rounded inline-block">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($art->status === 'published')
                                        <a href="{{ $art->url }}" target="_blank" class="p-1.5 rounded-lg text-stone-400 hover:text-forest hover:bg-forest/5 transition-colors" title="Lihat di Web Portal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    @endif

                                    <a href="{{ route('warga.articles.edit', $art->id) }}" class="p-1.5 rounded-lg text-stone-400 hover:text-forest hover:bg-forest/5 transition-colors" title="Edit Karya">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <button type="button" onclick="window.confirmDelete('{{ route('warga.articles.destroy', $art->id) }}', 'Yakin ingin menghapus karya: {{ addslashes($art->title) }}?')" class="p-1.5 rounded-lg text-stone-400 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer" title="Hapus Karya">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-stone-400 text-sm">
                                <svg class="w-10 h-10 text-stone-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p class="font-semibold text-stone-600">Belum ada karya tulis.</p>
                                <p class="text-sm text-stone-400 mt-0.5">Mulai tulis opini, ide, atau cerita inspiratif Anda hari ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-stone-100">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

</x-layouts.warga>
