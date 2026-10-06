@extends('layouts.islamic')

@section('title', 'Surat ' . ($quran['namaLatin'] ?? 'Detail') . ' — Mushaf Digital')

@section('content')
<div class="space-y-5">

    <!-- ===== BREADCRUMB & TOP NAV ===== -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <a href="{{ route('quran.index') }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 bg-white rounded-xl border border-[#D0DDD8] hover:border-[#0E5C45] hover:text-[#0E5C45] text-xs font-semibold text-[#54706A] transition-all shadow-sm w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Daftar 114 Surat
        </a>

        <!-- Previous / Next at top -->
        <div class="flex items-center gap-2 text-xs font-semibold">
            @if(!empty($quran['suratSebelumnya']))
                <a href="{{ route('quran.show', $quran['suratSebelumnya']['nomor']) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-white rounded-xl border border-[#D0DDD8] hover:border-[#0E5C45] hover:text-[#0E5C45] text-[#42544C] transition-all shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    {{ $quran['suratSebelumnya']['namaLatin'] }}
                </a>
            @endif
            @if(!empty($quran['suratSelanjutnya']))
                <a href="{{ route('quran.show', $quran['suratSelanjutnya']['nomor']) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-2 bg-white rounded-xl border border-[#D0DDD8] hover:border-[#0E5C45] hover:text-[#0E5C45] text-[#42544C] transition-all shadow-sm">
                    {{ $quran['suratSelanjutnya']['namaLatin'] }}
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @endif
        </div>
    </div>

    <!-- ===== SURAH HEADER CARD ===== -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#0E5C45] via-[#0B4A37] to-[#082C22] text-white p-6 sm:p-9 shadow-lg">
        <!-- Decorative arabic watermark -->
        <div class="absolute right-5 top-1/2 -translate-y-1/2 opacity-[0.08] pointer-events-none font-arabic text-8xl sm:text-9xl leading-none select-none">
            {{ $quran['nama'] ?? '' }}
        </div>
        <div class="absolute -bottom-10 -right-10 w-52 h-52 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5 pb-5 border-b border-white/15">
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-[#C28B38]/25 text-[#E9C37A] text-[10px] font-black tracking-widest border border-[#C28B38]/30">
                        SURAT KE-{{ $quran['nomor'] }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-white/10 text-white/85 text-[10px] font-semibold">
                        {{ $quran['tempatTurun'] }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-white/10 text-white/85 text-[10px] font-semibold">
                        {{ $quran['jumlahAyat'] }} Ayat
                    </span>
                </div>

                <div>
                    <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                        {{ $quran['namaLatin'] }}
                    </h1>
                    <p class="text-sm text-white/70 mt-1">
                        Artinya: <strong class="text-white">&ldquo;{{ $quran['arti'] }}&rdquo;</strong>
                    </p>
                </div>
            </div>

            <div class="shrink-0">
                <span class="font-arabic text-5xl sm:text-7xl text-white block leading-tight">{{ $quran['nama'] }}</span>
                <span class="text-[10px] font-semibold text-[#C28B38] tracking-wider uppercase block mt-1">Mushaf Kemenag RI</span>
            </div>
        </div>

        <!-- Description accordion -->
        @if(!empty($quran['deskripsi']))
            <div class="relative z-10 pt-4">
                <button type="button"
                        onclick="toggleDeskripsi()"
                        id="btn-toggle-deskripsi"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold text-white transition-all">
                    <svg class="w-3.5 h-3.5 text-[#E9C37A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span id="label-toggle-deskripsi">Info & Kandungan Surat</span>
                    <svg id="icon-deskripsi-chevron" class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="box-deskripsi" class="hidden mt-3 p-5 rounded-xl bg-white/10 backdrop-blur-sm text-xs sm:text-sm text-white/85 leading-relaxed border border-white/10">
                    {!! $quran['deskripsi'] !!}
                </div>
            </div>
        @endif
    </div>

    <!-- ===== AUDIO MUROTTAL PLAYER ===== -->
    <div class="bg-white rounded-2xl border border-[#D8E4DE] shadow-sm overflow-hidden">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 p-5 sm:p-6">

            <div class="flex items-center gap-4">
                <!-- Play Button — Triangle Icon Only -->
                <button type="button"
                        id="btn-play-full"
                        onclick="togglePlayFull()"
                        class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-[#0E5C45] hover:bg-[#083C2C] text-white flex items-center justify-center shadow-md transition-all active:scale-95 shrink-0"
                        title="Putar Murottal Surat">
                    <!-- Segitiga Play -->
                    <svg id="icon-full-play" class="w-6 h-6 fill-current ml-0.5" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    <!-- Pause (hidden by default) -->
                    <svg id="icon-full-pause" class="w-6 h-6 fill-current hidden" viewBox="0 0 24 24">
                        <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                    </svg>
                </button>

                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 rounded bg-amber-50 text-[#C28B38] text-[9px] font-bold uppercase tracking-wider border border-amber-200">
                            MUROTTAL
                        </span>
                        <h3 class="text-sm font-bold text-[#18251F]">
                            Surat {{ $quran['namaLatin'] }}
                        </h3>
                    </div>
                    <p class="text-[11px] text-[#6B8076]">Tekan tombol ▶ untuk memutar bacaan tartil seluruh surat.</p>
                </div>
            </div>

            <!-- Qari selector + time -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="qari-select" class="text-[10px] font-bold text-[#54706A] uppercase tracking-wider">QARI:</label>
                    <select id="qari-select"
                            onchange="changeQari(this.value)"
                            class="px-3 py-2 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] text-xs font-semibold text-[#18251F] outline-none focus:border-[#0E5C45]">
                        <option value="05" selected>Misyari Rasyid Al-Afasi</option>
                        <option value="03">Abdurrahman As-Sudais</option>
                        <option value="01">Abdullah Al-Juhany</option>
                        <option value="02">Abdul-Muhsin Al-Qasim</option>
                        <option value="04">Ibrahim Al-Dossari</option>
                        <option value="06">Yasser Al-Dosari</option>
                    </select>
                </div>

                <div class="flex items-center gap-2 px-3 py-2 rounded-xl bg-[#F5F9F7] border border-[#D0DDD8]">
                    <span class="text-xs font-mono font-bold text-[#0E5C45]" id="full-current-time">00:00</span>
                    <span class="text-[#C8D8D0] text-xs">/</span>
                    <span class="text-xs font-mono text-[#54706A]" id="full-duration">00:00</span>
                </div>

                <span id="audio-status-label" class="text-[10px] font-bold text-[#0E5C45] uppercase tracking-wider bg-[#E6F2EC] px-2 py-1 rounded-lg">SIAP DIPUTAR</span>
            </div>
        </div>

        <!-- Progress bar -->
        <div class="px-5 sm:px-6 pb-4 flex items-center gap-3">
            <svg class="w-3.5 h-3.5 text-[#0E5C45] fill-current shrink-0" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            <input type="range"
                   id="full-scrubber"
                   value="0" min="0" max="100" step="0.1"
                   oninput="seekAudioFull(this.value)"
                   class="flex-1 h-1.5 accent-[#0E5C45] rounded-full cursor-pointer">
            <svg class="w-3.5 h-3.5 text-[#B0C4BC] fill-current shrink-0" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
        </div>

        <audio id="audio-full-surat" preload="metadata"
               src="{{ $quran['audioFull']['05'] ?? ($quran['audioFull']['01'] ?? '') }}"></audio>
    </div>

    <!-- ===== STICKY TOOLBAR ===== -->
    <div class="sticky top-[70px] z-30 bg-white/95 backdrop-blur-md rounded-2xl border border-[#D8E4DE] p-3 flex flex-wrap items-center justify-between gap-3 shadow-sm">

        <!-- Mode Tabs -->
        <div class="flex items-center gap-1.5 text-[11px] font-bold">
            <button type="button" id="tab-mode-lengkap" onclick="setMode('lengkap')"
                    class="px-3 py-1.5 rounded-lg bg-[#0E5C45] text-white transition-colors">LENGKAP</button>
            <button type="button" id="tab-mode-arab" onclick="setMode('arab')"
                    class="px-3 py-1.5 rounded-lg bg-[#F5F9F7] text-[#54706A] hover:bg-[#E6F2EC] hover:text-[#0E5C45] border border-[#D0DDD8] transition-colors">ARAB SAJA</button>
            <button type="button" id="tab-mode-tafsir" onclick="setMode('tafsir')"
                    class="px-3 py-1.5 rounded-lg bg-[#F5F9F7] text-[#54706A] hover:bg-[#E6F2EC] hover:text-[#0E5C45] border border-[#D0DDD8] transition-colors">+ TAFSIR</button>
        </div>

        <!-- Jump to Ayat -->
        <div class="flex items-center gap-2">
            <label for="jump-ayat" class="text-[10px] font-bold text-[#54706A] uppercase tracking-wider">KE AYAT:</label>
            <select id="jump-ayat"
                    onchange="handleJumpToAyat(this.value)"
                    class="px-3 py-1.5 rounded-lg bg-[#F5F9F7] border border-[#D0DDD8] text-[11px] font-bold text-[#0E5C45] outline-none focus:border-[#0E5C45]">
                <option value="">-- Pilih (1–{{ $totalAyat }}) --</option>
                @foreach($allNomorAyat as $num)
                    <option value="{{ $num }}">Ayat {{ $num }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- ===== PAGINATION BAR (TOP) ===== -->
    @if($totalPages > 1)
        <div class="bg-white rounded-2xl border border-[#D8E4DE] p-4 flex flex-col sm:flex-row items-center justify-between gap-3 shadow-sm">
            <div class="text-xs text-[#54706A]">
                Ayat <strong class="text-[#0E5C45]">{{ $startAyat }}–{{ $endAyat }}</strong>
                dari <strong class="text-[#0E5C45]">{{ $totalAyat }}</strong> ayat
                &bull; Halaman <strong class="text-[#0E5C45]">{{ $currentPage }}</strong> / {{ $totalPages }}
            </div>

            <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                @if($currentPage > 1)
                    <a href="{{ route('quran.show', ['quran' => $nomor, 'page' => $currentPage - 1, 'per_page' => $perPage]) }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white hover:bg-[#E6F2EC] border border-[#D0DDD8] text-[#0E5C45] transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Sebelumnya
                    </a>
                @endif

                @for($p = max(1, $currentPage - 2); $p <= min($totalPages, $currentPage + 2); $p++)
                    <a href="{{ route('quran.show', ['quran' => $nomor, 'page' => $p, 'per_page' => $perPage]) }}"
                       class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold transition-all {{ $p == $currentPage ? 'bg-[#0E5C45] text-white shadow-sm' : 'bg-[#F5F9F7] text-[#54706A] hover:bg-[#E6F2EC] border border-[#D0DDD8]' }}">
                        {{ $p }}
                    </a>
                @endfor

                @if($currentPage < $totalPages)
                    <a href="{{ route('quran.show', ['quran' => $nomor, 'page' => $currentPage + 1, 'per_page' => $perPage]) }}"
                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-[#0E5C45] text-white hover:bg-[#083C2C] shadow-sm transition-all">
                        Berikutnya
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif

                <!-- Per page -->
                <div class="flex items-center gap-1 text-[10px] font-bold ml-1">
                    <span class="text-[#96AEA7]">/ hal:</span>
                    @foreach([20, 50] as $pp)
                        <a href="{{ route('quran.show', ['quran' => $nomor, 'page' => 1, 'per_page' => $pp]) }}"
                           class="px-2 py-1 rounded-md {{ $perPage == $pp && !$showAll ? 'bg-[#0E5C45] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">{{ $pp }}</a>
                    @endforeach
                    <a href="{{ route('quran.show', ['quran' => $nomor, 'page' => 1, 'per_page' => 'all']) }}"
                       class="px-2 py-1 rounded-md {{ $showAll ? 'bg-[#0E5C45] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua</a>
                </div>
            </div>
        </div>
    @endif

    <!-- ===== BISMILLAH ===== -->
    @if($quran['nomor'] != 1 && $quran['nomor'] != 9 && $currentPage == 1)
        <div class="bg-white rounded-2xl border border-[#D8E4DE] py-7 px-4 text-center shadow-sm">
            <p class="font-arabic text-3xl sm:text-4xl text-[#0E5C45] leading-[2.5]">
                بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
            </p>
            <p class="text-xs text-[#6B8076] mt-2">Dengan nama Allah Yang Maha Pengasih, Maha Penyayang</p>
        </div>
    @endif

    <!-- ===== AYAT LIST ===== -->
    <div class="space-y-4">
        @foreach($quran['ayat'] as $ayat)
            <div id="ayat-{{ $ayat['nomorAyat'] }}"
                 class="ayat-container bg-white rounded-2xl border border-[#D8E4DE] overflow-hidden transition-all scroll-mt-36 shadow-sm">

                <!-- Ayat top bar -->
                <div class="flex items-center justify-between gap-3 px-5 sm:px-6 py-3 bg-[#F8FAF9] border-b border-[#EDF2EF]">

                    <!-- Nomor Ayat badge -->
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-[#0E5C45] text-white flex items-center justify-center font-black text-[11px] shadow-sm">
                            {{ $ayat['nomorAyat'] }}
                        </div>
                        <span class="text-[11px] font-semibold text-[#C28B38]">
                            {{ $quran['namaLatin'] }} : {{ $ayat['nomorAyat'] }}
                        </span>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex items-center gap-1.5">

                        <!-- Play button — hanya icon segitiga -->
                        <button type="button"
                                class="btn-play-ayat w-9 h-9 rounded-full flex items-center justify-center bg-[#E6F2EC] hover:bg-[#0E5C45] text-[#0E5C45] hover:text-white transition-all shadow-sm"
                                data-ayat="{{ $ayat['nomorAyat'] }}"
                                onclick="togglePlayAyat({{ $ayat['nomorAyat'] }})"
                                title="Putar Ayat {{ $ayat['nomorAyat'] }}">
                            <svg class="w-3.5 h-3.5 fill-current ml-0.5 icon-play" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                            <svg class="w-3.5 h-3.5 fill-current hidden icon-pause" viewBox="0 0 24 24">
                                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                            </svg>
                        </button>

                        <!-- Copy button -->
                        <button type="button"
                                class="btn-copy-ayat w-8 h-8 rounded-lg flex items-center justify-center text-[#6B8076] hover:bg-[#F0F4F2] hover:text-[#0E5C45] transition-colors"
                                onclick="copyAyat({{ $ayat['nomorAyat'] }})"
                                title="Salin Ayat">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>

                        <!-- Tafsir toggle -->
                        <button type="button"
                                class="btn-toggle-tafsir-ayat px-2.5 py-1.5 rounded-lg bg-white hover:bg-[#E6F2EC] text-[#54706A] hover:text-[#0E5C45] border border-[#D0DDD8] text-[10px] font-bold transition-colors"
                                onclick="toggleAyatTafsir({{ $ayat['nomorAyat'] }})">
                            TAFSIR
                        </button>
                    </div>
                </div>

                <!-- Ayat content -->
                <div class="px-5 sm:px-7 py-5 space-y-3">

                    <!-- Arabic text -->
                    <p class="font-arabic text-right text-3xl sm:text-4xl leading-[2.6] sm:leading-[2.9] text-[#0E5C45] break-words"
                       id="text-arab-{{ $ayat['nomorAyat'] }}">
                        {{ $ayat['teksArab'] }}
                        <span class="inline-block font-sans text-[10px] font-black px-2 py-0.5 rounded-full bg-[#E6F2EC] text-[#0E5C45] border border-[#B8D8CB] align-middle mx-1.5">
                            {{ $ayat['nomorAyat'] }}
                        </span>
                    </p>

                    <!-- Latin -->
                    <div class="box-latin border-t border-[#EDF2EF] pt-3">
                        <p class="text-xs sm:text-sm font-medium italic text-[#A07828] leading-relaxed"
                           id="text-latin-{{ $ayat['nomorAyat'] }}">
                            {{ $ayat['teksLatin'] }}
                        </p>
                    </div>

                    <!-- Translation -->
                    <div class="box-terjemah">
                        <p class="text-xs sm:text-sm text-[#2A3B33] leading-relaxed"
                           id="text-idn-{{ $ayat['nomorAyat'] }}">
                            {{ $ayat['teksIndonesia'] }}
                        </p>
                    </div>

                    <!-- Tafsir box (collapsible) -->
                    <div id="tafsir-box-{{ $ayat['nomorAyat'] }}"
                         class="box-tafsir hidden mt-1 p-5 rounded-xl bg-[#FDF9F1] border border-[#E8DFC8]">
                        <div class="flex items-center justify-between pb-2 mb-3 border-b border-[#E8DFC8]">
                            <span class="text-[10px] font-bold text-[#A07828] uppercase tracking-wider flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Tafsir Kemenag RI — Ayat {{ $ayat['nomorAyat'] }}
                            </span>
                            <button type="button" onclick="toggleAyatTafsir({{ $ayat['nomorAyat'] }})"
                                    class="text-[10px] font-bold text-[#6B8076] hover:text-[#18251F]">Tutup ×</button>
                        </div>
                        <p class="text-xs sm:text-sm text-[#4A5952] leading-relaxed whitespace-pre-line">
                            {{ $tafsir[$ayat['nomorAyat']] ?? 'Penjelasan tafsir untuk ayat ini belum tersedia.' }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ===== PAGINATION BAR (BOTTOM) ===== -->
    @if($totalPages > 1)
        <div class="bg-white rounded-2xl border border-[#D8E4DE] p-5 shadow-sm">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-[#54706A] text-center sm:text-left">
                    Halaman <strong class="text-[#0E5C45]">{{ $currentPage }}</strong> dari <strong class="text-[#0E5C45]">{{ $totalPages }}</strong>
                    &nbsp;&bull;&nbsp; Ayat {{ $startAyat }}–{{ $endAyat }} dari {{ $totalAyat }}
                </div>

                <div class="flex flex-wrap items-center justify-center gap-2 text-xs font-semibold">
                    @if($currentPage > 1)
                        <a href="{{ route('quran.show', ['quran' => $nomor, 'page' => $currentPage - 1, 'per_page' => $perPage]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white hover:bg-[#E6F2EC] border border-[#D0DDD8] text-[#0E5C45] transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Halaman Sebelumnya
                        </a>
                    @endif

                    @for($p = max(1, $currentPage - 2); $p <= min($totalPages, $currentPage + 2); $p++)
                        <a href="{{ route('quran.show', ['quran' => $nomor, 'page' => $p, 'per_page' => $perPage]) }}"
                           class="w-10 h-10 rounded-xl flex items-center justify-center font-bold transition-all {{ $p == $currentPage ? 'bg-[#0E5C45] text-white shadow-md' : 'bg-[#F5F9F7] text-[#54706A] hover:bg-[#E6F2EC] border border-[#D0DDD8]' }}">
                            {{ $p }}
                        </a>
                    @endfor

                    @if($currentPage < $totalPages)
                        <a href="{{ route('quran.show', ['quran' => $nomor, 'page' => $currentPage + 1, 'per_page' => $perPage]) }}"
                           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-[#0E5C45] text-white hover:bg-[#083C2C] shadow-md transition-all">
                            Halaman Berikutnya
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- ===== NAVIGASI SURAT (BAWAH) ===== -->
    <div class="pt-4 border-t-2 border-[#D8E4DE]">
        <p class="text-center text-[10px] font-bold text-[#C28B38] uppercase tracking-widest mb-3">NAVIGASI SURAT</p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

            <!-- Surat Sebelumnya -->
            <div>
                @if(!empty($quran['suratSebelumnya']))
                    <a href="{{ route('quran.show', $quran['suratSebelumnya']['nomor']) }}"
                       class="group flex items-center gap-3 p-4 bg-white rounded-2xl border border-[#D0DDD8] hover:border-[#0E5C45] hover:bg-[#F5FBF8] transition-all shadow-sm h-full">
                        <div class="w-10 h-10 rounded-xl bg-[#E6F2EC] group-hover:bg-[#0E5C45] text-[#0E5C45] group-hover:text-white flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-[9px] font-bold uppercase tracking-widest text-[#C28B38] block">Surat Sebelumnya</span>
                            <h4 class="text-sm font-extrabold text-[#18251F] group-hover:text-[#0E5C45] truncate transition-colors">
                                {{ $quran['suratSebelumnya']['nomor'] }}. {{ $quran['suratSebelumnya']['namaLatin'] }}
                            </h4>
                        </div>
                    </a>
                @else
                    <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-200 cursor-not-allowed h-full opacity-60">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold uppercase tracking-widest text-gray-400 block">Awal Mushaf</span>
                            <span class="text-xs font-semibold text-gray-400">Al-Fatihah (Pertama)</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kembali ke daftar -->
            <div>
                <a href="{{ route('quran.index') }}"
                   class="flex items-center justify-center gap-2 p-4 bg-white rounded-2xl border border-[#D0DDD8] hover:bg-[#0E5C45] hover:text-white hover:border-[#0E5C45] text-[#0E5C45] text-xs font-extrabold uppercase tracking-wider transition-all shadow-sm h-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Daftar 114 Surat
                </a>
            </div>

            <!-- Surat Selanjutnya -->
            <div>
                @if(!empty($quran['suratSelanjutnya']))
                    <a href="{{ route('quran.show', $quran['suratSelanjutnya']['nomor']) }}"
                       class="group flex items-center justify-end gap-3 p-4 bg-white rounded-2xl border border-[#D0DDD8] hover:border-[#0E5C45] hover:bg-[#F5FBF8] transition-all shadow-sm h-full">
                        <div class="overflow-hidden text-right">
                            <span class="text-[9px] font-bold uppercase tracking-widest text-[#C28B38] block">Surat Berikutnya</span>
                            <h4 class="text-sm font-extrabold text-[#18251F] group-hover:text-[#0E5C45] truncate transition-colors">
                                {{ $quran['suratSelanjutnya']['nomor'] }}. {{ $quran['suratSelanjutnya']['namaLatin'] }}
                            </h4>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-[#E6F2EC] group-hover:bg-[#0E5C45] text-[#0E5C45] group-hover:text-white flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                @else
                    <div class="flex items-center justify-end gap-3 p-4 bg-gray-50 rounded-2xl border border-gray-200 cursor-not-allowed h-full opacity-60">
                        <div class="text-right">
                            <span class="text-[9px] font-bold uppercase tracking-widest text-gray-400 block">Akhir Mushaf</span>
                            <span class="text-xs font-semibold text-gray-400">An-Nas (Terakhir)</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Hidden single ayat audio -->
    <audio id="audio-single-ayat" preload="none"></audio>

</div>
@endsection

@push('scripts')
<script>
    // Audio config
    var audioFullList = @json($quran['audioFull'] ?? []);
    var currentQari = '05';
    var ayatAudioMap = @json($allAyatAudioMap ?? []);
    var perPage = {{ $showAll ? 9999 : $perPage }};
    var currentPage = {{ $currentPage }};
    var showAll = {{ $showAll ? 'true' : 'false' }};

    var fullAudio = document.getElementById('audio-full-surat');
    var btnPlayFull = document.getElementById('btn-play-full');
    var iconFullPlay = document.getElementById('icon-full-play');
    var iconFullPause = document.getElementById('icon-full-pause');
    var fullCurrentTime = document.getElementById('full-current-time');
    var fullDuration = document.getElementById('full-duration');
    var fullScrubber = document.getElementById('full-scrubber');
    var audioStatusLabel = document.getElementById('audio-status-label');
    var singleAudio = document.getElementById('audio-single-ayat');
    var playingAyatNumber = null;

    function formatTime(sec) {
        if (isNaN(sec) || sec < 0) return '00:00';
        var m = Math.floor(sec / 60), s = Math.floor(sec % 60);
        return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
    }

    function setFullPlayState(playing) {
        if (playing) {
            iconFullPlay.classList.add('hidden');
            iconFullPause.classList.remove('hidden');
            audioStatusLabel.textContent = 'SEDANG BERPUTAR';
            audioStatusLabel.className = 'text-[10px] font-bold text-[#C28B38] uppercase tracking-wider bg-amber-50 px-2 py-1 rounded-lg border border-amber-200';
            btnPlayFull.classList.replace('bg-[#0E5C45]', 'bg-[#C28B38]');
            btnPlayFull.classList.replace('hover:bg-[#083C2C]', 'hover:bg-[#A07828]');
        } else {
            iconFullPlay.classList.remove('hidden');
            iconFullPause.classList.add('hidden');
            btnPlayFull.classList.replace('bg-[#C28B38]', 'bg-[#0E5C45]');
            btnPlayFull.classList.replace('hover:bg-[#A07828]', 'hover:bg-[#083C2C]');
        }
    }

    function changeQari(qariCode) {
        currentQari = qariCode;
        if (audioFullList[qariCode]) {
            var wasPlaying = !fullAudio.paused;
            fullAudio.src = audioFullList[qariCode];
            if (wasPlaying) fullAudio.play();
        }
        if (playingAyatNumber !== null && ayatAudioMap[playingAyatNumber] && ayatAudioMap[playingAyatNumber][currentQari]) {
            singleAudio.src = ayatAudioMap[playingAyatNumber][currentQari];
            singleAudio.play();
        }
    }

    function togglePlayFull() {
        if (!fullAudio) return;
        if (singleAudio && !singleAudio.paused) {
            singleAudio.pause();
            resetAyatButtons();
        }
        if (fullAudio.paused) {
            fullAudio.play().then(function () {
                setFullPlayState(true);
            }).catch(function (e) {
                alert('Tidak dapat memutar audio: ' + e.message);
            });
        } else {
            fullAudio.pause();
            setFullPlayState(false);
            audioStatusLabel.textContent = 'DIJEDA';
            audioStatusLabel.className = 'text-[10px] font-bold text-[#54706A] uppercase tracking-wider bg-[#F5F9F7] px-2 py-1 rounded-lg border border-[#D0DDD8]';
        }
    }

    if (fullAudio) {
        fullAudio.addEventListener('timeupdate', function () {
            if (fullAudio.duration) {
                if (fullCurrentTime) fullCurrentTime.textContent = formatTime(fullAudio.currentTime);
                if (fullDuration) fullDuration.textContent = formatTime(fullAudio.duration);
                if (fullScrubber) fullScrubber.value = (fullAudio.currentTime / fullAudio.duration) * 100;
            }
        });
        fullAudio.addEventListener('loadedmetadata', function () {
            if (fullDuration) fullDuration.textContent = formatTime(fullAudio.duration);
        });
        fullAudio.addEventListener('ended', function () {
            setFullPlayState(false);
            audioStatusLabel.textContent = 'SELESAI';
            audioStatusLabel.className = 'text-[10px] font-bold text-[#0E5C45] uppercase tracking-wider bg-[#E6F2EC] px-2 py-1 rounded-lg';
            if (fullScrubber) fullScrubber.value = 0;
        });
    }

    function seekAudioFull(val) {
        if (fullAudio && fullAudio.duration) {
            fullAudio.currentTime = (val / 100) * fullAudio.duration;
        }
    }

    function togglePlayAyat(ayatNomor) {
        if (fullAudio && !fullAudio.paused) {
            fullAudio.pause();
            setFullPlayState(false);
            audioStatusLabel.textContent = 'DIJEDA';
            audioStatusLabel.className = 'text-[10px] font-bold text-[#54706A] uppercase tracking-wider bg-[#F5F9F7] px-2 py-1 rounded-lg border border-[#D0DDD8]';
        }

        var btn = document.querySelector('.btn-play-ayat[data-ayat="' + ayatNomor + '"]');

        if (playingAyatNumber === ayatNomor && !singleAudio.paused) {
            singleAudio.pause();
            resetAyatButtons();
            playingAyatNumber = null;
            return;
        }

        resetAyatButtons();

        var audioUrls = ayatAudioMap[ayatNomor];
        if (!audioUrls) { alert('Audio untuk ayat ini belum tersedia.'); return; }

        var audioSrc = audioUrls[currentQari] || audioUrls['05'] || audioUrls['01'];
        if (!audioSrc) { alert('File audio tidak ditemukan.'); return; }

        singleAudio.src = audioSrc;
        singleAudio.play().then(function () {
            playingAyatNumber = ayatNomor;
            if (btn) {
                btn.querySelector('.icon-play').classList.add('hidden');
                btn.querySelector('.icon-pause').classList.remove('hidden');
                btn.classList.add('bg-[#C28B38]', 'text-white');
                btn.classList.remove('bg-[#E6F2EC]', 'text-[#0E5C45]');
            }
            var container = document.getElementById('ayat-' + ayatNomor);
            if (container) {
                container.classList.add('border-[#0E5C45]', 'ring-2', 'ring-[#0E5C45]/20');
            }
        }).catch(function (e) {
            alert('Gagal memutar audio: ' + e.message);
        });
    }

    if (singleAudio) {
        singleAudio.addEventListener('ended', function () {
            resetAyatButtons();
            playingAyatNumber = null;
        });
    }

    function resetAyatButtons() {
        document.querySelectorAll('.btn-play-ayat').forEach(function (b) {
            b.querySelector('.icon-play').classList.remove('hidden');
            b.querySelector('.icon-pause').classList.add('hidden');
            b.classList.remove('bg-[#C28B38]', 'text-white');
            b.classList.add('bg-[#E6F2EC]', 'text-[#0E5C45]');
        });
        document.querySelectorAll('.ayat-container').forEach(function (c) {
            c.classList.remove('border-[#0E5C45]', 'ring-2', 'ring-[#0E5C45]/20');
        });
    }

    function copyAyat(ayatNomor) {
        var arab = (document.getElementById('text-arab-' + ayatNomor) || {}).innerText || '';
        var latin = (document.getElementById('text-latin-' + ayatNomor) || {}).innerText || '';
        var idn = (document.getElementById('text-idn-' + ayatNomor) || {}).innerText || '';
        var surat = "{{ $quran['namaLatin'] }}";
        var text = surat + ' : Ayat ' + ayatNomor + '\n\n' + arab.trim() + '\n\n' + latin.trim() + '\n\n"' + idn.trim() + '"';

        navigator.clipboard.writeText(text).then(function () {
            var btn = event.currentTarget;
            var orig = btn.innerHTML;
            btn.innerHTML = '<span class="text-[9px] font-bold text-[#0E5C45]">✓</span>';
            setTimeout(function () { btn.innerHTML = orig; }, 1800);
        }).catch(function () {
            alert('Tidak dapat menyalin teks.');
        });
    }

    function toggleAyatTafsir(ayatNomor) {
        var box = document.getElementById('tafsir-box-' + ayatNomor);
        if (box) box.classList.toggle('hidden');
    }

    function toggleDeskripsi() {
        var box = document.getElementById('box-deskripsi');
        var label = document.getElementById('label-toggle-deskripsi');
        var chevron = document.getElementById('icon-deskripsi-chevron');
        if (box.classList.contains('hidden')) {
            box.classList.remove('hidden');
            if (label) label.textContent = 'Tutup Info Surat';
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        } else {
            box.classList.add('hidden');
            if (label) label.textContent = 'Info & Kandungan Surat';
            if (chevron) chevron.style.transform = '';
        }
    }

    function setMode(mode) {
        var tabs = {
            lengkap: document.getElementById('tab-mode-lengkap'),
            arab: document.getElementById('tab-mode-arab'),
            tafsir: document.getElementById('tab-mode-tafsir'),
        };
        var activeClass = 'px-3 py-1.5 rounded-lg bg-[#0E5C45] text-white transition-colors text-[11px] font-bold';
        var inactiveClass = 'px-3 py-1.5 rounded-lg bg-[#F5F9F7] text-[#54706A] hover:bg-[#E6F2EC] hover:text-[#0E5C45] border border-[#D0DDD8] transition-colors text-[11px] font-bold';

        Object.keys(tabs).forEach(function (k) {
            if (tabs[k]) tabs[k].className = inactiveClass;
        });
        if (tabs[mode]) tabs[mode].className = activeClass;

        var boxLatin = document.querySelectorAll('.box-latin');
        var boxTerjemah = document.querySelectorAll('.box-terjemah');
        var boxTafsir = document.querySelectorAll('.box-tafsir');

        if (mode === 'lengkap') {
            boxLatin.forEach(function (el) { el.classList.remove('hidden'); });
            boxTerjemah.forEach(function (el) { el.classList.remove('hidden'); });
            boxTafsir.forEach(function (el) { el.classList.add('hidden'); });
        } else if (mode === 'arab') {
            boxLatin.forEach(function (el) { el.classList.add('hidden'); });
            boxTerjemah.forEach(function (el) { el.classList.add('hidden'); });
            boxTafsir.forEach(function (el) { el.classList.add('hidden'); });
        } else if (mode === 'tafsir') {
            boxLatin.forEach(function (el) { el.classList.remove('hidden'); });
            boxTerjemah.forEach(function (el) { el.classList.remove('hidden'); });
            boxTafsir.forEach(function (el) { el.classList.remove('hidden'); });
        }
    }

    function handleJumpToAyat(targetAyatNum) {
        if (!targetAyatNum) return;
        targetAyatNum = parseInt(targetAyatNum);

        if (!showAll) {
            var targetPage = Math.ceil(targetAyatNum / perPage);
            if (targetPage !== currentPage) {
                window.location.href = "{{ route('quran.show', $nomor) }}?page=" + targetPage + "&per_page={{ $perPage }}#ayat-" + targetAyatNum;
                return;
            }
        }

        var el = document.getElementById('ayat-' + targetAyatNum);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            el.classList.add('ring-4', 'ring-[#0E5C45]/30');
            setTimeout(function () { el.classList.remove('ring-4', 'ring-[#0E5C45]/30'); }, 3000);
        }
    }

    window.addEventListener('load', function () {
        if (window.location.hash) {
            var target = document.querySelector(window.location.hash);
            if (target) {
                setTimeout(function () {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    target.classList.add('ring-4', 'ring-[#0E5C45]/30');
                    setTimeout(function () { target.classList.remove('ring-4', 'ring-[#0E5C45]/30'); }, 3000);
                }, 350);
            }
        }
    });
</script>
@endpush