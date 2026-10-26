<x-layouts.admin title="Kelola Kategori Artikel - Admin SMAN 1 Malingping" headerTitle="Manajemen Kategori">

    <div class="mb-5">
        <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Kategori Artikel</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <div class="bg-white rounded-xl border border-stone-200 shadow-2xs p-4 sm:p-5 h-fit">
            <h2 class="font-serif text-base text-stone-900 font-bold mb-3.5 pb-2.5 border-b border-stone-100 flex items-center gap-2">
                <svg class="w-4 h-4 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Kategori Baru
            </h2>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-3.5 font-sans">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Nama Kategori <span class="text-terracotta">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Riset & Sains" class="w-full px-3.5 py-2 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 focus:bg-white">
                </div>

                <div x-data="{ selectedType: '{{ old('type', 'both') }}' }">
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Tipe Publikasi <span class="text-terracotta">*</span>
                    </label>
                    <input type="hidden" name="type" :value="selectedType">

                    <div class="space-y-1.5">
                        <label @click="selectedType = 'both'" class="flex items-center gap-2.5 p-2.5 rounded-lg border cursor-pointer transition-all"
                               :class="selectedType === 'both' ? 'border-forest bg-forest/5 ring-1 ring-forest' : 'border-stone-200 hover:border-stone-300 bg-white'">
                            <input type="radio" value="both" x-model="selectedType" class="text-forest focus:ring-forest">
                            <span class="text-sm font-bold text-stone-800">Keduanya (Jurnal & Warga)</span>
                        </label>

                        <label @click="selectedType = 'jurnal'" class="flex items-center gap-2.5 p-2.5 rounded-lg border cursor-pointer transition-all"
                               :class="selectedType === 'jurnal' ? 'border-forest bg-forest/5 ring-1 ring-forest' : 'border-stone-200 hover:border-stone-300 bg-white'">
                            <input type="radio" value="jurnal" x-model="selectedType" class="text-forest focus:ring-forest">
                            <span class="text-sm font-bold text-stone-800">Khusus Jurnal Sekolah</span>
                        </label>

                        <label @click="selectedType = 'suara_warga'" class="flex items-center gap-2.5 p-2.5 rounded-lg border cursor-pointer transition-all"
                               :class="selectedType === 'suara_warga' ? 'border-terracotta bg-terracotta/5 ring-1 ring-terracotta' : 'border-stone-200 hover:border-stone-300 bg-white'">
                            <input type="radio" value="suara_warga" x-model="selectedType" class="text-terracotta focus:ring-terracotta">
                            <span class="text-sm font-bold text-stone-800">Khusus Suara Warga</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Warna Label
                    </label>
                    <div class="flex items-center gap-2.5">
                        <input type="color" name="color" value="{{ old('color', '#2A5C43') }}" class="w-9 h-9 p-0.5 rounded-lg border border-stone-200 cursor-pointer">
                        <span class="text-sm text-stone-500 font-mono">Pilih warna label</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="description" rows="2" placeholder="Keterangan singkat kategori..." class="w-full px-3.5 py-2 rounded-lg border border-stone-200 text-sm focus:border-forest focus:ring-1 focus:ring-forest bg-stone-50 focus:bg-white resize-none">{{ old('description') }}</textarea>
                </div>

                <div class="pt-1">
                    <button type="submit" class="w-full bg-forest text-white py-2.5 rounded-xl text-sm font-bold tracking-wider hover:bg-stone-900 transition-colors shadow-xs flex items-center justify-center gap-1.5">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden h-fit font-sans" x-data="{ allOpenCats: false }">
            <div class="px-4 py-3 border-b border-stone-100 flex justify-between items-center bg-stone-50/70">
                <h2 class="font-serif text-base text-stone-900 font-bold">Kategori Aktif</h2>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-stone-500 font-semibold">{{ $categories->total() }} Kategori</span>
                    @if($categories->isNotEmpty())
                        <button type="button" @click="allOpenCats = !allOpenCats; $dispatch('toggle-admin-cats', { open: allOpenCats })" class="md:hidden text-forest hover:text-stone-900 text-xs font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                            <span x-text="allOpenCats ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenCats ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    @endif
                </div>
            </div>

            <div class="md:hidden divide-y divide-stone-200">
                @forelse($categories as $cat)
                    <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors" x-data="{ isOpen: false }" @toggle-admin-cats.window="isOpen = $event.detail.open">
                        <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $cat->color ?: '#2A5C43' }};"></span>
                                    <span class="font-bold text-stone-900 text-sm truncate">{{ $cat->name }}</span>

                                    @if($cat->type === 'jurnal')
                                        <span class="bg-forest/10 text-forest text-[10px] font-bold px-1.5 py-0.2 rounded">Jurnal</span>
                                    @elseif($cat->type === 'suara_warga')
                                        <span class="bg-terracotta/10 text-terracotta text-[10px] font-bold px-1.5 py-0.2 rounded">Warga</span>
                                    @else
                                        <span class="bg-stone-100 text-stone-700 text-[10px] font-bold px-1.5 py-0.2 rounded">Semua</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 text-xs text-stone-400">
                                    <span class="font-mono text-stone-400">/{{ $cat->slug }}</span>
                                    <span>&bull;</span>
                                    <span class="text-stone-600 font-medium">{{ $cat->articles_count }} artikel</span>
                                </div>
                            </div>

                            <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </button>

                        <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">
                            @if($cat->description)
                                <p class="text-stone-600 bg-stone-50 p-2.5 rounded-lg border border-stone-100 leading-relaxed italic">
                                    {{ $cat->description }}
                                </p>
                            @else
                                <p class="text-stone-400 italic">Tidak ada deskripsi kategori.</p>
                            @endif

                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <button type="button" onclick='openEditCategoryModal(@json($cat))' class="py-2 px-3 rounded-lg bg-forest text-white font-bold text-center inline-flex items-center justify-center gap-1.5 hover:bg-stone-900 transition-colors shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Edit</span>
                                </button>

                                <button type="button" onclick="window.confirmDelete('{{ route('admin.categories.destroy', $cat->id) }}', 'Yakin ingin menghapus kategori {{ addslashes($cat->name) }}?')" class="py-2 px-3 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-4 py-8 text-center text-stone-400 text-sm">
                        Belum ada kategori yang dibuat.
                    </div>
                @endforelse
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                        <tr>
                            <th class="px-4 py-2.5">Nama & Slug</th>
                            <th class="px-4 py-2.5">Tipe Publikasi</th>
                            <th class="px-4 py-2.5">Jumlah</th>
                            <th class="px-4 py-2.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($categories as $cat)
                            <tr class="hover:bg-stone-50/70 transition-colors">
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $cat->color ?: '#2A5C43' }};"></span>
                                        <div>
                                            <p class="font-bold text-stone-900 text-sm">{{ $cat->name }}</p>
                                            <p class="text-sm text-stone-400 font-mono">/{{ $cat->slug }}</p>
                                        </div>
                                    </div>
                                    @if($cat->description)
                                        <p class="text-sm text-stone-500 mt-0.5 line-clamp-1 pl-5">{{ $cat->description }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 whitespace-nowrap">
                                    @if($cat->type === 'jurnal')
                                        <span class="bg-forest/10 text-forest text-sm font-bold px-2.5 py-0.5 rounded">Jurnal</span>
                                    @elseif($cat->type === 'suara_warga')
                                        <span class="bg-terracotta/10 text-terracotta text-sm font-bold px-2.5 py-0.5 rounded">Warga</span>
                                    @else
                                        <span class="bg-stone-100 text-stone-700 text-sm font-bold px-2.5 py-0.5 rounded">Semua</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2.5 whitespace-nowrap text-stone-600 font-medium">
                                    {{ $cat->articles_count }} artikel
                                </td>
                                <td class="py-2.5 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-1.5">

                                        <button type="button" onclick='openEditCategoryModal(@json($cat))' title="Edit Kategori" class="p-1.5 text-forest hover:text-white hover:bg-forest border border-forest/20 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            <span class="sr-only">Edit</span>
                                        </button>

                                        <button type="button" onclick="window.confirmDelete('{{ route('admin.categories.destroy', $cat->id) }}', 'Yakin ingin menghapus kategori {{ addslashes($cat->name) }}?')" title="Hapus Kategori" class="p-1.5 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span class="sr-only">Hapus</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-stone-400 text-sm">
                                    Belum ada kategori yang dibuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-stone-100">
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    <div id="edit_category_modal" class="fixed inset-0 z-[400] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 font-sans p-4">
        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm" onclick="closeEditCategoryModal()"></div>
        <div class="bg-white rounded-2xl p-5 max-w-md w-full relative z-10 shadow-xl transform scale-95 transition-transform duration-300">
            <h3 class="font-serif text-lg font-bold text-stone-900 mb-1">Edit Kategori</h3>

            <form id="edit_category_form" action="" method="POST" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Nama Kategori <span class="text-terracotta">*</span>
                    </label>
                    <input type="text" id="edit_cat_name" name="name" required class="w-full px-3.5 py-2 rounded-lg border border-stone-200 text-sm focus:border-forest outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Slug URL / Permalink
                    </label>
                    <input type="text" id="edit_cat_slug" name="slug" class="w-full px-3.5 py-2 rounded-lg border border-stone-200 text-sm focus:border-forest outline-none font-mono">
                    <span class="text-sm text-stone-400 block mt-1">Kosongkan jika ingin dibuat otomatis dari nama kategori.</span>
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Tipe Publikasi <span class="text-terracotta">*</span>
                    </label>
                    <input type="hidden" id="edit_cat_type" name="type" value="both">
                    <div class="grid grid-cols-3 gap-2" id="edit_cat_type_container">
                        <button type="button" onclick="setEditCatType('both')" id="edit_btn_both" class="edit-type-btn py-2 px-2 rounded-xl border-2 text-sm font-bold text-center transition-all">Keduanya</button>
                        <button type="button" onclick="setEditCatType('jurnal')" id="edit_btn_jurnal" class="edit-type-btn py-2 px-2 rounded-xl border-2 text-sm font-semibold text-center transition-all">Jurnal</button>
                        <button type="button" onclick="setEditCatType('suara_warga')" id="edit_btn_suara_warga" class="edit-type-btn py-2 px-2 rounded-xl border-2 text-sm font-semibold text-center transition-all">Warga</button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Warna Label
                    </label>
                    <div class="flex items-center gap-2.5">
                        <input type="color" id="edit_cat_color" name="color" class="w-9 h-9 p-0.5 rounded-lg border border-stone-200 cursor-pointer">
                        <span class="text-sm text-stone-500 font-mono">Pilih warna aksen label</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-stone-700 tracking-wider mb-1.5">
                        Deskripsi (Opsional)
                    </label>
                    <textarea id="edit_cat_description" name="description" rows="2" class="w-full px-3.5 py-2 rounded-lg border border-stone-200 text-sm focus:border-forest outline-none resize-none"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-stone-100">
                    <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-2 rounded-xl text-stone-600 text-sm font-semibold hover:bg-stone-100">Batal</button>
                    <button type="submit" class="bg-forest text-white text-sm font-bold px-5 py-2 rounded-xl hover:bg-stone-900 shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function setEditCatType(val) {
            document.getElementById('edit_cat_type').value = val;
            const btnBoth = document.getElementById('edit_btn_both');
            const btnJurnal = document.getElementById('edit_btn_jurnal');
            const btnSuara = document.getElementById('edit_btn_suara_warga');

            [btnBoth, btnJurnal, btnSuara].forEach(b => {
                b.className = 'edit-type-btn py-2 px-2 rounded-xl border-2 text-sm font-semibold text-stone-600 border-stone-200 hover:border-stone-300 text-center transition-all';
            });

            if (val === 'both') {
                btnBoth.className = 'edit-type-btn py-2 px-2 rounded-xl border-2 text-sm font-bold border-forest bg-forest/5 text-forest text-center transition-all';
            } else if (val === 'jurnal') {
                btnJurnal.className = 'edit-type-btn py-2 px-2 rounded-xl border-2 text-sm font-bold border-forest bg-forest/5 text-forest text-center transition-all';
            } else {
                btnSuara.className = 'edit-type-btn py-2 px-2 rounded-xl border-2 text-sm font-bold border-terracotta bg-terracotta/5 text-terracotta text-center transition-all';
            }
        }

        function openEditCategoryModal(category) {
            const modal = document.getElementById('edit_category_modal');
            const card = modal.querySelector('div.bg-white');
            const form = document.getElementById('edit_category_form');

            form.action = '/admin/categories/' + category.id;
            document.getElementById('edit_cat_name').value = category.name || '';
            document.getElementById('edit_cat_slug').value = category.slug || '';
            document.getElementById('edit_cat_color').value = category.color || '#2A5C43';
            document.getElementById('edit_cat_description').value = category.description || '';
            setEditCatType(category.type || 'both');

            modal.classList.remove('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }

        function closeEditCategoryModal() {
            const modal = document.getElementById('edit_category_modal');
            const card = modal.querySelector('div.bg-white');
            modal.classList.add('opacity-0', 'pointer-events-none');
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
        }
    </script>
    @endpush

</x-layouts.admin>
