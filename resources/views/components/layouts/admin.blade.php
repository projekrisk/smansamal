@props([
    'title' => 'Dasbor Admin - SMAN 1 Malingping',
    'headerTitle' => 'Dasbor Pengelola'
])

@php
    $currentUser = auth()->user();
    $pendingArticlesCount = \App\Models\Article::where('type', 'suara_warga')->where('status', 'pending_review')->count();
    $pendingCommentsCount = \App\Models\Comment::where('status', 'pending')->count();
    $pendingUsersCount = \App\Models\User::where('is_active', false)->whereNotIn('role_type', ['admin', 'super_admin'])->count();
    $pendingReportsCount = \App\Models\ArticleReport::where('status', 'pending')->count();
    $pendingTestimonialsCount = \App\Models\Testimonial::where('is_approved', false)->count();
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
                background-color: rgba(255, 255, 255, 0.12) !important;
            }
        }
    </style>
</head>
<body class="antialiased selection:bg-forest selection:text-white flex h-screen overflow-hidden bg-stone-50 font-sans text-stone-900">

    <div id="sidebar-overlay" class="fixed inset-0 bg-stone-900/40 backdrop-blur-sm z-40 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden" onclick="handleSidebarToggle()"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-stone-900 text-stone-300 border-r border-stone-800 transform -translate-x-full lg:translate-x-0 lg:static lg:flex lg:flex-col h-full transition-all duration-300 ease-in-out">

        <div id="logo-area" class="h-16 flex items-center px-6 border-b border-stone-800 flex-shrink-0 transition-all duration-300 bg-stone-950">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 overflow-hidden">
                <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-9 h-9 flex-shrink-0">
                <span class="sidebar-text font-serif text-lg font-semibold text-white leading-none whitespace-nowrap transition-opacity duration-300">
                    Admin<span class="text-terracotta"> Panel</span>
                </span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2 font-sans text-sm font-medium no-scrollbar">
            <p class="nav-section-title px-4 text-[10px] uppercase tracking-widest text-stone-500 mb-2 mt-2 transition-all duration-300"><span>Utama</span></p>

            <a href="{{ route('admin.dashboard') }}" title="Ringkasan" class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-stone-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Ringkasan</span>
                </div>
            </a>

            <p class="nav-section-title px-4 text-[10px] uppercase tracking-widest text-stone-500 mb-2 mt-8 transition-all duration-300"><span>Manajemen Konten</span></p>

            <a href="{{ route('admin.articles.index', ['type' => 'suara_warga']) }}" title="Tinjauan Suara Warga" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ (request()->routeIs('admin.articles.*') && request('type') === 'suara_warga') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @if($pendingArticlesCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-terracotta rounded-full ring-2 ring-stone-900 animate-pulse"></span>
                        @endif
                    </div>
                    <span class="sidebar-text whitespace-nowrap">Tinjauan Suara Warga</span>
                </div>
                @if($pendingArticlesCount > 0)
                    <span class="sidebar-text bg-terracotta text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 transition-opacity duration-300">{{ $pendingArticlesCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.articles.index', ['type' => 'jurnal']) }}" title="Manajemen Berita" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ (request()->routeIs('admin.articles.*') && request('type') === 'jurnal') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Manajemen Berita</span>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}" title="Kategori Konten" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('admin.categories.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Kategori Konten</span>
                </div>
            </a>

            <a href="{{ route('admin.comments.index') }}" title="Komentar Berita" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('admin.comments.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        @if($pendingCommentsCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-terracotta rounded-full ring-2 ring-stone-900 animate-pulse"></span>
                        @endif
                    </div>
                    <span class="sidebar-text whitespace-nowrap">Komentar Berita</span>
                </div>
                @if($pendingCommentsCount > 0)
                    <span class="sidebar-text bg-terracotta text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 transition-opacity duration-300">{{ $pendingCommentsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.agendas.index') }}" title="Agenda & Event" class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('admin.agendas.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.agendas.*') ? 'text-white' : 'text-stone-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Agenda & Event</span>
                </div>
            </a>

            <a href="{{ route('admin.reports.index') }}" title="Laporan Konten" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('admin.reports.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                        @if($pendingReportsCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-stone-900 animate-pulse"></span>
                        @endif
                    </div>
                    <span class="sidebar-text whitespace-nowrap">Laporan Konten</span>
                </div>
                @if($pendingReportsCount > 0)
                    <span class="sidebar-text bg-rose-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 transition-opacity duration-300">{{ $pendingReportsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.testimonials.index') }}" title="Testimoni Alumni" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('admin.testimonials.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        @if($pendingTestimonialsCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-terracotta rounded-full ring-2 ring-stone-900 animate-pulse"></span>
                        @endif
                    </div>
                    <span class="sidebar-text whitespace-nowrap">Testimoni Alumni</span>
                </div>
                @if($pendingTestimonialsCount > 0)
                    <span class="sidebar-text bg-terracotta text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 transition-opacity duration-300">{{ $pendingTestimonialsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.pages.index') }}" title="Halaman Statis" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('admin.pages.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.pages.*') ? 'text-white' : 'text-stone-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="sidebar-text whitespace-nowrap">Halaman Statis</span>
                </div>
            </a>

            <a href="{{ route('admin.announcements.index') }}" title="Pengumuman" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('admin.announcements.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.announcements.*') ? 'text-white' : 'text-stone-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    <span class="sidebar-text whitespace-nowrap">Pengumuman</span>
                </div>
            </a>

            <p class="nav-section-title px-4 text-[10px] uppercase tracking-widest text-stone-500 mb-2 mt-8 transition-all duration-300"><span>Sistem</span></p>

            <a href="{{ route('admin.users.index') }}" title="Kelola Pengguna" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="relative flex-shrink-0">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        @if($pendingUsersCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-amber-500 rounded-full ring-2 ring-stone-900 animate-pulse"></span>
                        @endif
                    </div>
                    <span class="sidebar-text whitespace-nowrap">Kelola Pengguna</span>
                </div>
                @if($pendingUsersCount > 0)
                    <span class="sidebar-text bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 transition-opacity duration-300">{{ $pendingUsersCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.ads.index') }}" title="Pengaturan Iklan" class="nav-item group flex items-center justify-between px-4 py-3 rounded-xl {{ request()->routeIs('admin.ads.*') ? 'bg-forest/20 text-white font-semibold border border-forest/30 shadow-xs' : 'hover:bg-stone-800 hover:text-white' }} transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    <span class="sidebar-text whitespace-nowrap">Pengaturan Iklan</span>
                </div>
            </a>

            <a href="{{ route('home') }}" target="_blank" title="Portal Utama" class="nav-item group flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-stone-800 hover:text-white transition-all duration-300">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 text-stone-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Portal Utama</span>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" title="Keluar Akses" class="w-full nav-item group flex items-center gap-3 px-4 py-3 rounded-xl text-terracotta hover:bg-terracotta/10 transition-all duration-300 mt-auto text-left">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="sidebar-text whitespace-nowrap">Keluar Akses</span>
                    </div>
                </button>
            </form>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <header class="h-16 bg-white border-b border-stone-200 flex items-center justify-between px-4 lg:px-6 z-30 flex-shrink-0 transition-all duration-300 shadow-xs">

            <button onclick="handleSidebarToggle()" class="p-2 -ml-2 text-stone-600 hover:text-stone-900 focus:outline-none hover:bg-stone-50 rounded-lg transition-colors mr-3 lg:mr-6" title="Buka/Tutup Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>

            <form action="{{ route('admin.articles.index') }}" method="GET" class="hidden md:flex relative w-64 lg:w-96">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari artikel, pengguna, topik..." class="w-full pl-10 pr-4 py-2.5 rounded-full border border-stone-200 bg-stone-50 focus:outline-none focus:border-forest focus:ring-1 focus:ring-forest font-sans text-sm transition-colors">
                <svg class="w-4 h-4 text-stone-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>

            <div class="flex items-center gap-4 lg:gap-6 ml-auto">

                @php
                    $adminPendingTotal = $pendingArticlesCount + $pendingCommentsCount + $pendingUsersCount + $pendingReportsCount + $pendingTestimonialsCount;
                @endphp
                <div class="relative group">
                    <button id="notif-btn" onclick="toggleNotif()" class="relative p-2 text-stone-500 hover:text-stone-900 hover:bg-stone-100 rounded-xl transition-colors focus:outline-none cursor-pointer" title="Notifikasi Sistem">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @if($adminPendingTotal > 0)
                            <span class="absolute top-1 right-1 min-w-[18px] h-[18px] bg-terracotta text-white text-[10px] font-bold rounded-full border-2 border-white flex items-center justify-center px-1 shadow-2xs leading-none">
                                {{ $adminPendingTotal > 9 ? '9+' : $adminPendingTotal }}
                            </span>
                        @endif
                    </button>

                    <div id="notif-dropdown" class="absolute right-0 mt-2 w-80 sm:w-88 bg-white rounded-2xl shadow-xl border border-stone-200/90 opacity-0 pointer-events-none transform translate-y-2 transition-all duration-200 z-50 overflow-hidden">
                        <div class="px-4 py-3 bg-stone-50/70 border-b border-stone-100 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <h4 class="font-serif text-sm font-bold text-stone-900">Sistem Alert</h4>
                                @if($adminPendingTotal > 0)
                                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-terracotta/10 text-terracotta">
                                        {{ $adminPendingTotal }} Tindakan
                                    </span>
                                @endif
                            </div>
                            <span class="text-[10px] uppercase tracking-wider font-bold text-terracotta">Moderasi</span>
                        </div>
                        <div class="p-3 space-y-2 text-xs font-sans">
                            @if($pendingArticlesCount > 0)
                                <a href="{{ route('admin.articles.index', ['type' => 'suara_warga', 'status' => 'pending_review']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-terracotta/5 hover:bg-terracotta/10 border border-terracotta/10 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-terracotta"></span>
                                        <span class="text-stone-800 font-semibold">Artikel Suara Warga ditinjau</span>
                                    </div>
                                    <span class="bg-terracotta text-white font-bold px-2 py-0.5 rounded-full text-[10px]">{{ $pendingArticlesCount }}</span>
                                </a>
                            @endif

                            @if($pendingCommentsCount > 0)
                                <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-forest/5 hover:bg-forest/10 border border-forest/10 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-forest"></span>
                                        <span class="text-stone-800 font-semibold">Komentar publik menunggu persetujuan</span>
                                    </div>
                                    <span class="bg-forest text-white font-bold px-2 py-0.5 rounded-full text-[10px]">{{ $pendingCommentsCount }}</span>
                                </a>
                            @endif

                            @if($pendingUsersCount > 0)
                                <a href="{{ route('admin.users.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200/60 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span class="text-stone-800 font-semibold">Akun warga menunggu aktivasi</span>
                                    </div>
                                    <span class="bg-amber-600 text-white font-bold px-2 py-0.5 rounded-full text-[10px]">{{ $pendingUsersCount }}</span>
                                </a>
                            @endif

                            @if($pendingReportsCount > 0)
                                <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 border border-rose-200/60 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                                        <span class="text-stone-800 font-semibold">Laporan artikel baru</span>
                                    </div>
                                    <span class="bg-rose-600 text-white font-bold px-2 py-0.5 rounded-full text-[10px]">{{ $pendingReportsCount }}</span>
                                </a>
                            @endif

                            @if($pendingTestimonialsCount > 0)
                                <a href="{{ route('admin.testimonials.index', ['status' => 'pending']) }}" class="flex items-center justify-between p-2.5 rounded-xl bg-forest/5 hover:bg-forest/10 border border-forest/10 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-forest animate-pulse"></span>
                                        <span class="text-stone-800 font-semibold">Testimoni alumni menunggu kurasi</span>
                                    </div>
                                    <span class="bg-forest text-white font-bold px-2 py-0.5 rounded-full text-[10px]">{{ $pendingTestimonialsCount }}</span>
                                </a>
                            @endif

                            @if($adminPendingTotal === 0)
                                <div class="py-6 text-center">
                                    <div class="w-8 h-8 rounded-full bg-forest/10 text-forest flex items-center justify-center mx-auto mb-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <p class="text-xs font-semibold text-stone-700">Semua antrean bersih</p>
                                    <p class="text-[10px] text-stone-400 mt-0.5">Tidak ada data yang menunggu tindakan moderasi.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 border-l border-stone-200 pl-4 lg:pl-6">
                    <div class="text-right hidden md:block">
                        <p class="font-sans font-bold text-sm text-stone-900 leading-none">{{ $currentUser->name ?? 'Super Admin' }}</p>
                        <p class="font-sans text-[10px] font-bold text-forest uppercase tracking-wider mt-1">{{ $currentUser->role_badge['label'] ?? 'Sistem Kontrol' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-forest">
                        <img src="{{ $currentUser->avatar_url ?? 'https://placehold.co/150x150/2A5C43/ffffff?text=A' }}" alt="Admin" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 sm:p-5 lg:p-6 no-scrollbar">
            {{ $slot }}

            <footer class="border-t border-stone-200/60 pt-4 mt-8 pb-3 flex flex-col md:flex-row items-center justify-between gap-3 font-sans text-[11px] text-stone-400">
                <p>&copy; 2026 SMAN 1 Malingping. Sistem Administrator.</p>
                <p>Versi Sistem: 2.4.1</p>
            </footer>
        </main>
    </div>

    <div id="delete-modal" class="fixed inset-0 z-[300] flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">

        <div class="absolute inset-0 bg-stone-900/60 backdrop-blur-sm cursor-pointer" onclick="closeDeleteModal()"></div>

        <div class="bg-white w-[90%] max-w-sm p-5 md:p-6 rounded-2xl shadow-xl relative z-10 transform scale-95 transition-transform duration-300 text-center font-sans">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>

            <h3 class="font-serif text-lg text-stone-900 font-bold mb-1">Konfirmasi Hapus</h3>
            <p id="delete-modal-message" class="text-stone-500 text-xs mb-5 leading-relaxed">
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini permanen dan tidak dapat dibatalkan.
            </p>

            <form id="delete-modal-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex items-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-stone-100 hover:bg-stone-200 text-stone-700 py-3 rounded-xl text-sm font-semibold transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl text-sm font-bold transition-colors shadow-sm">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-toast />

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
    @stack('scripts')
</body>
</html>
