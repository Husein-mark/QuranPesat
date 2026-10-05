<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuoteForge — Kumpulan Inspirasi & Pemikiran Bermakna</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Newsreader untuk sentuhan editorial humanis -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400;1,6..72,500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #FAF9F5;
            background-image: radial-gradient(#e5e5dc 1px, transparent 1px);
            background-size: 24px 24px;
        }
        .font-quote {
            font-family: 'Newsreader', Georgia, serif;
        }
    </style>
</head>
<body class="min-h-screen text-stone-800 flex flex-col antialiased selection:bg-amber-100 selection:text-amber-900">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-30 bg-[#FAF9F5]/90 backdrop-blur-md border-b border-stone-200/80">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-stone-900 text-stone-100 flex items-center justify-center font-serif text-lg font-bold shadow-sm">
                    &ldquo;
                </div>
                <div>
                    <span class="font-semibold text-stone-900 tracking-tight text-base block leading-none">QuoteForge</span>
                    <span class="text-[11px] text-stone-500 font-medium tracking-wide">EDISI REFLEKSI HARIAN</span>
                </div>
            </div>

            <!-- Tanggal & Navigasi -->
            <div class="flex items-center gap-4 sm:gap-6">
                <span class="hidden md:inline-flex items-center gap-1.5 text-xs text-stone-500 bg-stone-200/60 px-3 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    API Aktif
                </span>
                
                <nav class="flex items-center gap-4 text-sm font-medium text-stone-600">
                    <a href="/" class="text-stone-900 hover:text-amber-800 transition-colors">Beranda</a>
                    <a href="/produk" class="hover:text-stone-900 transition-colors">Produk</a>
                    <a href="https://dummyjson.com/quotes" target="_blank" class="px-3.5 py-1.5 rounded-lg border border-stone-300 hover:border-stone-400 bg-white/60 text-xs font-semibold text-stone-700 transition-all shadow-2xs">
                        Endpoint API &rarr;
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 max-w-5xl mx-auto w-full px-6 py-12 md:py-16 flex flex-col gap-12">

        <!-- Banner Tanggal & Meta -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-stone-200/70 pb-5">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-amber-800">Kutipan Hari Ini</p>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-stone-900">Kata-Kata yang Menggerakkan Pikiran</h1>
            </div>
            <div class="text-xs text-stone-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span id="current-date"></span>
            </div>
        </div>

        @if($quotes && isset($quotes['quote']))

        <!-- Primary Quote Card (Hero Card) -->
        <article class="relative bg-white rounded-3xl p-8 sm:p-12 md:p-14 border border-stone-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden transition-all">
            
            <!-- Watermark Quote Icon -->
            <div class="absolute -top-3 right-6 select-none pointer-events-none opacity-[0.06] text-stone-900 font-serif text-[180px] leading-none">
                &rdquo;
            </div>

            <div class="relative z-10 flex flex-col">
                <!-- Meta Tag & Reading Indicator -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200/60">
                            #Kutipan-{{ $quotes['id'] ?? 'Inspirasi' }}
                        </span>
                        <span class="text-xs text-stone-400">&bull;</span>
                        <span class="text-xs font-medium text-stone-500">Bacaan 15 detik</span>
                    </div>

                    <!-- Bookmark Icon Button -->
                    <button onclick="toggleBookmark(this)" class="p-2 text-stone-400 hover:text-amber-800 hover:bg-stone-50 rounded-lg transition-colors" title="Simpan Kutipan">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </button>
                </div>

                <!-- Quote Text -->
                <blockquote class="text-2xl sm:text-3xl md:text-4xl font-quote font-normal italic leading-relaxed text-stone-800 mb-8 max-w-3xl">
                    &ldquo;{{ $quotes['quote'] }}&rdquo;
                </blockquote>

                <!-- Author & Signature Section -->
                <div class="pt-6 border-t border-stone-100 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-800 font-semibold text-lg shadow-2xs">
                            {{ strtoupper(substr($author, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-bold text-stone-900 leading-tight">{{ $author }}</h3>
                                <svg class="w-4 h-4 text-sky-600 inline" fill="currentColor" viewBox="0 0 24 24" title="Kreator Terverifikasi">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <p class="text-xs text-stone-500 font-medium mt-0.5">Penulis & Tokoh Inspiratif</p>
                        </div>
                    </div>

                    <!-- Interactive Action Tools -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <!-- Listen / TTS Button -->
                        <button onclick="speakQuote()" id="btn-speak" 
                                class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-stone-200 bg-stone-50/70 hover:bg-stone-100 text-stone-700 text-xs font-semibold transition-all"
                                title="Dengarkan pembacaan teks">
                            <svg class="w-4 h-4 text-stone-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                            </svg>
                            <span>Dengarkan</span>
                        </button>

                        <!-- Copy Button -->
                        <button onclick="copyQuote()" id="btn-copy"
                                class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-stone-200 bg-stone-50/70 hover:bg-stone-100 text-stone-700 text-xs font-semibold transition-all">
                            <svg class="w-4 h-4 text-stone-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            <span id="copy-label">Salin</span>
                        </button>

                        <!-- Share Button -->
                        <button onclick="shareQuote()" 
                                class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-stone-200 bg-stone-50/70 hover:bg-stone-100 text-stone-700 text-xs font-semibold transition-all">
                            <svg class="w-4 h-4 text-stone-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            <span>Bagikan</span>
                        </button>

                        <!-- Next Quote Button (Primary CTA) -->
                        <a href="/" 
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-stone-900 hover:bg-stone-800 text-white text-xs font-semibold transition-all shadow-xs hover:shadow-md">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Kutipan Lain</span>
                        </a>
                    </div>
                </div>
            </div>
        </article>

        @else
        <!-- Error / Offline fallback -->
        <div class="bg-white rounded-3xl p-10 border border-stone-200 text-center max-w-lg mx-auto">
            <div class="w-12 h-12 bg-amber-50 text-amber-700 rounded-full flex items-center justify-center mx-auto mb-4 font-bold text-lg">!</div>
            <h3 class="text-lg font-bold text-stone-900 mb-1">Gagal Menghubungi Sumber Data</h3>
            <p class="text-sm text-stone-500 mb-6">Koneksi ke penyedia quote terputus sejenak. Silakan coba kembali.</p>
            <a href="/" class="px-5 py-2.5 rounded-xl bg-stone-900 text-white text-xs font-semibold hover:bg-stone-800">Muat Ulang</a>
        </div>
        @endif

        <!-- Featured Quotes Grid (Mengisi ruang dengan konten berbobot) -->
        @if(!empty($featured) && count($featured) > 0)
        <section class="space-y-4 pt-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-stone-900">Kutipan Pilihan Lainnya</h2>
                    <p class="text-xs text-stone-500">Cuplikan pemikiran bermakna dari berbagai tokoh dunia</p>
                </div>
                <span class="text-xs font-medium text-stone-400">Dari total {{ $totalQuotes ?? '100+' }} data</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($featured as $item)
                <div class="bg-white/80 hover:bg-white p-6 rounded-2xl border border-stone-200/90 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between group">
                    <div>
                        <div class="text-stone-300 group-hover:text-amber-800 transition-colors font-serif text-2xl font-bold leading-none mb-3">
                            &ldquo;
                        </div>
                        <p class="font-quote text-sm text-stone-700 leading-relaxed italic line-clamp-4 mb-4">
                            {{ $item['quote'] }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-stone-800 truncate max-w-[170px]">{{ $item['author'] }}</span>
                        <span class="text-[10px] text-stone-400 uppercase tracking-wider">#{{ $item['id'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Value / Context Cards (Fitur & Ekosistem) -->
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-stone-200/70 pt-8">
            <div class="flex items-start gap-3 p-4 rounded-xl bg-stone-100/60 border border-stone-200/60">
                <div class="p-2 rounded-lg bg-white text-stone-700 shadow-2xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-stone-800">Kurasi Universal</h4>
                    <p class="text-[11px] text-stone-500 mt-0.5">Kutipan sains, sastra, filsafat, dan motivasi hidup.</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 rounded-xl bg-stone-100/60 border border-stone-200/60">
                <div class="p-2 rounded-lg bg-white text-stone-700 shadow-2xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-stone-800">Cepat & Ringan</h4>
                    <p class="text-[11px] text-stone-500 mt-0.5">Didukung Laravel 12 & arsitektur HTTP Client modern.</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 rounded-xl bg-stone-100/60 border border-stone-200/60">
                <div class="p-2 rounded-lg bg-white text-stone-700 shadow-2xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-stone-800">Endpoint Terintegrasi</h4>
                    <p class="text-[11px] text-stone-500 mt-0.5">Tersedia route <a href="/produk" class="underline hover:text-stone-900">/produk</a> untuk data JSON.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="border-t border-stone-200 bg-white/50 py-6">
        <div class="max-w-5xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-stone-500">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-stone-800">QuoteForge</span>
                <span>&copy; {{ date('Y') }} &middot; Dirancang dengan kesederhanaan bermakna.</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="/produk" class="hover:text-stone-900 transition-colors">Katalog Produk</a>
                <span>&middot;</span>
                <a href="https://dummyjson.com" target="_blank" class="hover:text-stone-900 transition-colors">DummyJSON</a>
                <span>&middot;</span>
                <span class="text-stone-400">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
            </div>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 px-4 py-2.5 rounded-xl bg-stone-900 text-stone-100 text-xs font-semibold shadow-lg flex items-center gap-2 opacity-0 translate-y-3 transition-all duration-300 pointer-events-none z-50">
        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
        </svg>
        <span id="toast-text">Kutipan berhasil disalin!</span>
    </div>

    <!-- Script Interaktif -->
    <script>
        // Tanggal Format Indonesia
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const today = new Date().toLocaleDateString('id-ID', options);
        const dateEl = document.getElementById('current-date');
        if (dateEl) dateEl.textContent = today;

        const currentQuote = @json($quotes['quote'] ?? '');
        const currentAuthor = @json($author ?? '');

        // Salin Teks
        function copyQuote() {
            if (!currentQuote) return;
            const fullText = `"${currentQuote}" — ${currentAuthor}`;
            navigator.clipboard.writeText(fullText).then(() => {
                showToast("Kutipan berhasil disalin ke papan klip!");
            });
        }

        // Web Speech API (Dengarkan Teks)
        function speakQuote() {
            if (!currentQuote) return;
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
                const utterance = new SpeechSynthesisUtterance(currentQuote);
                utterance.lang = 'en-US'; // Sumber DummyJSON dalam bahasa Inggris
                utterance.rate = 0.9;
                
                const btn = document.getElementById('btn-speak');
                btn.classList.add('bg-amber-100', 'text-amber-900', 'border-amber-300');
                
                utterance.onend = () => {
                    btn.classList.remove('bg-amber-100', 'text-amber-900', 'border-amber-300');
                };

                window.speechSynthesis.speak(utterance);
                showToast("Memutar audio kutipan...");
            } else {
                showToast("Fitur audio tidak didukung di browser ini.");
            }
        }

        // Bagikan (Web Share API)
        function shareQuote() {
            if (navigator.share && currentQuote) {
                navigator.share({
                    title: `Kutipan dari ${currentAuthor}`,
                    text: `"${currentQuote}" — ${currentAuthor}`,
                    url: window.location.href,
                }).catch(() => {});
            } else {
                copyQuote();
            }
        }

        // Bookmark Toggle
        function toggleBookmark(btn) {
            const svg = btn.querySelector('svg');
            const isSaved = svg.getAttribute('fill') === 'currentColor';
            if (isSaved) {
                svg.setAttribute('fill', 'none');
                btn.classList.remove('text-amber-800');
                showToast("Dihapus dari simpanan.");
            } else {
                svg.setAttribute('fill', 'currentColor');
                btn.classList.add('text-amber-800');
                showToast("Kutipan tersimpan!");
            }
        }

        // Toast Helper
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastText = document.getElementById('toast-text');
            toastText.textContent = message;
            toast.classList.remove('opacity-0', 'translate-y-3');
            toast.classList.add('opacity-100', 'translate-y-0');
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-3');
                toast.classList.remove('opacity-100', 'translate-y-0');
            }, 2500);
        }
    </script>
</body>
</html>