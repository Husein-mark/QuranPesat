@extends('layouts.islamic')

@section('title', ($doa['nama'] ?? 'Detail Doa') . ' — eQuran Digital')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Back Button -->
    <div>
        <a href="{{ route('doa.index') }}" 
           class="inline-block px-3 py-1.5 bg-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold text-[#114B3A] uppercase tracking-wider transition-colors">
            &larr; KEMBALI KE KUMPULAN DOA
        </a>
    </div>

    @if(!empty($doa))
        <div class="bg-white border-2 border-[#114B3A] p-6 sm:p-8 space-y-6">
            
            <!-- Top Metadata -->
            <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-[#DCD5C5]">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 bg-[#114B3A] text-white text-xs font-extrabold">
                        NO. {{ $doa['id'] }}
                    </span>
                    @if(!empty($doa['grup']))
                        <span class="px-2.5 py-1 bg-[#F7F5EE] border border-[#BDB39E] text-xs font-bold text-[#8C6D38]">
                            GRUP: {{ $doa['grup'] }}
                        </span>
                    @endif
                </div>

                <button type="button" 
                        id="btn-copy"
                        class="px-4 py-2 bg-[#F7F5EE] hover:bg-[#114B3A] text-[#114B3A] hover:text-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold uppercase transition-colors"
                        onclick="copyThisDoa()">
                    SALIN DOA KE CLIPBOARD
                </button>
            </div>

            <!-- Doa Title -->
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1C2621]" id="detail-nama">
                {{ $doa['nama'] }}
            </h1>

            <!-- Arabic Text -->
            <div class="py-4 text-right">
                <p class="font-arabic text-3xl sm:text-4xl leading-[2.6] text-[#114B3A] break-words" id="detail-arab">
                    {{ $doa['ar'] }}
                </p>
            </div>

            <!-- Latin Transliteration -->
            @if(!empty($doa['tr']))
                <div class="pt-4 pb-2 border-t border-[#F0ECE2]">
                    <span class="text-[11px] font-bold text-[#8C6D38] uppercase tracking-wider block mb-1">BACAAN LATIN:</span>
                    <p class="text-sm sm:text-base font-medium italic text-[#8C6D38] leading-relaxed" id="detail-latin">
                        {{ $doa['tr'] }}
                    </p>
                </div>
            @endif

            <!-- Indonesian Translation -->
            @if(!empty($doa['idn']))
                <div class="pt-2">
                    <span class="text-[11px] font-bold text-[#53635B] uppercase tracking-wider block mb-1">TERJEMAHAN:</span>
                    <p class="text-sm sm:text-base text-[#1C2621] leading-relaxed font-normal" id="detail-idn">
                        &ldquo;{{ $doa['idn'] }}&rdquo;
                    </p>
                </div>
            @endif

            <!-- Riwayat Hadits -->
            @if(!empty($doa['tentang']))
                <div class="mt-6 p-5 bg-[#F9F5EC] border-l-4 border-[#8C6D38] border-t border-r border-b border-[#DCD5C5]">
                    <span class="text-xs font-bold text-[#8C6D38] uppercase tracking-wider block mb-2">
                        TAKHRIJ & SUMBER RIWAYAT:
                    </span>
                    <p class="text-xs sm:text-sm text-[#404D46] leading-relaxed whitespace-pre-line" id="detail-tentang">
                        {{ $doa['tentang'] }}
                    </p>
                </div>
            @endif

            <!-- Tags -->
            @if(!empty($doa['tag']) && is_array($doa['tag']))
                <div class="pt-4 border-t border-[#F0ECE2] flex flex-wrap items-center gap-1.5">
                    <span class="text-xs font-bold text-[#53635B] uppercase">TAG TERKAIT:</span>
                    @foreach($doa['tag'] as $t)
                        <a href="{{ route('doa.index', ['tag' => $t]) }}" 
                           class="px-2.5 py-1 bg-[#F7F5EE] border border-[#DCD5C5] text-xs font-bold text-[#53635B] hover:border-[#114B3A] hover:text-[#114B3A]">
                            #{{ $t }}
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    @else
        <div class="bg-white border-2 border-[#DCD5C5] p-12 text-center space-y-4">
            <h2 class="text-xl font-bold text-[#114B3A]">Doa tidak ditemukan</h2>
            <p class="text-sm text-[#53635B]">ID doa yang Anda cari tidak tersedia dalam database kami.</p>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function copyThisDoa() {
        var nama = document.getElementById('detail-nama') ? document.getElementById('detail-nama').innerText : '';
        var arab = document.getElementById('detail-arab') ? document.getElementById('detail-arab').innerText : '';
        var latin = document.getElementById('detail-latin') ? document.getElementById('detail-latin').innerText : '';
        var idn = document.getElementById('detail-idn') ? document.getElementById('detail-idn').innerText : '';
        var tentang = document.getElementById('detail-tentang') ? document.getElementById('detail-tentang').innerText : '';

        var text = nama + '\n\n' + arab + '\n\n' + latin + '\n\n' + idn;
        if (tentang) {
            text += '\n\n' + tentang;
        }

        navigator.clipboard.writeText(text).then(function() {
            var btn = document.getElementById('btn-copy');
            btn.textContent = 'TERSEALIN!';
            btn.className = 'px-4 py-2 bg-[#114B3A] text-white border border-[#114B3A] text-xs font-bold uppercase transition-colors';
            setTimeout(function() {
                btn.textContent = 'SALIN DOA KE CLIPBOARD';
                btn.className = 'px-4 py-2 bg-[#F7F5EE] hover:bg-[#114B3A] text-[#114B3A] hover:text-white border border-[#DCD5C5] hover:border-[#114B3A] text-xs font-bold uppercase transition-colors';
            }, 2000);
        });
    }
</script>
@endpush
