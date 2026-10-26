<x-layouts.admin title="Tambah Agenda Baru - Admin SMAN 1 Malingping">

    <div class="mb-4 sm:mb-5">
        <h1 class="font-serif text-2xl text-stone-900 font-bold">Tambah Agenda</h1>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-sm text-red-600 font-sans max-w-xl">
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.agendas.store') }}" method="POST" class="bg-transparent sm:bg-white rounded-none sm:rounded-xl border-0 sm:border sm:border-stone-200 shadow-none sm:shadow-2xs p-0 sm:p-5 w-full space-y-4 font-sans">
        @csrf

        <div>
            <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">Nama Acara / Kegiatan <span class="text-terracotta">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Pekan Olahraga dan Seni (Porseni)" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-white">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">Tanggal Kegiatan <span class="text-terracotta">*</span></label>
                <input type="date" name="event_date" value="{{ old('event_date') }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-white">
            </div>

            <div>
                <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">Waktu Pelaksanaan</label>
                <input type="text" name="time_info" value="{{ old('time_info') }}" placeholder="Contoh: 08:00 - 14:00 WIB" class="w-full px-3.5 py-2.5 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-white">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">Lokasi / Tempat <span class="text-terracotta">*</span></label>
            <input type="text" name="location" value="{{ old('location', 'Kampus SMAN 1 Malingping') }}" required class="w-full px-3.5 py-2.5 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-white">
        </div>

        <div>
            <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">Deskripsi Lengkap Acara <span class="text-terracotta">*</span></label>
            <textarea name="description" rows="3" required placeholder="Jelaskan rincian agenda dan informasi penting lainnya..." class="w-full px-3.5 py-2.5 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-white resize-none">{{ old('description') }}</textarea>
        </div>

        <div class="flex items-center gap-2 pt-1">
            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-stone-300 text-forest focus:ring-forest w-4 h-4">
            <label for="is_active" class="font-sans text-sm font-bold text-stone-700">Tampilkan pada Kalender Beranda</label>
        </div>

        <div class="pt-3 border-t border-stone-200 sm:border-stone-100 flex justify-end gap-2.5">
            <a href="{{ route('admin.agendas.index') }}" class="px-4 py-2 rounded-xl border border-stone-300 text-stone-600 text-sm font-bold uppercase tracking-wider hover:bg-stone-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="bg-forest text-white px-5 py-2 rounded-xl text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-xs">
                Simpan
            </button>
        </div>
    </form>

</x-layouts.admin>
