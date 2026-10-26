<x-layouts.admin title="Moderasi Komentar - Admin SMAN 1 Malingping">

    <div class="mb-5">
        <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Moderasi Komentar</h1>
    </div>

    <div class="flex gap-1.5 mb-4 text-xs font-semibold">
        <a href="{{ route('admin.comments.index') }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ empty($status) ? 'bg-forest text-white' : 'bg-white text-stone-600 border border-stone-200 hover:bg-stone-50' }}">
            Semua
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'approved') ? 'bg-green-700 text-white' : 'bg-white text-stone-600 border border-stone-200 hover:bg-stone-50' }}">
            Tayang
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'spam']) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'spam') ? 'bg-red-700 text-white' : 'bg-white text-stone-600 border border-stone-200 hover:bg-stone-50' }}">
            Spam
        </a>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden" x-data="{ allOpenComments: false }">

        <div class="md:hidden px-4 py-2.5 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-xs">
            <span class="font-medium text-stone-500">
                Total: <strong class="text-stone-900">{{ $comments->total() }} Komentar</strong>
            </span>
            @if($comments->isNotEmpty())
                <button type="button" @click="allOpenComments = !allOpenComments; $dispatch('toggle-admin-comments', { open: allOpenComments })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                    <span x-text="allOpenComments ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenComments ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            @endif
        </div>

        <div class="md:hidden divide-y divide-stone-200">
            @forelse($comments as $comment)
                <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors {{ $comment->status === 'pending' ? 'bg-amber-50/20' : ($comment->status === 'spam' ? 'bg-rose-50/20' : '') }}" x-data="{ isOpen: false }" @toggle-admin-comments.window="isOpen = $event.detail.open">
                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                @if($comment->status === 'approved')
                                    <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border border-emerald-200">
                                        Approved
                                    </span>
                                @elseif($comment->status === 'spam')
                                    <span class="bg-rose-50 text-rose-700 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border border-rose-200">
                                        Spam
                                    </span>
                                @else
                                    <span class="bg-amber-50 text-amber-800 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full border border-amber-200">
                                        Pending
                                    </span>
                                @endif
                            </div>

                            <p class="font-bold text-sm text-stone-900 leading-snug">
                                {{ $comment->author_name }}
                            </p>
                            <p class="text-xs text-stone-600 line-clamp-1 italic mt-0.5">
                                "{{ $comment->content }}"
                            </p>
                            <span class="text-[11px] text-stone-400 mt-0.5 block">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">
                        <div class="bg-stone-50 p-2.5 rounded-lg border border-stone-100 text-stone-700 italic leading-relaxed">
                            "{{ $comment->content }}"
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-[11px] bg-stone-50 p-2 rounded-lg border border-stone-100">
                            <div>
                                <span class="text-stone-400 block">Email:</span>
                                <span class="font-mono text-stone-700 truncate block">{{ $comment->author_email ?: 'Tidak ada email' }}</span>
                            </div>
                            <div>
                                <span class="text-stone-400 block">Waktu:</span>
                                <span class="text-stone-700">{{ $comment->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        <div class="text-[11px] text-stone-500">
                            <span class="text-stone-400 block mb-0.5">Pada Artikel:</span>
                            <a href="{{ $comment->article ? $comment->article->url : '#' }}" target="_blank" class="text-forest font-bold hover:underline line-clamp-1">
                                {{ $comment->article->title ?? 'Artikel' }}
                            </a>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-1 border-t border-stone-100">
                            @if($comment->status !== 'approved')
                                <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="py-1.5 px-3 rounded-lg bg-emerald-600 text-white font-bold text-center inline-flex items-center gap-1 hover:bg-emerald-700 transition-colors shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>Setujui</span>
                                    </button>
                                </form>
                            @endif

                            @if($comment->status !== 'spam')
                                <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="spam">
                                    <button type="submit" class="py-1.5 px-3 rounded-lg border border-amber-300 text-amber-700 bg-amber-50 hover:bg-amber-100 font-bold text-center inline-flex items-center gap-1 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span>Spam</span>
                                    </button>
                                </form>
                            @endif

                            <button type="button" onclick="window.confirmDelete('{{ route('admin.comments.destroy', $comment->id) }}', 'Yakin ingin menghapus komentar dari {{ addslashes($comment->author_name) }}?')" class="py-1.5 px-3 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center gap-1 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center text-stone-400 text-sm">
                    Tidak ada komentar yang ditemukan.
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left font-sans text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                    <tr>
                        <th class="py-2.5 px-4">Pengirim</th>
                        <th class="py-2.5 px-4">Isi Komentar</th>
                        <th class="py-2.5 px-4">Pada Artikel</th>
                        <th class="py-2.5 px-4">Status</th>
                        <th class="py-2.5 px-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                @if($comment->user)
                                    <a href="{{ $comment->user->profile_url }}" target="_blank" class="font-bold text-stone-900 hover:text-forest transition-colors text-sm hover:underline block">
                                        {{ $comment->author_name }}
                                    </a>
                                @else
                                    <span class="font-bold text-stone-900 block text-sm">{{ $comment->author_name }}</span>
                                @endif
                                <span class="text-xs text-stone-400">{{ $comment->author_email ?: 'Tidak ada email' }}</span>
                            </td>
                            <td class="py-2.5 px-4 max-w-sm">
                                <p class="text-sm text-stone-700 leading-relaxed">{{ $comment->content }}</p>
                                <span class="text-sm text-stone-400 mt-0.5 block">{{ $comment->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                            </td>
                            <td class="py-2.5 px-4 max-w-xs">
                                <a href="{{ $comment->article ? $comment->article->url : '#' }}" target="_blank" class="text-sm text-forest hover:underline font-semibold block line-clamp-1">
                                    {{ $comment->article->title ?? 'Artikel' }}
                                </a>
                            </td>
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                @if($comment->status === 'approved')
                                    <span class="bg-green-100 text-green-800 text-sm font-bold px-2.5 py-0.5 rounded-full">Approved</span>
                                @elseif($comment->status === 'spam')
                                    <span class="bg-red-100 text-red-800 text-sm font-bold px-2.5 py-0.5 rounded-full">Spam</span>
                                @else
                                    <span class="bg-amber-100 text-amber-800 text-sm font-bold px-2.5 py-0.5 rounded-full">Pending</span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    @if($comment->status !== 'approved')

                                        <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" title="Setujui Komentar" class="p-1.5 text-forest hover:text-white hover:bg-forest border border-forest/20 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <span class="sr-only">Setujui</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if($comment->status !== 'spam')

                                        <form action="{{ route('admin.comments.status', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="spam">
                                            <button type="submit" title="Tandai Spam" class="p-1.5 text-amber-700 hover:text-white hover:bg-amber-600 border border-amber-300 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                <span class="sr-only">Spam</span>
                                            </button>
                                        </form>
                                    @endif

                                    <button type="button" onclick="window.confirmDelete('{{ route('admin.comments.destroy', $comment->id) }}', 'Yakin ingin menghapus komentar dari {{ addslashes($comment->author_name) }}?')" title="Hapus Komentar" class="p-1.5 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-stone-400 text-sm">
                                Tidak ada komentar yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-stone-100">
            {{ $comments->links() }}
        </div>
    </div>

</x-layouts.admin>
