<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mushaf Digital — Baca Al-Qur\'an, Doa & Jadwal Sholat')</title>

    <!-- Google Fonts: Amiri (Arabic) & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-bg-main: #F0F4F2;
            --color-surface: #FFFFFF;
            --color-primary: #0E5C45;
            --color-primary-dark: #083C2C;
            --color-primary-light: #E6F2EC;
            --color-gold: #C28B38;
            --color-gold-light: #FDF7EC;
            --color-border: #D8E4DE;
            --color-text-main: #18251F;
            --color-text-muted: #54706A;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--color-bg-main);
            color: var(--color-text-main);
        }

        .font-arabic {
            font-family: 'Amiri', 'Traditional Arabic', serif;
            direction: rtl;
        }

        /* Hamburger animation */
        .hamburger-btn .ham-line {
            display: block;
            width: 22px;
            height: 2px;
            background: #0E5C45;
            border-radius: 2px;
            transition: all 0.28s cubic-bezier(.4,0,.2,1);
            transform-origin: center;
        }
        .hamburger-btn.is-active .ham-line:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }
        .hamburger-btn.is-active .ham-line:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }
        .hamburger-btn.is-active .ham-line:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #E8EDEA; }
        ::-webkit-scrollbar-thumb { background: #9BBCB2; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #0E5C45; }

        /* Nav active underline effect */
        .nav-link-active {
            color: #0E5C45 !important;
            font-weight: 700;
        }
        .nav-link-active::after {
            content: '';
            display: block;
            height: 2.5px;
            background: #0E5C45;
            border-radius: 2px;
            margin-top: 4px;
        }

        /* Mobile menu slide down */
        #mobile-nav {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.32s ease;
        }
        #mobile-nav.open {
            max-height: 320px;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-[#0E5C45] selection:text-white">

    <!-- ======= HEADER / NAVBAR ======= -->
    <header class="sticky top-0 z-50 bg-white border-b border-[#D8E4DE] shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16 sm:h-[70px]">

                <!-- Brand -->
                <a href="{{ route('quran.index') }}" class="flex items-center gap-2.5 shrink-0 group">
                    <!-- Mushaf icon -->
                    <div class="w-9 h-9 rounded-lg bg-[#0E5C45] flex items-center justify-center shadow-sm group-hover:bg-[#0A3C2F] transition-colors">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[17px] font-black text-[#0E5C45] leading-none block">Mushaf Digital</span>
                        <span class="text-[10px] font-semibold text-[#C28B38] tracking-wide leading-none block mt-0.5">Al-Qur'an • Doa • Sholat</span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('quran.index') }}"
                       class="flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold transition-all
                              {{ request()->routeIs('quran.*') ? 'bg-[#E6F2EC] text-[#0E5C45]' : 'text-[#3A5046] hover:bg-[#F0F4F2] hover:text-[#0E5C45]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Al-Qur'an
                        @if(request()->routeIs('quran.*'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#0E5C45]"></span>
                        @endif
                    </a>

                    <a href="{{ route('doa.index') }}"
                       class="flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold transition-all
                              {{ request()->routeIs('doa.*') ? 'bg-[#E6F2EC] text-[#0E5C45]' : 'text-[#3A5046] hover:bg-[#F0F4F2] hover:text-[#0E5C45]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Doa Harian
                        @if(request()->routeIs('doa.*'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#0E5C45]"></span>
                        @endif
                    </a>

                    <a href="{{ route('shalat.index') }}"
                       class="flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold transition-all
                              {{ request()->routeIs('shalat.*') ? 'bg-[#E6F2EC] text-[#0E5C45]' : 'text-[#3A5046] hover:bg-[#F0F4F2] hover:text-[#0E5C45]' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jadwal Sholat
                        @if(request()->routeIs('shalat.*'))
                            <span class="w-1.5 h-1.5 rounded-full bg-[#0E5C45]"></span>
                        @endif
                    </a>
                </nav>

                <!-- Mobile: Hamburger Button -->
                <button type="button"
                        id="hamburger-btn"
                        onclick="toggleMobileMenu()"
                        class="hamburger-btn md:hidden w-10 h-10 rounded-xl flex flex-col items-center justify-center gap-[5px] bg-[#F0F4F2] hover:bg-[#E6F2EC] border border-[#D8E4DE] focus:outline-none transition-colors"
                        aria-label="Buka Menu">
                    <span class="ham-line"></span>
                    <span class="ham-line"></span>
                    <span class="ham-line"></span>
                </button>
            </div>
        </div>

        <!-- Mobile Nav Dropdown -->
        <div id="mobile-nav" class="md:hidden border-t border-[#D8E4DE] bg-white">
            <div class="max-w-6xl mx-auto px-4 py-3 space-y-1">
                <a href="{{ route('quran.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all
                          {{ request()->routeIs('quran.*') ? 'bg-[#0E5C45] text-white' : 'text-[#1A2621] hover:bg-[#F0F4F2]' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('quran.*') ? 'text-[#C28B38]' : 'text-[#0E5C45]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Al-Qur'an — 114 Surat
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('doa.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all
                          {{ request()->routeIs('doa.*') ? 'bg-[#0E5C45] text-white' : 'text-[#1A2621] hover:bg-[#F0F4F2]' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('doa.*') ? 'text-[#C28B38]' : 'text-[#0E5C45]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Doa Harian & Dzikir
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('shalat.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all
                          {{ request()->routeIs('shalat.*') ? 'bg-[#0E5C45] text-white' : 'text-[#1A2621] hover:bg-[#F0F4F2]' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('shalat.*') ? 'text-[#C28B38]' : 'text-[#0E5C45]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Jadwal Sholat Indonesia
                    <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Error Alerts -->
    @if(isset($error) && $error)
        <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-5 w-full">
            <div class="bg-red-50 border border-red-200 border-l-4 border-l-red-500 p-4 rounded-xl text-red-800 flex items-start justify-between gap-4">
                <div>
                    <p class="font-bold text-xs uppercase tracking-wider mb-1 text-red-600">Pemberitahuan</p>
                    <p class="text-sm">{{ $error }}</p>
                </div>
                <button onclick="this.closest('div').remove()" class="text-red-400 hover:text-red-700 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-5 w-full">
            <div class="bg-red-50 border border-red-200 border-l-4 border-l-red-500 p-4 rounded-xl text-red-800">
                <p class="font-bold text-xs uppercase tracking-wider mb-1 text-red-600">Kesalahan</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1 w-full max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-16 bg-[#082C22] text-[#C5D9D1] border-t-4 border-[#C28B38]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-[#0F3D2E]">

                <!-- Col 1 -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-[#0E5C45] flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h4 class="text-base font-bold text-white">Mushaf Digital</h4>
                    </div>
                    <p class="text-xs text-[#8FADA5] leading-relaxed">
                        Aplikasi Al-Qur'an digital terpadu dengan teks Arab berharakat, terjemahan resmi, murottal tartil, doa harian, dan jadwal sholat seluruh Indonesia.
                    </p>
                </div>

                <!-- Col 2 -->
                <div>
                    <h5 class="text-[10px] font-bold text-[#C28B38] tracking-widest uppercase mb-3">FITUR UTAMA</h5>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('quran.index') }}" class="text-[#B0CCC5] hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="w-1 h-1 rounded-full bg-[#C28B38] shrink-0"></span> Baca 114 Surat Al-Qur'an & Tafsir
                        </a></li>
                        <li><a href="{{ route('doa.index') }}" class="text-[#B0CCC5] hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="w-1 h-1 rounded-full bg-[#C28B38] shrink-0"></span> Kumpulan Doa Harian & Dzikir
                        </a></li>
                        <li><a href="{{ route('shalat.index') }}" class="text-[#B0CCC5] hover:text-white transition-colors flex items-center gap-1.5">
                            <span class="w-1 h-1 rounded-full bg-[#C28B38] shrink-0"></span> Jadwal Sholat 517 Kab/Kota
                        </a></li>
                    </ul>
                </div>

                <!-- Col 3 -->
                <div>
                    <h5 class="text-[10px] font-bold text-[#C28B38] tracking-widest uppercase mb-3">SUMBER DATA</h5>
                    <div class="space-y-2 text-xs text-[#8FADA5]">
                        <p><strong class="text-white">Mushaf & Terjemah:</strong> LPMQ Kementerian Agama RI</p>
                        <p><strong class="text-white">Audio Murottal:</strong> Misyari Rasyid Al-Afasi & Sudais</p>
                        <p><strong class="text-white">Jadwal Sholat:</strong> Ditjen Bimas Islam Kemenag RI</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-[11px] text-[#6A8A82] gap-2">
                <p>&copy; {{ date('Y') }} Mushaf Digital — Aplikasi Al-Qur'an Indonesia.</p>
                <p>Dibuat dengan ❤️ untuk kemudahan ibadah umat Muslim Indonesia.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            var nav = document.getElementById('mobile-nav');
            var btn = document.getElementById('hamburger-btn');
            if (!nav || !btn) return;
            var isOpen = nav.classList.contains('open');
            if (isOpen) {
                nav.classList.remove('open');
                btn.classList.remove('is-active');
                btn.setAttribute('aria-label', 'Buka Menu');
            } else {
                nav.classList.add('open');
                btn.classList.add('is-active');
                btn.setAttribute('aria-label', 'Tutup Menu');
            }
        }
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            var nav = document.getElementById('mobile-nav');
            var btn = document.getElementById('hamburger-btn');
            if (nav && btn && nav.classList.contains('open')) {
                if (!nav.contains(e.target) && !btn.contains(e.target)) {
                    nav.classList.remove('open');
                    btn.classList.remove('is-active');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
