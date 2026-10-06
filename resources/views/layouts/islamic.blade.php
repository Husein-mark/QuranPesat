<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Al-Qur\'an & Layanan Islami') — eQuran Digital</title>
    
    <!-- Google Fonts: Amiri (Arabic) & Plus Jakarta Sans (Latin) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-bg-main: #F7F5EE;
            --color-surface: #FFFFFF;
            --color-primary: #114B3A;
            --color-primary-dark: #0A3227;
            --color-primary-light: #EBF3EF;
            --color-gold: #8C6D38;
            --color-gold-light: #F9F5EC;
            --color-border: #DCD5C5;
            --color-border-dark: #BDB39E;
            --color-text-main: #1C2621;
            --color-text-muted: #53635B;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--color-bg-main);
            color: var(--color-text-main);
        }

        .font-arabic {
            font-family: 'Amiri', 'Traditional Arabic', serif;
            direction: rtl;
        }

        /* Solid styling - Tanpa gradiasi */
        .bg-islamic-primary { background-color: #114B3A; }
        .bg-islamic-dark { background-color: #0A3227; }
        .bg-islamic-surface { background-color: #FFFFFF; }
        .bg-islamic-light { background-color: #EBF3EF; }
        .bg-islamic-gold { background-color: #8C6D38; }
        .bg-islamic-gold-light { background-color: #F9F5EC; }
        .text-islamic-primary { color: #114B3A; }
        .text-islamic-gold { color: #8C6D38; }
        .border-islamic { border-color: #DCD5C5; }
        .border-islamic-dark { border-color: #BDB39E; }
        .border-islamic-primary { border-color: #114B3A; }
        .border-islamic-gold { border-color: #8C6D38; }

        /* Custom scrollbar tanpa gradiasi */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #EBE6D9;
        }
        ::-webkit-scrollbar-thumb {
            background: #B4A996;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #114B3A;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-[#114B3A] selection:text-white">

    <!-- Main Navigation Header (Solid Bar) -->
    <header class="sticky top-0 z-40 bg-[#FFFFFF] border-b-2 border-[#114B3A] shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Title -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('quran.index') }}" class="group block">
                        <div class="flex items-center gap-2.5">
                            <span class="inline-block px-2.5 py-1 bg-[#114B3A] text-white font-bold text-xs tracking-widest border border-[#0A3227]">
                                MUSHAF
                            </span>
                            <div>
                                <span class="text-xl sm:text-2xl font-extrabold tracking-tight text-[#114B3A] block leading-none">
                                    E Quran Digital
                                </span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Tabs (Text-based, strictly without icons) -->
                <nav class="hidden md:flex items-center gap-1.5 text-xs font-bold tracking-wider">
                    <a href="{{ route('quran.index') }}" 
                       class="px-4 py-2.5 border transition-colors {{ request()->routeIs('quran.*') ? 'bg-[#114B3A] text-white border-[#114B3A]' : 'bg-white text-[#1C2621] border-[#DCD5C5] hover:bg-[#EBF3EF] hover:border-[#114B3A]' }}">
                         01.  AL-QUR'AN
                    </a>

                    <a href="{{ route('doa.index') }}" 
                       class="px-4 py-2.5 border transition-colors {{ request()->routeIs('doa.*') ? 'bg-[#114B3A] text-white border-[#114B3A]' : 'bg-white text-[#1C2621] border-[#DCD5C5] hover:bg-[#EBF3EF] hover:border-[#114B3A]' }}">
                         02.  DOA HARIAN
                    </a>

                    <a href="{{ route('shalat.index') }}" 
                       class="px-4 py-2.5 border transition-colors {{ request()->routeIs('shalat.*') ? 'bg-[#114B3A] text-white border-[#114B3A]' : 'bg-white text-[#1C2621] border-[#DCD5C5] hover:bg-[#EBF3EF] hover:border-[#114B3A]' }}">
                         03.  JADWAL SHOLAT
                    </a>

                </nav>

                <!-- Mobile Menu Toggle Button -->
                <div class="flex md:hidden">
                    <button type="button" 
                            onclick="toggleMobileMenu()" 
                            class="px-3 py-2 text-xs font-bold border border-[#114B3A] text-[#114B3A] bg-[#EBF3EF] active:bg-[#114B3A] active:text-white">
                        MENU NAVIGASI
                    </button>
                </div>
            </div>

            <!-- Mobile Nav Dropdown -->
            <div id="mobile-nav" class="hidden md:hidden pb-4 pt-2 border-t border-[#DCD5C5] flex flex-col gap-2">
                <a href="{{ route('quran.index') }}" 
                   class="px-3 py-2 text-xs font-bold border {{ request()->routeIs('quran.*') ? 'bg-[#114B3A] text-white border-[#114B3A]' : 'bg-white text-[#1C2621] border-[#DCD5C5]' }}">
                    [ 01 ] AL-QUR'AN LENGKAP
                </a>
                <a href="{{ route('doa.index') }}" 
                   class="px-3 py-2 text-xs font-bold border {{ request()->routeIs('doa.*') ? 'bg-[#114B3A] text-white border-[#114B3A]' : 'bg-white text-[#1C2621] border-[#DCD5C5]' }}">
                    [ 02 ] KUMPULAN DOA HARIAN
                </a>
                <a href="{{ route('shalat.index') }}" 
                   class="px-3 py-2 text-xs font-bold border {{ request()->routeIs('shalat.*') ? 'bg-[#114B3A] text-white border-[#114B3A]' : 'bg-white text-[#1C2621] border-[#DCD5C5]' }}">
                    [ 03 ] JADWAL SHOLAT INDONESIA
                </a>
            </div>
        </div>
    </header>

    <!-- Error/Alert Display Section -->
    @if(isset($error) && $error)
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-6 w-full">
            <div class="bg-[#FBF1EF] border-l-4 border-[#C83232] p-4 text-[#8C1D1D]">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-bold text-xs uppercase tracking-wider mb-1">PEMBERITAHUAN SISTEM</p>
                        <p class="text-sm">{{ $error }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-xs font-bold px-2 py-1 bg-white border border-[#C83232]">
                        TUTUP
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-6 w-full">
            <div class="bg-[#FBF1EF] border-l-4 border-[#C83232] p-4 text-[#8C1D1D]">
                <p class="font-bold text-xs uppercase tracking-wider mb-1">KESALAHAN</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Main Page Content -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8">
        @yield('content')
    </main>

    <!-- Professional Islamic Footer (Solid Blocks) -->
    <footer class="mt-16 bg-[#0A3227] text-[#DCD5C5] border-t-4 border-[#8C6D38]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-[#1E4D3E]">
                
                <!-- Col 1: Portal Overview -->
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <h4 class="text-lg font-bold text-white tracking-wide">E Quran Digital</h4>
                    </div>
                    <p class="text-xs text-[#A8BDB4] leading-relaxed mb-4">
                        Aplikasi Al-Qur'an dan Layanan Islami digital terintegrasi API eQuran.id dan Kementerian Agama Republik Indonesia (Kemenag). Dirancang profesional dengan kenyamanan baca teks Arab, audio murottal, doa harian, dan jadwal sholat.
                    </p>
                    <p class="text-[11px] text-[#7E968B]">
                        Dibangun untuk pemenuhan Lembar Kerja Peserta Didik (LKPD) Praktik Individu RPL.
                    </p>
                </div>

                <!-- Col 2: Navigasi Layanan LKPD -->
                <div>
                    <h5 class="text-xs font-bold text-[#E5DCCB] tracking-widest uppercase mb-3 pb-1 border-b border-[#1E4D3E]">
                        3 LAYANAN EQURAN.ID
                    </h5>
                    <ul class="space-y-2 text-xs">
                        <li>
                            <a href="{{ route('quran.index') }}" class="text-[#C4D8CE] hover:text-white transition-colors block py-0.5">
                                &bull; [ 01 ] Al-Qur'an (Surat, Ayat, Audio & Tafsir Kemenag)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('doa.index') }}" class="text-[#C4D8CE] hover:text-white transition-colors block py-0.5">
                                &bull; [ 02 ] Doa Harian (227 Doa, Teks Arab, Latin & Riwayat)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shalat.index') }}" class="text-[#C4D8CE] hover:text-white transition-colors block py-0.5">
                                &bull; [ 03 ] Jadwal Sholat (517 Kab/Kota di 34 Provinsi)
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Standar & Sumber Resmi -->
                <div>
                    <h5 class="text-xs font-bold text-[#E5DCCB] tracking-widest uppercase mb-3 pb-1 border-b border-[#1E4D3E]">
                        INFORMASI TEKNIS & INTEGRASI
                    </h5>
                    <div class="space-y-2 text-xs text-[#A8BDB4]">
                        <p><strong>Sumber Teks & Terjemah:</strong> Lajnah Pentashihan Mushaf Al-Qur'an (LPMQ) Kemenag RI.</p>
                        <p><strong>Murottal Audio:</strong> Qari Misyari Rasyid Al-Afasi, Abdurrahman As-Sudais, Abdullah Al-Juhany, dll.</p>
                        <p class="text-[11px] text-[#7E968B] pt-1">
                            Status Server: Aktif &bull; Caching: 24 Jam
                        </p>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-6 flex flex-col sm:flex-row items-center justify-center text-xs text-[#7E968B] gap-3">
                <p>&copy; {{ date('Y') }} E Quran Digital &mdash; Proyek Website Islami Laravel. Hak cipta terpelihara.</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            var menu = document.getElementById('mobile-nav');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
