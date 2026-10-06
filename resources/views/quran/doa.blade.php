@extends('layouts.islamic')

@section('title', 'Kumpulan Doa Harian & Dzikir — eQuran Digital')

@section('content')
<div class="space-y-8">

    <!-- Top Headline Banner (Solid Clean Surface) -->
    <div class="bg-white border-2 border-[#114B3A] p-6 sm:p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-[#DCD5C5]">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2">
                    <span class="text-xs font-semibold text-[#8C6D38] tracking-widest uppercase">
                        KUMPULAN DOA HARIAN & AS-SUNNAH
                    </span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-[#114B3A] tracking-tight">
                    Kumpulan Doa Harian
                </h1>
            </div>

            <!-- Stats Badge Box -->
            <div class="bg-[#F7F5EE] border border-[#DCD5C5] p-4 text-center min-w-[200px]">
                <span class="block text-3xl font-extrabold text-[#114B3A]">{{ count($doaList) }}</span>
                <span class="text-[11px] font-bold text-[#53635B] uppercase tracking-wider">Doa Ditampilkan</span>
                <span class="block text-[10px] text-[#8C6D38] font-semibold mt-1">Sumber: Hisnul Muslim & Hadits</span>
            </div>
        </div>

        <!-- Filter & Search Controls (Interaksi Pengguna) -->
        <div class="pt-6 space-y-4">
            <form action="{{ route('doa.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                
                <!-- Keyword Input -->
                <div class="flex-1">
                    <label for="doa-search" class="sr-only">Cari Doa</label>
                    <input type="text" 
                           id="doa-search" 
                           name="q" 
                           value="{{ $search ?? '' }}" 
                           placeholder="Cari doa berdasarkan nama, lafadz, arti (misal: tidur, makan, wudhu, sakit)..." 
                           class="w-full px-4 py-2.5 bg-[#F7F5EE] border-2 border-[#DCD5C5] focus:border-[#114B3A] text-sm text-[#1C2621] outline-none transition-colors"
                           autocomplete="off">
                </div>

                <!-- Category / Group Filter Dropdown -->
                <div class="w-full md:w-72">
                    <select name="grup" 
                            id="doa-grup" 
                            class="w-full px-3 py-2.5 bg-[#F7F5EE] border-2 border-[#DCD5C5] focus:border-[#114B3A] text-xs font-bold text-[#1C2621] outline-none">
                        <option value="">-- Semua Kategori / Grup Doa --</option>
                        @foreach($semuaGrup as $grup)
                            <option value="{{ $grup }}" {{ ($grupPilihan ?? '') === $grup ? 'selected' : '' }}>
                                {{ $grup }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-2">
                    <button type="submit" 
                            class="px-5 py-2.5 bg-[#114B3A] hover:bg-[#0A3227] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] transition-colors">
                        CARI & FILTER
                    </button>

                    @if(!empty($search) || !empty($grupPilihan) || !empty($tagPilihan))
                        <a href="{{ route('doa.index') }}" 
                           class="px-4 py-2.5 bg-[#FFFFFF] border-2 border-[#DCD5C5] hover:border-[#8C6D38] text-xs font-bold text-[#8C6D38] uppercase transition-colors">
                            RESET
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Doa Listing -->
    @if(empty($doaList))
        <!-- Empty State / Pesan Data Tidak Ditemukan -->
        <div class="bg-white border-2 border-[#DCD5C5] p-12 text-center space-y-4">
            <div class="inline-block px-3 py-1 bg-[#F9F5EC] border border-[#8C6D38] text-[#8C6D38] font-bold text-xs uppercase">
                DOA TIDAK DITEMUKAN
            </div>
            <h2 class="text-xl font-bold text-[#114B3A]">Tidak ada doa yang cocok dengan kriteria pencarian</h2>
            <p class="text-sm text-[#53635B] max-w-md mx-auto leading-relaxed">
                Silakan coba kata kunci lain atau pilih kategori grup doa yang berbeda untuk menemukan doa yang Anda butuhkan.
            </p>
            <div class="pt-2">
                <a href="{{ route('doa.index') }}" class="inline-block px-5 py-2.5 bg-[#114B3A] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] hover:bg-[#0A3227]">
                    TAMPILKAN SEMUA DOA
                </a>
            </div>
        </div>
    @else
        <div class="space-y-6" id="doa-container">
            @foreach($doaList as $doa)
                <div class="doa-card bg-white border border-[#DCD5C5] hover:border-[#114B3A] p-6 sm:p-7 transition-colors"
                     id="doa-card-{{ $doa['id'] }}">
                    
                    <!-- Card Top Bar -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-3 mb-4 border-b border-[#F0ECE2]">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 bg-[#F7F5EE] border border-[#BDB39E] text-xs font-extrabold text-[#114B3A]">
                                NO. {{ $doa['id'] }}
                            </span>
                            @if(!empty($doa['grup']))
                                <span class="px-2.5 py-1 bg-[#EBF3EF] border border-[#114B3A] text-[11px] font-bold text-[#114B3A]">
                                    GRUP: {{ $doa['grup'] }}
                                </span>
                            @endif
                        </div>

                        <!-- Action Buttons (Strictly text-based, no icons) -->
                        <div class="flex items-center gap-2">
                            <button type="button" 
                                    class="px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#114B3A] text-[#114B3A] hover:text-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold uppercase transition-colors"
                                    onclick="copyDoa({{ $doa['id'] }})">
                                SALIN DOA
                            </button>
                            
                            @if(!empty($doa['tentang']))
                                <button type="button" 
                                        class="px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#8C6D38] text-[#8C6D38] hover:text-white border border-[#DCD5C5] hover:border-[#8C6D38] text-xs font-bold uppercase transition-colors"
                                        onclick="toggleRiwayat({{ $doa['id'] }})">
                                    RIWAYAT HADITS
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Doa Title -->
                    <h3 class="text-lg sm:text-xl font-bold text-[#1C2621] mb-4 leading-snug" 
                        id="doa-nama-{{ $doa['id'] }}">
                        {{ $doa['nama'] }}
                    </h3>

                    <!-- Arabic Text (Amiri Font, Clear Tashkeel) -->
                    <div class="py-3 text-right">
                        <p class="font-arabic text-2xl sm:text-3xl leading-[2.6] sm:leading-[2.8] text-[#114B3A] break-words" 
                           id="doa-arab-{{ $doa['id'] }}">
                            {{ $doa['ar'] }}
                        </p>
                    </div>

                    <!-- Latin Transliteration -->
                    @if(!empty($doa['tr']))
                        <div class="pt-3 pb-1 border-t border-[#F0ECE2]">
                            <p class="text-xs sm:text-sm font-medium italic text-[#8C6D38] leading-relaxed" 
                               id="doa-latin-{{ $doa['id'] }}">
                                {{ $doa['tr'] }}
                            </p>
                        </div>
                    @endif

                    <!-- Indonesian Translation -->
                    @if(!empty($doa['idn']))
                        <div class="pt-2">
                            <p class="text-xs sm:text-sm text-[#1C2621] leading-relaxed font-normal" 
                               id="doa-idn-{{ $doa['id'] }}">
                                &ldquo;{{ $doa['idn'] }}&rdquo;
                            </p>
                        </div>
                    @endif

                    <!-- Sumber & Riwayat Hadits (Takhrij) -->
                    @if(!empty($doa['tentang']))
                        <div id="riwayat-box-{{ $doa['id'] }}" 
                             class="hidden mt-4 p-4 bg-[#F9F5EC] border-l-4 border-[#8C6D38] border-t border-r border-b border-[#DCD5C5]">
                            <span class="text-xs font-bold text-[#8C6D38] uppercase tracking-wider block mb-1">
                                TAKHRIJ & SUMBER RIWAYAT:
                            </span>
                            <p class="text-xs text-[#404D46] leading-relaxed whitespace-pre-line" 
                               id="doa-tentang-{{ $doa['id'] }}">
                                {{ $doa['tentang'] }}
                            </p>
                        </div>
                    @endif

                    <!-- Tag Badges -->
                    @if(!empty($doa['tag']) && is_array($doa['tag']))
                        <div class="mt-4 pt-3 border-t border-[#F0ECE2] flex flex-wrap items-center gap-1.5">
                            <span class="text-[10px] font-bold text-[#53635B] uppercase">TAG:</span>
                            @foreach($doa['tag'] as $t)
                                <a href="{{ route('doa.index', ['tag' => $t]) }}" 
                                   class="px-2 py-0.5 bg-[#F7F5EE] border border-[#DCD5C5] text-[10px] font-bold text-[#53635B] hover:border-[#114B3A] hover:text-[#114B3A]">
                                    #{{ $t }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // Salin Teks Doa ke Clipboard
    function copyDoa(id) {
        var nama = document.getElementById('doa-nama-' + id) ? document.getElementById('doa-nama-' + id).innerText.trim() : '';
        var arab = document.getElementById('doa-arab-' + id) ? document.getElementById('doa-arab-' + id).innerText.trim() : '';
        var latin = document.getElementById('doa-latin-' + id) ? document.getElementById('doa-latin-' + id).innerText.trim() : '';
        var idn = document.getElementById('doa-idn-' + id) ? document.getElementById('doa-idn-' + id).innerText.trim() : '';
        var tentang = document.getElementById('doa-tentang-' + id) ? document.getElementById('doa-tentang-' + id).innerText.trim() : '';

        var text = nama + '\n\n' + arab + '\n\n' + latin + '\n\n' + idn;
        if (tentang) {
            text += '\n\nSumber: ' + tentang;
        }

        navigator.clipboard.writeText(text).then(function() {
            var btn = event.target;
            var originalText = btn.textContent;
            btn.textContent = 'TERSEALIN!';
            btn.className = 'px-3 py-1.5 bg-[#114B3A] text-white border border-[#114B3A] text-xs font-bold uppercase transition-colors';
            setTimeout(function() {
                btn.textContent = originalText;
                btn.className = 'px-3 py-1.5 bg-[#F7F5EE] hover:bg-[#114B3A] text-[#114B3A] hover:text-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold uppercase transition-colors';
            }, 2000);
        }).catch(function() {
            alert('Tidak dapat menyalin doa secara otomatis. Silakan salin secara manual.');
        });
    }

    // Toggle Tampilan Riwayat Hadits
    function toggleRiwayat(id) {
        var box = document.getElementById('riwayat-box-' + id);
        if (box) {
            box.classList.toggle('hidden');
        }
    }
</script>
@endpush
