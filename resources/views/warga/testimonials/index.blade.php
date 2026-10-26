<x-layouts.warga title="Testimoni Saya - Dasbor Warga" headerTitle="Testimoni Alumni">

    @php
        $hasTestimonial = $testimonials->isNotEmpty() || auth()->user()->testimonials()->exists();
    @endphp

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3.5 mb-5">
        <div>
            <h1 class="font-serif text-2xl font-bold text-stone-900">Testimoni Alumni</h1>
        </div>

        @if(!$hasTestimonial)
            <a href="{{ route('warga.testimonials.create') }}" class="bg-forest text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-stone-900 transition-colors shadow-2xs inline-flex items-center gap-2 flex-shrink-0 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tulis Testimoni Baru</span>
            </a>
        @else
            <span class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-stone-100 text-stone-600 text-xs font-semibold border border-stone-200">
                <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>Kuota 1 Testimoni Terpenuhi (Terkunci)</span>
            </span>
        @endif
    </div>

    <div class="mb-4 p-3.5 rounded-xl bg-stone-100 border border-stone-200/80 flex items-start gap-2.5 text-xs text-stone-700 leading-relaxed">
        <svg class="w-4 h-4 text-stone-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <span class="font-bold text-stone-900">Ketentuan Testimoni:</span> Setiap alumni hanya dapat mengirimkan <strong>1 kali testimoni</strong>. Testimoni yang telah diajukan bersifat permanen/terkunci dan tidak dapat diedit atau dihapus oleh alumni.
        </div>
    </div>

    <div class="bg-white border border-stone-200 rounded-xl shadow-2xs overflow-hidden mb-6">
        <div class="divide-y divide-stone-100">
            @forelse($testimonials as $testi)
                <div class="p-4 sm:p-5 hover:bg-stone-50/70 transition-colors flex flex-col sm:flex-row items-start justify-between gap-4">
                    <div class="flex items-start gap-3.5 max-w-3xl">
                        <img src="{{ $testi->avatar_url }}" alt="{{ $testi->name }}" class="w-10 h-10 rounded-full object-cover border border-stone-200 flex-shrink-0 mt-0.5">
                        <div>
                            <div class="flex items-center gap-2.5 mb-1.5">
                                <h4 class="font-bold text-sm text-stone-900">{{ $testi->name }}</h4>
                                <span class="text-sm text-stone-500">&bull; {{ $testi->role_subtitle }}</span>
                            </div>

                            @if($testi->rejection_reason)
                                <div class="mb-3 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800">
                                    <div class="flex items-center gap-1.5 font-bold text-rose-900 mb-1">
                                        <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span>Catatan Redaksi:</span>
                                    </div>
                                    <p class="leading-relaxed pl-5">{{ $testi->rejection_reason }}</p>
                                </div>
                            @endif

                            <div class="flex flex-wrap items-center gap-2 text-sm">
                                @if($testi->is_approved || $testi->status === 'approved')
                                    <span class="inline-flex items-center gap-1 text-forest font-semibold bg-forest/10 px-2.5 py-0.5 rounded-md text-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Ditayangkan di Beranda
                                    </span>
                                @elseif($testi->status === 'rejected' || !empty($testi->rejection_reason))
                                    <span class="inline-flex items-center gap-1 text-rose-800 font-semibold bg-rose-100 px-2.5 py-0.5 rounded-md text-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Ditolak Redaksi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-amber-800 font-semibold bg-amber-100 px-2.5 py-0.5 rounded-md text-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Menunggu Kurasi Redaksi
                                    </span>
                                @endif
                                <span class="text-stone-400">&bull; Diajukan: {{ $testi->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:self-center flex-shrink-0">
                        <button type="button"
                            onclick="openViewTestimonialModalFromEl(this)"
                            data-name="{{ $testi->name }}"
                            data-role="{{ $testi->role_subtitle }}"
                            data-avatar="{{ $testi->avatar_url }}"
                            data-content="{{ $testi->content }}"
                            data-rejection="{{ $testi->rejection_reason ?? '' }}"
                            data-status-label="{{ ($testi->is_approved || $testi->status === 'approved') ? 'Ditayangkan di Beranda' : (($testi->status === 'rejected' || !empty($testi->rejection_reason)) ? 'Ditolak Redaksi' : 'Menunggu Kurasi Redaksi') }}"
                            data-status-class="{{ ($testi->is_approved || $testi->status === 'approved') ? 'text-forest bg-forest/10 border border-forest/20' : (($testi->status === 'rejected' || !empty($testi->rejection_reason)) ? 'text-rose-800 bg-rose-100 border border-rose-200' : 'text-amber-800 bg-amber-100 border border-amber-200') }}"
                            data-date="{{ $testi->created_at->translatedFormat('d F Y') }}"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-forest text-white hover:bg-stone-900 text-xs font-bold transition-colors shadow-2xs cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Lihat Isi</span>
                        </button>

                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-stone-100 text-stone-600 text-xs font-semibold border border-stone-200" title="Testimoni telah terkunci dan tidak dapat diedit atau dihapus oleh alumni">
                            <svg class="w-3.5 h-3.5 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span>Terkunci</span>
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-stone-400 text-sm">
                    <svg class="w-10 h-10 text-stone-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <p class="font-semibold text-stone-600">Belum ada testimoni.</p>
                    <p class="text-sm text-stone-400 mt-0.5">Tuliskan kesan dan pesan berharga Anda untuk adik-adik kelas dan almamater.</p>
                </div>
            @endforelse
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
                    <span>Catatan Redaksi:</span>
                </div>
                <p id="view-testi-rejection" class="leading-relaxed pl-5"></p>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-stone-100 font-sans">
                <button type="button" onclick="closeViewTestimonialModal()" class="px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 text-xs sm:text-sm font-semibold transition-colors cursor-pointer">
                    Tutup
                </button>
            </div>
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
            document.getElementById('view-testi-date').innerText = 'Diajukan: ' + data.date;

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
    </script>
    @endpush

</x-layouts.warga>
