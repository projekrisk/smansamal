
<footer class="w-full bg-stone-900 text-stone-400 py-8 mt-auto border-t border-stone-800">
    <div class="max-w-[1200px] mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6 font-sans text-sm">
        <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4 text-center md:text-left">
            <span class="font-serif font-semibold text-white tracking-wide">SMAN 1 Malingping</span>
            <span class="hidden md:inline text-stone-600">&bull;</span>
            <p>&copy; {{ date('Y') }}</p>
        </div>
        <div class="flex flex-wrap items-center justify-center md:justify-end gap-x-6 gap-y-2 text-xs md:text-sm">
            <a href="{{ route('sop') }}" class="hover:text-white transition-colors">SOP Pelayanan</a>
            <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Kontak</a>
            <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
            <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Kebijakan Privasi</a>
        </div>
    </div>
</footer>
