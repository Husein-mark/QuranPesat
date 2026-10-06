@extends('layouts.islamic')

@section('title', 'Mushaf Digital — Daftar 114 Surat Al-Qur\'an')

@section('content')
<div class="space-y-6 sm:space-y-7">

    <!-- Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#0E5C45] via-[#0B4A37] to-[#082C22] text-white p-6 sm:p-10 shadow-lg">
        <!-- Decorative watermark -->
        <div class="absolute right-6 top-1/2 -translate-y-1/2 hidden lg:block opacity-[0.07] pointer-events-none font-arabic text-[120px] leading-none select-none">
            القرآن
        </div>
        <div class="absolute -bottom-12 -right-12 w-56 h-56 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
        <div class="absolute -top-8 -left-8 w-48 h-48 rounded-full bg-[#C28B38]/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3 max-w-xl">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full bg-[#C28B38]/20 text-[#E9C37A] text-[10px] font-bold tracking-widest uppercase border border-[#C28B38]/30">
                        MUSHAF STANDAR KEMENAG RI
                    </span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                    Mushaf Digital
                </h1>
                <p class="text-sm sm:text-base text-white/75 leading-relaxed max-w-lg">
                    Baca 114 surat Al-Qur'an lengkap dengan teks Arab berharakat, transliterasi, terjemahan resmi Indonesia, audio murottal, dan tafsir Kemenag.
                </p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-3 min-w-[260px]">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/10">
                    <span class="block text-2xl sm:text-3xl font-black text-white">114</span>
                    <span class="text-[10px] font-bold text-[#E9C37A] uppercase tracking-wider">Surat</span>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/10">
                    <span class="block text-2xl sm:text-3xl font-black text-white">6236</span>
                    <span class="text-[10px] font-bold text-[#E9C37A] uppercase tracking-wider">Ayat</span>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white/10">
                    <span class="block text-2xl sm:text-3xl font-black text-white">30</span>
                    <span class="text-[10px] font-bold text-[#E9C37A] uppercase tracking-wider">Juz</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#D8E4DE] shadow-sm">
        <form action="{{ route('quran.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3">

            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#7A9A90]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       id="quran-search"
                       name="q"
                       value="{{ $search ?? '' }}"
                       placeholder="Cari nama surat, arti, atau nomor (misal: Al-Kahf, 36, Pembukaan)..."
                       class="w-full pl-10 pr-4 py-3 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] focus:border-[#0E5C45] focus:bg-white text-sm text-[#1A2621] outline-none transition-all placeholder:text-[#96AEA7]"
                       autocomplete="off">
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <select name="tempat_turun"
                        id="tempat-turun"
                        class="flex-1 md:flex-initial px-3 py-3 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] focus:border-[#0E5C45] text-xs font-semibold text-[#1A2621] outline-none">
                    <option value="">Semua Golongan</option>
                    <option value="Mekah" {{ ($tempatTurun ?? '') === 'Mekah' ? 'selected' : '' }}>Makkiyyah</option>
                    <option value="Madinah" {{ ($tempatTurun ?? '') === 'Madinah' ? 'selected' : '' }}>Madaniyyah</option>
                </select>

                <button type="submit"
                        class="px-5 py-3 bg-[#0E5C45] hover:bg-[#083C2C] text-white text-xs font-bold tracking-wider rounded-xl transition-all shadow-sm shrink-0">
                    Cari
                </button>

                @if(!empty($search) || !empty($tempatTurun))
                    <a href="{{ route('quran.index') }}"
                       class="px-4 py-3 bg-white hover:bg-gray-50 border border-[#D0DDD8] text-xs font-bold text-[#C28B38] rounded-xl transition-all shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <div class="mt-3 flex items-center gap-2 text-xs text-[#6B8076] px-1">
            <span>Menampilkan <strong id="visible-count" class="text-[#0E5C45]">{{ count($quran) }}</strong> dari 114 surat</span>
            @if(!empty($search))
                <span>&bull; kata kunci: "<em class="text-[#0E5C45] not-italic font-semibold">{{ $search }}</em>"</span>
            @endif
            @if(!empty($tempatTurun))
                <span>&bull; golongan: <span class="text-[#0E5C45] font-semibold">{{ $tempatTurun }}</span></span>
            @endif
        </div>
    </div>

    <!-- Surat Grid -->
    @if(empty($quran))
        <div class="bg-white rounded-2xl border border-[#D8E4DE] p-14 text-center space-y-4 shadow-sm">
            <div class="w-14 h-14 mx-auto rounded-full bg-amber-50 text-[#C28B38] flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-[#0E5C45]">Surat tidak ditemukan</h2>
            <p class="text-sm text-[#566860] max-w-sm mx-auto">Tidak ada surat yang sesuai dengan pencarian Anda. Coba kata kunci lain.</p>
            <a href="{{ route('quran.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0E5C45] text-white text-xs font-bold rounded-xl hover:bg-[#083C2C] transition-all">
                Tampilkan Semua 114 Surat
            </a>
        </div>
    @else
        <div id="surat-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($quran as $surat)
                <a href="{{ route('quran.show', $surat['nomor']) }}"
                   class="surat-card group bg-white rounded-2xl border border-[#D8E4DE] hover:border-[#0E5C45] hover:shadow-md p-4 sm:p-5 flex items-center justify-between transition-all duration-200 active:scale-[0.99]"
                   data-latin="{{ strtolower($surat['namaLatin'] ?? '') }}"
                   data-arti="{{ strtolower($surat['arti'] ?? '') }}"
                   data-nomor="{{ $surat['nomor'] ?? '' }}"
                   data-arab="{{ $surat['nama'] ?? '' }}"
                   data-turun="{{ strtolower($surat['tempatTurun'] ?? '') }}">

                    <!-- Left: Nomor + Info -->
                    <div class="flex items-center gap-3">
                        <!-- Nomor Badge -->
                        <div class="relative w-10 h-10 shrink-0">
                            <svg viewBox="0 0 40 40" class="w-10 h-10 absolute inset-0 text-[#E6F2EC] group-hover:text-[#0E5C45] transition-colors" fill="currentColor">
                                <path d="M20 2 L23.5 10 L32 10 L25.5 15.5 L28 24 L20 19 L12 24 L14.5 15.5 L8 10 L16.5 10 Z"/>
                            </svg>
                            <span class="absolute inset-0 flex items-center justify-center text-[11px] font-black text-[#0E5C45] group-hover:text-white transition-colors z-10">
                                {{ $surat['nomor'] }}
                            </span>
                        </div>

                        <!-- Info -->
                        <div>
                            <h3 class="text-sm font-extrabold text-[#18251F] group-hover:text-[#0E5C45] transition-colors leading-tight">
                                {{ $surat['namaLatin'] }}
                            </h3>
                            <p class="text-[11px] text-[#6B8076] leading-none mt-0.5">&ldquo;{{ $surat['arti'] }}&rdquo;</p>
                            <div class="flex items-center gap-1.5 mt-1 text-[10px] font-semibold text-[#C28B38]">
                                <span>{{ $surat['tempatTurun'] }}</span>
                                <span class="text-[#C28B38]/50">&bull;</span>
                                <span>{{ $surat['jumlahAyat'] }} Ayat</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Arabic Name -->
                    <div class="text-right pl-2 shrink-0">
                        <span class="font-arabic text-[22px] sm:text-[26px] text-[#0E5C45] block leading-none">
                            {{ $surat['nama'] }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('quran-search');
        var tempatTurunSelect = document.getElementById('tempat-turun');
        var cards = document.querySelectorAll('.surat-card');
        var visibleCountEl = document.getElementById('visible-count');

        function filterCards() {
            var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            var turunFilter = tempatTurunSelect ? tempatTurunSelect.value.toLowerCase() : '';
            var count = 0;

            cards.forEach(function (card) {
                var latin = card.getAttribute('data-latin') || '';
                var arti = card.getAttribute('data-arti') || '';
                var nomor = card.getAttribute('data-nomor') || '';
                var arab = card.getAttribute('data-arab') || '';
                var turun = card.getAttribute('data-turun') || '';

                var matchQuery = !query || latin.includes(query) || arti.includes(query) || nomor.includes(query) || arab.includes(query);
                var matchTurun = !turunFilter || turun.includes(turunFilter);

                if (matchQuery && matchTurun) {
                    card.style.display = '';
                    count++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (visibleCountEl) {
                visibleCountEl.textContent = count;
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterCards);
        }
    });
</script>
@endpush