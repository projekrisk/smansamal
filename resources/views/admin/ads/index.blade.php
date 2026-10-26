<x-layouts.admin title="Pengaturan Iklan AdSense - SMAN 1 Malingping" headerTitle="Pengaturan Iklan AdSense">

    <form id="ads-form" action="{{ route('admin.ads.update') }}" method="POST">
        @csrf

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h1 class="font-serif text-2xl text-stone-900 font-bold">Pengaturan Iklan</h1>
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-forest text-white font-sans text-sm font-bold  tracking-wider hover:bg-stone-900 transition-colors shadow-xs">
                <span>Simpan</span>
            </button>
        </div>

        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-sans text-sm flex items-center justify-between gap-3 shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

            <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden flex flex-col">
                <div class="px-4 py-3 border-b border-stone-100 flex items-center justify-between bg-stone-50/70">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $settings['ad_in_article_enabled'] ? 'bg-emerald-500' : 'bg-stone-300' }}"></span>
                        <h2 class="font-sans font-bold text-sm text-stone-900">Iklan In-Article</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="ad_in_article_enabled" value="1" class="sr-only peer" {{ $settings['ad_in_article_enabled'] ? 'checked' : '' }}>
                        <div class="w-9 h-5 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-forest"></div>
                        <span class="ml-2 text-sm font-semibold text-stone-600">{{ $settings['ad_in_article_enabled'] ? 'Aktif' : 'Off' }}</span>
                    </label>
                </div>

                <div class="p-4 space-y-3.5 flex-1">

                    <div class="flex items-center justify-between gap-3 text-sm">
                        <label class="font-bold text-stone-700">Setelah Paragraf Ke-</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="ad_in_article_paragraph" min="1" max="20" value="{{ old('ad_in_article_paragraph', $settings['ad_in_article_paragraph']) }}" class="w-16 px-2.5 py-1.5 rounded-lg border border-stone-200 bg-stone-50 focus:bg-white focus:outline-none focus:border-forest text-sm font-bold text-center">
                            <span class="text-stone-400 text-sm">(Default: 2)</span>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-sm text-stone-600  tracking-wider mb-1.5">Kode Script AdSense</label>
                        <textarea name="ad_in_article_code" rows="4" placeholder="<ins class=&quot;adsbygoogle&quot; ...></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>" class="w-full font-mono text-sm p-3 rounded-lg border border-stone-200 bg-stone-50 focus:bg-white focus:outline-none focus:border-forest leading-normal text-stone-800 resize-y">{{ old('ad_in_article_code', $settings['ad_in_article_code']) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden flex flex-col">
                <div class="px-4 py-3 border-b border-stone-100 flex items-center justify-between bg-stone-50/70">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $settings['ad_bottom_article_enabled'] ? 'bg-emerald-500' : 'bg-stone-300' }}"></span>
                        <h2 class="font-sans font-bold text-sm text-stone-900">Iklan Di Bawah Berita</h2>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="ad_bottom_article_enabled" value="1" class="sr-only peer" {{ $settings['ad_bottom_article_enabled'] ? 'checked' : '' }}>
                        <div class="w-9 h-5 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-forest"></div>
                        <span class="ml-2 text-sm font-semibold text-stone-600">{{ $settings['ad_bottom_article_enabled'] ? 'Aktif' : 'Off' }}</span>
                    </label>
                </div>

                <div class="p-4 space-y-3.5 flex-1">
                    <div class="flex items-center justify-between text-sm text-stone-500">
                        <span>Penempatan: Tepat di bawah isi artikel berita</span>
                    </div>

                    <div>
                        <label class="block font-bold text-sm text-stone-600  tracking-wider mb-1.5">Kode Script AdSense</label>
                        <textarea name="ad_bottom_article_code" rows="4" placeholder="<ins class=&quot;adsbygoogle&quot; style=&quot;display:block&quot; data-ad-format=&quot;auto&quot;></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>" class="w-full font-mono text-sm p-3 rounded-lg border border-stone-200 bg-stone-50 focus:bg-white focus:outline-none focus:border-forest leading-normal text-stone-800 resize-y">{{ old('ad_bottom_article_code', $settings['ad_bottom_article_code']) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-xl border border-stone-200 shadow-2xs overflow-hidden mb-5">
            <div class="px-4 py-3 border-b border-stone-100 flex items-center justify-between bg-stone-50/70">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ $settings['adsense_header_enabled'] ? 'bg-emerald-500' : 'bg-stone-300' }}"></span>
                    <h2 class="font-sans font-bold text-sm text-stone-900">Script Header AdSense (Opsional)</h2>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="adsense_header_enabled" value="1" class="sr-only peer" {{ $settings['adsense_header_enabled'] ? 'checked' : '' }}>
                    <div class="w-9 h-5 bg-stone-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-forest"></div>
                    <span class="ml-2 text-sm font-semibold text-stone-600">{{ $settings['adsense_header_enabled'] ? 'Aktif' : 'Off' }}</span>
                </label>
            </div>

            <div class="p-4">
                <label class="block font-bold text-sm text-stone-600  tracking-wider mb-1.5">Tag Script &lt;head&gt; (Auto Ads / Client ID)</label>
                <textarea name="adsense_header_code" rows="2" placeholder="&lt;script async src=&quot;https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-xxx&quot; crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;" class="w-full font-mono text-sm p-3 rounded-lg border border-stone-200 bg-stone-50 focus:bg-white focus:outline-none focus:border-forest leading-normal text-stone-800 resize-y">{{ old('adsense_header_code', $settings['adsense_header_code']) }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-forest text-white font-sans text-sm font-bold  tracking-wider hover:bg-stone-900 transition-colors shadow-xs">
                <span>Simpan</span>
            </button>
        </div>

    </form>
</x-layouts.admin>
