<x-layouts.admin title="Kalender Agenda - Admin SMAN 1 Malingping">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
        <div>
            <h1 class="font-serif text-2xl text-stone-900 font-bold mb-0.5">Agenda Sekolah</h1>
        </div>
        <a href="{{ route('admin.agendas.create') }}" class="bg-forest text-white text-sm font-bold px-4 py-2.5 rounded-xl hover:bg-stone-900 transition-colors shadow-xs inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Agenda Baru</span>
        </a>
    </div>

    <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden font-sans" x-data="{ allOpenAgendas: false }">

        <div class="md:hidden px-4 py-2.5 bg-stone-50/80 border-b border-stone-200 flex items-center justify-between text-xs">
            <span class="font-medium text-stone-500">
                Total: <strong class="text-stone-900">{{ $agendas->total() }} Agenda</strong>
            </span>
            @if($agendas->isNotEmpty())
                <button type="button" @click="allOpenAgendas = !allOpenAgendas; $dispatch('toggle-admin-agendas', { open: allOpenAgendas })" class="text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                    <span x-text="allOpenAgendas ? 'Tutup Semua' : 'Buka Semua'">Buka Semua</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="allOpenAgendas ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            @endif
        </div>

        <div class="md:hidden divide-y divide-stone-200">
            @forelse($agendas as $agenda)
                <div class="p-3.5 bg-white hover:bg-stone-50/70 transition-colors" x-data="{ isOpen: false }" @toggle-admin-agendas.window="isOpen = $event.detail.open">
                    <button type="button" @click="isOpen = !isOpen" class="w-full text-left flex items-start justify-between gap-2.5 focus:outline-none cursor-pointer">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-1.5 mb-1.5">
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold tracking-wider {{ $agenda->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-stone-100 text-stone-500 border border-stone-200' }}">
                                    {{ $agenda->is_active ? 'Aktif' : 'Non-aktif' }}
                                </span>
                                <span class="text-stone-500 text-xs font-semibold">{{ $agenda->formatted_date }}</span>
                            </div>

                            <h4 class="font-bold text-sm text-stone-900 leading-snug">
                                {{ $agenda->title }}
                            </h4>

                            <div class="flex items-center gap-2 text-xs text-stone-400 mt-1">
                                <span class="text-stone-600 truncate max-w-[150px]">{{ $agenda->location }}</span>
                                <span>&bull;</span>
                                <span>{{ $agenda->time_info ?: 'Menyesuaikan' }}</span>
                            </div>
                        </div>

                        <div class="p-1 rounded-lg text-stone-400 bg-stone-100 flex-shrink-0 transition-transform duration-200 mt-0.5" :class="isOpen ? 'rotate-180 bg-stone-200 text-stone-700' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </button>

                    <div x-show="isOpen" x-cloak class="mt-3 pt-3 border-t border-stone-100 space-y-2.5 text-xs">
                        @if($agenda->description)
                            <p class="text-stone-600 bg-stone-50 p-2.5 rounded-lg border border-stone-100 leading-relaxed">
                                {{ $agenda->description }}
                            </p>
                        @endif

                        <div class="grid grid-cols-2 gap-2 text-[11px] bg-stone-50 p-2 rounded-lg border border-stone-100">
                            <div>
                                <span class="text-stone-400 block">Lokasi:</span>
                                <span class="font-semibold text-stone-700">{{ $agenda->location }}</span>
                            </div>
                            <div>
                                <span class="text-stone-400 block">Waktu:</span>
                                <span class="font-semibold text-stone-700">{{ $agenda->time_info ?: 'Menyesuaikan' }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 pt-1 border-t border-stone-100">
                            <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="py-2 px-3 rounded-lg bg-forest text-white font-bold text-center inline-flex items-center justify-center gap-1.5 hover:bg-stone-900 transition-colors shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Edit</span>
                            </a>

                            <button type="button" onclick="window.confirmDelete('{{ route('admin.agendas.destroy', $agenda->id) }}', 'Yakin ingin menghapus agenda: {{ addslashes($agenda->title) }}?')" class="py-2 px-3 rounded-lg border border-rose-200 text-rose-700 bg-rose-50/50 hover:bg-rose-100 font-bold text-center inline-flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <span>Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center text-stone-400 text-sm">
                    Belum ada agenda kegiatan yang ditambahkan.
                </div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-stone-50 border-b border-stone-200 text-stone-500 text-sm tracking-wider font-semibold">
                    <tr>
                        <th class="py-2.5 px-4">Tanggal Event</th>
                        <th class="py-2.5 px-4">Nama Kegiatan</th>
                        <th class="py-2.5 px-4">Lokasi</th>
                        <th class="py-2.5 px-4">Waktu</th>
                        <th class="py-2.5 px-4">Status</th>
                        <th class="py-2.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($agendas as $agenda)
                        <tr class="hover:bg-stone-50/70 transition-colors">
                            <td class="py-2.5 px-4 font-bold text-stone-900 whitespace-nowrap">
                                {{ $agenda->formatted_date }}
                            </td>
                            <td class="py-2.5 px-4 max-w-sm">
                                <span class="font-bold text-stone-800 block text-sm">{{ $agenda->title }}</span>
                                <span class="text-sm text-stone-400 line-clamp-1">{{ $agenda->description }}</span>
                            </td>
                            <td class="py-2.5 px-4 text-stone-600 whitespace-nowrap">
                                {{ $agenda->location }}
                            </td>
                            <td class="py-2.5 px-4 text-stone-500 whitespace-nowrap">
                                {{ $agenda->time_info ?: 'Menyesuaikan' }}
                            </td>
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="text-sm px-2.5 py-0.5 rounded-full font-bold {{ $agenda->is_active ? 'bg-green-100 text-green-800' : 'bg-stone-100 text-stone-500' }}">
                                    {{ $agenda->is_active ? 'Aktif' : 'Non-aktif' }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">

                                    <a href="{{ route('admin.agendas.edit', $agenda->id) }}" title="Edit Agenda" class="p-1.5 text-forest hover:text-white hover:bg-forest border border-forest/20 rounded-lg transition-colors inline-flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span class="sr-only">Edit</span>
                                    </a>

                                    <button type="button" onclick="window.confirmDelete('{{ route('admin.agendas.destroy', $agenda->id) }}', 'Yakin ingin menghapus agenda: {{ addslashes($agenda->title) }}?')" title="Hapus Agenda" class="p-1.5 text-rose-600 hover:text-white hover:bg-rose-600 border border-rose-200 rounded-lg transition-colors inline-flex items-center justify-center cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span class="sr-only">Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-stone-400 text-sm">
                                Belum ada agenda kegiatan yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-stone-100">
            {{ $agendas->links() }}
        </div>
    </div>

</x-layouts.admin>
