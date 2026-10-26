<x-layouts.admin title="Laporan Konten - Admin SMAN 1 Malingping">

    <div class="mb-5">
        <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Laporan Konten</h1>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5 font-sans">
        <div class="bg-white p-3.5 rounded-xl border border-stone-200 shadow-2xs">
            <span class="text-xs text-stone-400 font-medium block">Total Laporan</span>
            <div class="text-xl font-bold text-stone-900 mt-0.5">{{ $totalCount }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-rose-200/80 shadow-2xs bg-rose-50/10">
            <div class="flex items-center justify-between">
                <span class="text-xs text-rose-700 font-bold block">Menunggu Tindakan</span>
                @if($pendingCount > 0)
                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                @endif
            </div>
            <div class="text-xl font-bold text-rose-700 mt-0.5">{{ $pendingCount }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-blue-200/80 shadow-2xs">
            <span class="text-xs text-blue-700 font-medium block">Sedang Ditinjau</span>
            <div class="text-xl font-bold text-blue-900 mt-0.5">{{ $reviewedCount }}</div>
        </div>

        <div class="bg-white p-3.5 rounded-xl border border-emerald-200/80 shadow-2xs">
            <span class="text-xs text-emerald-700 font-medium block">Telah Ditindaklanjuti</span>
            <div class="text-xl font-bold text-emerald-900 mt-0.5">{{ $resolvedCount }}</div>
        </div>
    </div>

    <div class="bg-white p-3.5 rounded-xl border border-stone-200 shadow-2xs mb-4 font-sans space-y-3">

        <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold">
            <a href="{{ route('admin.reports.index', array_filter(['reason' => $reason, 'q' => $search])) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ empty($status) ? 'bg-stone-900 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.reports.index', array_filter(['status' => 'pending', 'reason' => $reason, 'q' => $search])) }}" class="px-3 py-1.5 rounded-lg transition-colors inline-flex items-center gap-1.5 {{ ($status === 'pending') ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100' }}">
                <span>Menunggu</span>
                <span class="bg-white/20 text-current px-1.5 py-0.2 rounded-full text-[10px] font-bold">{{ $pendingCount }}</span>
            </a>
            <a href="{{ route('admin.reports.index', array_filter(['status' => 'reviewed', 'reason' => $reason, 'q' => $search])) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ ($status === 'reviewed') ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-800 border border-blue-200 hover:bg-blue-100' }}">
                Ditinjau ({{ $reviewedCount }})
            </a>
            <a href="{{ route('admin.reports.index', array_filter(['status' => 'resolved', 'reason' => $reason, 'q' => $search])) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ ($status === 'resolved') ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100' }}">
                Ditindaklanjuti ({{ $resolvedCount }})
            </a>
            <a href="{{ route('admin.reports.index', array_filter(['status' => 'dismissed', 'reason' => $reason, 'q' => $search])) }}" class="px-3 py-1.5 rounded-lg transition-colors {{ ($status === 'dismissed') ? 'bg-stone-700 text-white' : 'bg-stone-100 text-stone-600 border border-stone-200 hover:bg-stone-200' }}">
                Diabaikan ({{ $dismissedCount }})
            </a>
        </div>

        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-2.5 pt-1">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif

            <div class="md:col-span-4">
                <select name="reason" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 outline-none cursor-pointer">
                    <option value="">Semua Alasan Pelanggaran</option>
                    <option value="spam" {{ $reason === 'spam' ? 'selected' : '' }}>Spam / Iklan Tidak Relevan</option>
                    <option value="inappropriate" {{ $reason === 'inappropriate' ? 'selected' : '' }}>Konten Tidak Pantas / Asusila</option>
                    <option value="hate_speech" {{ $reason === 'hate_speech' ? 'selected' : '' }}>Ujaran Kebencian / SARA</option>
                    <option value="hoax" {{ $reason === 'hoax' ? 'selected' : '' }}>Informasi Palsu / Misinformasi</option>
                    <option value="plagiarism" {{ $reason === 'plagiarism' ? 'selected' : '' }}>Plagiarisme / Hak Cipta</option>
                    <option value="other" {{ $reason === 'other' ? 'selected' : '' }}>Pelanggaran Lainnya</option>
                </select>
            </div>

            <div class="md:col-span-8 flex gap-2">
                <div class="relative flex-1">
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari artikel, pelapor, atau rincian..." class="w-full pl-8 pr-3 py-2 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 outline-none">
                    <svg class="w-3.5 h-3.5 text-stone-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button type="submit" class="px-3.5 py-2 rounded-lg bg-forest text-white text-sm font-bold hover:bg-stone-900 transition-colors cursor-pointer flex-shrink-0">
                    Cari
                </button>
                @if($search || $reason || $status)
                    <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 rounded-lg border border-stone-200 bg-white text-stone-600 hover:bg-stone-50 text-sm font-semibold transition-colors flex-shrink-0 flex items-center gap-1" title="Reset Semua Filter">
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden font-sans" x-data="{ allOpenReports: false }">
        <div class="px-4 py-3 border-b border-stone-100 flex justify-between items-center bg-stone-50/70">
            <h2 class="font-serif text-base text-stone-900 font-bold">Daftar Laporan Masuk</h2>
            <div class="flex items-center gap-3">
                <span class="text-sm text-stone-500 font-semibold">{{ $reports->total() }} Laporan</span>
                @if($reports->isNotEmpty())
                    <button type="button" @click="allOpenReports = !allOpenReports; $dispatch('toggle-admin-reports', { open: allOpenReports })" class="md:hidden text-forest hover:text-stone-900 text-sm font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                        <span x-text="allOpenReports ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenReports ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                @endif
            </div>
        </div>

        <div class="md:hidden divide-y divide-stone-200">
            @forelse($reports as $report)
                @php
                    $reportData = [
                        'id' => $report->id,
                        'article_id' => $report->article_id,
                        'article_title' => $report->article->title ?? 'Artikel Dihapus',
                        'article_url' => $report->article ? $report->article->url : '#',
                        'article_status' => $report->article->status ?? '-',
                        'article_type' => $report->article?->type === 'suara_warga' ? 'Suara Warga' : 'Jurnal / Berita',
                        'author_name' => $report->article->user->name ?? 'Warga',
                        'reporter_name' => $report->effective_reporter_name,
                        'reporter_email' => $report->effective_reporter_email ?? 'Tidak ada email',
                        'reason' => $report->reason,
                        'reason_label' => $report->reason_label,
                        'details' => $report->details ?: 'Tidak ada keterangan tambahan.',
                        'status' => $report->status,
                        'status_label' => $report->status_badge['label'],
                        'admin_notes' => $report->admin_notes ?: '',
                        'reviewer_name' => $report->reviewer->name ?? null,
                        'reviewed_at' => $report->reviewed_at ? $report->reviewed_at->translatedFormat('d M Y, H:i') : null,
                        'created_at' => $report->created_at->translatedFormat('d M Y, H:i'),
                        'update_url' => route('admin.reports.status', $report),
                        'delete_url' => route('admin.reports.destroy', $report),
                    ];
                @endphp
                <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors {{ $report->status === 'pending' ? 'bg-amber-50/15' : '' }}" x-data="{ isOpen: false }" @toggle-admin-reports.window="isOpen = $event.detail.open">
                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                <span class="{{ $report->status_badge['class'] }} text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                                    {{ $report->status_badge['label'] }}
                                </span>
                                <span class="bg-rose-50 text-rose-700 border border-rose-200 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    🚩 {{ $report->reason_label }}
                                </span>
                            </div>

                            <a href="{{ $report->article ? $report->article->url : '#' }}" target="_blank" @click.stop class="font-bold text-stone-900 text-sm hover:text-forest transition-colors block leading-snug line-clamp-2">
                                "{{ $report->article->title ?? 'Artikel telah dihapus' }}"
                            </a>

                            <div class="flex items-center gap-2 text-sm text-stone-400 mt-1">
                                <span>Pelapor: <strong class="text-stone-700">{{ $report->effective_reporter_name }}</strong></span>
                                <span>&bull;</span>
                                <span>{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">

                        <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-100">
                            <span class="text-stone-400 block text-[11px] font-semibold mb-0.5">Catatan Pelapor:</span>
                            <p class="text-stone-700 leading-relaxed italic">
                                "{{ $report->details ?: 'Tidak ada keterangan tambahan.' }}"
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="p-2 rounded-lg bg-stone-50 border border-stone-100">
                                <span class="text-stone-400 block text-[11px]">Penulis Artikel</span>
                                <span class="font-semibold text-stone-700">{{ $report->article->user->name ?? 'Warga' }}</span>
                            </div>
                            <div class="p-2 rounded-lg bg-stone-50 border border-stone-100">
                                <span class="text-stone-400 block text-[11px]">Status Artikel</span>
                                <span class="font-bold text-[10px] {{ ($report->article->status ?? '') === 'published' ? 'text-emerald-700' : 'text-amber-700' }}">
                                    {{ $report->article->status ?? 'Dihapus' }}
                                </span>
                            </div>
                        </div>

                        @if($report->admin_notes)
                            <div class="p-2.5 rounded-lg bg-blue-50/50 border border-blue-100">
                                <span class="text-blue-600 block text-[11px] font-semibold mb-0.5">Catatan Moderator:</span>
                                <p class="text-stone-700 leading-relaxed">{{ $report->admin_notes }}</p>
                                @if($report->reviewer)
                                    <span class="text-[10px] text-stone-400 block mt-1">Oleh: {{ $report->reviewer->name }} ({{ $report->reviewed_at?->translatedFormat('d M Y, H:i') }})</span>
                                @endif
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-2 pt-1">
                            <button type="button" onclick='openReportModal(@json($reportData))' class="py-2 px-3 rounded-lg bg-forest text-white font-bold text-center inline-flex items-center justify-center gap-1.5 hover:bg-stone-900 transition-colors shadow-2xs cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Tindaklanjuti</span>
                            </button>

                            <button type="button" onclick="window.confirmDelete('{{ route('admin.reports.destroy', $report) }}', 'Yakin ingin menghapus data laporan ini?')" class="py-2 px-3 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus Laporan</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-stone-400 text-sm">
                    Tidak ada laporan artikel yang sesuai kriteria filter.
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                    <tr>
                        <th class="py-2.5 px-4">Artikel yang Dilaporkan</th>
                        <th class="py-2.5 px-4">Alasan & Rincian</th>
                        <th class="py-2.5 px-4">Pelapor</th>
                        <th class="py-2.5 px-4">Status</th>
                        <th class="py-2.5 px-4">Tanggal</th>
                        <th class="py-2.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($reports as $report)
                        @php
                            $reportData = [
                                'id' => $report->id,
                                'article_id' => $report->article_id,
                                'article_title' => $report->article->title ?? 'Artikel Dihapus',
                                'article_url' => $report->article ? $report->article->url : '#',
                                'article_status' => $report->article->status ?? '-',
                                'article_type' => $report->article?->type === 'suara_warga' ? 'Suara Warga' : 'Jurnal / Berita',
                                'author_name' => $report->article->user->name ?? 'Warga',
                                'reporter_name' => $report->effective_reporter_name,
                                'reporter_email' => $report->effective_reporter_email ?? 'Tidak ada email',
                                'reason' => $report->reason,
                                'reason_label' => $report->reason_label,
                                'details' => $report->details ?: 'Tidak ada keterangan tambahan.',
                                'status' => $report->status,
                                'status_label' => $report->status_badge['label'],
                                'admin_notes' => $report->admin_notes ?: '',
                                'reviewer_name' => $report->reviewer->name ?? null,
                                'reviewed_at' => $report->reviewed_at ? $report->reviewed_at->translatedFormat('d M Y, H:i') : null,
                                'created_at' => $report->created_at->translatedFormat('d M Y, H:i'),
                                'update_url' => route('admin.reports.status', $report),
                                'delete_url' => route('admin.reports.destroy', $report),
                            ];
                        @endphp
                        <tr class="hover:bg-stone-50/70 transition-colors {{ $report->status === 'pending' ? 'bg-amber-50/15' : '' }}">
                            <td class="py-2.5 px-4 max-w-xs">
                                <a href="{{ $report->article ? $report->article->url : '#' }}" target="_blank" class="font-bold text-stone-900 block text-sm hover:text-forest transition-colors line-clamp-2 leading-snug">
                                    {{ $report->article->title ?? 'Artikel telah dihapus' }}
                                </a>
                                <div class="flex items-center gap-1.5 text-sm text-stone-400 mt-1">
                                    <span>Penulis: {{ $report->article->user->name ?? 'Warga' }}</span>
                                    <span>&bull;</span>
                                    <span class="text-[10px] font-bold text-stone-500">{{ $report->article->type ?? '-' }}</span>
                                </div>
                            </td>

                            <td class="py-2.5 px-4 max-w-xs">
                                <span class="bg-rose-50 text-rose-700 border border-rose-200 text-sm font-bold px-2 py-0.5 rounded-full inline-block mb-1">
                                    🚩 {{ $report->reason_label }}
                                </span>
                                @if($report->details)
                                    <p class="text-sm text-stone-600 line-clamp-2 italic leading-relaxed">
                                        "{{ $report->details }}"
                                    </p>
                                @endif
                            </td>

                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-stone-800">{{ $report->effective_reporter_name }}</div>
                                <span class="text-sm text-stone-400 font-mono">{{ $report->effective_reporter_email ?: '-' }}</span>
                            </td>

                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="{{ $report->status_badge['class'] }} text-sm font-bold px-2.5 py-0.5 rounded-full uppercase">
                                    {{ $report->status_badge['label'] }}
                                </span>
                            </td>

                            <td class="py-2.5 px-4 whitespace-nowrap text-sm text-stone-500">
                                <span class="block text-stone-700 font-medium">{{ $report->created_at->translatedFormat('d M Y') }}</span>
                                <span class="text-stone-400">{{ $report->created_at->translatedFormat('H:i') }} ({{ $report->created_at->diffForHumans() }})</span>
                            </td>

                            <td class="py-2.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    @if($report->article)

                                        <a href="{{ $report->article->url }}" target="_blank" title="Lihat Artikel" class="p-1.5 text-stone-500 hover:text-stone-900 hover:bg-stone-100 border border-stone-200 rounded-lg transition-colors inline-flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span class="sr-only">Lihat</span>
                                        </a>
                                    @endif

                                    <button type="button" onclick='openReportModal(@json($reportData))' title="Tinjau & Tindaklanjuti Laporan" class="p-1.5 text-forest hover:text-white hover:bg-forest border border-forest/20 rounded-lg transition-colors cursor-pointer inline-flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span class="sr-only">Tindaklanjuti</span>
                                    </button>

                                    <button type="button" onclick="window.confirmDelete('{{ route('admin.reports.destroy', $report) }}', 'Yakin ingin menghapus data laporan ini?')" title="Hapus Laporan" class="p-1.5 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 rounded-lg transition-colors cursor-pointer inline-flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-stone-400 text-sm">
                                Tidak ada laporan artikel yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-stone-100">
            {{ $reports->links() }}
        </div>
    </div>

    <div id="report_modal" class="fixed inset-0 z-[400] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 font-sans p-4">
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm" onclick="closeReportModal()"></div>
        <div class="bg-white rounded-2xl p-5 max-w-lg w-full relative z-10 shadow-xl transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">

            <div class="flex items-start justify-between pb-3.5 border-b border-stone-100 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                    </div>
                    <div>
                        <h3 class="font-serif text-lg font-bold text-stone-900 leading-tight">Tindaklanjuti Laporan</h3>
                        <p id="modal_report_created_at" class="text-sm text-stone-400">Tanggal laporan</p>
                    </div>
                </div>
                <button type="button" onclick="closeReportModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-3.5 text-sm mb-5">
                <div class="p-3 bg-stone-50 rounded-xl border border-stone-200/80">
                    <span class="text-[10px] font-bold text-stone-400 block tracking-wider mb-1">Artikel Dilaporkan:</span>
                    <a id="modal_article_link" href="#" target="_blank" class="font-bold text-stone-900 text-sm hover:text-forest transition-colors block leading-snug">
                        -
                    </a>
                    <div class="flex items-center gap-2 mt-1.5 text-stone-500">
                        <span>Penulis: <strong id="modal_article_author" class="text-stone-800">-</strong></span>
                        <span>&bull;</span>
                        <span id="modal_article_type" class="font-semibold text-[10px] bg-stone-200/60 px-1.5 py-0.5 rounded">-</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 block text-[11px]">Alasan Pelaporan</span>
                        <span id="modal_report_reason" class="font-bold text-rose-700">-</span>
                    </div>
                    <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-100">
                        <span class="text-stone-400 block text-[11px]">Pelapor</span>
                        <span id="modal_reporter_info" class="font-bold text-stone-800">-</span>
                    </div>
                </div>

                <div class="p-2.5 rounded-lg bg-stone-50 border border-stone-100">
                    <span class="text-stone-400 block text-[11px] font-semibold mb-0.5">Catatan Pelapor:</span>
                    <p id="modal_report_details" class="text-stone-700 italic leading-relaxed">-</p>
                </div>
            </div>

            <form id="report_update_form" action="" method="POST" class="space-y-3.5 pt-3 border-t border-stone-100 text-sm font-sans">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block font-bold text-stone-800 mb-1">Ubah Status Laporan <span class="text-rose-500">*</span></label>
                    <select id="modal_select_status" name="status" required class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 focus:bg-white outline-none">
                        <option value="pending">Menunggu Tindakan</option>
                        <option value="reviewed">Sedang Ditinjau</option>
                        <option value="resolved">Ditindaklanjuti (Selesai)</option>
                        <option value="dismissed">Diabaikan (Laporan Tidak Valid)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-stone-800 mb-1">Tindakan Pada Artikel (Opsional)</label>
                    <select name="article_action" class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 focus:bg-white outline-none">
                        <option value="none">Tidak Ada Tindakan Pada Artikel</option>
                        <option value="unpublish">Tarik Artikel ke Draft (Sembunyikan dari Publik)</option>
                        <option value="delete">Hapus Artikel Permanen</option>
                    </select>
                    <span class="text-[11px] text-stone-400 mt-1 block">Pilih "Tarik Artikel ke Draft" jika artikel terbukti melanggar dan perlu disembunyikan.</span>
                </div>

                <div>
                    <label class="block font-bold text-stone-800 mb-1">Catatan Moderator / Pengelola</label>
                    <textarea id="modal_admin_notes" name="admin_notes" rows="2" placeholder="Tulis catatan tindakan moderasi..." class="w-full px-3 py-2 rounded-xl border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 focus:bg-white outline-none resize-none"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeReportModal()" class="px-4 py-2 rounded-xl border border-stone-200 text-stone-600 hover:bg-stone-50 font-bold text-sm transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-forest hover:bg-stone-900 text-white font-bold text-sm transition-colors shadow-xs cursor-pointer">
                        Simpan Tindakan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReportModal(data) {
            const modal = document.getElementById('report_modal');
            const form = document.getElementById('report_update_form');

            form.action = data.update_url;
            document.getElementById('modal_article_link').href = data.article_url;
            document.getElementById('modal_article_link').textContent = `"${data.article_title}"`;
            document.getElementById('modal_article_author').textContent = data.author_name;
            document.getElementById('modal_article_type').textContent = data.article_type;
            document.getElementById('modal_report_reason').textContent = data.reason_label;
            document.getElementById('modal_reporter_info').textContent = `${data.reporter_name} (${data.reporter_email})`;
            document.getElementById('modal_report_details').textContent = data.details;
            document.getElementById('modal_report_created_at').textContent = data.created_at;
            document.getElementById('modal_select_status').value = data.status;
            document.getElementById('modal_admin_notes').value = data.admin_notes || '';

            modal.classList.remove('opacity-0', 'pointer-events-none');
            const modalBox = modal.querySelector('div:nth-child(2)');
            if (modalBox) {
                modalBox.classList.remove('scale-95');
                modalBox.classList.add('scale-100');
            }
        }

        function closeReportModal() {
            const modal = document.getElementById('report_modal');
            modal.classList.add('opacity-0', 'pointer-events-none');
            const modalBox = modal.querySelector('div:nth-child(2)');
            if (modalBox) {
                modalBox.classList.remove('scale-100');
                modalBox.classList.add('scale-95');
            }
        }
    </script>
</x-layouts.admin>
