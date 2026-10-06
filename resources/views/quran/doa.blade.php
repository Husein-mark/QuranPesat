@extends('layouts.islamic')

@section('title', 'Kumpulan Doa Harian & Dzikir — Mushaf Digital')

@section('content')
<div class="space-y-6 sm:space-y-7">

    <!-- Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#0E5C45] via-[#0B4A37] to-[#082C22] text-white p-6 sm:p-10 shadow-lg">
        <div class="absolute right-6 top-1/2 -translate-y-1/2 hidden lg:block opacity-[0.07] pointer-events-none font-arabic text-[100px] leading-none select-none">الدعاء</div>
        <div class="absolute -bottom-10 -right-10 w-52 h-52 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div class="space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#C28B38]/20 text-[#E9C37A] text-[10px] font-bold tracking-widest border border-[#C28B38]/30">
                    DOA HARIAN & SUNNAH
                </span>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">Kumpulan Doa Harian</h1>
                <p class="text-sm text-white/70 leading-relaxed max-w-lg">
                    Kumpulan doa dan dzikir sehari-hari bersumber dari Al-Qur'an dan hadits shahih, dilengkapi teks Arab, transliterasi, dan terjemahan.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 text-center min-w-[160px] border border-white/10">
                <span class="block text-3xl font-black text-white">{{ count($doaList) }}</span>
                <span class="text-[10px] font-bold text-[#E9C37A] uppercase tracking-wider block mt-1">Doa Ditampilkan</span>
                <span class="text-[10px] text-white/60 mt-1 block">Hisnul Muslim & Hadits</span>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#D8E4DE] shadow-sm">
        <form action="{{ route('doa.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">

            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#7A9A90]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text"
                       id="doa-search"
                       name="q"
                       value="{{ $search ?? '' }}"
                       placeholder="Cari nama doa, lafadz, arti (misal: tidur, makan, pagi, sakit)..."
                       class="w-full pl-10 pr-4 py-3 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] focus:border-[#0E5C45] focus:bg-white text-sm text-[#18251F] outline-none transition-all placeholder:text-[#96AEA7]"
                       autocomplete="off">
            </div>

            <div class="flex items-center gap-2">
                <select name="grup"
                        id="doa-grup"
                        class="flex-1 px-3 py-3 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] focus:border-[#0E5C45] text-xs font-semibold text-[#18251F] outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($semuaGrup as $grup)
                        <option value="{{ $grup }}" {{ ($grupPilihan ?? '') === $grup ? 'selected' : '' }}>{{ $grup }}</option>
                    @endforeach
                </select>

                <button type="submit"
                        class="px-5 py-3 bg-[#0E5C45] hover:bg-[#083C2C] text-white text-xs font-bold tracking-wider rounded-xl transition-all shadow-sm shrink-0">
                    Cari
                </button>

                @if(!empty($search) || !empty($grupPilihan) || !empty($tagPilihan))
                    <a href="{{ route('doa.index') }}"
                       class="px-4 py-3 bg-white border border-[#D0DDD8] text-xs font-bold text-[#C28B38] rounded-xl transition-all shrink-0 hover:bg-gray-50">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Doa List -->
    @if(empty($doaList))
        <div class="bg-white rounded-2xl border border-[#D8E4DE] p-14 text-center space-y-4 shadow-sm">
            <div class="w-14 h-14 mx-auto rounded-full bg-amber-50 text-[#C28B38] flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-[#0E5C45]">Doa tidak ditemukan</h2>
            <p class="text-sm text-[#54706A] max-w-sm mx-auto">Coba kata kunci lain atau pilih kategori yang berbeda.</p>
            <a href="{{ route('doa.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0E5C45] text-white text-xs font-bold rounded-xl hover:bg-[#083C2C] transition-all">
                Tampilkan Semua Doa
            </a>
        </div>
    @else
        <div class="space-y-4" id="doa-container">
            @foreach($doaList as $doa)
                <div class="doa-card bg-white rounded-2xl border border-[#D8E4DE] overflow-hidden shadow-sm hover:border-[#0E5C45] transition-all"
                     id="doa-card-{{ $doa['id'] }}">

                    <!-- Card top bar -->
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 sm:px-6 py-3 bg-[#F8FAF9] border-b border-[#EDF2EF]">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-lg bg-[#E6F2EC] text-[#0E5C45] text-[10px] font-black">
                                NO. {{ $doa['id'] }}
                            </span>
                            @if(!empty($doa['grup']))
                                <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-[#C28B38] text-[10px] font-bold border border-amber-200">
                                    {{ $doa['grup'] }}
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <button type="button"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-[#E6F2EC] text-[#0E5C45] border border-[#D0DDD8] hover:border-[#0E5C45] text-[10px] font-bold rounded-lg transition-colors"
                                    onclick="copyDoa({{ $doa['id'] }})">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                SALIN DOA
                            </button>

                            @if(!empty($doa['tentang']))
                                <button type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-amber-50 text-[#C28B38] border border-[#D0DDD8] hover:border-amber-300 text-[10px] font-bold rounded-lg transition-colors"
                                        onclick="toggleRiwayat({{ $doa['id'] }})">
                                    HADITS
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="px-5 sm:px-7 py-5 space-y-3">
                        <!-- Judul -->
                        <h3 class="text-base sm:text-lg font-bold text-[#18251F]"
                            id="doa-nama-{{ $doa['id'] }}">
                            {{ $doa['nama'] }}
                        </h3>

                        <!-- Arab -->
                        <div class="py-2 text-right">
                            <p class="font-arabic text-2xl sm:text-3xl leading-[2.6] text-[#0E5C45] break-words"
                               id="doa-arab-{{ $doa['id'] }}">
                                {{ $doa['ar'] }}
                            </p>
                        </div>

                        <!-- Latin -->
                        @if(!empty($doa['tr']))
                            <div class="border-t border-[#EDF2EF] pt-3">
                                <p class="text-xs sm:text-sm font-medium italic text-[#A07828] leading-relaxed"
                                   id="doa-latin-{{ $doa['id'] }}">
                                    {{ $doa['tr'] }}
                                </p>
                            </div>
                        @endif

                        <!-- Terjemahan -->
                        @if(!empty($doa['idn']))
                            <p class="text-xs sm:text-sm text-[#2A3B33] leading-relaxed"
                               id="doa-idn-{{ $doa['id'] }}">
                                &ldquo;{{ $doa['idn'] }}&rdquo;
                            </p>
                        @endif

                        <!-- Riwayat hadits -->
                        @if(!empty($doa['tentang']))
                            <div id="riwayat-box-{{ $doa['id'] }}"
                                 class="hidden p-4 rounded-xl bg-[#FDF9F1] border-l-4 border-[#C28B38] border border-[#E8DFC8]">
                                <span class="text-[10px] font-bold text-[#A07828] uppercase tracking-wider block mb-1.5">Takhrij & Sumber Riwayat:</span>
                                <p class="text-xs text-[#4A5952] leading-relaxed whitespace-pre-line"
                                   id="doa-tentang-{{ $doa['id'] }}">{{ $doa['tentang'] }}</p>
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
            @endforeach
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    function copyDoa(id) {
        var nama = (document.getElementById('doa-nama-' + id) || {}).innerText || '';
        var arab = (document.getElementById('doa-arab-' + id) || {}).innerText || '';
        var latin = (document.getElementById('doa-latin-' + id) || {}).innerText || '';
        var idn = (document.getElementById('doa-idn-' + id) || {}).innerText || '';
        var tentang = (document.getElementById('doa-tentang-' + id) || {}).innerText || '';
        var text = nama.trim() + '\n\n' + arab.trim() + '\n\n' + latin.trim() + '\n\n' + idn.trim();
        if (tentang) text += '\n\nSumber: ' + tentang.trim();

        navigator.clipboard.writeText(text).then(function () {
            var btn = event.target.closest('button');
            var orig = btn.innerHTML;
            btn.innerHTML = '✓ TERSALIN';
            btn.classList.add('bg-[#E6F2EC]', 'text-[#0E5C45]');
            setTimeout(function () {
                btn.innerHTML = orig;
                btn.classList.remove('bg-[#E6F2EC]', 'text-[#0E5C45]');
            }, 2000);
        }).catch(function () {
            alert('Tidak dapat menyalin doa secara otomatis.');
        });
    }

    function toggleRiwayat(id) {
        var box = document.getElementById('riwayat-box-' + id);
        if (box) box.classList.toggle('hidden');
    }
</script>
@endpush
