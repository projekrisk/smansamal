@props([
    'name' => 'content',
    'id' => 'editor-content',
    'value' => '',
    'placeholder' => 'Tuliskan artikel atau karya inspiratif Anda di sini... Mendukung pemformatan teks tebal, miring, kutipan, daftar poin, dan tag HTML.',
    'required' => true,
    'minHeight' => '320px'
])

@php
    $editorId = $id ?? 'editor_' . uniqid();
    $initialContent = old($name, $value ?? '');
@endphp

<div class="rich-editor-wrapper bg-white rounded-2xl border border-stone-200 overflow-hidden shadow-xs focus-within:border-forest focus-within:ring-2 focus-within:ring-forest/10 transition-all font-sans" id="wrapper-{{ $editorId }}">

    <textarea name="{{ $name }}" id="{{ $editorId }}-hidden" class="hidden" {{ $required ? 'required' : '' }}>{!! $initialContent !!}</textarea>

    <div class="bg-stone-50/90 border-b border-stone-200/80 px-3 py-2.5 flex flex-wrap items-center justify-between gap-2 select-none">

        <div class="flex flex-wrap items-center gap-1 text-stone-700">

            <div class="flex items-center bg-white rounded-lg border border-stone-200/80 p-0.5 shadow-2xs mr-1">
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'undo')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded text-stone-600 transition-colors" title="Batal (Ctrl+Z)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a5 5 0 015 5v2m-15-7l4-4m-4 4l4 4"></path></svg>
                </button>
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'redo')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded text-stone-600 transition-colors" title="Ulangi (Ctrl+Y)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a5 5 0 00-5 5v2m15-7l-4-4m4 4l-4 4"></path></svg>
                </button>
            </div>

            <div class="flex items-center bg-white rounded-lg border border-stone-200/80 p-0.5 shadow-2xs mr-1">
                <button type="button" onclick="formatBlock('{{ $editorId }}', 'p')" class="px-2 py-1 hover:bg-stone-100 hover:text-forest rounded text-xs font-bold text-stone-600 transition-colors" title="Paragraf Biasa">
                    P
                </button>
                <button type="button" onclick="formatBlock('{{ $editorId }}', 'h2')" class="px-2 py-1 hover:bg-stone-100 hover:text-forest rounded text-xs font-serif font-bold text-stone-700 transition-colors" title="Judul Bagian (H2)">
                    H2
                </button>
                <button type="button" onclick="formatBlock('{{ $editorId }}', 'h3')" class="px-2 py-1 hover:bg-stone-100 hover:text-forest rounded text-xs font-serif font-bold text-stone-700 transition-colors" title="Sub Judul (H3)">
                    H3
                </button>
            </div>

            <div class="flex items-center bg-white rounded-lg border border-stone-200/80 p-0.5 shadow-2xs mr-1">
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'bold')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded font-bold text-stone-700 transition-colors" title="Tebal / Bold (Ctrl+B)">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8 11h4.5a2.5 2.5 0 100-5H8v5zm10 4.5a4.5 4.5 0 01-4.5 4.5H6V4h6.5a4.5 4.5 0 013.256 7.606A4.498 4.498 0 0118 15.5zM8 13v5h5.5a2.5 2.5 0 100-5H8z"/></svg>
                </button>
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'italic')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded italic font-serif text-stone-700 transition-colors" title="Miring / Italic (Ctrl+I)">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M15 20H7v-2h2.927l3.216-12H10V4h8v2h-2.927l-3.216 12H15v2z"/></svg>
                </button>
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'underline')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded underline text-stone-700 transition-colors" title="Garis Bawah / Underline (Ctrl+U)">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8 3v9a4 4 0 108 0V3h2v9a6 6 0 11-12 0V3h2zM4 20h16v2H4v-2z"/></svg>
                </button>
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'strikeThrough')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded text-stone-600 transition-colors" title="Coret / Strikethrough">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.155 7.545a4.348 4.348 0 00-3.08-1.503C12.062 6.042 11 7.02 11 8.25c0 .927.575 1.637 1.625 2H3V12h18v-1.75h-3.327c-.208-.946-.662-1.93-1.518-2.705zM7.054 13.75A4.57 4.57 0 0012 17.957c2.146 0 3.738-1.129 3.738-2.707 0-.469-.142-.897-.393-1.25H7.054zM2 19h20v2H2v-2z"/></svg>
                </button>
            </div>

            <div class="flex items-center bg-white rounded-lg border border-stone-200/80 p-0.5 shadow-2xs mr-1">
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'insertUnorderedList')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded text-stone-600 transition-colors" title="Daftar Poin (Bullet List)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </button>
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'insertOrderedList')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded text-stone-600 transition-colors" title="Daftar Angka (Numbered List)">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M7 5h14v2H7V5zm0 8h14v2H7v-2zm0 8h14v2H7v-2zM3 4h2v5H3V4zm0 8h2v2H4v1h1v2H2v-1h1v-1H2v-2h1v-1zm1 7H2v-1h2v-1H2v-2h3v5H4v-1z"/></svg>
                </button>
                <button type="button" onclick="formatBlock('{{ $editorId }}', 'blockquote')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded text-stone-600 transition-colors" title="Kutipan / Blockquote">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/></svg>
                </button>
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'insertHorizontalRule')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded text-stone-600 transition-colors" title="Garis Pembatas Horizontal">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                </button>
            </div>

            <div class="flex items-center bg-white rounded-lg border border-stone-200/80 p-0.5 shadow-2xs">
                <button type="button" onclick="insertLinkPrompt('{{ $editorId }}')" class="p-1.5 hover:bg-stone-100 hover:text-forest rounded text-stone-600 transition-colors" title="Sisipkan Tautan / Link">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                </button>
                <button type="button" onclick="formatDoc('{{ $editorId }}', 'removeFormat')" class="p-1.5 hover:bg-stone-100 hover:text-red-600 rounded text-stone-600 transition-colors" title="Hapus Format / Bersihkan Teks">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>

        <div class="flex items-center gap-1.5">
            <button type="button" id="btn-mode-{{ $editorId }}" onclick="toggleEditorMode('{{ $editorId }}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-stone-300 bg-white hover:bg-stone-100 text-xs font-bold text-stone-700 transition-colors shadow-2xs" title="Beralih antara Mode Visual dan Editor HTML Langsung">
                <span id="mode-icon-{{ $editorId }}">
                    <svg class="w-3.5 h-3.5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                </span>
                <span id="mode-label-{{ $editorId }}">Kode HTML</span>
            </button>
        </div>

    </div>

    <div class="relative bg-white">

        <div
            id="{{ $editorId }}-visual"
            contenteditable="true"
            style="min-height: {{ $minHeight }};"
            class="rich-visual-editor prose prose-stone max-w-none p-5 sm:p-7 outline-none font-sans text-stone-800 text-sm md:text-base leading-relaxed overflow-y-auto"
            data-placeholder="{{ $placeholder }}"
            oninput="syncFromVisual('{{ $editorId }}')"
            onblur="syncFromVisual('{{ $editorId }}')"
        >{!! $initialContent !!}</div>

        <textarea
            id="{{ $editorId }}-html"
            style="min-height: {{ $minHeight }};"
            class="rich-html-editor hidden w-full p-5 sm:p-7 font-mono text-xs md:text-sm text-stone-800 bg-stone-50/50 outline-none resize-y leading-relaxed border-0 focus:ring-0"
            placeholder="Tulis atau tempel kode HTML di sini (contoh: <p>...</p>, <h2>...</h2>, <blockquote>...</blockquote>)..."
            oninput="syncFromHtml('{{ $editorId }}')"
            onblur="syncFromHtml('{{ $editorId }}')"
        >{!! $initialContent !!}</textarea>

    </div>

    <div class="bg-stone-50 border-t border-stone-200/80 px-4 py-2 flex flex-wrap items-center justify-between text-[11px] text-stone-500 font-sans gap-2">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-forest"></span>
                <span id="status-mode-{{ $editorId }}" class="font-medium">Mode: Visual WYSIWYG</span>
            </span>
            <span class="text-stone-300">|</span>
            <span>Mendukung format HTML murni</span>
        </div>
        <div class="flex items-center gap-3 font-mono">
            <span id="word-count-{{ $editorId }}">0 kata</span>
            <span class="text-stone-300">|</span>
            <span id="char-count-{{ $editorId }}">0 karakter</span>
        </div>
    </div>
