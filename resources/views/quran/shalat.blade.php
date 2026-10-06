@extends('layouts.islamic')

@section('title', 'Jadwal Sholat Digital — eQuran Digital')

@section('content')
<div class="space-y-8">

    <!-- Top Headline Banner (Solid Clean Surface) -->
    <div class="bg-white border-2 border-[#114B3A] p-6 sm:p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-[#DCD5C5]">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2">
                    <span class="px-2.5 py-0.5 bg-[#114B3A] text-white text-[11px] font-bold tracking-wider uppercase">
                        LAYANAN 03
                    </span>
                    <span class="text-xs font-semibold text-[#8C6D38] tracking-widest uppercase">
                        PENGAYAAN &mdash; INTEGRASI API GET & POST
                    </span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-[#114B3A] tracking-tight">
                    Jadwal Sholat Seluruh Indonesia
                </h1>
                <p class="text-sm text-[#53635B] max-w-2xl leading-relaxed">
                    Akses waktu sholat akurat untuk 517 kabupaten/kota di seluruh Indonesia. Terintegrasi langsung dengan API eQuran.id dan hisab Kementerian Agama Republik Indonesia.
                </p>
            </div>

            <!-- Current Time Box (Solid Background) -->
            <div class="bg-[#F7F5EE] border border-[#DCD5C5] p-4 text-center min-w-[220px]">
                <span class="text-[10px] font-bold text-[#8C6D38] uppercase tracking-wider block">WAKTU SISTEM SAAT INI</span>
                <span id="live-clock" class="block text-2xl sm:text-3xl font-mono font-extrabold text-[#114B3A] my-1">
                    {{ date('H:i:s') }}
                </span>
                <span class="text-[11px] text-[#53635B] font-semibold block">
                    {{ date('d F Y') }}
                </span>
            </div>
        </div>

        <!-- Form Pemilihan Lokasi & Periode (Interaksi Pengguna) -->
        <div class="pt-6">
            <form action="{{ route('shalat.index') }}" method="GET" id="form-shalat" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Dropdown Provinsi (GET Data) -->
                    <div class="space-y-1">
                        <label for="select-provinsi" class="block text-xs font-bold text-[#1C2621] uppercase">
                            1. PILIH PROVINSI:
                        </label>
                        <select name="provinsi" 
                                id="select-provinsi" 
                                onchange="loadKabKota(this.value)"
                                class="w-full px-3 py-2.5 bg-[#F7F5EE] border-2 border-[#DCD5C5] focus:border-[#114B3A] text-xs font-bold text-[#1C2621] outline-none">
                            @foreach($daftarProvinsi as $prov)
                                <option value="{{ $prov }}" {{ ($provinsiTerpilih ?? '') === $prov ? 'selected' : '' }}>
                                    {{ $prov }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Kab/Kota (POST Data Dinamis) -->
                    <div class="space-y-1">
                        <label for="select-kabkota" class="block text-xs font-bold text-[#1C2621] uppercase">
                            2. KABUPATEN / KOTA:
                        </label>
                        <select name="kabkota" 
                                id="select-kabkota" 
                                class="w-full px-3 py-2.5 bg-[#F7F5EE] border-2 border-[#DCD5C5] focus:border-[#114B3A] text-xs font-bold text-[#1C2621] outline-none">
                            @foreach($daftarKabKota as $kab)
                                <option value="{{ $kab }}" {{ ($kabkotaTerpilih ?? '') === $kab ? 'selected' : '' }}>
                                    {{ $kab }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Bulan -->
                    <div class="space-y-1">
                        <label for="select-bulan" class="block text-xs font-bold text-[#1C2621] uppercase">
                            3. BULAN:
                        </label>
                        @php
                            $namaBulan = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        @endphp
                        <select name="bulan" 
                                id="select-bulan" 
                                class="w-full px-3 py-2.5 bg-[#F7F5EE] border-2 border-[#DCD5C5] focus:border-[#114B3A] text-xs font-bold text-[#1C2621] outline-none">
                            @foreach($namaBulan as $num => $nama)
                                <option value="{{ $num }}" {{ (int)($bulanTerpilih ?? date('n')) === $num ? 'selected' : '' }}>
                                    {{ $num }} - {{ $nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Tahun & Tombol Tampilkan -->
                    <div class="space-y-1">
                        <label for="select-tahun" class="block text-xs font-bold text-[#1C2621] uppercase">
                            4. TAHUN:
                        </label>
                        <div class="flex items-center gap-2">
                            <select name="tahun" 
                                    id="select-tahun" 
                                    class="w-1/2 px-3 py-2.5 bg-[#F7F5EE] border-2 border-[#DCD5C5] focus:border-[#114B3A] text-xs font-bold text-[#1C2621] outline-none">
                                @for($y = 2025; $y <= 2027; $y++)
                                    <option value="{{ $y }}" {{ (int)($tahunTerpilih ?? date('Y')) === $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>

                            <button type="submit" 
                                    class="w-1/2 px-4 py-2.5 bg-[#114B3A] hover:bg-[#0A3227] text-white text-xs font-bold tracking-wider uppercase border border-[#0A3227] transition-colors">
                                LIHAT
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            <div class="mt-4 pt-3 border-t border-[#F0ECE2] text-xs text-[#53635B] flex flex-wrap items-center justify-between gap-2">
                <span>
                    Lokasi Aktif: <strong class="text-[#114B3A]">{{ $kabkotaTerpilih ?? '-' }}</strong>, <strong class="text-[#114B3A]">{{ $provinsiTerpilih ?? '-' }}</strong>
                </span>
                <span class="text-[11px] text-[#8C6D38] font-semibold">
                    [ Data diperbarui otomatis dari server eQuran Kemenag ]
                </span>
            </div>
        </div>
    </div>

    @if(!empty($jadwalData) && isset($jadwalData['jadwal']) && is_array($jadwalData['jadwal']))
        @php
            $currentDayNum = (int)date('j');
            $currentMonthNum = (int)date('n');
            $currentYearNum = (int)date('Y');
            
            // Cari jadwal hari ini jika bulan dan tahun cocok
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

        <!-- Highlight Jadwal Hari Ini Box (Solid Cards) -->
        <div class="bg-white border-2 border-[#8C6D38] p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-[#DCD5C5] gap-4">
                <div>
                    <span class="px-2.5 py-0.5 bg-[#8C6D38] text-white text-[10px] font-bold uppercase tracking-wider">
                        JADWAL HARI INI
                    </span>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-[#114B3A] mt-1">
                        {{ $jadwalHariIni['hari'] ?? '' }}, {{ $jadwalHariIni['tanggal'] ?? '' }} {{ $jadwalData['bulan_nama'] ?? '' }} {{ $jadwalData['tahun'] ?? '' }}
                    </h2>
                    <p class="text-xs text-[#53635B] mt-0.5">
                        Wilayah: {{ $jadwalData['kabkota'] ?? '' }}, {{ $jadwalData['provinsi'] ?? '' }}
                    </p>
                </div>

                <div class="text-xs text-right">
                    <span class="inline-block px-3 py-1.5 bg-[#F7F5EE] border border-[#DCD5C5] font-bold text-[#114B3A]">
                        STATUS: JADWAL AKTIF
                    </span>
                </div>
            </div>

            <!-- 8 Times Cards Grid (Solid Clean Blocks, No Gradients) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 text-center">
                
                <!-- Imsak -->
                <div class="bg-[#F7F5EE] border-2 border-[#DCD5C5] p-3 hover:border-[#114B3A] transition-colors">
                    <span class="text-[11px] font-bold text-[#53635B] uppercase tracking-wider block">IMSAK</span>
                    <span class="text-xl font-extrabold text-[#114B3A] font-mono block mt-1">
                        {{ $jadwalHariIni['imsak'] ?? '--:--' }}
                    </span>
                </div>

                <!-- Subuh -->
                <div class="bg-[#EBF3EF] border-2 border-[#114B3A] p-3">
                    <span class="text-[11px] font-bold text-[#114B3A] uppercase tracking-wider block">SUBUH</span>
                    <span class="text-xl font-extrabold text-[#114B3A] font-mono block mt-1">
                        {{ $jadwalHariIni['subuh'] ?? '--:--' }}
                    </span>
                </div>

                <!-- Terbit -->
                <div class="bg-[#F7F5EE] border-2 border-[#DCD5C5] p-3 hover:border-[#114B3A] transition-colors">
                    <span class="text-[11px] font-bold text-[#53635B] uppercase tracking-wider block">TERBIT</span>
                    <span class="text-xl font-extrabold text-[#114B3A] font-mono block mt-1">
                        {{ $jadwalHariIni['terbit'] ?? '--:--' }}
                    </span>
                </div>

                <!-- Dhuha -->
                <div class="bg-[#F7F5EE] border-2 border-[#DCD5C5] p-3 hover:border-[#114B3A] transition-colors">
                    <span class="text-[11px] font-bold text-[#53635B] uppercase tracking-wider block">DHUHA</span>
                    <span class="text-xl font-extrabold text-[#114B3A] font-mono block mt-1">
                        {{ $jadwalHariIni['dhuha'] ?? '--:--' }}
                    </span>
                </div>

                <!-- Dzuhur -->
                <div class="bg-[#EBF3EF] border-2 border-[#114B3A] p-3">
                    <span class="text-[11px] font-bold text-[#114B3A] uppercase tracking-wider block">DZUHUR</span>
                    <span class="text-xl font-extrabold text-[#114B3A] font-mono block mt-1">
                        {{ $jadwalHariIni['dzuhur'] ?? '--:--' }}
                    </span>
                </div>

                <!-- Ashar -->
                <div class="bg-[#EBF3EF] border-2 border-[#114B3A] p-3">
                    <span class="text-[11px] font-bold text-[#114B3A] uppercase tracking-wider block">ASHAR</span>
                    <span class="text-xl font-extrabold text-[#114B3A] font-mono block mt-1">
                        {{ $jadwalHariIni['ashar'] ?? '--:--' }}
                    </span>
                </div>

                <!-- Maghrib -->
                <div class="bg-[#EBF3EF] border-2 border-[#114B3A] p-3">
                    <span class="text-[11px] font-bold text-[#114B3A] uppercase tracking-wider block">MAGHRIB</span>
                    <span class="text-xl font-extrabold text-[#114B3A] font-mono block mt-1">
                        {{ $jadwalHariIni['maghrib'] ?? '--:--' }}
                    </span>
                </div>

                <!-- Isya -->
                <div class="bg-[#EBF3EF] border-2 border-[#114B3A] p-3">
                    <span class="text-[11px] font-bold text-[#114B3A] uppercase tracking-wider block">ISYA</span>
                    <span class="text-xl font-extrabold text-[#114B3A] font-mono block mt-1">
                        {{ $jadwalHariIni['isya'] ?? '--:--' }}
                    </span>
                </div>

            </div>
        </div>

        <!-- Full Monthly Calendar Table -->
        <div class="bg-white border-2 border-[#114B3A] p-6 sm:p-8 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-[#DCD5C5]">
                <h3 class="text-lg font-bold text-[#114B3A]">
                    Tabel Waktu Sholat Bulan {{ $jadwalData['bulan_nama'] ?? '' }} {{ $jadwalData['tahun'] ?? '' }}
                </h3>
                <span class="text-xs text-[#53635B]">
                    Baris dengan latar belakang hijau muda menandakan tanggal hari ini.
                </span>
            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm border-collapse">
                    <thead>
                        <tr class="bg-[#0A3227] text-[#F4ECE1] text-[11px] uppercase tracking-wider font-bold">
                            <th class="py-3 px-3 border border-[#0A3227]">TGL</th>
                            <th class="py-3 px-3 border border-[#0A3227]">HARI</th>
                            <th class="py-3 px-3 border border-[#0A3227]">IMSAK</th>
                            <th class="py-3 px-3 border border-[#0A3227]">SUBUH</th>
                            <th class="py-3 px-3 border border-[#0A3227]">TERBIT</th>
                            <th class="py-3 px-3 border border-[#0A3227]">DHUHA</th>
                            <th class="py-3 px-3 border border-[#0A3227]">DZUHUR</th>
                            <th class="py-3 px-3 border border-[#0A3227]">ASHAR</th>
                            <th class="py-3 px-3 border border-[#0A3227]">MAGHRIB</th>
                            <th class="py-3 px-3 border border-[#0A3227]">ISYA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#DCD5C5]">
                        @foreach($jadwalData['jadwal'] as $row)
                            @php
                                $isToday = ($bulanTerpilih == $currentMonthNum && $tahunTerpilih == $currentYearNum && (int)$row['tanggal'] === $currentDayNum);
                            @endphp
                            <tr class="transition-colors {{ $isToday ? 'bg-[#EBF3EF] font-bold border-2 border-[#114B3A]' : 'hover:bg-[#F7F5EE]' }}">
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-bold text-[#114B3A]">
                                    {{ sprintf('%02d', $row['tanggal']) }}
                                    @if($isToday)
                                        <span class="text-[9px] px-1 bg-[#114B3A] text-white uppercase ml-1">KINI</span>
                                    @endif
                                </td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] text-[#1C2621]">{{ $row['hari'] }}</td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-mono">{{ $row['imsak'] }}</td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-mono text-[#114B3A]">{{ $row['subuh'] }}</td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-mono text-[#53635B]">{{ $row['terbit'] }}</td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-mono text-[#53635B]">{{ $row['dhuha'] }}</td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-mono text-[#114B3A]">{{ $row['dzuhur'] }}</td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-mono text-[#114B3A]">{{ $row['ashar'] }}</td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-mono text-[#114B3A]">{{ $row['maghrib'] }}</td>
                                <td class="py-2.5 px-3 border border-[#DCD5C5] font-mono text-[#114B3A]">{{ $row['isya'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Empty State jika Jadwal Belum Dipilih atau Tidak Ditemukan -->
        <div class="bg-white border-2 border-[#DCD5C5] p-12 text-center space-y-4">
            <div class="inline-block px-3 py-1 bg-[#F9F5EC] border border-[#8C6D38] text-[#8C6D38] font-bold text-xs uppercase">
                PILIH LOKASI
            </div>
            <h2 class="text-xl font-bold text-[#114B3A]">Jadwal sholat belum dimuat</h2>
            <p class="text-sm text-[#53635B] max-w-md mx-auto leading-relaxed">
                Silakan pilih provinsi dan kabupaten/kota pada formulir di atas, lalu klik tombol <strong>LIHAT</strong> untuk memuat jadwal sholat lengkap.
            </p>
        </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // Live Clock Update
    function updateClock() {
        var el = document.getElementById('live-clock');
        if (el) {
            var now = new Date();
            var h = String(now.getHours()).padStart(2, '0');
            var m = String(now.getMinutes()).padStart(2, '0');
            var s = String(now.getSeconds()).padStart(2, '0');
            el.textContent = h + ':' + m + ':' + s;
        }
    }
    setInterval(updateClock, 1000);

    // Dynamic AJAX Kab/Kota Loader saat Provinsi diganti
    function loadKabKota(provinsiName) {
        var selectKab = document.getElementById('select-kabkota');
        if (!selectKab) return;

        selectKab.innerHTML = '<option value="">Memuat daftar kota...</option>';
        selectKab.disabled = true;

        fetch('{{ route("shalat.kabkota") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ provinsi: provinsiName })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            selectKab.innerHTML = '';
            var list = data.data || [];
            if (list.length === 0) {
                selectKab.innerHTML = '<option value="">Kota tidak ditemukan</option>';
            } else {
                list.forEach(function(kab) {
                    var opt = document.createElement('option');
                    opt.value = kab;
                    opt.textContent = kab;
                    selectKab.appendChild(opt);
                });
            }
            selectKab.disabled = false;
        })
        .catch(function(err) {
            console.error('Error loading kabkota:', err);
            selectKab.innerHTML = '<option value="">Gagal memuat kota</option>';
            selectKab.disabled = false;
        });
    }
</script>
@endpush
