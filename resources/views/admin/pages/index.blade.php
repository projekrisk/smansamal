<x-layouts.admin title="Manajemen Halaman - Dasbor Pengelola" headerTitle="Halaman Statis">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3.5 mb-5 font-sans">
        <div>
            <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Manajemen Halaman</h1>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center gap-2 bg-forest text-white px-4 py-2.5 rounded-xl text-sm sm:text-sm font-bold hover:bg-stone-900 transition-colors shadow-2xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Halaman Baru</span>
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5 font-sans">
        <div class="bg-white p-3.5 rounded-xl border border-stone-200 shadow-2xs">
            <span class="text-xs text-stone-400 font-medium block">Total Halaman</span>
            <div class="text-xl font-bold text-stone-900 mt-0.5">{{ number_format($totalCount) }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-emerald-200/80 shadow-2xs bg-emerald-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs text-emerald-700 font-bold block">Halaman Aktif</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <div class="text-xl font-bold text-emerald-900 mt-0.5">{{ number_format($activeCount) }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-amber-200/80 shadow-2xs bg-amber-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs text-amber-700 font-bold block">Draf / Nonaktif</span>
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <div class="text-xl font-bold text-amber-900 mt-0.5">{{ number_format($draftCount) }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-blue-200/80 shadow-2xs bg-blue-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs text-blue-700 font-bold block">Halaman Sistem</span>
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            </div>
            <div class="text-xl font-bold text-blue-900 mt-0.5">{{ number_format($systemCount) }}</div>
        </div>
    </div>

    <div class="bg-white p-2.5 sm:p-3 rounded-xl border border-stone-200 shadow-2xs mb-4 flex flex-col md:flex-row gap-2.5 items-center justify-between font-sans">
        <div class="flex flex-wrap gap-1.5 text-xs xs:text-xs font-semibold w-full md:w-auto">
            <a href="{{ route('admin.pages.index', array_filter(['q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ empty($status) ? 'bg-forest text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.pages.index', array_filter(['status' => 'active', 'q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'active') ? 'bg-emerald-600 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Aktif ({{ $activeCount }})
            </a>
            <a href="{{ route('admin.pages.index', array_filter(['status' => 'draft', 'q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'draft') ? 'bg-amber-500 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Draf ({{ $draftCount }})
            </a>
            <a href="{{ route('admin.pages.index', array_filter(['status' => 'system', 'q' => $search])) }}" class="px-3.5 py-1.5 rounded-lg transition-colors {{ ($status === 'system') ? 'bg-blue-600 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Sistem ({{ $systemCount }})
            </a>
        </div>

        <form action="{{ route('admin.pages.index') }}" method="GET" class="w-full md:w-72">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul atau URL slug..." class="w-full pl-9 pr-8 py-2 rounded-lg border border-stone-200 text-sm sm:text-sm focus:border-forest focus:ring-forest bg-stone-50/50">
                <svg class="w-4 h-4 text-stone-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                @if($search)
                    <a href="{{ route('admin.pages.index', array_filter(['status' => $status])) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600" title="Hapus pencarian">&times;</a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden font-sans">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-sm font-bold text-stone-600 tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Judul Halaman & Slug</th>
                        <th class="py-3 px-4">Tipe</th>
                        <th class="py-3 px-4 text-center">Dibaca</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4">Terakhir Diperbarui</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($pages as $page)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-stone-900 mb-0.5 text-sm sm:text-base">
                                    {{ $page->title }}
                                </div>
                                <div class="flex items-center gap-1.5 text-sm text-stone-500 font-mono">
                                    <span class="text-stone-400">URL:</span>
                                    <span class="text-forest underline">{{ $page->public_url }}</span>
                                </div>
                                @if($page->meta_description)
                                    <p class="text-sm text-stone-500 line-clamp-1 mt-1 max-w-lg">{{ $page->meta_description }}</p>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($page->is_system)
                                    <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-sm font-bold px-2.5 py-0.5 rounded-full border border-blue-200/60">
                                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        Sistem Bawaan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-stone-100 text-stone-700 text-sm font-semibold px-2.5 py-0.5 rounded-full border border-stone-200">
                                        Kustom
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 text-sm font-medium text-stone-600">
                                    <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    {{ number_format($page->views_count) }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('admin.pages.toggle-status', $page->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 text-sm font-bold px-2.5 py-1 rounded-full cursor-pointer transition-colors {{ $page->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-amber-100 text-amber-800 hover:bg-amber-200' }}" title="Klik untuk mengubah status">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $page->is_active ? 'bg-emerald-600' : 'bg-amber-600' }}"></span>
                                        <span>{{ $page->is_active ? 'Aktif' : 'Draf' }}</span>
                                    </button>
                                </form>
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap text-sm text-stone-500">
                                <div>{{ $page->updated_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[11px] text-stone-400">{{ $page->updated_at->format('H:i') }} WIB</div>
                            </td>

                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ $page->public_url }}" target="_blank" class="p-2 text-stone-400 hover:text-stone-700 hover:bg-stone-100 rounded-lg transition-colors" title="Lihat Halaman Langsung">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>

                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="p-2 text-forest hover:bg-forest/10 rounded-lg transition-colors font-bold" title="Edit Halaman">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    @if(!$page->is_system)
                                        <button type="button" onclick="window.confirmDelete('{{ route('admin.pages.destroy', $page->id) }}', 'Yakin ingin menghapus halaman \'{{ addslashes($page->title) }}\'? Tautan halaman ini tidak akan dapat diakses kembali.')" class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer" title="Hapus Halaman">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    @else
                                        <span class="p-2 text-stone-300 cursor-not-allowed" title="Halaman sistem bawaan dilindungi dari penghapusan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-stone-500">
                                <svg class="w-12 h-12 text-stone-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="font-medium text-stone-700">Tidak ada halaman yang ditemukan.</p>
                                <p class="text-sm text-stone-400 mt-1">Coba sesuaikan kata kunci pencarian atau buat halaman statis baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pages->hasPages())
            <div class="p-4 border-t border-stone-200">
                {{ $pages->links() }}
            </div>
        @endif
    </div>

</x-layouts.admin>
