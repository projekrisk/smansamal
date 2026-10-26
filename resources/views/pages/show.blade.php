@push('styles')
<style>
    .page-prose p,
    .page-prose li {
        font-size: 17px !important;
        line-height: 1.85 !important;
        color: #374151;
    }
    .page-prose h2 {
        font-family: Georgia, Cambria, "Times New Roman", Times, serif;
        font-size: 1.65rem;
        font-weight: 700;
        color: #1c1917;
        margin-top: 2rem;
        margin-bottom: 0.85rem;
    }
    .page-prose h3 {
        font-family: Georgia, Cambria, "Times New Roman", Times, serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: #292524;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
    .page-prose ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .page-prose ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
    }
    .page-prose blockquote {
        border-left: 4px solid #2A5C43;
        padding-left: 1.25rem;
        font-style: italic;
        color: #44403c;
        margin: 1.5rem 0;
        background-color: #f5f5f4;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        border-radius: 0 0.75rem 0.75rem 0;
    }
</style>
@endpush

<x-layouts.app
    :title="$page->title . ' - SMAN 1 Malingping'"
    :description="$page->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($page->content), 160)"
    type="article">

    <main class="flex-grow pt-28 md:pt-32 pb-20 px-4 sm:px-6">
        <article class="w-full max-w-[820px] mx-auto {{ $page->is_system ? 'bg-white p-6 sm:p-10 md:p-12 rounded-2xl md:rounded-[2rem] border border-stone-200 shadow-2xs' : 'py-2 sm:py-4' }}">

            <div class="flex flex-col items-center text-center mb-8">
                <div class="flex items-center gap-2.5 mb-4 text-xs font-sans">
                    <a href="{{ route('home') }}" class="text-stone-500 hover:text-stone-900 transition-colors">Beranda</a>
                    <span class="text-stone-400">/</span>
                    <span class="text-stone-500">Halaman Resmi</span>
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl text-stone-900 leading-tight md:leading-snug mb-4 font-bold max-w-3xl">
                    {{ $page->title }}
                </h1>

                @if($page->meta_description)
                    <p class="font-sans text-stone-600 text-base sm:text-lg max-w-2xl leading-relaxed">
                        {{ $page->meta_description }}
                    </p>
                @endif

                <div class="flex flex-wrap items-center justify-center gap-3 mt-5 pt-4 border-t border-stone-100 text-xs text-stone-500">
                    <span class="inline-flex items-center gap-1.5 bg-stone-100 text-stone-700 px-3 py-1 rounded-full font-medium">
                        <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Diperbarui: {{ $page->updated_at->translatedFormat('d F Y') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 bg-forest/10 text-forest px-3 py-1 rounded-full font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ number_format($page->views_count) }} kali dibaca
                    </span>
                </div>
            </div>

            <div class="w-full h-px bg-stone-200/80 mb-8"></div>

            <div class="prose page-prose font-sans text-stone-800 text-[17px] max-w-none leading-relaxed">
                {!! \App\Models\Article::wrapTables($page->content) !!}
            </div>

            <div class="mt-12 pt-6 border-t border-stone-200 flex flex-wrap items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-bold text-forest hover:text-stone-900 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Kembali ke Beranda</span>
                </a>

                <div class="text-xs text-stone-400">
                    Dokumen Resmi SMA Negeri 1 Malingping
                </div>
            </div>

        </article>
    </main>

</x-layouts.app>
