<x-layouts.warga title="Komentar Pembaca - Dasbor Warga" headerTitle="Komentar Pembaca">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3.5 mb-5">
        <div>
            <h1 class="font-serif text-2xl font-bold text-stone-900">Komentar Pembaca</h1>
        </div>

        <form method="GET" action="{{ route('warga.comments.index') }}" class="w-full sm:w-72">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari komentar atau nama..." class="form-input text-sm pl-9 pr-8 py-2 rounded-xl">
                <svg class="w-4 h-4 text-stone-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                @if(request('q'))
                    <a href="{{ route('warga.comments.index', array_filter(['status' => request('status')])) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600" title="Hapus pencarian">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="flex items-center gap-2 mb-5 text-xs font-semibold overflow-x-auto pb-1 no-scrollbar">
        <a href="{{ route('warga.comments.index') }}" class="px-3.5 py-1.5 rounded-xl transition-colors whitespace-nowrap {{ empty($status) ? 'bg-forest text-white shadow-2xs font-bold' : 'bg-white text-stone-600 border border-stone-200 hover:bg-stone-50' }}">
            Semua
        </a>
        <a href="{{ route('warga.comments.index', ['status' => 'pending']) }}" class="px-3.5 py-1.5 rounded-xl transition-colors whitespace-nowrap inline-flex items-center gap-1.5 {{ ($status === 'pending') ? 'bg-amber-600 text-white shadow-2xs font-bold' : 'bg-white text-stone-600 border border-stone-200 hover:bg-stone-50' }}">
            <span>Menunggu</span>
            @if($pendingCount > 0)
                <span class="{{ ($status === 'pending') ? 'bg-white text-amber-700' : 'bg-amber-100 text-amber-800' }} text-xs px-2 py-0.2 rounded-full font-bold">
                    {{ $pendingCount }}
                </span>
            @endif
        </a>
        <a href="{{ route('warga.comments.index', ['status' => 'approved']) }}" class="px-3.5 py-1.5 rounded-xl transition-colors whitespace-nowrap inline-flex items-center gap-1.5 {{ ($status === 'approved') ? 'bg-forest text-white shadow-2xs font-bold' : 'bg-white text-stone-600 border border-stone-200 hover:bg-stone-50' }}">
            <span>Tayang</span>
            @if($approvedCount > 0)
                <span class="{{ ($status === 'approved') ? 'bg-white text-forest' : 'bg-stone-100 text-stone-700' }} text-xs px-2 py-0.2 rounded-full font-bold">
                    {{ $approvedCount }}
                </span>
            @endif
        </a>
    </div>

    <div class="bg-white border border-stone-200 rounded-xl shadow-2xs overflow-hidden mb-6" x-data="{ allOpenComments: false }">

        <div class="sm:hidden px-4 py-2.5 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-xs font-sans">
            <span class="font-medium text-stone-500">
                Total: <strong class="text-stone-900">{{ $comments->total() }} Komentar</strong>
            </span>
            @if($comments->isNotEmpty())
                <button type="button" @click="allOpenComments = !allOpenComments; $dispatch('toggle-warga-comments', { open: allOpenComments })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                    <span x-text="allOpenComments ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenComments ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            @endif
        </div>

        <div class="sm:hidden divide-y divide-stone-100 font-sans">
            @forelse($comments as $comm)
                <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors" x-data="{ isOpen: false }" @toggle-warga-comments.window="isOpen = $event.detail.open">
                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                        <div class="flex items-start gap-3 min-w-0 flex-1">
                            <div class="w-8 h-8 rounded-full {{ $comm->user_id ? 'bg-forest text-white' : 'bg-stone-200 text-stone-700' }} flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5 shadow-2xs">
                                {{ strtoupper(substr($comm->author_name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                    <span class="font-bold text-sm text-stone-900 truncate">{{ $comm->author_name }}</span>
                                    @if($comm->status === 'approved')
                                        <span class="bg-forest/10 text-forest text-xs font-semibold px-2 py-0.5 rounded-md">Tayang</span>
                                    @else
                                        <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2 py-0.5 rounded-md">Menunggu</span>
                                    @endif
                                </div>
                                
                                <p class="text-xs text-stone-500 line-clamp-1 italic font-sans" x-show="!isOpen">
                                    "{{ $comm->content }}"
                                </p>
                                <span class="text-[11px] text-stone-400 block mt-0.5" x-show="!isOpen">
                                    {{ $comm->created_at->diffForHumans() }} &bull; Pada: {{ $comm->article->title ?? 'Artikel' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">
                        <div class="flex flex-wrap items-center gap-2 text-xs">
                            @if($comm->user_id)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-forest/10 text-forest font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Warga Terdaftar
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 font-semibold">
                                    Tamu (Guest)
                                </span>
                            @endif
                            <span class="text-stone-400">&bull; {{ $comm->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="bg-stone-50 p-3 rounded-xl border border-stone-200/70 text-stone-700 text-xs leading-relaxed font-sans">
                            {{ $comm->content }}
                        </div>

                        <div class="text-xs text-stone-500 flex items-center gap-1.5 bg-stone-50/60 p-2 rounded-lg border border-stone-100">
                            <span class="text-stone-400">Pada karya:</span>
                            <a href="{{ $comm->article ? $comm->article->url : '#' }}" target="_blank" class="font-bold text-forest hover:underline truncate">
                                {{ $comm->article->title ?? 'Artikel' }} &rarr;
                            </a>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-1 border-t border-stone-100">
                            @if($comm->status === 'pending')
                                <form action="{{ route('warga.comments.approve', $comm->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-forest hover:bg-stone-900 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors shadow-2xs inline-flex items-center gap-1.5 cursor-pointer" title="Setujui komentar agar tampil ke publik">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Setujui</span>
                                    </button>
                                </form>
                            @endif

                            <button type="button" onclick="window.confirmDelete('{{ route('warga.comments.destroy', $comm->id) }}', 'Yakin ingin menghapus komentar dari {{ addslashes($comm->author_name) }}?')" class="px-3 py-1.5 rounded-lg text-stone-500 hover:text-red-600 hover:bg-red-50 transition-colors inline-flex items-center gap-1 text-xs font-semibold border border-stone-200 hover:border-red-200 cursor-pointer" title="Hapus Komentar">
                                <svg class="w-3.5 h-3.5 text-stone-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-stone-400 text-xs">
                    <p class="font-semibold text-stone-600">Tidak ada komentar dalam kategori ini.</p>
                </div>
            @endforelse
        </div>

        <div class="hidden sm:block divide-y divide-stone-100">
            @forelse($comments as $comm)
                <div class="p-4 sm:p-5 hover:bg-stone-50/70 transition-colors flex flex-col sm:flex-row items-start justify-between gap-4">
                    <div class="flex items-start gap-3.5 max-w-3xl">

                        <div class="w-9 h-9 rounded-full {{ $comm->user_id ? 'bg-forest text-white' : 'bg-stone-200 text-stone-700' }} flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5 shadow-2xs">
                            {{ strtoupper(substr($comm->author_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="font-bold text-sm text-stone-900">{{ $comm->author_name }}</span>

                                @if($comm->user_id)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-forest/10 text-forest text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Warga Terdaftar
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 text-xs font-semibold">
                                        Tamu (Guest)
                                    </span>
                                @endif

                                @if($comm->status === 'approved')
                                    <span class="bg-forest/10 text-forest text-xs font-semibold px-2 py-0.5 rounded-md">Tayang</span>
                                @else
                                    <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2 py-0.5 rounded-md">Menunggu Persetujuan</span>
                                @endif

                                <span class="text-sm text-stone-400">&bull; {{ $comm->created_at->diffForHumans() }}</span>
                            </div>

                            <p class="font-sans text-sm text-stone-700 leading-relaxed bg-stone-50 p-3 rounded-xl border border-stone-200/60 mb-2">
                                {{ $comm->content }}
                            </p>

                            <div class="text-sm text-stone-500 flex items-center gap-1.5">
                                <span>Pada karya:</span>
                                <a href="{{ $comm->article ? $comm->article->url : '#' }}" target="_blank" class="font-semibold text-forest hover:underline">
                                    {{ $comm->article->title }} &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:self-center flex-shrink-0">
                        @if($comm->status === 'pending')
                            <form action="{{ route('warga.comments.approve', $comm->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-forest hover:bg-stone-900 text-white text-sm font-bold px-3.5 py-1.5 rounded-lg transition-colors shadow-2xs inline-flex items-center gap-1.5 cursor-pointer" title="Setujui komentar agar tampil ke publik">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Setujui</span>
                                </button>
                            </form>
                        @endif

                        <button type="button" onclick="window.confirmDelete('{{ route('warga.comments.destroy', $comm->id) }}', 'Yakin ingin menghapus komentar dari {{ addslashes($comm->author_name) }}?')" class="px-3 py-1.5 rounded-lg text-stone-500 hover:text-red-600 hover:bg-red-50 transition-colors inline-flex items-center gap-1 text-xs font-semibold border border-stone-200 hover:border-red-200 cursor-pointer" title="Hapus Komentar">
                            <svg class="w-4 h-4 text-stone-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            <span>Hapus</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-stone-400 text-sm">
                    <svg class="w-10 h-10 text-stone-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <p class="font-semibold text-stone-600">Tidak ada komentar dalam kategori ini.</p>
                    <p class="text-sm text-stone-400 mt-0.5">Komentar pembaca pada karya Anda akan tersaring di sini.</p>
                </div>
            @endforelse
        </div>

        @if($comments->hasPages())
            <div class="p-4 border-t border-stone-100">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

</x-layouts.warga>
