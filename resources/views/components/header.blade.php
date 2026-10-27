@props([
    'isHome' => true,
])

<div id="header-wrapper" class="fixed top-0 left-0 right-0 w-full flex justify-center z-50 transition-all duration-300 pt-4 md:pt-8 px-4 sm:px-6">
    <header id="main-header" class="w-full flex justify-between items-center bg-white backdrop-blur-md px-6 md:px-8 py-4 shadow-sm transition-all duration-300 max-w-[1200px] rounded-full border border-white">

        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" class="w-10 h-10 md:w-11 md:h-11" loading="lazy" decoding="async">
            <span class="font-serif text-xl md:text-2xl font-semibold text-forest leading-none group-hover:opacity-90 transition-opacity">
                SMAN 1<span class="text-terracotta"> Malingping</span>
            </span>
        </a>

        <nav class="hidden lg:flex items-center space-x-5 xl:space-x-7 font-sans text-sm font-medium text-stone-800">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-forest font-semibold' : 'hover:text-forest' }} transition-colors">Beranda</a>
            <a href="{{ route('profil-sekolah') }}" class="{{ request()->routeIs('profil-sekolah') ? 'text-forest font-semibold' : 'hover:text-forest' }} transition-colors">Profil</a>
            <a href="{{ route('sop') }}" class="{{ request()->routeIs('sop') ? 'text-forest font-semibold' : 'hover:text-forest' }} transition-colors">SOP</a>
            <a href="{{ route('home') }}#news" class="{{ (request()->routeIs('berita.*') || request()->routeIs('jurnal.*')) ? 'text-forest font-semibold' : 'hover:text-forest' }} transition-colors">Berita</a>
            <a href="{{ route('home') }}#artikel" class="{{ request()->routeIs('suara-warga.*') ? 'text-forest font-semibold' : 'hover:text-forest' }} transition-colors">Suara Warga</a>
            <a href="{{ route('home') }}#alumni" class="mobile-link hover:text-forest transition-colors">Alumni</a>
        </nav>

        <div class="hidden lg:flex items-center gap-3">
            @auth
                @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                    $navNotifs = auth()->user()->notifications()->take(6)->get();
                @endphp

                <div class="relative" x-data="{ notifOpen: false }">
                    <button
                        @click="notifOpen = !notifOpen"
                        @click.away="notifOpen = false"
                        class="relative w-9 h-9 rounded-full bg-white border border-stone-200 flex items-center justify-center text-stone-600 hover:text-forest hover:border-forest transition-colors shadow-2xs focus:outline-none"
                        title="Notifikasi"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-terracotta text-white text-[10px] font-bold rounded-full border-2 border-white flex items-center justify-center px-1">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </button>

                    <div
                        x-show="notifOpen"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-stone-100 py-2 z-50 font-sans text-sm"
                        style="display: none;"
                    >
                        <div class="p-3.5 border-b border-stone-100 flex justify-between items-center px-4">
                            <span class="font-bold text-stone-900 text-sm">Notifikasi</span>
                            @if($unreadCount > 0)
                                <form method="POST" action="{{ route('notifications.read-all') }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-forest hover:text-stone-900 font-semibold transition-colors">
                                        Tandai Semua Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="max-h-80 overflow-y-auto no-scrollbar divide-y divide-stone-50">
                            @forelse($navNotifs as $notif)
                                @php
                                    $data = $notif->data;
                                    $isUnread = is_null($notif->read_at);
                                @endphp
                                <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left p-3.5 hover:bg-stone-50 transition-colors flex gap-3 {{ $isUnread ? 'bg-forest/5' : '' }} cursor-pointer">
                                        <div class="relative w-8 h-8 flex-shrink-0 mt-0.5">
                                            <div class="w-8 h-8 rounded-full overflow-hidden bg-stone-200">
                                                <img src="{{ $data['author_avatar'] ?? asset('images/avatar-default.svg') }}" alt="{{ $data['author_name'] ?? 'Penulis' }}" class="w-full h-full object-cover">
                                            </div>
                                            @if(($data['type'] ?? '') === 'new_comment')
                                                <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-forest text-white flex items-center justify-center text-[8px] shadow-2xs" title="Komentar Baru">💬</span>
                                            @elseif(($data['type'] ?? '') === 'comment_reply')
                                                <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-terracotta text-white flex items-center justify-center text-[8px] shadow-2xs" title="Balasan Komentar">↩️</span>
                                            @elseif(($data['type'] ?? '') === 'testimonial_approved')
                                                <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[8px] shadow-2xs" title="Testimoni Disetujui">⭐</span>
                                            @elseif(($data['type'] ?? '') === 'testimonial_rejected')
                                                <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-rose-600 text-white flex items-center justify-center text-[8px] shadow-2xs" title="Testimoni Perlu Revisi">📝</span>
                                            @endif
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <p class="text-xs text-stone-800 leading-snug">
                                                <span class="font-bold text-stone-900">{{ $data['author_name'] ?? 'Warga' }}</span>
                                                @if(($data['type'] ?? '') === 'new_comment')
                                                    mengomentari karya Anda:
                                                    <span class="font-semibold text-forest block mt-0.5 truncate">"{{ $data['article_title'] ?? $data['title'] ?? 'Artikel' }}"</span>
                                                    @if(!empty($data['comment_snippet']))
                                                        <span class="text-[11px] text-stone-500 italic block mt-0.5 line-clamp-1">"{{ $data['comment_snippet'] }}"</span>
                                                    @endif
                                                @elseif(($data['type'] ?? '') === 'comment_reply')
                                                    membalas komentar Anda di:
                                                    <span class="font-semibold text-terracotta block mt-0.5 truncate">"{{ $data['article_title'] ?? $data['title'] ?? 'Artikel' }}"</span>
                                                    @if(!empty($data['comment_snippet']))
                                                        <span class="text-[11px] text-stone-500 italic block mt-0.5 line-clamp-1">"{{ $data['comment_snippet'] }}"</span>
                                                    @endif
                                                @elseif(($data['type'] ?? '') === 'testimonial_approved')
                                                    <span class="text-emerald-700 font-bold block mt-0.5">Testimoni Anda disetujui</span>
                                                    <span class="text-[11px] text-stone-600 block mt-0.5">Testimoni alumni Anda kini ditayangkan di beranda sekolah.</span>
                                                @elseif(($data['type'] ?? '') === 'testimonial_rejected')
                                                    <span class="text-rose-700 font-bold block mt-0.5">Testimoni ditolak redaksi</span>
                                                    <span class="text-[11px] text-rose-700 block mt-0.5 line-clamp-1">Catatan: "{{ $data['rejection_reason'] ?? 'Catatan redaksi' }}"</span>
                                                @else
                                                    menerbitkan artikel baru:
                                                    <span class="font-semibold text-forest block mt-0.5 truncate">"{{ Str::limit($data['title'] ?? 'Artikel Baru', 38) }}"</span>
                                                @endif
                                            </p>
                                            <span class="text-[10px] text-stone-400 mt-1 block">{{ $notif->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($isUnread)
                                            <span class="w-2 h-2 rounded-full bg-forest flex-shrink-0 mt-1.5" title="Belum dibaca"></span>
                                        @endif
                                    </button>
                                </form>
                            @empty
                                <div class="p-6 text-center text-xs text-stone-400">
                                    Belum ada notifikasi baru untuk Anda.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2.5 bg-white border border-stone-200 py-1.5 px-3 rounded-full hover:border-forest transition-colors shadow-sm focus:outline-none">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-7 h-7 rounded-full object-cover" loading="lazy" decoding="async">
                        <span class="font-sans text-xs font-bold text-stone-800 max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                        <svg class="w-3.5 h-3.5 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition.origin.top.right class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-stone-100 py-2 z-50 font-sans text-sm" style="display: none;">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-forest font-bold hover:bg-stone-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-stone-700 hover:bg-stone-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Dashboard Warga
                            </a>
                            <a href="{{ route('warga.profile', auth()->user()->username ?? auth()->id()) }}" class="flex items-center gap-2 px-4 py-2 text-stone-700 hover:bg-stone-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Publik Saya
                            </a>
                            <a href="{{ route('warga.articles.create') }}" class="flex items-center gap-2 px-4 py-2 text-stone-700 hover:bg-stone-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Tulis Suara Warga
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-stone-700 hover:bg-stone-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan Akun
                        </a>
                        <hr class="my-1 border-stone-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="inline-block bg-forest text-white px-6 py-2.5 rounded-full text-sm font-medium hover:bg-stone-900 transition-colors duration-300 shadow-sm">
                    Login
                </a>
            @endauth
        </div>

        <div class="flex items-center gap-2 lg:hidden">
            @auth
                @php
                    $mobileUnread = auth()->user()->unreadNotifications->count();
                @endphp
                <a href="{{ route('dashboard') }}" class="relative p-2 text-stone-700 focus:outline-none" title="Notifikasi">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    @if($mobileUnread > 0)
                        <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-terracotta rounded-full border border-white"></span>
                    @endif
                </a>
            @endauth
            <button id="menu-open" class="text-stone-800 p-2 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </header>
</div>

<div id="mobile-overlay" class="fixed inset-0 bg-stone-900/40 backdrop-blur-sm z-[60] opacity-0 pointer-events-none"></div>
<div id="mobile-menu" class="fixed top-0 right-0 h-full w-4/5 max-w-sm bg-stone-50 z-[70] transform translate-x-full shadow-2xl flex flex-col">
    <div class="p-6 flex justify-between items-center border-b border-stone-200">
        <span class="font-serif text-xl font-semibold text-forest">Menu Portal</span>
        <button id="menu-close" class="text-stone-500 hover:text-stone-900 p-2 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    <div class="flex-grow overflow-y-auto p-6 flex flex-col space-y-6 font-sans text-lg text-stone-800">
        <a href="{{ route('home') }}" class="mobile-link hover:text-forest transition-colors">Beranda</a>
        <a href="{{ route('profil-sekolah') }}" class="mobile-link hover:text-forest transition-colors">Profil Sekolah</a>
        <a href="{{ route('sop') }}" class="mobile-link hover:text-forest transition-colors">SOP Pelayanan</a>
        <a href="{{ route('home') }}#berita" class="mobile-link hover:text-forest transition-colors">Berita</a>
        <a href="{{ route('home') }}#suara-warga" class="mobile-link hover:text-forest transition-colors">Suara Warga</a>
        <a href="{{ route('home') }}#alumni" class="mobile-link hover:text-forest transition-colors">Alumni</a>
        <hr class="border-stone-200">
        @auth
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover">
                <div>
                    <p class="font-bold text-sm text-stone-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-stone-500">{{ auth()->user()->role_badge['label'] }}</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="bg-forest text-white text-center px-6 py-3 rounded-full text-base font-medium">Dashboard Admin</a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-forest text-white text-center px-6 py-3 rounded-full text-base font-medium">Dashboard Warga</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full border border-red-200 text-red-600 text-center px-6 py-3 rounded-full text-base font-medium">Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="bg-forest text-white text-center px-6 py-3 rounded-full text-base font-medium hover:bg-stone-900 transition-colors">
                Login Warga
            </a>
            <a href="{{ route('admin.login') }}" class="border border-stone-300 text-stone-700 text-center px-6 py-2.5 rounded-full text-sm font-medium hover:bg-stone-100 transition-colors">
                Login Pengelola / Admin
            </a>
        @endauth
    </div>
</div>
