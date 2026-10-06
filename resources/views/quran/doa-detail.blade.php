@extends('layouts.islamic')

@section('title', ($doa['nama'] ?? 'Detail Doa') . ' — Mushaf Digital')

@section('content')
<div class="space-y-6 max-w-3xl mx-auto">

    <!-- Back Button -->
    <a href="{{ route('doa.index') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 bg-white rounded-xl border border-[#D0DDD8] hover:border-[#0E5C45] hover:text-[#0E5C45] text-xs font-semibold text-[#54706A] transition-all shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Doa Harian
    </a>

    @if(!empty($doa))
        <div class="bg-white rounded-2xl border border-[#D8E4DE] overflow-hidden shadow-sm">

            <!-- Top bar -->
            <div class="flex flex-wrap items-center justify-between gap-3 px-5 sm:px-7 py-4 bg-[#F8FAF9] border-b border-[#EDF2EF]">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-lg bg-[#0E5C45] text-white text-[10px] font-black">NO. {{ $doa['id'] }}</span>
                    @if(!empty($doa['grup']))
                        <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-[#C28B38] text-[10px] font-bold border border-amber-200">{{ $doa['grup'] }}</span>
                    @endif
                </div>

                <button type="button"
                        id="btn-copy"
                        onclick="copyThisDoa()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-[#E6F2EC] text-[#0E5C45] border border-[#D0DDD8] hover:border-[#0E5C45] text-[10px] font-bold rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    SALIN DOA
                </button>
            </div>

            <div class="px-5 sm:px-7 py-6 space-y-5">

                <!-- Judul -->
                <h1 class="text-xl sm:text-2xl font-extrabold text-[#18251F]" id="detail-nama">
                    {{ $doa['nama'] }}
                </h1>

                <!-- Arabic -->
                <div class="py-4 text-right border-y border-[#EDF2EF]">
                    <p class="font-arabic text-3xl sm:text-4xl leading-[2.6] text-[#0E5C45] break-words" id="detail-arab">
                        {{ $doa['ar'] }}
                    </p>
                </div>

                <!-- Latin -->
                @if(!empty($doa['tr']))
                    <div>
                        <span class="text-[9px] font-bold text-[#C28B38] uppercase tracking-widest block mb-1.5">BACAAN LATIN:</span>
                        <p class="text-sm font-medium italic text-[#A07828] leading-relaxed" id="detail-latin">
                            {{ $doa['tr'] }}
                        </p>
                    </div>
                @endif

                <!-- Terjemahan -->
                @if(!empty($doa['idn']))
                    <div>
                        <span class="text-[9px] font-bold text-[#54706A] uppercase tracking-widest block mb-1.5">TERJEMAHAN:</span>
                        <p class="text-sm text-[#2A3B33] leading-relaxed" id="detail-idn">
                            &ldquo;{{ $doa['idn'] }}&rdquo;
                        </p>
                    </div>
                @endif

                <!-- Riwayat -->
                @if(!empty($doa['tentang']))
                    <div class="p-4 rounded-xl bg-[#FDF9F1] border-l-4 border-[#C28B38] border border-[#E8DFC8]">
                        <span class="text-[9px] font-bold text-[#A07828] uppercase tracking-widest block mb-2">TAKHRIJ & SUMBER RIWAYAT:</span>
                        <p class="text-xs sm:text-sm text-[#4A5952] leading-relaxed whitespace-pre-line" id="detail-tentang">
                            {{ $doa['tentang'] }}
                        </p>
                    </div>
                @endif

                <!-- Tags -->
                @if(!empty($doa['tag']) && is_array($doa['tag']))
                    <div class="pt-2 border-t border-[#EDF2EF] flex flex-wrap items-center gap-1.5">
                        <span class="text-[9px] font-bold text-[#54706A] uppercase">TAG:</span>
                        @foreach($doa['tag'] as $t)
                            <a href="{{ route('doa.index', ['tag' => $t]) }}"
                               class="px-2 py-0.5 rounded-full bg-[#F0F4F2] text-[10px] font-semibold text-[#54706A] hover:bg-[#E6F2EC] hover:text-[#0E5C45] border border-[#D8E4DE] transition-colors">
                                #{{ $t }}
                            </a>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-[#D8E4DE] p-14 text-center space-y-3 shadow-sm">
            <h2 class="text-lg font-bold text-[#0E5C45]">Doa tidak ditemukan</h2>
            <p class="text-sm text-[#54706A]">ID doa yang Anda cari tidak tersedia.</p>
            <a href="{{ route('doa.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0E5C45] text-white text-xs font-bold rounded-xl hover:bg-[#083C2C] transition-all">
                Kembali ke Daftar Doa
            </a>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function copyThisDoa() {
        var nama = (document.getElementById('detail-nama') || {}).innerText || '';
        var arab = (document.getElementById('detail-arab') || {}).innerText || '';
        var latin = (document.getElementById('detail-latin') || {}).innerText || '';
        var idn = (document.getElementById('detail-idn') || {}).innerText || '';
        var tentang = (document.getElementById('detail-tentang') || {}).innerText || '';
        var text = nama.trim() + '\n\n' + arab.trim() + '\n\n' + latin.trim() + '\n\n' + idn.trim();
        if (tentang) text += '\n\nSumber: ' + tentang.trim();

        navigator.clipboard.writeText(text).then(function () {
            var btn = document.getElementById('btn-copy');
            var orig = btn.innerHTML;
            btn.innerHTML = '✓ TERSALIN!';
            btn.classList.add('bg-[#E6F2EC]');
            setTimeout(function () {
                btn.innerHTML = orig;
                btn.classList.remove('bg-[#E6F2EC]');
            }, 2000);
        }).catch(function () {
            alert('Tidak dapat menyalin doa secara otomatis.');
        });
    }
</script>
@endpush
