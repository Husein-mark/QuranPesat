@extends('layouts.islamic')

@section('title', 'Jadwal Sholat Seluruh Indonesia — Mushaf Digital')

@section('content')
<div class="space-y-6 sm:space-y-7">

    <!-- Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#0E5C45] via-[#0B4A37] to-[#082C22] text-white p-6 sm:p-10 shadow-lg">
        <div class="absolute right-6 top-1/2 -translate-y-1/2 hidden lg:block opacity-[0.07] pointer-events-none font-arabic text-[100px] leading-none select-none">الصلاة</div>
        <div class="absolute -bottom-10 -right-10 w-52 h-52 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div class="space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#C28B38]/20 text-[#E9C37A] text-[10px] font-bold tracking-widest border border-[#C28B38]/30">
                    JADWAL SHOLAT RESMI KEMENAG RI
                </span>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">Jadwal Sholat Indonesia</h1>
                <p class="text-sm text-white/70 leading-relaxed max-w-lg">
                    Waktu sholat akurat untuk 517 kabupaten/kota di seluruh Indonesia berdasarkan hisab resmi Kementerian Agama Republik Indonesia.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 text-center min-w-[180px] border border-white/10">
                <span class="text-[10px] font-bold text-[#E9C37A] uppercase tracking-wider block">WAKTU SEKARANG</span>
                <span id="live-clock" class="block text-3xl font-mono font-black text-white my-2">{{ date('H:i:s') }}</span>
                <span class="text-[11px] text-white/70 block">{{ date('d F Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-2xl border border-[#D8E4DE] p-5 sm:p-6 shadow-sm">
        <h2 class="text-sm font-bold text-[#18251F] mb-4">Pilih Wilayah & Periode</h2>
        <form action="{{ route('shalat.index') }}" method="GET" id="form-shalat">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Provinsi -->
                <div class="space-y-1.5">
                    <label for="select-provinsi" class="text-[10px] font-bold text-[#54706A] uppercase tracking-wider">1. Provinsi</label>
                    <select name="provinsi"
                            id="select-provinsi"
                            onchange="loadKabKota(this.value)"
                            class="w-full px-3 py-2.5 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] focus:border-[#0E5C45] text-xs font-semibold text-[#18251F] outline-none transition-colors">
                        @foreach($daftarProvinsi as $prov)
                            <option value="{{ $prov }}" {{ ($provinsiTerpilih ?? '') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kab/Kota -->
                <div class="space-y-1.5">
                    <label for="select-kabkota" class="text-[10px] font-bold text-[#54706A] uppercase tracking-wider">2. Kabupaten/Kota</label>
                    <select name="kabkota"
                            id="select-kabkota"
                            class="w-full px-3 py-2.5 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] focus:border-[#0E5C45] text-xs font-semibold text-[#18251F] outline-none transition-colors">
                        @foreach($daftarKabKota as $kab)
                            <option value="{{ $kab }}" {{ ($kabkotaTerpilih ?? '') === $kab ? 'selected' : '' }}>{{ $kab }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bulan -->
                <div class="space-y-1.5">
                    <label for="select-bulan" class="text-[10px] font-bold text-[#54706A] uppercase tracking-wider">3. Bulan</label>
                    @php
                        $namaBulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    <select name="bulan"
                            id="select-bulan"
                            class="w-full px-3 py-2.5 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] focus:border-[#0E5C45] text-xs font-semibold text-[#18251F] outline-none transition-colors">
                        @foreach($namaBulan as $num => $nama)
                            <option value="{{ $num }}" {{ (int)($bulanTerpilih ?? date('n')) === $num ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun + Submit -->
                <div class="space-y-1.5">
                    <label for="select-tahun" class="text-[10px] font-bold text-[#54706A] uppercase tracking-wider">4. Tahun</label>
                    <div class="flex gap-2">
                        <select name="tahun"
                                id="select-tahun"
                                class="flex-1 px-3 py-2.5 bg-[#F5F9F7] rounded-xl border border-[#D0DDD8] focus:border-[#0E5C45] text-xs font-semibold text-[#18251F] outline-none transition-colors">
                            @for($y = 2025; $y <= 2027; $y++)
                                <option value="{{ $y }}" {{ (int)($tahunTerpilih ?? date('Y')) === $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <button type="submit"
                                class="px-4 py-2.5 bg-[#0E5C45] hover:bg-[#083C2C] text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                            Lihat
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-[#EDF2EF] text-[11px] text-[#54706A] flex flex-wrap items-center justify-between gap-2">
                <span>Lokasi aktif: <strong class="text-[#0E5C45]">{{ $kabkotaTerpilih ?? '-' }}, {{ $provinsiTerpilih ?? '-' }}</strong></span>
                <span class="text-[#C28B38] font-semibold">Data dari server eQuran Kemenag RI</span>
            </div>
        </form>
    </div>

    @if(!empty($jadwalData) && isset($jadwalData['jadwal']) && is_array($jadwalData['jadwal']))
        @php
            $currentDayNum = (int)date('j');
            $currentMonthNum = (int)date('n');
            $currentYearNum = (int)date('Y');
            $jadwalHariIni = null;
            if ($bulanTerpilih == $currentMonthNum && $tahunTerpilih == $currentYearNum) {
                foreach ($jadwalData['jadwal'] as $j) {
                    if ((int)$j['tanggal'] === $currentDayNum) {
                        $jadwalHariIni = $j;
                        break;
                    }
                }
            }
            if (!$jadwalHariIni && !empty($jadwalData['jadwal'])) {
                $jadwalHariIni = $jadwalData['jadwal'][0];
            }
        @endphp

        <!-- Jadwal Hari Ini -->
        <div class="bg-white rounded-2xl border border-[#D8E4DE] shadow-sm overflow-hidden">
            <div class="px-5 sm:px-7 py-4 border-b border-[#EDF2EF] bg-[#F8FAF9] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="inline-block px-2.5 py-1 rounded-full bg-[#0E5C45] text-white text-[10px] font-bold uppercase tracking-wider mb-1">
                        Jadwal Hari Ini
                    </span>
                    <h2 class="text-lg sm:text-xl font-extrabold text-[#0E5C45]">
                        {{ $jadwalHariIni['hari'] ?? '' }}, {{ $jadwalHariIni['tanggal'] ?? '' }} {{ $jadwalData['bulan_nama'] ?? '' }} {{ $jadwalData['tahun'] ?? '' }}
                    </h2>
                    <p class="text-xs text-[#54706A]">{{ $jadwalData['kabkota'] ?? '' }}, {{ $jadwalData['provinsi'] ?? '' }}</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#E6F2EC] text-[#0E5C45] text-[10px] font-bold border border-[#B8D8CB]">
                    <span class="w-2 h-2 rounded-full bg-[#0E5C45] animate-pulse"></span>
                    AKTIF
                </span>
            </div>

            <!-- Sholat time cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-0 divide-x divide-y divide-[#EDF2EF]">
                @php
                    $sholat = [
                        'imsak' => ['Imsak', '#54706A'],
                        'subuh' => ['Subuh', '#0E5C45'],
                        'terbit' => ['Terbit', '#54706A'],
                        'dhuha' => ['Dhuha', '#54706A'],
                        'dzuhur' => ['Dzuhur', '#0E5C45'],
                        'ashar' => ['Ashar', '#0E5C45'],
                        'maghrib' => ['Maghrib', '#0E5C45'],
                        'isya' => ['Isya', '#0E5C45'],
                    ];
                    $highlighted = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];
                @endphp
                @foreach($sholat as $key => [$label, $color])
                    <div class="py-5 px-3 text-center {{ in_array($key, $highlighted) ? 'bg-[#F5FBF8]' : 'bg-white' }} hover:bg-[#E6F2EC] transition-colors">
                        <span class="text-[10px] font-bold uppercase tracking-wider block" style="color: {{ $color }}">{{ $label }}</span>
                        <span class="text-xl font-mono font-extrabold text-[#0E5C45] block mt-1">{{ $jadwalHariIni[$key] ?? '--:--' }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tabel Jadwal Bulanan -->
        <div class="bg-white rounded-2xl border border-[#D8E4DE] shadow-sm overflow-hidden">
            <div class="px-5 sm:px-7 py-4 border-b border-[#EDF2EF] bg-[#F8FAF9] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <h3 class="text-base font-bold text-[#18251F]">
                    Tabel Sholat — {{ $jadwalData['bulan_nama'] ?? '' }} {{ $jadwalData['tahun'] ?? '' }}
                </h3>
                <span class="text-[11px] text-[#54706A]">
                    Baris hijau = hari ini
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="bg-[#0E5C45] text-white text-[10px] uppercase tracking-wider font-bold">
                            <th class="py-3 px-3">Tgl</th>
                            <th class="py-3 px-3">Hari</th>
                            <th class="py-3 px-3">Imsak</th>
                            <th class="py-3 px-3">Subuh</th>
                            <th class="py-3 px-3">Terbit</th>
                            <th class="py-3 px-3">Dhuha</th>
                            <th class="py-3 px-3">Dzuhur</th>
                            <th class="py-3 px-3">Ashar</th>
                            <th class="py-3 px-3">Maghrib</th>
                            <th class="py-3 px-3">Isya</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EDF2EF]">
                        @foreach($jadwalData['jadwal'] as $row)
                            @php
                                $isToday = ($bulanTerpilih == $currentMonthNum && $tahunTerpilih == $currentYearNum && (int)$row['tanggal'] === $currentDayNum);
                            @endphp
                            <tr class="{{ $isToday ? 'bg-[#E6F2EC] font-semibold' : 'hover:bg-[#F8FAF9]' }} transition-colors">
                                <td class="py-2.5 px-3 font-bold text-[#0E5C45]">
                                    {{ sprintf('%02d', $row['tanggal']) }}
                                    @if($isToday)
                                        <span class="text-[9px] px-1.5 py-0.5 bg-[#0E5C45] text-white rounded-full uppercase ml-1">Hari ini</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 text-[#2A3B33]">{{ $row['hari'] }}</td>
                                <td class="py-2.5 px-3 font-mono text-[#54706A]">{{ $row['imsak'] }}</td>
                                <td class="py-2.5 px-3 font-mono font-semibold text-[#0E5C45]">{{ $row['subuh'] }}</td>
                                <td class="py-2.5 px-3 font-mono text-[#54706A]">{{ $row['terbit'] }}</td>
                                <td class="py-2.5 px-3 font-mono text-[#54706A]">{{ $row['dhuha'] }}</td>
                                <td class="py-2.5 px-3 font-mono font-semibold text-[#0E5C45]">{{ $row['dzuhur'] }}</td>
                                <td class="py-2.5 px-3 font-mono font-semibold text-[#0E5C45]">{{ $row['ashar'] }}</td>
                                <td class="py-2.5 px-3 font-mono font-semibold text-[#0E5C45]">{{ $row['maghrib'] }}</td>
                                <td class="py-2.5 px-3 font-mono font-semibold text-[#0E5C45]">{{ $row['isya'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl border border-[#D8E4DE] p-14 text-center space-y-4 shadow-sm">
            <div class="w-14 h-14 mx-auto rounded-full bg-[#E6F2EC] text-[#0E5C45] flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-[#0E5C45]">Jadwal belum dimuat</h2>
            <p class="text-sm text-[#54706A] max-w-sm mx-auto">Pilih provinsi, kabupaten/kota, bulan, dan tahun lalu klik <strong>Lihat</strong>.</p>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // Live clock
    (function updateClock() {
        var el = document.getElementById('live-clock');
        if (el) {
            var now = new Date();
            el.textContent = String(now.getHours()).padStart(2, '0') + ':' +
                             String(now.getMinutes()).padStart(2, '0') + ':' +
                             String(now.getSeconds()).padStart(2, '0');
        }
        setTimeout(updateClock, 1000);
    })();

    function loadKabKota(provinsiName) {
        var selectKab = document.getElementById('select-kabkota');
        if (!selectKab) return;
        selectKab.innerHTML = '<option value="">Memuat...</option>';
        selectKab.disabled = true;

        fetch('{{ route("shalat.kabkota") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ provinsi: provinsiName })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            selectKab.innerHTML = '';
            var list = data.data || [];
            if (!list.length) {
                selectKab.innerHTML = '<option value="">Kota tidak ditemukan</option>';
            } else {
                list.forEach(function (kab) {
                    var opt = document.createElement('option');
                    opt.value = kab;
                    opt.textContent = kab;
                    selectKab.appendChild(opt);
                });
            }
            selectKab.disabled = false;
        })
        .catch(function () {
            selectKab.innerHTML = '<option value="">Gagal memuat</option>';
            selectKab.disabled = false;
        });
    }
</script>
@endpush
