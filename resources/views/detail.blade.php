@extends('layouts.islamic')

@section('title', 'Surat ' . ($quran['namaLatin'] ?? 'Detail Surat') . ' — Teks Arab, Latin, Audio & Tafsir')

@section('content')
<div class="space-y-6">

    <!-- Top Navigation Bar & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#DCD5C5]">
        <div>
            <a href="{{ route('quran.index') }}" 
               class="inline-block px-3 py-1.5 bg-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold text-[#114B3A] uppercase tracking-wider transition-colors">
                &larr; KEMBALI KE DAFTAR SURAT
            </a>
        </div>

        <!-- Next / Prev Surah Navigation -->
        <div class="flex items-center gap-2 text-xs font-bold">
            @if(!empty($quran['suratSebelumnya']))
                <a href="{{ route('quran.show', $quran['suratSebelumnya']['nomor']) }}" 
                   class="px-3 py-1.5 bg-white border border-[#DCD5C5] hover:border-[#114B3A] text-[#1C2621] uppercase transition-colors">
                    &larr; {{ $quran['suratSebelumnya']['namaLatin'] }} ({{ $quran['suratSebelumnya']['nomor'] }})
                </a>
            @endif

            @if(!empty($quran['suratSelanjutnya']))
                <a href="{{ route('quran.show', $quran['suratSelanjutnya']['nomor']) }}" 
                   class="px-3 py-1.5 bg-white border border-[#DCD5C5] hover:border-[#114B3A] text-[#1C2621] uppercase transition-colors">
                    {{ $quran['suratSelanjutnya']['namaLatin'] }} ({{ $quran['suratSelanjutnya']['nomor'] }}) &rarr;
                </a>
            @endif
        </div>
    </div>

    <!-- Surah Header Card (Solid Surface) -->
    <div class="bg-white border-2 border-[#114B3A] p-6 sm:p-8">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 pb-6 border-b border-[#DCD5C5]">
            
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-0.5 bg-[#114B3A] text-white text-xs font-bold tracking-widest uppercase">
                        SURAT NOMOR {{ sprintf('%03d', $quran['nomor']) }}
                    </span>
                    <span class="px-2.5 py-0.5 bg-[#F7F5EE] border border-[#BDB39E] text-xs font-bold text-[#8C6D38] uppercase">
                        GOLONGAN {{ $quran['tempatTurun'] }}
                    </span>
                    <span class="px-2.5 py-0.5 bg-[#F7F5EE] border border-[#BDB39E] text-xs font-bold text-[#53635B] uppercase">
                        {{ $quran['jumlahAyat'] }} AYAT
                    </span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-extrabold text-[#114B3A] tracking-tight">
                    {{ $quran['namaLatin'] }}
                </h1>
                
                <p class="text-base text-[#53635B]">
                    Arti Surat: <strong class="text-[#1C2621]">&ldquo;{{ $quran['arti'] }}&rdquo;</strong>
                </p>
            </div>

            <!-- Big Arabic Title -->
            <div class="text-right">
                <span class="font-arabic text-5xl sm:text-7xl text-[#114B3A] block leading-none py-2">
                    {{ $quran['nama'] }}
                </span>
                <span class="text-xs text-[#8C6D38] font-bold tracking-widest uppercase block mt-1">
                    MUSHAF STANDAR INDONESIA
                </span>
            </div>

        </div>

        <!-- Description Accordion / Toggle -->
        @if(!empty($quran['deskripsi']))
            <div class="pt-5">
                <button type="button" 
                        onclick="toggleDeskripsi()" 
                        id="btn-toggle-deskripsi"
                        class="px-3 py-1.5 bg-[#F7F5EE] border border-[#DCD5C5] text-xs font-bold text-[#114B3A] hover:bg-[#EBF3EF] transition-colors">
                    [ + BUKA DESKRIPSI & LATAR BELAKANG SURAT ]
                </button>
                <div id="box-deskripsi" class="hidden mt-3 p-4 bg-[#F7F5EE] border border-[#DCD5C5] text-xs sm:text-sm text-[#404D46] leading-relaxed">
                    {!! $quran['deskripsi'] !!}
                </div>
            </div>
        @endif
    </div>

    <!-- Audio Murottal Full Surat Player (Solid Box, Audio Wajib) -->
    <div class="bg-white border-2 border-[#8C6D38] p-5 sm:p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 bg-[#8C6D38] text-white text-[10px] font-bold uppercase tracking-wider">
                        AUDIO RESMI
                    </span>
                    <h3 class="text-sm sm:text-base font-extrabold text-[#114B3A] tracking-tight">
                        Murottal Lengkap Surat {{ $quran['namaLatin'] }}
                    </h3>
                </div>
                <p class="text-xs text-[#53635B]">
                    Dengarkan tilawah tartil surat utuh dengan pilihan qari terkemuka.
                </p>
            </div>

            <!-- Qari Selector & Controls Bar -->
            <div class="flex flex-wrap items-center gap-3">
                
                <!-- Pilihan Qari -->
                <div class="flex items-center gap-2">
                    <label for="qari-select" class="text-xs font-bold text-[#1C2621]">QARI:</label>
                    <select id="qari-select" 
                            onchange="changeQari(this.value)" 
                            class="px-3 py-2 bg-[#F7F5EE] border border-[#DCD5C5] text-xs font-bold text-[#1C2621] outline-none">
                        <option value="05" selected>Misyari Rasyid Al-Afasi</option>
                        <option value="03">Abdurrahman as-Sudais</option>
                        <option value="01">Abdullah Al-Juhany</option>
                        <option value="02">Abdul-Muhsin Al-Qasim</option>
                        <option value="04">Ibrahim Al-Dossari</option>
                        <option value="06">Yasser Al-Dosari</option>
                    </select>
                </div>

                <!-- Custom Solid Play/Pause Button -->
                <button type="button" 
                        id="btn-play-full" 
                        onclick="togglePlayFull()" 
                        class="px-5 py-2 bg-[#114B3A] hover:bg-[#0A3227] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] transition-colors">
                    PUTAR AUDIO SURAT
                </button>

                <!-- Audio Time Tracker -->
                <div class="px-3 py-2 bg-[#F7F5EE] border border-[#DCD5C5] text-xs font-mono font-bold text-[#114B3A]">
                    <span id="full-current-time">00:00</span> / <span id="full-duration">00:00</span>
                </div>

            </div>
        </div>

        <!-- Hidden Audio Element for Full Surat -->
        <audio id="audio-full-surat" 
               preload="metadata" 
               src="{{ $quran['audioFull']['05'] ?? ($quran['audioFull']['01'] ?? '') }}">
        </audio>

        <!-- Progress Scrubber Bar (Solid Bar, No Gradient) -->
        <div class="mt-4 pt-3 border-t border-[#F0ECE2] flex items-center gap-3">
            <span class="text-[10px] font-bold text-[#53635B] uppercase">PROGRESS:</span>
            <input type="range" 
                   id="full-scrubber" 
                   value="0" 
                   min="0" 
                   max="100" 
                   step="0.1" 
                   oninput="seekAudioFull(this.value)"
                   class="flex-1 accent-[#114B3A] h-2 bg-[#DCD5C5] cursor-pointer">
            <span id="audio-status-label" class="text-[11px] font-bold text-[#8C6D38] uppercase">SIAP DIPUTAR</span>
        </div>
    </div>

    <!-- View Mode Toolbar & Jump to Ayat (Interaksi Pengguna) -->
    <div class="sticky top-20 z-30 bg-[#F7F5EE] border-2 border-[#DCD5C5] p-3 flex flex-wrap items-center justify-between gap-3 shadow-xs">
        
        <!-- Mode Tabs -->
        <div class="flex items-center gap-1.5 text-xs font-bold">
            <button type="button" 
                    id="tab-mode-lengkap" 
                    onclick="setMode('lengkap')" 
                    class="px-3 py-1.5 bg-[#114B3A] text-white border border-[#114B3A]">
                MODE LENGKAP
            </button>
            <button type="button" 
                    id="tab-mode-tafsir" 
                    onclick="setMode('tafsir')" 
                    class="px-3 py-1.5 bg-white text-[#1C2621] border border-[#DCD5C5] hover:bg-[#EBF3EF]">
                MODE TAFSIR KEMENAG
            </button>
            <button type="button" 
                    id="tab-mode-arab" 
                    onclick="setMode('arab')" 
                    class="px-3 py-1.5 bg-white text-[#1C2621] border border-[#DCD5C5] hover:bg-[#EBF3EF]">
                HANYA TEKS ARAB
            </button>
        </div>

        <!-- Jump to Ayat Dropdown -->
        <div class="flex items-center gap-2">
            <label for="jump-ayat" class="text-xs font-bold text-[#1C2621]">MENUJU AYAT:</label>
            <select id="jump-ayat" 
                    onchange="jumpToAyat(this.value)" 
                    class="px-3 py-1.5 bg-white border border-[#DCD5C5] text-xs font-bold text-[#114B3A] outline-none">
                <option value="">-- Pilih Ayat (1 - {{ $quran['jumlahAyat'] }}) --</option>
                @foreach($quran['ayat'] as $a)
                    <option value="ayat-{{ $a['nomorAyat'] }}">Ayat {{ $a['nomorAyat'] }}</option>
                @endforeach
            </select>
        </div>

    </div>

    <!-- Ayat Listing Section -->
    <div class="space-y-4">
        
        <!-- Bismillah Header for Surat besides Al-Fatihah and At-Taubah (Nomor 9) -->
        @if($quran['nomor'] != 1 && $quran['nomor'] != 9)
            <div class="bg-white border border-[#DCD5C5] py-8 px-4 text-center">
                <span class="font-arabic text-3xl sm:text-4xl text-[#114B3A] block leading-relaxed">
                    بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ
                </span>
                <p class="text-xs text-[#53635B] mt-2">
                    Dengan nama Allah Yang Maha Pengasih, Maha Penyayang
                </p>
            </div>
        @endif

        @foreach($quran['ayat'] as $ayat)
            <div id="ayat-{{ $ayat['nomorAyat'] }}" 
                 class="ayat-container bg-white border border-[#DCD5C5] p-5 sm:p-7 transition-colors scroll-mt-36"
                 data-nomor="{{ $ayat['nomorAyat'] }}">
                
                <!-- Ayat Top Action Bar -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 mb-4 border-b border-[#F0ECE2]">
                    
                    <!-- Ayat Badge -->
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-[#114B3A] text-white text-xs font-extrabold tracking-wider">
                            AYAT {{ $ayat['nomorAyat'] }}
                        </span>
                        <span class="text-[11px] font-bold text-[#8C6D38]">
                            {{ $quran['namaLatin'] }}: {{ $ayat['nomorAyat'] }}
                        </span>
                    </div>

                    <!-- Action Buttons (Strictly without icons, text only) -->
                    <div class="flex items-center gap-2">
                        
                        <!-- Play Ayat Audio Button -->
                        <button type="button" 
                                class="btn-play-ayat px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#114B3A] text-[#114B3A] hover:text-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold uppercase transition-colors"
                                data-ayat="{{ $ayat['nomorAyat'] }}"
                                onclick="togglePlayAyat({{ $ayat['nomorAyat'] }})">
                            PUTAR AYAT
                        </button>

                        <!-- Copy Text Button -->
                        <button type="button" 
                                class="btn-copy-ayat px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#8C6D38] text-[#8C6D38] hover:text-white border border-[#DCD5C5] hover:border-[#8C6D38] text-xs font-bold uppercase transition-colors"
                                onclick="copyAyat({{ $ayat['nomorAyat'] }})">
                            SALIN AYAT
                        </button>

                        <!-- Toggle Tafsir Button -->
                        <button type="button" 
                                class="btn-toggle-tafsir-ayat px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#EBF3EF] text-[#53635B] border border-[#DCD5C5] text-xs font-bold uppercase transition-colors"
                                onclick="toggleAyatTafsir({{ $ayat['nomorAyat'] }})">
                            TAFSIR
                        </button>

                    </div>
                </div>

                <!-- Ayat Arabic Text (Amiri Font, Clear Tashkeel) -->
                <div class="py-3 text-right">
                    <p class="font-arabic text-3xl sm:text-4xl leading-[2.6] sm:leading-[2.8] text-[#114B3A] break-words" 
                       id="text-arab-{{ $ayat['nomorAyat'] }}">
                        {{ $ayat['teksArab'] }}
                        <span class="inline-block font-sans text-xs font-bold px-2 py-0.5 bg-[#F7F5EE] text-[#8C6D38] border border-[#BDB39E] align-middle mx-1.5">
                            {{ $ayat['nomorAyat'] }}
                        </span>
                    </p>
                </div>

                <!-- Latin Transliteration -->
                <div class="box-latin pt-3 pb-1 border-t border-[#F0ECE2]">
                    <p class="text-xs sm:text-sm font-medium italic text-[#8C6D38] leading-relaxed" 
                       id="text-latin-{{ $ayat['nomorAyat'] }}">
                        {{ $ayat['teksLatin'] }}
                    </p>
                </div>

                <!-- Indonesian Translation -->
                <div class="box-terjemah pt-2">
                    <p class="text-xs sm:text-sm text-[#1C2621] leading-relaxed font-normal" 
                       id="text-idn-{{ $ayat['nomorAyat'] }}">
                        {{ $ayat['teksIndonesia'] }}
                    </p>
                </div>

                <!-- Tafsir Box (Collapsible / Active on Mode Tafsir) -->
                <div id="tafsir-box-{{ $ayat['nomorAyat'] }}" 
                     class="box-tafsir hidden mt-4 p-4 bg-[#F9F5EC] border-l-4 border-[#8C6D38] border-t border-r border-b border-[#DCD5C5]">
                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-[#E8DFC8]">
                        <span class="text-xs font-bold text-[#8C6D38] uppercase tracking-wider">
                            TAFSIR KEMENTERIAN AGAMA RI &mdash; AYAT {{ $ayat['nomorAyat'] }}
                        </span>
                        <button type="button" 
                                onclick="toggleAyatTafsir({{ $ayat['nomorAyat'] }})" 
                                class="text-[10px] font-bold text-[#53635B] underline">
                            TUTUP TAFSIR
                        </button>
                    </div>
                    <p class="text-xs sm:text-sm text-[#3E4A44] leading-relaxed whitespace-pre-line">
                        {{ $tafsir[$ayat['nomorAyat']] ?? 'Penjelasan tafsir Kemenag untuk ayat ini belum tersedia.' }}
                    </p>
                </div>

            </div>
        @endforeach

    </div>

    <!-- Floating Global Verse Audio Player (Dedicated for per-ayat playback) -->
    <audio id="audio-single-ayat" preload="none"></audio>

</div>
@endsection

@push('scripts')
<script>
    // Data audio full surat dari API
    var audioFullList = @json($quran['audioFull'] ?? []);
    var currentQari = '05';

    // Data audio per ayat dari API
    var ayatAudioMap = {};
    @foreach($quran['ayat'] as $ay)
        ayatAudioMap[{{ $ay['nomorAyat'] }}] = @json($ay['audio'] ?? []);
    @endforeach

    var fullAudio = document.getElementById('audio-full-surat');
    var btnPlayFull = document.getElementById('btn-play-full');
    var fullCurrentTime = document.getElementById('full-current-time');
    var fullDuration = document.getElementById('full-duration');
    var fullScrubber = document.getElementById('full-scrubber');
    var audioStatusLabel = document.getElementById('audio-status-label');

    var singleAudio = document.getElementById('audio-single-ayat');
    var playingAyatNumber = null;

    // Ganti Qari
    function changeQari(qariCode) {
        currentQari = qariCode;
        if (audioFullList[qariCode]) {
            var wasPlaying = !fullAudio.paused;
            fullAudio.src = audioFullList[qariCode];
            if (wasPlaying) {
                fullAudio.play();
            }
        }
        // Jika sedang putar ayat, update juga
        if (playingAyatNumber !== null && ayatAudioMap[playingAyatNumber] && ayatAudioMap[playingAyatNumber][currentQari]) {
            singleAudio.src = ayatAudioMap[playingAyatNumber][currentQari];
            singleAudio.play();
        }
    }

    // Format Waktu MM:SS
    function formatTime(seconds) {
        if (isNaN(seconds) || seconds < 0) return '00:00';
        var m = Math.floor(seconds / 60);
        var s = Math.floor(seconds % 60);
        return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
    }

    // Toggle Play/Pause Full Surat
    function togglePlayFull() {
        if (!fullAudio) return;

        // Jika ayat sedang diputar, hentikan dulu
        if (!singleAudio.paused) {
            singleAudio.pause();
            resetAyatButtons();
        }

        if (fullAudio.paused) {
            fullAudio.play().then(function() {
                btnPlayFull.textContent = 'JEDA AUDIO SURAT';
                btnPlayFull.className = 'px-5 py-2 bg-[#8C6D38] hover:bg-[#705428] text-white text-xs font-bold tracking-wider uppercase border border-[#705428] transition-colors';
                audioStatusLabel.textContent = 'SEDANG BERPUTAR';
            }).catch(function(e) {
                alert('Tidak dapat memutar audio: ' + e.message);
            });
        } else {
            fullAudio.pause();
            btnPlayFull.textContent = 'LANJUTKAN AUDIO SURAT';
            btnPlayFull.className = 'px-5 py-2 bg-[#114B3A] hover:bg-[#0A3227] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] transition-colors';
            audioStatusLabel.textContent = 'DIJEDA';
        }
    }

    // Event listener untuk Audio Full
    if (fullAudio) {
        fullAudio.addEventListener('timeupdate', function () {
            if (fullAudio.duration) {
                fullCurrentTime.textContent = formatTime(fullAudio.currentTime);
                fullDuration.textContent = formatTime(fullAudio.duration);
                fullScrubber.value = (fullAudio.currentTime / fullAudio.duration) * 100;
            }
        });

        fullAudio.addEventListener('loadedmetadata', function () {
            fullDuration.textContent = formatTime(fullAudio.duration);
        });

        fullAudio.addEventListener('ended', function () {
            btnPlayFull.textContent = 'PUTAR AUDIO SURAT';
            btnPlayFull.className = 'px-5 py-2 bg-[#114B3A] hover:bg-[#0A3227] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] transition-colors';
            audioStatusLabel.textContent = 'SELESAI';
            fullScrubber.value = 0;
        });
    }

    function seekAudioFull(val) {
        if (fullAudio && fullAudio.duration) {
            fullAudio.currentTime = (val / 100) * fullAudio.duration;
        }
    }

    // Toggle Play/Pause Per Ayat
    function togglePlayAyat(ayatNomor) {
        // Hentikan audio full surat jika sedang berputar
        if (fullAudio && !fullAudio.paused) {
            fullAudio.pause();
            btnPlayFull.textContent = 'PUTAR AUDIO SURAT';
            btnPlayFull.className = 'px-5 py-2 bg-[#114B3A] hover:bg-[#0A3227] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] transition-colors';
            audioStatusLabel.textContent = 'DIJEDA';
        }

        var btn = document.querySelector('.btn-play-ayat[data-ayat="' + ayatNomor + '"]');

        if (playingAyatNumber === ayatNomor && !singleAudio.paused) {
            singleAudio.pause();
            btn.textContent = 'PUTAR AYAT';
            btn.className = 'btn-play-ayat px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#114B3A] text-[#114B3A] hover:text-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold uppercase transition-colors';
            playingAyatNumber = null;
            return;
        }

        resetAyatButtons();

        var audioUrls = ayatAudioMap[ayatNomor];
        if (!audioUrls) {
            alert('Audio untuk ayat ini belum tersedia.');
            return;
        }

        var audioSrc = audioUrls[currentQari] || audioUrls['05'] || audioUrls['01'];
        if (!audioSrc) {
            alert('File audio tidak ditemukan.');
            return;
        }

        singleAudio.src = audioSrc;
        singleAudio.play().then(function() {
            playingAyatNumber = ayatNomor;
            btn.textContent = 'JEDA AYAT';
            btn.className = 'btn-play-ayat px-3 py-1.5 bg-[#8C6D38] text-white border border-[#8C6D38] text-xs font-bold uppercase transition-colors';

            // Beri highlight pada kotak ayat yang sedang diputar
            var container = document.getElementById('ayat-' + ayatNomor);
            if (container) {
                container.classList.add('border-[#8C6D38]', 'bg-[#FDFBF7]');
            }
        }).catch(function(e) {
            alert('Gagal memutar audio ayat: ' + e.message);
        });
    }

    if (singleAudio) {
        singleAudio.addEventListener('ended', function () {
            resetAyatButtons();
            playingAyatNumber = null;
        });
    }

    function resetAyatButtons() {
        document.querySelectorAll('.btn-play-ayat').forEach(function(b) {
            b.textContent = 'PUTAR AYAT';
            b.className = 'btn-play-ayat px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#114B3A] text-[#114B3A] hover:text-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold uppercase transition-colors';
        });
        document.querySelectorAll('.ayat-container').forEach(function(c) {
            c.classList.remove('border-[#8C6D38]', 'bg-[#FDFBF7]');
        });
    }

    // Salin Teks Ayat ke Clipboard
    function copyAyat(ayatNomor) {
        var arab = document.getElementById('text-arab-' + ayatNomor).innerText.trim();
        var latin = document.getElementById('text-latin-' + ayatNomor).innerText.trim();
        var idn = document.getElementById('text-idn-' + ayatNomor).innerText.trim();
        var suratNama = "{{ $quran['namaLatin'] }}";

        var formatted = suratNama + ' : Ayat ' + ayatNomor + '\n\n' + arab + '\n\n' + latin + '\n\n"' + idn + '"';

        navigator.clipboard.writeText(formatted).then(function() {
            var btn = event.target;
            var originalText = btn.textContent;
            btn.textContent = 'TERSEALIN!';
            btn.className = 'btn-copy-ayat px-3 py-1.5 bg-[#114B3A] text-white border border-[#114B3A] text-xs font-bold uppercase transition-colors';
            setTimeout(function() {
                btn.textContent = originalText;
                btn.className = 'btn-copy-ayat px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#8C6D38] text-[#8C6D38] hover:text-white border border-[#DCD5C5] hover:border-[#8C6D38] text-xs font-bold uppercase transition-colors';
            }, 2000);
        }).catch(function() {
            alert('Tidak dapat menyalin teks. Silakan salin secara manual.');
        });
    }

    // Toggle Tafsir Per Ayat
    function toggleAyatTafsir(ayatNomor) {
        var box = document.getElementById('tafsir-box-{{ "" }}' + ayatNomor);
        if (box) {
            box.classList.toggle('hidden');
        }
    }

    // Toggle Deskripsi Surat
    function toggleDeskripsi() {
        var box = document.getElementById('box-deskripsi');
        var btn = document.getElementById('btn-toggle-deskripsi');
        if (box.classList.contains('hidden')) {
            box.classList.remove('hidden');
            btn.textContent = '[ - TUTUP DESKRIPSI SURAT ]';
        } else {
            box.classList.add('hidden');
            btn.textContent = '[ + BUKA DESKRIPSI & LATAR BELAKANG SURAT ]';
        }
    }

    // Mode View Tabs
    function setMode(mode) {
        var btnLengkap = document.getElementById('tab-mode-lengkap');
        var btnTafsir = document.getElementById('tab-mode-tafsir');
        var btnArab = document.getElementById('tab-mode-arab');

        var boxLatin = document.querySelectorAll('.box-latin');
        var boxTerjemah = document.querySelectorAll('.box-terjemah');
        var boxTafsir = document.querySelectorAll('.box-tafsir');

        // Reset tab styles
        [btnLengkap, btnTafsir, btnArab].forEach(function(b) {
            b.className = 'px-3 py-1.5 bg-white text-[#1C2621] border border-[#DCD5C5] hover:bg-[#EBF3EF]';
        });

        if (mode === 'lengkap') {
            btnLengkap.className = 'px-3 py-1.5 bg-[#114B3A] text-white border border-[#114B3A]';
            boxLatin.forEach(el => el.classList.remove('hidden'));
            boxTerjemah.forEach(el => el.classList.remove('hidden'));
            boxTafsir.forEach(el => el.classList.add('hidden'));
        } else if (mode === 'tafsir') {
            btnTafsir.className = 'px-3 py-1.5 bg-[#114B3A] text-white border border-[#114B3A]';
            boxLatin.forEach(el => el.classList.remove('hidden'));
            boxTerjemah.forEach(el => el.classList.remove('hidden'));
            boxTafsir.forEach(el => el.classList.remove('hidden'));
        } else if (mode === 'arab') {
            btnArab.className = 'px-3 py-1.5 bg-[#114B3A] text-white border border-[#114B3A]';
            boxLatin.forEach(el => el.classList.add('hidden'));
            boxTerjemah.forEach(el => el.classList.add('hidden'));
            boxTafsir.forEach(el => el.classList.add('hidden'));
        }
    }

    // Jump to Ayat
    function jumpToAyat(targetId) {
        if (!targetId) return;
        var el = document.getElementById(targetId);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            el.classList.add('border-[#114B3A]', 'bg-[#F9F5EC]');
            setTimeout(function() {
                el.classList.remove('bg-[#F9F5EC]');
            }, 2500);
        }
    }
</script>
@endpush