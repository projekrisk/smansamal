@props([
    'title' => 'Dasbor Warga - SMAN 1 Malingping',
    'headerTitle' => 'Dasbor Warga'
])

@php
    $currentUser = auth()->user();
    $userArticleIds = $currentUser ? $currentUser->articles()->pluck('id') : collect();
    $totalUserArticles = $currentUser ? $currentUser->articles()->count() : 0;
    $totalUserComments = $currentUser ? \App\Models\Comment::whereIn('article_id', $userArticleIds)->count() : 0;

    $recentLikes = $currentUser ? \App\Models\ArticleLike::with(['article', 'user'])
        ->whereIn('article_id', $userArticleIds)
        ->latest()
        ->take(3)
        ->get() : collect();

    $recentComments = $currentUser ? \App\Models\Comment::with(['article', 'user'])
        ->whereIn('article_id', $userArticleIds)
        ->latest()
        ->take(3)
        ->get() : collect();

    $userNotifications = $currentUser ? $currentUser->notifications()->take(8)->get() : collect();
    $unreadNotifCount = $currentUser ? $currentUser->unreadNotifications()->count() : 0;
@endphp

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,300;9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Fraunces', 'serif'],
                    },
                    colors: {
                        stone: {
                            50: '#F9F8F6',
                            100: '#EFEBE4',
                            800: '#3D3935',
                            900: '#2A2724',
                            950: '#1b1917',
                        },
                        forest: '#2A5C43',
                        terracotta: '#CC7A6B',
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #F9F8F6;
            color: #2A2724;
        }

        #sidebar {
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1), transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-text {
            transition: opacity 0.2s ease, max-width 0.4s ease, margin 0.4s ease, padding 0.4s ease;
            white-space: nowrap;
            overflow: hidden;
            max-width: 200px;
            opacity: 1;
        }

        .nav-item {
            transition: all 0.3s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border-radius: 0.75rem;
            border: 1px solid #EFEBE4;
            background-color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            line-height: 1.25rem;
            transition: all 0.25s ease;
            color: #2A2724;
        }
        .form-input:focus {
            outline: none;
            border-color: #2A5C43;
            box-shadow: 0 0 0 2px rgba(42, 92, 67, 0.1);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @media (min-width: 1024px) {
            #sidebar.collapsed {
                width: 5rem !important;
            }
            #sidebar.collapsed nav {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }
            #sidebar.collapsed .sidebar-text {
                display: none !important;
            }
            #sidebar.collapsed .nav-item {
                width: 3.25rem !important;
                height: 3.25rem !important;
                min-height: 3.25rem !important;
                padding: 0 !important;
                margin-left: auto !important;
                margin-right: auto !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 0 !important;
                border-radius: 0.875rem !important;
            }
            #sidebar.collapsed .nav-item > div {
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            #sidebar.collapsed .nav-item svg {
                margin: 0 !important;
                flex-shrink: 0 !important;
            }
            #sidebar.collapsed #logo-area {
                padding-left: 0 !important;
                padding-right: 0 !important;
                justify-content: center !important;
            }
            #sidebar.collapsed #logo-area a {
                justify-content: center !important;
                gap: 0 !important;
            }
            #sidebar.collapsed .nav-section-title {
                text-align: center !important;
                padding: 0 !important;
                margin: 1.25rem auto 0.5rem auto !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                width: 100% !important;
            }
            #sidebar.collapsed .nav-section-title span {
                display: none !important;
            }
            #sidebar.collapsed .nav-section-title::after {
                content: "" !important;
                display: block !important;
                width: 1.5rem !important;
                height: 1px !important;
                background-color: rgba(0, 0, 0, 0.1) !important;
            }
        }

        .toast-slide-in {
            animation: toastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .toast-slide-out {
            animation: toastSlideOut 0.3s ease forwards;
        }
        @keyframes toastSlideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    </style>
</head>
<body class="antialiased selection:bg-forest selection:text-white flex h-screen overflow-hidden bg-stone-50 font-sans text-stone-900">

    <x-toast />

    <div id="sidebar-overlay" class="fixed inset-0 bg-stone-900/40 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden" onclick="handleSidebarToggle()"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-stone-200 transform -translate-x-full lg:translate-x-0 lg:static lg:flex lg:flex-col h-full transition-all duration-300 ease-in-out">

        <div id="logo-area" class="h-16 flex items-center px-6 border-b border-stone-100 flex-shrink-0 transition-all duration-300">
            <a href="{{ route('home') }}" class="flex items-center gap-3 overflow-hidden" title="Beranda Portal SMAN 1 Malingping">
                <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-9 h-9 flex-shrink-0">
                <span class="sidebar-text font-serif text-lg font-semibold text-forest leading-none whitespace-nowrap transition-opacity duration-300">
                    SMAN 1<span class="text-terracotta"> Malingping</span>
                </span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-1.5 font-sans text-sm font-semibold text-stone-600 no-scrollbar">
            <p class="nav-section-title px-3 text-sm uppercase tracking-wider text-stone-400 mb-2 mt-1 transition-all duration-300 font-bold"><span>Menu Utama</span></p>

            <a href="{{ route('dashboard') }}" title="Ringkasan" class="nav-item group flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-forest/10 text-forest font-bold ring-1 ring-forest/20 shadow-xs' : 'hover:bg-stone-100 hover:text-stone-900' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-forest' : 'text-stone-400 group-hover:text-stone-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Ringkasan</span>
                </div>
            </a>

            <a href="{{ route('warga.articles.create') }}" title="Tulis Artikel Baru" class="nav-item group flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('warga.articles.create') ? 'bg-forest/10 text-forest font-bold ring-1 ring-forest/20 shadow-xs' : 'hover:bg-stone-100 hover:text-stone-900' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('warga.articles.create') ? 'text-forest' : 'text-stone-400 group-hover:text-stone-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Tulis Artikel Baru</span>
                </div>
            </a>

            <a href="{{ route('warga.articles.index') }}" title="Karya Saya" class="nav-item group flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ (request()->routeIs('warga.articles.index') || request()->routeIs('warga.articles.edit')) ? 'bg-forest/10 text-forest font-bold ring-1 ring-forest/20 shadow-xs' : 'hover:bg-stone-100 hover:text-stone-900' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ (request()->routeIs('warga.articles.index') || request()->routeIs('warga.articles.edit')) ? 'text-forest' : 'text-stone-400 group-hover:text-stone-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Karya Saya</span>
                </div>
                <span class="sidebar-text bg-stone-200 text-stone-700 text-sm font-bold px-2 py-0.5 rounded-full flex-shrink-0 transition-opacity duration-300">{{ $totalUserArticles }}</span>
            </a>

            <a href="{{ route('warga.comments.index') }}" title="Komentar Pembaca" class="nav-item group flex items-center justify-between px-3.5 py-2.5 rounded-xl {{ request()->routeIs('warga.comments.*') ? 'bg-forest/10 text-forest font-bold ring-1 ring-forest/20 shadow-xs' : 'hover:bg-stone-100 hover:text-stone-900' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('warga.comments.*') ? 'text-forest' : 'text-stone-400 group-hover:text-stone-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Komentar</span>
                </div>
                <span class="sidebar-text bg-terracotta text-white text-sm font-bold px-2 py-0.5 rounded-full flex-shrink-0 transition-opacity duration-300">{{ $totalUserComments }}</span>
            </a>

            @if($currentUser && ($currentUser->role_type === 'alumni' || $currentUser->hasRole('Alumni')))
                <p class="nav-section-title px-3 text-sm uppercase tracking-wider text-terracotta mb-2 mt-6 transition-all duration-300 font-bold"><span>Khusus Alumni</span></p>

                <a href="{{ route('warga.testimonials.index') }}" title="Testimoni Saya" class="nav-item group flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('warga.testimonials.*') ? 'bg-terracotta/15 text-terracotta font-bold ring-1 ring-terracotta/20 shadow-xs' : 'hover:bg-stone-100 hover:text-stone-900' }} transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('warga.testimonials.*') ? 'text-terracotta' : 'text-stone-400 group-hover:text-stone-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        <span class="sidebar-text whitespace-nowrap">Testimoni Saya</span>
                    </div>
                </a>
            @endif

            <p class="nav-section-title px-3 text-sm uppercase tracking-wider text-stone-400 mb-2 mt-6 transition-all duration-300 font-bold"><span>Pengaturan</span></p>

            <a href="{{ route('profile.edit') }}" title="Profil Akun" class="nav-item group flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('profile.*') ? 'bg-forest/10 text-forest font-bold ring-1 ring-forest/20 shadow-xs' : 'hover:bg-stone-100 hover:text-stone-900' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('profile.*') ? 'text-forest' : 'text-stone-400 group-hover:text-stone-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Profil Akun</span>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="w-full pt-1">
                @csrf
                <button type="submit" title="Keluar Akun" class="w-full nav-item group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-stone-600 hover:bg-red-50 hover:text-red-700 transition-all duration-300 text-left cursor-pointer">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 text-stone-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="sidebar-text whitespace-nowrap">Keluar</span>
                    </div>
                </button>
            </form>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <header class="h-16 bg-white border-b border-stone-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-30 flex-shrink-0 transition-all duration-300">

            <div class="flex items-center gap-3">
                <button onclick="handleSidebarToggle()" class="p-2 -ml-2 text-stone-600 hover:text-stone-900 focus:outline-none hover:bg-stone-100 rounded-lg transition-colors cursor-pointer" title="Buka/Tutup Menu Sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="font-serif text-lg font-bold text-stone-800 hidden sm:block">{{ $headerTitle }}</h2>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 ml-auto">

                <a href="{{ route('home') }}" class="hidden md:inline-flex items-center gap-1.5 text-sm font-semibold text-stone-600 hover:text-forest px-3 py-1.5 rounded-lg hover:bg-stone-50 transition-colors" title="Buka Beranda Portal Sekolah">
                    <svg class="w-4 h-4 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Lihat Portal</span>
                </a>

                <div class="relative group">
                    <button id="notif-btn" onclick="toggleNotif()" class="relative p-2 text-stone-500 hover:text-stone-900 hover:bg-stone-100 rounded-xl transition-colors focus:outline-none cursor-pointer" title="Pemberitahuan">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if($unreadNotifCount > 0)
                            <span class="absolute top-1 right-1 min-w-[18px] h-[18px] bg-terracotta text-white text-[10px] font-bold rounded-full border-2 border-white flex items-center justify-center px-1 shadow-2xs leading-none">
                                {{ $unreadNotifCount > 9 ? '9+' : $unreadNotifCount }}
                            </span>
                        @endif
                    </button>

                    <div id="notif-dropdown" class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-stone-200/90 opacity-0 pointer-events-none transform translate-y-2 transition-all duration-200 z-50 overflow-hidden">
                        <div class="px-4 py-3 bg-stone-50/70 border-b border-stone-100 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <h4 class="font-serif text-sm font-bold text-stone-900">Notifikasi</h4>
                                @if($unreadNotifCount > 0)
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-terracotta/10 text-terracotta">
                                        {{ $unreadNotifCount }} Baru
                                    </span>
                                @endif
                            </div>
                            @if($unreadNotifCount > 0)
                                <form method="POST" action="{{ route('notifications.read-all') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-forest hover:text-stone-900 font-bold transition-colors cursor-pointer inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Tandai Semua Dibaca</span>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="max-h-80 overflow-y-auto no-scrollbar divide-y divide-stone-100">
                            @forelse($userNotifications as $notif)
                                @php
                                    $data = $notif->data;
                                    $isUnread = is_null($notif->read_at);
                                @endphp
                                <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left p-3 hover:bg-stone-50 transition-colors flex gap-2.5 {{ $isUnread ? 'bg-forest/[0.04]' : 'bg-white' }} cursor-pointer group">
                                        <div class="relative w-8 h-8 flex-shrink-0 mt-0.5">
                                            <div class="w-8 h-8 rounded-full overflow-hidden bg-stone-200 border border-stone-100">
                                                <img src="{{ $data['author_avatar'] ?? asset('images/avatar-default.svg') }}" alt="{{ $data['author_name'] ?? 'Penulis' }}" class="w-full h-full object-cover">
                                            </div>
                                            @if(($data['type'] ?? '') === 'new_comment')
                                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-forest text-white flex items-center justify-center text-[7px] shadow-2xs" title="Komentar Baru">💬</span>
                                            @elseif(($data['type'] ?? '') === 'comment_reply')
                                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-terracotta text-white flex items-center justify-center text-[7px] shadow-2xs" title="Balasan Komentar">↩️</span>
                                            @elseif(($data['type'] ?? '') === 'article_reported')
                                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[7px] shadow-2xs" title="Laporan Artikel">🚩</span>
                                            @elseif(($data['type'] ?? '') === 'testimonial_approved')
                                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[7px] shadow-2xs" title="Testimoni Disetujui">⭐</span>
                                            @elseif(($data['type'] ?? '') === 'testimonial_rejected')
                                                <span class="absolute -bottom-1 -right-1 w-3.5 h-3.5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[7px] shadow-2xs" title="Testimoni Perlu Revisi">📝</span>
                                            @endif
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <p class="font-sans text-xs text-stone-800 leading-snug">
                                                <strong class="text-stone-900 font-bold group-hover:text-forest transition-colors">{{ $data['author_name'] ?? 'Warga' }}</strong>
                                                @if(($data['type'] ?? '') === 'new_comment')
                                                    mengomentari karya Anda:
                                                    <span class="font-semibold text-forest block mt-0.5 truncate text-[11px]">"{{ $data['article_title'] ?? $data['title'] ?? 'Artikel' }}"</span>
                                                    @if(!empty($data['comment_snippet']))
                                                        <span class="bg-stone-50 border-l-2 border-forest/50 px-2 py-0.5 rounded text-[11px] text-stone-600 italic block mt-1 line-clamp-1">"{{ $data['comment_snippet'] }}"</span>
                                                    @endif
                                                @elseif(($data['type'] ?? '') === 'comment_reply')
                                                    membalas komentar Anda di:
                                                    <span class="font-semibold text-terracotta block mt-0.5 truncate text-[11px]">"{{ $data['article_title'] ?? $data['title'] ?? 'Artikel' }}"</span>
                                                    @if(!empty($data['comment_snippet']))
                                                        <span class="bg-stone-50 border-l-2 border-terracotta/50 px-2 py-0.5 rounded text-[11px] text-stone-600 italic block mt-1 line-clamp-1">"{{ $data['comment_snippet'] }}"</span>
                                                    @endif
                                                @elseif(($data['type'] ?? '') === 'article_reported')
                                                    melaporkan artikel:
                                                    <span class="font-semibold text-rose-700 block mt-0.5 truncate text-[11px]">"{{ $data['article_title'] ?? 'Artikel' }}"</span>
                                                    <span class="bg-rose-50 border-l-2 border-rose-500 px-2 py-0.5 rounded text-[11px] text-rose-700 font-medium block mt-1">Alasan: {{ $data['reason_label'] ?? 'Pelanggaran' }}</span>
                                                @elseif(($data['type'] ?? '') === 'testimonial_approved')
                                                    <span class="text-emerald-700 font-bold block mt-0.5">Testimoni Anda telah disetujui!</span>
                                                    <span class="text-stone-600 block mt-0.5 text-[11px] line-clamp-2">Testimoni alumni Anda kini telah aktif dan ditayangkan di beranda sekolah.</span>
                                                @elseif(($data['type'] ?? '') === 'testimonial_rejected')
                                                    <span class="text-rose-700 font-bold block mt-0.5">Testimoni Anda ditolak redaksi:</span>
                                                    <span class="bg-rose-50 border-l-2 border-rose-500 px-2 py-1 rounded text-[11px] text-rose-800 font-medium block mt-1 line-clamp-2">
                                                        "{{ $data['rejection_reason'] ?? 'Catatan redaksi' }}"
                                                    </span>
                                                    <span class="text-[10px] text-stone-500 font-medium mt-1 inline-flex items-center gap-1">
                                                        Testimoni terkunci &bull; Lihat rincian &rarr;
                                                    </span>
                                                @else
                                                    {{ $data['message'] ?? 'mempublikasikan artikel baru.' }}
                                                @endif
                                            </p>
                                            <span class="text-[10px] text-stone-400 mt-1 inline-flex items-center gap-1">
                                                <svg class="w-2.5 h-2.5 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $notif->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        @if($isUnread)
                                            <span class="w-2 h-2 rounded-full bg-forest flex-shrink-0 mt-2 ring-4 ring-forest/15" title="Belum dibaca"></span>
                                        @endif
                                    </button>
                                </form>
                            @empty
                                <div class="py-7 px-4 text-center">
                                    <div class="w-9 h-9 rounded-full bg-stone-100 text-stone-400 flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-stone-700">Belum ada notifikasi baru</p>
                                    <p class="text-[11px] text-stone-400 mt-0.5">Komentar dan tanggapan karya Anda akan muncul di sini.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="px-4 py-2 bg-stone-50/70 border-t border-stone-100 text-center">
                            <span class="text-[10px] text-stone-400 font-medium uppercase tracking-wider">Pemberitahuan Warga Sekolah</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 p-1 rounded-xl hover:bg-stone-100 transition-colors group" title="Pengaturan Profil">
                    <div class="text-right hidden sm:block">
                        <p class="font-sans text-sm font-bold text-stone-900 leading-tight group-hover:text-forest transition-colors">{{ Str::limit($currentUser->name ?? 'Warga', 18) }}</p>
                        <p class="font-sans text-sm text-forest font-semibold leading-tight">{{ ucfirst($currentUser->role_type ?? 'Warga') }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full overflow-hidden border border-stone-200 group-hover:border-forest transition-colors flex-shrink-0">
                        <img src="{{ $currentUser->avatar_url ?? asset('images/avatar-default.svg') }}" alt="{{ $currentUser->name ?? 'Avatar' }}" class="w-full h-full object-cover">
                    </div>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-6 no-scrollbar">
            {{ $slot }}
        </main>
    </div>

    <div id="delete-modal" class="fixed inset-0 z-[300] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">

        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm cursor-pointer" onclick="closeDeleteModal()"></div>

        <div class="bg-white w-[90%] max-w-md p-6 rounded-2xl shadow-xl relative z-10 transform scale-95 transition-transform duration-300 text-center border border-stone-200">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>

            <h3 class="font-serif text-xl font-bold text-stone-900 mb-1.5">Konfirmasi Hapus</h3>
            <p id="delete-modal-message" class="font-sans text-stone-600 text-sm mb-6 leading-relaxed">
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini permanen dan tidak dapat dibatalkan.
            </p>

            <form id="delete-modal-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex items-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-stone-100 hover:bg-stone-200 text-stone-700 py-2.5 rounded-xl font-sans text-sm font-semibold transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-xl font-sans text-sm font-bold transition-colors shadow-xs cursor-pointer">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function handleSidebarToggle() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.toggle('collapsed');
            } else {
                const isClosed = sidebar.classList.contains('-translate-x-full');
                if (isClosed) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('opacity-0', 'pointer-events-none');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0', 'pointer-events-none');
                }
            }
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('opacity-0', 'pointer-events-none');
            } else {
                sidebar.classList.remove('collapsed');
                sidebar.classList.add('-translate-x-full');
            }
        });

        function toggleNotif() {
            const dropdown = document.getElementById('notif-dropdown');
            const isClosed = dropdown.classList.contains('opacity-0');
            if (isClosed) {
                dropdown.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-2');
                dropdown.classList.add('opacity-100', 'translate-y-0');
            } else {
                dropdown.classList.add('opacity-0', 'pointer-events-none', 'translate-y-2');
                dropdown.classList.remove('opacity-100', 'translate-y-0');
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notif-dropdown');
            const notifBtn = document.getElementById('notif-btn');
            if (notifBtn && dropdown && !notifBtn.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('opacity-0', 'pointer-events-none', 'translate-y-2');
                dropdown.classList.remove('opacity-100', 'translate-y-0');
            }
        });

        function dismissToast(el) {
            if (!el) return;
            el.classList.remove('toast-slide-in');
            el.classList.add('toast-slide-out');
            setTimeout(() => { el.remove(); }, 300);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast-item');
            toasts.forEach(t => {
                setTimeout(() => {
                    dismissToast(t);
                }, 4000);
            });
        });

        window.confirmDelete = function(actionUrl, customMessage) {
            const modal = document.getElementById('delete-modal');
            const modalForm = document.getElementById('delete-modal-form');
            const modalMessage = document.getElementById('delete-modal-message');
            const modalCard = modal.querySelector('div.bg-white');

            modalForm.action = actionUrl;
            if (customMessage) {
                modalMessage.innerText = customMessage;
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        };

        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            const modalCard = modal.querySelector('div.bg-white');

            modal.classList.add('opacity-0', 'pointer-events-none');
            modalCard.classList.remove('scale-100');
            modalCard.classList.add('scale-95');
        }
    </script>
</body>
</html>
