<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuranController extends Controller
{
    private string $baseUrl = 'https://equran.id/api';

    /**
     * Menampilkan daftar seluruh surat Al-Qur'an dengan fitur pencarian & filter.
     */
    public function index(Request $request)
    {
        $search = trim($request->get('q', ''));
        $tempatTurun = $request->get('tempat_turun', '');
        $error = null;
        $quran = [];

        try {
            $response = Http::timeout(12)->get("{$this->baseUrl}/v2/surat");

            if ($response->successful()) {
                $allSurat = $response->json()['data'] ?? [];

                // Filter berdasarkan keyword (nama, latin, arti, nomor)
                if ($search !== '') {
                    $searchLower = strtolower($search);
                    $allSurat = array_filter($allSurat, function ($s) use ($searchLower) {
                        return str_contains(strtolower($s['namaLatin'] ?? ''), $searchLower)
                            || str_contains(strtolower($s['arti'] ?? ''), $searchLower)
                            || str_contains((string)($s['nomor'] ?? ''), $searchLower)
                            || str_contains($s['nama'] ?? '', $searchLower);
                    });
                }

                // Filter berdasarkan tempat turun (Mekah / Madinah)
                if (!empty($tempatTurun)) {
                    $allSurat = array_filter($allSurat, function ($s) use ($tempatTurun) {
                        return strtolower($s['tempatTurun'] ?? '') === strtolower($tempatTurun);
                    });
                }

                $quran = array_values($allSurat);
            } else {
                $error = 'Gagal memuat data surat dari server API eQuran (Status: ' . $response->status() . '). Silakan coba lagi.';
            }
        } catch (\Exception $e) {
            Log::error('QuranController index error: ' . $e->getMessage());
            $error = 'Terjadi kesalahan jaringan atau waktu habis saat menghubungi API Al-Qur\'an. Silakan periksa koneksi internet Anda.';
        }

        return view('quran', [
            'quran' => $quran,
            'search' => $search,
            'tempatTurun' => $tempatTurun,
            'error' => $error,
        ]);
    }

    /**
     * Menampilkan detail surat tertentu beserta ayat, audio surat, audio ayat, tafsir, dan paginasi ayat.
     */
    public function show(Request $request, string $nomor)
    {
        $nomor = (int) $nomor;
        if ($nomor < 1 || $nomor > 114) {
            return redirect()->route('quran.index')->with('error', 'Nomor surat tidak valid. Al-Qur\'an terdiri dari 114 surat.');
        }

        $error = null;
        $surat = null;
        $tafsir = null;

        try {
            // Ambil data surat beserta ayat dan audio
            $responseSurat = Http::timeout(12)->get("{$this->baseUrl}/v2/surat/{$nomor}");
            if ($responseSurat->successful()) {
                $surat = $responseSurat->json()['data'] ?? null;
            } else {
                $error = 'Surat tidak ditemukan atau server Al-Qur\'an sedang mengalami gangguan.';
            }

            // Ambil data tafsir untuk surat ini
            $responseTafsir = Http::timeout(12)->get("{$this->baseUrl}/v2/tafsir/{$nomor}");
            if ($responseTafsir->successful()) {
                $tafsirData = $responseTafsir->json()['data'] ?? null;
                if ($tafsirData && isset($tafsirData['tafsir'])) {
                    // Petakan tafsir berdasarkan nomor ayat agar mudah diakses
                    $tafsirMap = [];
                    foreach ($tafsirData['tafsir'] as $t) {
                        $tafsirMap[$t['ayat']] = $t['teks'];
                    }
                    $tafsir = $tafsirMap;
                }
            }
        } catch (\Exception $e) {
            Log::error("QuranController show ({$nomor}) error: " . $e->getMessage());
            $error = 'Gagal menghubungi server API Al-Qur\'an. Silakan periksa koneksi internet.';
        }

        // Paginasi Ayat untuk surat yang memiliki banyak ayat
        $allAyat = $surat['ayat'] ?? [];
        $totalAyat = count($allAyat);

        // Ambil preferensi ayat per halaman (default 20 ayat agar cepat dan nyaman dibaca)
        $perPageParam = $request->get('per_page', '20');
        $showAll = ($perPageParam === 'all' || $perPageParam === 'semua');
        $perPage = (int) $perPageParam;
        if (! $showAll && ($perPage < 5 || $perPage > 150)) {
            $perPage = 20;
        }

        if ($showAll || $totalAyat <= $perPage) {
            $currentPage = 1;
            $totalPages = 1;
            $paginatedAyat = $allAyat;
            $startAyat = $totalAyat > 0 ? 1 : 0;
            $endAyat = $totalAyat;
        } else {
            $totalPages = max(1, (int) ceil($totalAyat / $perPage));
            $currentPage = (int) $request->get('page', 1);
            if ($currentPage < 1) {
                $currentPage = 1;
            } elseif ($currentPage > $totalPages) {
                $currentPage = $totalPages;
            }

            $offset = ($currentPage - 1) * $perPage;
            $paginatedAyat = array_slice($allAyat, $offset, $perPage);
            $startAyat = $offset + 1;
            $endAyat = min($totalAyat, $offset + $perPage);
        }

        // Peta audio seluruh ayat agar audio player ayat tetap bisa berputar
        $allAyatAudioMap = [];
        $allNomorAyat = [];
        foreach ($allAyat as $item) {
            $nomorAyat = $item['nomorAyat'] ?? null;
            if ($nomorAyat !== null) {
                $allNomorAyat[] = $nomorAyat;
                $allAyatAudioMap[$nomorAyat] = $item['audio'] ?? [];
            }
        }

        // Ganti koleksi ayat dengan ayat halaman saat ini
        if ($surat) {
            $surat['ayat'] = $paginatedAyat;
        }

        return view('detail', [
            'quran' => $surat,
            'tafsir' => $tafsir,
            'nomor' => $nomor,
            'error' => $error,
            'totalAyat' => $totalAyat,
            'perPage' => $showAll ? 'all' : $perPage,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'startAyat' => $startAyat,
            'endAyat' => $endAyat,
            'allAyatAudioMap' => $allAyatAudioMap,
            'allNomorAyat' => $allNomorAyat,
            'showAll' => $showAll,
        ]);
    }

    /**
     * Menampilkan daftar kumpulan Doa Harian dengan filter kategori dan pencarian.
     */
    public function doa(Request $request)
    {
        $search = trim($request->get('q', ''));
        $grupPilihan = $request->get('grup', '');
        $tagPilihan = $request->get('tag', '');
        $error = null;
        $doaList = [];
        $semuaGrup = [];
        $semuaTag = [];

        try {
            $response = Http::timeout(12)->get("{$this->baseUrl}/doa");

            if ($response->successful()) {
                $allDoa = $response->json()['data'] ?? [];

                // Kumpulkan daftar grup unik dan tag unik
                foreach ($allDoa as $item) {
                    if (!empty($item['grup']) && !in_array($item['grup'], $semuaGrup)) {
                        $semuaGrup[] = $item['grup'];
                    }
                    if (!empty($item['tag']) && is_array($item['tag'])) {
                        foreach ($item['tag'] as $t) {
                            if (!empty($t) && !in_array($t, $semuaTag)) {
                                $semuaTag[] = $t;
                            }
                        }
                    }
                }
                sort($semuaGrup);
                sort($semuaTag);

                // Filter grup
                if (!empty($grupPilihan)) {
                    $allDoa = array_filter($allDoa, function ($d) use ($grupPilihan) {
                        return ($d['grup'] ?? '') === $grupPilihan;
                    });
                }

                // Filter tag
                if (!empty($tagPilihan)) {
                    $allDoa = array_filter($allDoa, function ($d) use ($tagPilihan) {
                        return isset($d['tag']) && is_array($d['tag']) && in_array($tagPilihan, $d['tag']);
                    });
                }

                // Filter search keyword
                if ($search !== '') {
                    $searchLower = strtolower($search);
                    $allDoa = array_filter($allDoa, function ($d) use ($searchLower) {
                        return str_contains(strtolower($d['nama'] ?? ''), $searchLower)
                            || str_contains(strtolower($d['idn'] ?? ''), $searchLower)
                            || str_contains(strtolower($d['grup'] ?? ''), $searchLower)
                            || str_contains(strtolower($d['tr'] ?? ''), $searchLower);
                    });
                }

                $doaList = array_values($allDoa);
            } else {
                $error = 'Gagal memuat kumpulan doa harian dari API (Status: ' . $response->status() . ').';
            }
        } catch (\Exception $e) {
            Log::error('QuranController doa error: ' . $e->getMessage());
            $error = 'Terjadi gangguan jaringan saat memuat doa harian. Silakan coba kembali.';
        }

        return view('quran.doa', [
            'doaList' => $doaList,
            'semuaGrup' => $semuaGrup,
            'semuaTag' => $semuaTag,
            'search' => $search,
            'grupPilihan' => $grupPilihan,
            'tagPilihan' => $tagPilihan,
            'error' => $error,
        ]);
    }

    /**
     * Menampilkan detail satu doa tertentu.
     */
    public function doaDetail(string $id)
    {
        $error = null;
        $doa = null;

        try {
            $response = Http::timeout(12)->get("{$this->baseUrl}/doa/{$id}");
            if ($response->successful()) {
                $doa = $response->json()['data'] ?? null;
            } else {
                // Fallback jika /doa/{id} tidak didukung langsung, cari dari daftar /doa
                $resAll = Http::timeout(12)->get("{$this->baseUrl}/doa");
                if ($resAll->successful()) {
                    $allDoa = $resAll->json()['data'] ?? [];
                    foreach ($allDoa as $item) {
                        if ((string)($item['id'] ?? '') === (string)$id) {
                            $doa = $item;
                            break;
                        }
                    }
                }
            }

            if (!$doa) {
                $error = 'Doa dengan ID tersebut tidak ditemukan.';
            }
        } catch (\Exception $e) {
            Log::error("QuranController doaDetail ({$id}) error: " . $e->getMessage());
            $error = 'Gagal memuat detail doa karena gangguan jaringan.';
        }

        return view('quran.doa-detail', [
            'doa' => $doa,
            'error' => $error,
        ]);
    }

    /**
     * Menampilkan halaman Jadwal Sholat dengan pemilihan provinsi, kab/kota, bulan, dan tahun.
     */
    public function shalat(Request $request)
    {
        $provinsi = $request->get('provinsi', 'DKI Jakarta');
        $kabkota = $request->get('kabkota', 'Kota Jakarta');
        $bulan = (int)$request->get('bulan', (int)date('n'));
        $tahun = (int)$request->get('tahun', (int)date('Y'));

        $error = null;
        $daftarProvinsi = [];
        $daftarKabKota = [];
        $jadwalData = null;

        try {
            // 1. Ambil daftar seluruh provinsi (GET)
            $resProv = Http::timeout(12)->get("{$this->baseUrl}/v2/shalat/provinsi");
            if ($resProv->successful()) {
                $daftarProvinsi = $resProv->json()['data'] ?? [];
            }

            // Jika provinsi tidak ada di daftar, pakai provinsi pertama
            if (!empty($daftarProvinsi) && !in_array($provinsi, $daftarProvinsi)) {
                $provinsi = $daftarProvinsi[0];
            }

            // 2. Ambil daftar kabupaten/kota untuk provinsi ini (POST)
            $resKab = Http::timeout(12)->post("{$this->baseUrl}/v2/shalat/kabkota", [
                'provinsi' => $provinsi,
            ]);
            if ($resKab->successful()) {
                $daftarKabKota = $resKab->json()['data'] ?? [];
            }

            // Jika kabkota tidak ada di daftar, pakai kabkota pertama
            if (!empty($daftarKabKota) && !in_array($kabkota, $daftarKabKota)) {
                $kabkota = $daftarKabKota[0];
            }

            // 3. Ambil jadwal sholat bulanan (POST)
            if (!empty($provinsi) && !empty($kabkota)) {
                $resJadwal = Http::timeout(12)->post("{$this->baseUrl}/v2/shalat", [
                    'provinsi' => $provinsi,
                    'kabkota' => $kabkota,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ]);

                if ($resJadwal->successful()) {
                    $jadwalData = $resJadwal->json()['data'] ?? null;
                } else {
                    $error = 'Jadwal sholat untuk lokasi tersebut belum tersedia pada server eQuran.';
                }
            }
        } catch (\Exception $e) {
            Log::error('QuranController shalat error: ' . $e->getMessage());
            $error = 'Terjadi gangguan saat mengambil data jadwal sholat. Silakan periksa koneksi internet.';
        }

        return view('quran.shalat', [
            'daftarProvinsi' => $daftarProvinsi,
            'daftarKabKota' => $daftarKabKota,
            'provinsiTerpilih' => $provinsi,
            'kabkotaTerpilih' => $kabkota,
            'bulanTerpilih' => $bulan,
            'tahunTerpilih' => $tahun,
            'jadwalData' => $jadwalData,
            'error' => $error,
        ]);
    }

    /**
     * Endpoint API JSON untuk mengambil daftar kabupaten/kota via AJAX saat provinsi diubah.
     */
    public function getKabKota(Request $request)
    {
        $provinsi = $request->input('provinsi');
        if (!$provinsi) {
            return response()->json(['code' => 400, 'message' => 'Parameter provinsi wajib diisi', 'data' => []], 400);
        }

        try {
            $response = Http::timeout(10)->post("{$this->baseUrl}/v2/shalat/kabkota", [
                'provinsi' => $provinsi,
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Gagal menghubungi API eQuran: ' . $e->getMessage(), 'data' => []], 500);
        }
    }

    /**
     * Endpoint API JSON untuk mengambil jadwal sholat via AJAX.
     */
    public function getJadwal(Request $request)
    {
        $provinsi = $request->input('provinsi');
        $kabkota = $request->input('kabkota');
        $bulan = (int)$request->input('bulan', date('n'));
        $tahun = (int)$request->input('tahun', date('Y'));

        try {
            $response = Http::timeout(10)->post("{$this->baseUrl}/v2/shalat", [
                'provinsi' => $provinsi,
                'kabkota' => $kabkota,
                'bulan' => $bulan,
                'tahun' => $tahun,
            ]);

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Gagal mengambil jadwal sholat: ' . $e->getMessage()], 500);
        }
    }
}