</div>

<style>
    .rich-visual-editor:empty:before {
        content: attr(data-placeholder);
        color: #a8a29e;
        pointer-events: none;
        display: block;
    }
    .rich-visual-editor p {
        margin-bottom: 1rem;
        line-height: 1.75;
    }
    .rich-visual-editor h2 {
        font-family: 'Fraunces', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #2A2724;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
    .rich-visual-editor h3 {
        font-family: 'Fraunces', serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2A2724;
        margin-top: 1.25rem;
        margin-bottom: 0.5rem;
    }
    .rich-visual-editor blockquote {
        border-left: 4px solid #2A5C43;
        padding-left: 1rem;
        font-style: italic;
        color: #44403c;
        margin: 1.25rem 0;
        font-family: 'Fraunces', serif;
        background-color: #F9F8F6;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        border-radius: 0 0.5rem 0.5rem 0;
    }
    .rich-visual-editor ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .rich-visual-editor ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .rich-visual-editor a {
        color: #2A5C43;
        text-decoration: underline;
        font-weight: 600;
    }
    .rich-visual-editor hr {
        border: 0;
        border-top: 1px dashed #d6d3d1;
        margin: 1.5rem 0;
    }
</style>

@once
<script>
    function formatDoc(editorId, cmd, val = null) {
        const visual = document.getElementById(editorId + '-visual');
        const html = document.getElementById(editorId + '-html');

        if (visual.classList.contains('hidden')) {
            toggleEditorMode(editorId);
        }

        visual.focus();
        document.execCommand(cmd, false, val);
        syncFromVisual(editorId);
    }

    function formatBlock(editorId, tag) {
        formatDoc(editorId, 'formatBlock', `<${tag}>`);
    }

    function insertLinkPrompt(editorId) {
        const url = prompt('Masukkan URL tautan (contoh: https://sman1malingping.sch.id):', 'https://');
        if (url && url !== 'https://') {
            formatDoc(editorId, 'createLink', url);
        }
    }

    function syncFromVisual(editorId) {
        const visual = document.getElementById(editorId + '-visual');
        const html = document.getElementById(editorId + '-html');
        const hidden = document.getElementById(editorId + '-hidden');
        if (!visual || !html || !hidden) return;

        const content = visual.innerHTML;
        html.value = content;
        hidden.value = content;
        updateStats(editorId, visual.innerText);
    }

    function syncFromHtml(editorId) {
        const visual = document.getElementById(editorId + '-visual');
        const html = document.getElementById(editorId + '-html');
        const hidden = document.getElementById(editorId + '-hidden');
        if (!visual || !html || !hidden) return;

        const content = html.value;
        visual.innerHTML = content;
        hidden.value = content;
        updateStats(editorId, visual.innerText);
    }

    function toggleEditorMode(editorId) {
        const visual = document.getElementById(editorId + '-visual');
        const html = document.getElementById(editorId + '-html');
        const btn = document.getElementById('btn-mode-' + editorId);
        const label = document.getElementById('mode-label-' + editorId);
        const icon = document.getElementById('mode-icon-' + editorId);
        const statusMode = document.getElementById('status-mode-' + editorId);
        if (!visual || !html) return;

        const isVisualActive = !visual.classList.contains('hidden');

        if (isVisualActive) {
            syncFromVisual(editorId);
            visual.classList.add('hidden');
            html.classList.remove('hidden');
            html.focus();

            label.innerText = 'Visual Editor';
            icon.innerHTML = '<svg class="w-3.5 h-3.5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>';
            btn.classList.add('border-terracotta/40', 'bg-terracotta/5');
            statusMode.innerText = 'Mode: Kode HTML (Source View)';
        } else {
            syncFromHtml(editorId);
            html.classList.add('hidden');
            visual.classList.remove('hidden');
            visual.focus();

            label.innerText = 'Kode HTML';
            icon.innerHTML = '<svg class="w-3.5 h-3.5 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>';
            btn.classList.remove('border-terracotta/40', 'bg-terracotta/5');
            statusMode.innerText = 'Mode: Visual WYSIWYG';
        }
    }

    function updateStats(editorId, text) {
        const wordEl = document.getElementById('word-count-' + editorId);
        const charEl = document.getElementById('char-count-' + editorId);
        if (!wordEl || !charEl) return;

        const cleanText = (text || '').trim();
        const charCount = cleanText.length;
        const words = cleanText ? cleanText.split(/\s+/).length : 0;

        wordEl.innerText = `${words} kata`;
        charEl.innerText = `${charCount} karakter`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.rich-editor-wrapper').forEach(wrapper => {
            const form = wrapper.closest('form');
            const hidden = wrapper.querySelector('textarea.hidden');
            const visual = wrapper.querySelector('.rich-visual-editor');
            const html = wrapper.querySelector('.rich-html-editor');

            if (form && hidden && visual && html) {
                const editorId = hidden.id.replace('-hidden', '');
                updateStats(editorId, visual.innerText);

                form.addEventListener('submit', () => {
                    if (!visual.classList.contains('hidden')) {
                        hidden.value = visual.innerHTML;
                    } else {
                        hidden.value = html.value;
                    }
                });
            }
        });
    });
</script>
@endonce
