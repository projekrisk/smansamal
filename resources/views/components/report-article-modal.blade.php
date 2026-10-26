@props(['article'])

<div x-data="{
    menuOpen: false,
    reportOpen: false,
    submitting: false,
    successMessage: '',
    errorMessage: '',
    reason: 'spam',
    details: '',
    reporter_name: '',
    reporter_email: '',
    resetForm() {
        this.reason = 'spam';
        this.details = '';
        this.reporter_name = '';
        this.reporter_email = '';
        this.errorMessage = '';
        this.successMessage = '';
    },
    async submitReport(event) {
        event.preventDefault();
        this.submitting = true;
        this.errorMessage = '';
        this.successMessage = '';

        try {
            const formData = new FormData(event.target);
            const response = await fetch('{{ route('articles.report', $article->id) }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                this.successMessage = data.message || 'Laporan berhasil dikirim. Tim redaksi akan segera meninjau konten ini.';
                setTimeout(() => {
                    this.reportOpen = false;
                    this.resetForm();
                }, 2000);
            } else {
                this.errorMessage = data.message || 'Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.';
            }
        } catch (error) {
            this.errorMessage = 'Gagal menghubungi server. Periksa koneksi internet Anda.';
        } finally {
            this.submitting = false;
        }
    }
}"
@open-report-modal.window="reportOpen = true; menuOpen = false"
class="relative inline-block font-sans">

    <div @click.outside="menuOpen = false" class="relative">
        <button
            type="button"
            @click="menuOpen = !menuOpen"
            class="w-9 h-9 md:w-10 md:h-10 rounded-full border border-stone-200 flex items-center justify-center text-stone-600 hover:bg-stone-100 hover:text-stone-900 transition-colors focus:outline-none cursor-pointer"
            title="Opsi Lainnya"
            aria-label="Opsi Lainnya"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/></svg>
        </button>

        <div
            x-show="menuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-stone-200/90 py-1.5 z-40 text-xs font-sans overflow-hidden"
        >
            <button
                type="button"
                onclick="copyCurrentUrl('Tautan artikel berhasil disalin!');"
                @click="menuOpen = false"
                class="w-full px-4 py-2.5 text-left text-stone-700 hover:bg-stone-50 hover:text-forest flex items-center gap-2.5 transition-colors cursor-pointer"
            >
                <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <span>Salin Tautan Artikel</span>
            </button>

            <div class="h-px bg-stone-100 my-1"></div>

            <button
                type="button"
                @click="menuOpen = false; reportOpen = true"
                class="w-full px-4 py-2.5 text-left text-rose-600 hover:bg-rose-50 flex items-center gap-2.5 transition-colors cursor-pointer font-bold"
            >
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                <span>Laporkan Artikel</span>
            </button>
        </div>
    </div>

    <template x-teleport="body">
        <div
            x-show="reportOpen"
            x-cloak
            class="fixed inset-0 z-[999999] overflow-y-auto"
            role="dialog"
            aria-modal="true"
            aria-labelledby="report-modal-title"
            @keydown.escape.window="reportOpen = false"
            style="display: none;"
        >

            <div
                x-show="reportOpen"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="reportOpen = false"
                class="fixed inset-0 bg-stone-900/60 backdrop-blur-xs transition-opacity"
                aria-hidden="true"
            ></div>

            <div class="fixed inset-0 z-10 flex min-h-full items-center justify-center p-4 text-center pointer-events-none">

                <div
                    x-show="reportOpen"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                    @click.stop
                    class="relative w-full max-w-md transform overflow-hidden rounded-2xl sm:rounded-3xl bg-white text-left shadow-2xl border border-stone-200 transition-all pointer-events-auto flex flex-col font-sans my-auto"
                >

                <div class="px-5 py-4 border-b border-stone-100 flex items-center justify-between bg-stone-50/70">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                        </div>
                        <div>
                            <h3 id="report-modal-title" class="font-serif font-bold text-stone-900 text-base leading-snug">Laporkan Artikel</h3>
                            <p class="text-[11px] text-stone-500 font-sans truncate max-w-[240px] sm:max-w-[280px]">
                                {{ $article->title }}
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="reportOpen = false"
                        class="w-8 h-8 rounded-full text-stone-400 hover:text-stone-700 hover:bg-stone-200/60 flex items-center justify-center transition-colors cursor-pointer"
                        title="Tutup (ESC)"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form @submit="submitReport" class="flex flex-col">
                    @csrf

                    <div class="p-5 space-y-3.5 max-h-[70vh] overflow-y-auto">

                        <div x-show="successMessage" x-cloak class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="successMessage" class="font-medium"></span>
                        </div>

                        <div x-show="errorMessage" x-cloak class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-xs flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span x-text="errorMessage" class="font-medium"></span>
                        </div>

                        <div>
                            <label for="report-reason-{{ $article->id }}" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                                Alasan Pelanggaran <span class="text-rose-500">*</span>
                            </label>
                            <select
                                id="report-reason-{{ $article->id }}"
                                name="reason"
                                x-model="reason"
                                required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-stone-200 text-stone-800 text-xs sm:text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-stone-50/50 cursor-pointer"
                            >
                                <option value="spam">Spam atau Promosi Tidak Relevan</option>
                                <option value="inappropriate">Konten Asusila / Tidak Pantas</option>
                                <option value="hate_speech">Ujaran Kebencian / SARA</option>
                                <option value="misinformation">Informasi Palsu / Hoaks</option>
                                <option value="copyright">Plagiarisme / Pelanggaran Hak Cipta</option>
                                <option value="other">Pelanggaran Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label for="report-details-{{ $article->id }}" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                                Keterangan Singkat <span class="text-stone-400 font-normal lowercase">(opsional)</span>
                            </label>
                            <textarea
                                id="report-details-{{ $article->id }}"
                                name="details"
                                x-model="details"
                                rows="2"
                                maxlength="500"
                                placeholder="Jelaskan secara singkat bagian yang melanggar ketentuan..."
                                class="w-full px-3.5 py-2 rounded-xl border border-stone-200 text-stone-800 text-xs sm:text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-stone-50/50 resize-none leading-relaxed"
                            ></textarea>
                        </div>

                        @guest
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 border-t border-stone-100">
                                <div>
                                    <label class="block text-[11px] font-semibold text-stone-600 mb-1">Nama Anda (opsional)</label>
                                    <input
                                        type="text"
                                        name="reporter_name"
                                        x-model="reporter_name"
                                        placeholder="Nama pelapor"
                                        class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-xs focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-white"
                                    >
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-stone-600 mb-1">Email Anda (opsional)</label>
                                    <input
                                        type="email"
                                        name="reporter_email"
                                        x-model="reporter_email"
                                        placeholder="email@contoh.com"
                                        class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-xs focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-white"
                                    >
                                </div>
                            </div>
                        @else
                            <div class="pt-1 text-[11px] text-stone-400 font-sans flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Melapor sebagai: <strong class="text-stone-700 font-medium">{{ auth()->user()->name }}</strong></span>
                            </div>
                        @endguest
                    </div>

                    <div class="px-5 py-3.5 bg-stone-50 border-t border-stone-100 flex items-center justify-end gap-2.5">
                        <button
                            type="button"
                            @click="reportOpen = false"
                            :disabled="submitting"
                            class="px-3.5 py-2 rounded-xl text-xs font-semibold text-stone-600 hover:text-stone-900 hover:bg-stone-200/50 transition-colors cursor-pointer"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            :disabled="submitting"
                            class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 disabled:opacity-50 text-white font-bold text-xs shadow-xs transition-colors inline-flex items-center gap-2 cursor-pointer"
                        >
                            <svg x-show="submitting" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                            <span x-text="submitting ? 'Mengirim...' : 'Kirim Laporan'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
</div>
