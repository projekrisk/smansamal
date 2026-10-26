<x-layouts.admin title="Dasbor Admin - SMAN 1 Malingping" headerTitle="Ringkasan Sistem">

    <div class="mb-5">
        <h1 class="font-serif text-2xl text-stone-900 font-bold mb-1">Ringkasan Sistem</h1>
        <p class="font-sans text-stone-500 text-sm">Status portal SMAN 1 Malingping per {{ now()->locale('id')->isoFormat('D MMMM Y') }}.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white p-4 sm:p-5 rounded-xl border border-stone-200 shadow-2xs relative overflow-hidden group hover:border-forest transition-colors">
            <svg class="absolute -right-3 -bottom-3 w-24 h-24 text-forest/5 group-hover:text-forest/10 transition-colors pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <div class="relative z-10">
                <p class="font-sans text-sm font-bold text-stone-500 tracking-wider mb-1">Total Warga</p>
                <h3 class="font-serif text-3xl text-stone-900 font-bold leading-none">{{ number_format($stats['total_users']) }}</h3>
                <p class="font-sans text-sm text-forest font-semibold mt-1.5 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7 7v18"></path></svg>
                    +{{ $stats['new_users_this_month'] }} bulan ini
                </p>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-xl border border-stone-200 shadow-2xs relative overflow-hidden group hover:border-terracotta transition-colors">
            <svg class="absolute -right-3 -bottom-3 w-24 h-24 text-terracotta/5 group-hover:text-terracotta/10 transition-colors pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <div class="relative z-10">
                <p class="font-sans text-sm font-bold text-stone-500 tracking-wider mb-1">Menunggu Tinjauan</p>
                <h3 class="font-serif text-3xl text-terracotta font-bold leading-none">{{ $stats['pending_suara_warga'] }}</h3>
                <p class="font-sans text-sm text-stone-500 mt-1.5">Artikel Butuh Moderasi</p>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-xl border border-stone-200 shadow-2xs relative overflow-hidden group hover:border-forest transition-colors">
            <svg class="absolute -right-3 -bottom-3 w-24 h-24 text-forest/5 group-hover:text-forest/10 transition-colors pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
            <div class="relative z-10">
                <p class="font-sans text-sm font-bold text-stone-500 tracking-wider mb-1">Total Publikasi</p>
                <h3 class="font-serif text-3xl text-stone-900 font-bold leading-none">{{ number_format($stats['total_jurnal'] + $stats['total_suara_warga']) }}</h3>
                <p class="font-sans text-sm text-stone-500 mt-1.5">Jurnal & Suara Warga</p>
            </div>
        </div>

        <div class="bg-white p-4 sm:p-5 rounded-xl border border-stone-200 shadow-2xs relative overflow-hidden group hover:border-stone-400 transition-colors">
            <svg class="absolute -right-3 -bottom-3 w-24 h-24 text-stone-300/30 group-hover:text-stone-300/60 transition-colors pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <div class="relative z-10">
                <p class="font-sans text-sm font-bold text-stone-500 tracking-wider mb-1">Agenda Aktif</p>
                <h3 class="font-serif text-3xl text-stone-900 font-bold leading-none">{{ $stats['active_agendas'] }}</h3>
                <p class="font-sans text-sm text-stone-500 mt-1.5">Bulan Ini ({{ now()->locale('id')->isoFormat('MMM Y') }})</p>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-serif text-lg text-stone-900 font-bold">Antrean Moderasi (Suara Warga)</h2>
            <a href="{{ route('admin.articles.index', ['type' => 'suara_warga', 'status' => 'pending_review']) }}" class="font-sans text-sm font-semibold text-forest hover:underline">Lihat Semua</a>
        </div>

        <div class="bg-white border border-stone-200 rounded-xl shadow-2xs overflow-hidden" x-data="{ allOpenArticles: false }">

            <div class="md:hidden px-4 py-2 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-xs">
                <span class="font-medium text-stone-500">
                    Total: <strong class="text-stone-900">{{ count($pendingArticles) }} Antrean</strong>
                </span>
                @if(count($pendingArticles) > 0)
                    <button type="button" @click="allOpenArticles = !allOpenArticles; $dispatch('toggle-admin-dash-articles', { open: allOpenArticles })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                        <span x-text="allOpenArticles ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenArticles ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                @endif
            </div>

            <div class="md:hidden divide-y divide-stone-200">
                @forelse($pendingArticles as $art)
                    <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors" x-data="{ isOpen: false }" @toggle-admin-dash-articles.window="isOpen = $event.detail.open">
                        <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                    <span class="bg-amber-100 text-amber-800 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full">
                                        Perlu Moderasi
                                    </span>
                                    <span class="bg-stone-100 text-stone-600 text-[10px] px-2 py-0.5 rounded font-medium">
                                        {{ $art->category->name ?? 'Suara Warga' }}
                                    </span>
                                </div>

                                <h4 class="font-bold text-sm text-stone-900 leading-snug line-clamp-2">
                                    {{ $art->title }}
                                </h4>

                                <div class="flex items-center gap-2 text-xs text-stone-500 mt-1">
                                    <span class="font-semibold text-stone-700">{{ $art->user->name ?? 'Warga' }}</span>
                                    <span>&bull;</span>
                                    <span class="text-stone-400">{{ $art->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </button>

                        <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">
                            <div class="bg-stone-50 p-2.5 rounded-lg border border-stone-100 flex items-center justify-between text-[11px]">
                                <div>
                                    <span class="text-stone-400 block">Status Penulis:</span>
                                    <span class="font-semibold text-stone-700">{{ $art->user->role_detail ?? 'Warga Sekolah' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-stone-400 block">Diajukan:</span>
                                    <span class="font-semibold text-stone-700">{{ $art->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2 pt-1">
                                <form action="{{ route('admin.articles.moderate', $art->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="w-full py-2 px-2 rounded-lg bg-forest text-white font-bold text-center inline-flex items-center justify-center gap-1 hover:bg-stone-900 transition-colors shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>Setujui</span>
                                    </button>
                                </form>

                                <button type="button" onclick="openRejectModal('{{ route('admin.articles.moderate', $art->id) }}', '{{ addslashes($art->title) }}')" class="py-2 px-2 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/60 hover:bg-rose-100 font-bold text-center inline-flex items-center justify-center gap-1 transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <span>Tolak</span>
                                </button>

                                <a href="{{ $art->url }}" target="_blank" class="py-2 px-2 rounded-lg border border-stone-200 text-stone-700 hover:bg-stone-100 font-bold text-center inline-flex items-center justify-center gap-1 transition-colors">
                                    <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Pratinjau</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 text-center text-sm text-stone-400">
                        Tidak ada antrean artikel yang menunggu moderasi. Semua naskah telah ditinjau!
                    </div>
                @endforelse
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left font-sans text-sm">
                    <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                        <tr>
                            <th class="px-4 py-2.5">Penulis</th>
                            <th class="px-4 py-2.5">Judul Artikel</th>
                            <th class="px-4 py-2.5">Kategori</th>
                            <th class="px-4 py-2.5">Dikirim</th>
                            <th class="px-4 py-2.5 text-right">Aksi Moderasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($pendingArticles as $art)
                            <tr class="hover:bg-stone-50/70 transition-colors group">
                                <td class="px-4 py-2.5 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-stone-200 overflow-hidden flex-shrink-0">
                                            <img src="{{ $art->user->avatar_url ?? 'https://placehold.co/100x100/eeeeee/333333?text=W' }}" alt="Avatar" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-bold text-stone-900 text-sm leading-tight">{{ $art->user->name ?? 'Warga' }}</p>
                                            <p class="text-sm text-stone-500 tracking-wider">{{ $art->user->role_detail ?? 'Warga Sekolah' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2.5">
                                    <a href="{{ $art->url }}" target="_blank" class="font-bold text-stone-900 hover:text-forest transition-colors line-clamp-1">
                                        {{ $art->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-2.5 whitespace-nowrap">
                                    <span class="bg-stone-100 text-stone-700 text-sm font-semibold tracking-wider px-2.5 py-0.5 rounded">
                                        {{ $art->category->name ?? 'Suara Warga' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2.5 text-stone-500 whitespace-nowrap">
                                    {{ $art->created_at->diffForHumans() }}
                                </td>
                                <td class="px-4 py-2.5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">

                                        <form action="{{ route('admin.articles.moderate', $art->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-forest/10 text-forest hover:bg-forest hover:text-white flex items-center justify-center transition-colors" title="Setujui dan Terbitkan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>

                                        <button type="button" onclick="openRejectModal('{{ route('admin.articles.moderate', $art->id) }}', '{{ addslashes($art->title) }}')" class="w-8 h-8 rounded-lg bg-terracotta/10 text-terracotta hover:bg-terracotta hover:text-white flex items-center justify-center transition-colors" title="Tolak Naskah">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>

                                        <a href="{{ $art->url }}" target="_blank" class="w-8 h-8 rounded-lg bg-stone-100 text-stone-500 hover:text-stone-900 hover:bg-stone-200 flex items-center justify-center transition-colors" title="Pratinjau Tulisan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-stone-400">
                                    Tidak ada antrean artikel yang menunggu moderasi. Semua naskah telah ditinjau!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-serif text-lg text-stone-900 font-bold">Moderasi Komentar</h2>
            @if($stats['pending_comments'] > 0)
                <span class="bg-terracotta text-white font-sans text-sm font-bold px-3 py-0.5 rounded-full">{{ $stats['pending_comments'] }} Menunggu Moderasi</span>
            @else
                <span class="bg-forest/10 text-forest font-sans text-sm font-bold px-3 py-0.5 rounded-full">Semua Komentar Bersih</span>
            @endif
        </div>

        <div class="bg-white border border-stone-200 rounded-xl shadow-2xs overflow-hidden" x-data="{ allOpenComments: false }">

            <div class="md:hidden px-4 py-2 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-xs">
                <span class="font-medium text-stone-500">
                    Total: <strong class="text-stone-900">{{ count($moderationComments) }} Komentar</strong>
                </span>
                @if(count($moderationComments) > 0)
                    <button type="button" @click="allOpenComments = !allOpenComments; $dispatch('toggle-admin-dash-comments', { open: allOpenComments })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                        <span x-text="allOpenComments ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenComments ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                @endif
            </div>

            <div class="md:hidden divide-y divide-stone-200">
                @forelse($moderationComments as $comm)
                    <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors {{ $comm->status === 'pending' ? 'bg-amber-50/20' : ($comm->status === 'spam' ? 'bg-rose-50/20' : '') }}" x-data="{ isOpen: false }" @toggle-admin-dash-comments.window="isOpen = $event.detail.open">
                        <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                    @if($comm->status === 'approved')
                                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-emerald-200">
                                            Tayang
                                        </span>
                                    @elseif($comm->status === 'spam')
                                        <span class="bg-rose-50 text-rose-700 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-rose-200">
                                            Spam
                                        </span>
                                    @else
                                        <span class="bg-amber-50 text-amber-800 text-[10px] font-bold tracking-wider px-2 py-0.5 rounded-full border border-amber-200">
                                            Menunggu
                                        </span>
                                    @endif
                                </div>

                                <p class="font-bold text-sm text-stone-900 leading-snug">
                                    {{ $comm->author_name }}
                                </p>
                                <p class="text-xs text-stone-600 line-clamp-1 italic mt-0.5">
                                    "{{ $comm->content }}"
                                </p>
                                <span class="text-[11px] text-stone-400 mt-0.5 block">{{ $comm->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </button>

                        <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">
                            <div class="bg-stone-50 p-2.5 rounded-lg border border-stone-100 text-stone-700 italic leading-relaxed">
                                "{{ $comm->content }}"
                            </div>

                            <div class="text-[11px] text-stone-500">
                                <span class="text-stone-400 block mb-0.5">Pada Artikel:</span>
                                <a href="{{ $comm->article ? $comm->article->url : '#' }}" target="_blank" class="text-forest font-bold hover:underline line-clamp-1">
                                    {{ $comm->article->title ?? 'Artikel' }}
                                </a>
                            </div>

                            <div class="flex items-center justify-end gap-2 pt-1 border-t border-stone-100">
                                @if($comm->status !== 'approved')
                                    <form action="{{ route('admin.comments.status', $comm->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="py-1.5 px-3 rounded-lg bg-emerald-600 text-white font-bold text-center inline-flex items-center gap-1 hover:bg-emerald-700 transition-colors shadow-2xs">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span>Setujui</span>
                                        </button>
                                    </form>
                                @endif

                                @if($comm->status !== 'spam')
                                    <form action="{{ route('admin.comments.status', $comm->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="spam">
                                        <button type="submit" class="py-1.5 px-3 rounded-lg border border-amber-300 text-amber-700 bg-amber-50 hover:bg-amber-100 font-bold text-center inline-flex items-center gap-1 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            <span>Spam</span>
                                        </button>
                                    </form>
                                @endif

                                <button type="button" onclick="window.confirmDelete('{{ route('admin.comments.destroy', $comm->id) }}', 'Yakin ingin menghapus komentar dari {{ addslashes($comm->author_name) }}?')" class="py-1.5 px-3 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center gap-1 transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 text-center text-sm text-stone-400">
                        Tidak ada komentar yang perlu disetujui.
                    </div>
                @endforelse
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left font-sans text-sm">
                    <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                        <tr>
                            <th class="px-4 py-2.5">Komentator</th>
                            <th class="px-4 py-2.5 w-1/3">Isi Komentar</th>
                            <th class="px-4 py-2.5">Artikel Terkait</th>
                            <th class="px-4 py-2.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($moderationComments as $comm)
                            <tr class="hover:bg-stone-50/70 transition-colors {{ $comm->status === 'pending' ? 'bg-stone-50/40' : ($comm->status === 'spam' ? 'bg-terracotta/5' : '') }}">
                                <td class="px-4 py-2.5 whitespace-nowrap">
                                    <p class="font-bold text-stone-900 text-sm">{{ $comm->author_name }}</p>
                                    <p class="text-sm text-stone-400">{{ $comm->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-4 py-2.5">
                                    <p class="text-stone-700 italic line-clamp-2 text-sm">"{{ $comm->content }}"</p>
                                </td>
                                <td class="px-4 py-2.5">
                                    <a href="{{ $comm->article ? $comm->article->url : '#' }}" target="_blank" class="text-forest font-semibold hover:underline line-clamp-1 text-sm">
                                        {{ $comm->article->title ?? 'Artikel' }}
                                    </a>
                                </td>
                                <td class="px-4 py-2.5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5 text-stone-500">
                                        @if($comm->status !== 'approved')

                                            <form action="{{ route('admin.comments.status', $comm->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-forest/10 text-forest hover:bg-forest hover:text-white flex items-center justify-center transition-colors" title="Setujui Komentar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                        @endif

                                        @if($comm->status !== 'spam')

                                            <form action="{{ route('admin.comments.status', $comm->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="spam">
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-600 hover:text-white flex items-center justify-center transition-colors" title="Tandai Spam">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                </button>
                                            </form>
                                        @endif

                                        <button type="button" onclick="window.confirmDelete('{{ route('admin.comments.destroy', $comm->id) }}', 'Yakin ingin menghapus komentar dari {{ addslashes($comm->author_name) }}?')" class="w-8 h-8 rounded-lg bg-terracotta/10 text-terracotta hover:bg-terracotta hover:text-white flex items-center justify-center transition-colors" title="Hapus Permanen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-sm text-stone-400">
                                    Tidak ada komentar yang perlu disetujui.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="reject-modal" class="fixed inset-0 z-[300] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 font-sans">
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm" onclick="closeRejectModal()"></div>
        <div class="bg-white rounded-2xl p-5 max-w-sm w-full relative z-10 shadow-xl transform scale-95 transition-transform duration-300">
            <h4 class="font-serif text-lg text-stone-900 font-bold mb-1">Tolak Naskah Artikel</h4>
            <p id="reject-modal-title" class="text-sm text-stone-500 mb-3 line-clamp-1"></p>

            <form id="reject-modal-form" action="" method="POST">
                @csrf
                <input type="hidden" name="action" value="reject">
                <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">Alasan Penolakan</label>
                <textarea name="rejection_reason" rows="3" placeholder="Jelaskan alasan penolakan secara santun..." required class="w-full text-sm p-2.5 rounded-lg border border-stone-200 focus:border-terracotta focus:ring-1 focus:ring-terracotta mb-3 font-sans leading-relaxed"></textarea>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-600 text-sm font-semibold">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold px-4 py-2 rounded-lg transition-colors shadow-xs">
                        Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openRejectModal(actionUrl, articleTitle) {
            const modal = document.getElementById('reject-modal');
            const form = document.getElementById('reject-modal-form');
            const titleEl = document.getElementById('reject-modal-title');
            const card = modal.querySelector('div.bg-white');

            form.action = actionUrl;
            titleEl.innerText = 'Judul: ' + articleTitle;

            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeRejectModal() {
            const modal = document.getElementById('reject-modal');
            const card = modal.querySelector('div.bg-white');

            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }
    </script>
    @endpush

</x-layouts.admin>
