@props(['article'])

@php
    if (is_string($article) || is_numeric($article)) {
        $article = \App\Models\Article::with(['category', 'user'])->where('slug', $article)->orWhere('id', $article)->first();
    }
@endphp

@if($article && is_object($article) && isset($article->slug) && ($article->isPublished() || auth()->user()?->isAdmin()))
<a href="{{ $article->url }}" class="group flex flex-col h-full cursor-pointer">
    <div class="img-wrap w-full aspect-[3/1] md:aspect-[3/2] rounded-xl md:rounded-2xl mb-3 md:mb-4 flex-shrink-0">
        <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-full object-cover" loading="lazy" decoding="async">
    </div>
    <div class="flex flex-col flex-grow px-1 md:px-0">
        <p class="font-sans text-[10px] md:text-xs font-semibold text-terracotta uppercase tracking-wider mb-1 md:mb-2">
            {{ $article->category->name ?? 'Jurnal' }}
        </p>
        <h3 class="font-serif text-lg md:text-xl text-stone-900 leading-snug group-hover:text-forest transition-colors mb-4 line-clamp-2">
            {{ $article->title }}
        </h3>
        <div class="mt-auto flex items-center justify-between font-sans text-xs text-stone-500 pt-3 border-t border-stone-200">
            <span>{{ $article->formatted_date }}</span>
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1.5" title="Apresiasi">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    {{ $article->likes_count ?? 0 }}
                </span>
                <span class="flex items-center gap-1.5" title="Komentar">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    {{ $article->comments_count ?? (method_exists($article, 'comments') ? $article->comments()->count() : 0) }}
                </span>
            </div>
        </div>
    </div>
</a>
@endif
