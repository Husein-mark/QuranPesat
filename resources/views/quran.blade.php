@extends('layouts.islamic')

@section('title', 'Al-Qur\'an Digital — Daftar 114 Surat & Tafsir')

@section('content')
<div class="space-y-8">

    <!-- Top Headline Banner (Solid Clean Surface) -->
    <div class="bg-white border-2 border-[#114B3A] p-6 sm:p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-[#DCD5C5]">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2">
                    <span class="text-xs font-semibold text-[#8C6D38] tracking-widest uppercase">
                        MUSHAF STANDAR INDONESIA
                    </span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-[#114B3A] tracking-tight">
                    Daftar Surat Al-Qur'an
                </h1>
            </div>

            <!-- Quick Stats Blocks (Solid Backgrounds) -->
            <div class="grid grid-cols-3 gap-2.5 sm:gap-4 text-center min-w-[280px]">
                <div class="bg-[#F7F5EE] border border-[#DCD5C5] p-3">
                    <span class="block text-2xl font-extrabold text-[#114B3A]">114</span>
                    <span class="text-[10px] font-bold text-[#53635B] uppercase tracking-wider">Surat</span>
                </div>
                <div class="bg-[#F7F5EE] border border-[#DCD5C5] p-3">
                    <span class="block text-2xl font-extrabold text-[#114B3A]">6.236</span>
                    <span class="text-[10px] font-bold text-[#53635B] uppercase tracking-wider">Ayat</span>
                </div>
                <div class="bg-[#F7F5EE] border border-[#DCD5C5] p-3">
                    <span class="block text-2xl font-extrabold text-[#114B3A]">30</span>
                    <span class="text-[10px] font-bold text-[#53635B] uppercase tracking-wider">Juz</span>
                </div>
            </div>
        </div>

        <!-- Search & Filter Controls (Interaksi Pengguna) -->
        <div class="pt-6">
            <form action="{{ route('quran.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                
                <!-- Keyword Input -->
                <div class="flex-1">
                    <label for="quran-search" class="sr-only">Cari Surat</label>
                    <input type="text" 
                           id="quran-search" 
                           name="q" 
                           value="{{ $search ?? '' }}" 
                           placeholder="Ketik nama surat, arti, atau nomor (misal: Al-Kahf, Yasin, Pembukaan, 36)..." 
                           class="w-full px-4 py-2.5 bg-[#F7F5EE] border-2 border-[#DCD5C5] focus:border-[#114B3A] text-sm text-[#1C2621] outline-none transition-colors"
                           autocomplete="off">
                </div>

                <!-- Filter Tempat Turun -->
                <div class="flex items-center gap-2">
                    <select name="tempat_turun" 
                            id="tempat-turun" 
                            class="px-3 py-2.5 bg-[#F7F5EE] border-2 border-[#DCD5C5] focus:border-[#114B3A] text-sm text-[#1C2621] outline-none">
                        <option value="">Semua Tempat Turun</option>
                        <option value="Mekah" {{ ($tempatTurun ?? '') === 'Mekah' ? 'selected' : '' }}>Makkiyyah (Mekah)</option>
                        <option value="Madinah" {{ ($tempatTurun ?? '') === 'Madinah' ? 'selected' : '' }}>Madaniyyah (Madinah)</option>
                    </select>

                    <button type="submit" 
                            class="px-5 py-2.5 bg-[#114B3A] hover:bg-[#0A3227] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] transition-colors">
                        FILTER
                    </button>

                    @if(!empty($search) || !empty($tempatTurun))
                        <a href="{{ route('quran.index') }}" 
                           class="px-4 py-2.5 bg-[#FFFFFF] border-2 border-[#DCD5C5] hover:border-[#8C6D38] text-xs font-bold text-[#8C6D38] uppercase transition-colors">
                            RESET
                        </a>
                    @endif
                </div>
            </form>

            <div class="mt-3 flex items-center justify-between text-xs text-[#53635B]">
                <div>
                    @if(!empty($search))
                        untuk pencarian "<strong class="text-[#114B3A]">{{ $search }}</strong>"
                    @endif
                    @if(!empty($tempatTurun))
                        (Golongan: <strong class="text-[#114B3A]">{{ $tempatTurun }}</strong>)
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Surah Cards Grid -->
    @if(empty($quran))
        <!-- Empty State / Pesan Data Tidak Ditemukan -->
        <div class="bg-white border-2 border-[#DCD5C5] p-12 text-center space-y-4">
            <div class="inline-block px-3 py-1 bg-[#F9F5EC] border border-[#8C6D38] text-[#8C6D38] font-bold text-xs">
                DATA TIDAK DITEMUKAN
            </div>
            <h2 class="text-xl font-bold text-[#114B3A]">Surat yang Anda cari tidak tersedia</h2>
            <p class="text-sm text-[#53635B] max-w-md mx-auto leading-relaxed">
                Tidak ada surat yang sesuai dengan kata kunci pencarian atau filter yang Anda pilih. Silakan periksa ejaan atau gunakan tombol di bawah untuk menampilkan seluruh surat.
            </p>
            <div class="pt-2">
                <a href="{{ route('quran.index') }}" class="inline-block px-5 py-2.5 bg-[#114B3A] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] hover:bg-[#0A3227]">
                    TAMPILKAN SEMUA 114 SURAT
                </a>
            </div>
        </div>
    @else
        <div id="surat-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($quran as $surat)
                <div class="surat-card bg-white border border-[#DCD5C5] hover:border-[#114B3A] transition-all p-5 flex flex-col justify-between group"
                     data-latin="{{ strtolower($surat['namaLatin'] ?? '') }}"
                     data-arti="{{ strtolower($surat['arti'] ?? '') }}"
                     data-nomor="{{ $surat['nomor'] ?? '' }}"
                     data-arab="{{ $surat['nama'] ?? '' }}"
                     data-turun="{{ strtolower($surat['tempatTurun'] ?? '') }}">
                    
                    <div>
                        <!-- Card Top Bar -->
                        <div class="flex items-start justify-between gap-3 pb-3 mb-3 border-b border-[#F0ECE2]">
                            <!-- Surat Number Badge -->
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 flex items-center justify-center bg-[#F7F5EE] border border-[#BDB39E] text-xs font-extrabold text-[#114B3A] group-hover:bg-[#114B3A] group-hover:text-white transition-colors">
                                    {{ sprintf('%02d', $surat['nomor']) }}
                                </span>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#8C6D38] block leading-none">
                                        {{ $surat['tempatTurun'] }}
                                    </span>
                                    <span class="text-[11px] text-[#53635B] font-medium">
                                        {{ $surat['jumlahAyat'] }} Ayat
                                    </span>
                                </div>
                            </div>

                            <!-- Arabic Name (Amiri Font) -->
                            <div class="text-right">
                                <span class="font-arabic text-2xl text-[#114B3A] leading-tight block">
                                    {{ $surat['nama'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Surah Names & Meaning -->
                        <div class="space-y-1 mb-4">
                            <h3 class="text-base font-bold text-[#1C2621] group-hover:text-[#114B3A] transition-colors leading-snug">
                                {{ $surat['namaLatin'] }}
                            </h3>
                            <p class="text-xs text-[#53635B] leading-relaxed">
                                Arti: <span class="text-[#1C2621] font-medium">&ldquo;{{ $surat['arti'] }}&rdquo;</span>
                            </p>
                        </div>
                    </div>

                    <!-- Action Button Bar -->
                    <div class="pt-3 border-t border-[#F0ECE2] flex items-center justify-between gap-2">
                        <a href="{{ route('quran.show', $surat['nomor']) }}" 
                           class="w-full text-center px-4 py-2 bg-[#F7F5EE] hover:bg-[#114B3A] text-[#114B3A] hover:text-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold tracking-wider uppercase transition-colors">
                            BACA SURAT & TAFSIR &rarr;
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // Realtime Client-side Search Filter (Interaksi Pengguna Cepat)
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('quran-search');
        var cards = document.querySelectorAll('.surat-card');
        var visibleCountEl = document.getElementById('visible-count');

        if (searchInput && cards.length > 0) {
            searchInput.addEventListener('input', function (e) {
                var query = e.target.value.toLowerCase().trim();
                var count = 0;

                cards.forEach(function (card) {
                    var latin = card.getAttribute('data-latin') || '';
                    var arti = card.getAttribute('data-arti') || '';
                    var nomor = card.getAttribute('data-nomor') || '';
                    var arab = card.getAttribute('data-arab') || '';

                    if (query === '' || latin.includes(query) || arti.includes(query) || nomor.includes(query) || arab.includes(query)) {
                        card.style.display = 'flex';
                        count++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (visibleCountEl) {
                    visibleCountEl.textContent = count;
                }
            });
        }
    });
</script>
@endpush