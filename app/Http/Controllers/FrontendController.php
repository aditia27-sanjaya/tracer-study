<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Frontend;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Alumni;

class FrontendController extends Controller
{
    public function __construct() {
        $this->Admin    = new Admin;
    }

    public function index(Request $request)
    {
        $request->session()->flush();
        $allJadwal = $this->Admin->jadwal();
        $data['jadwal'] = collect($allJadwal)->where('status', '1');

        // Jumlah total alumni
        $jumlahAlumni = Alumni::count();
        // Ambil semua angkatan unik
        $angkatanList = Alumni::select('angkatan')->distinct()->orderBy('angkatan')->pluck('angkatan');

        $chartData = [];
        $totalBekerja = 0;
        $totalKuliah = 0;
        $totalLainnya = 0;

        foreach ($angkatanList as $angkatan) {
            // Ambil alumni berdasarkan angkatan ini
            $alumniIDs = Alumni::where('angkatan', $angkatan)->pluck('id');

            // Hitung jumlah yang bekerja
            $bekerja = DB::table('jawaban')
                ->join('pilihan_ganda', 'jawaban.pilihan_ganda_id', '=', 'pilihan_ganda.id_pg')
                ->whereIn('jawaban.alumni_id', $alumniIDs)
                ->where('pilihan_ganda.ket', 'BEKERJA')
                ->distinct('jawaban.alumni_id')
                ->count('jawaban.alumni_id');

            // Hitung jumlah yang kuliah
            $kuliah = DB::table('jawaban')
                ->join('pilihan_ganda', 'jawaban.pilihan_ganda_id', '=', 'pilihan_ganda.id_pg')
                ->whereIn('jawaban.alumni_id', $alumniIDs)
                ->where('pilihan_ganda.ket', 'KULIAH')
                ->distinct('jawaban.alumni_id')
                ->count('jawaban.alumni_id');

            // Hitung lainnya
            $lainnya = Alumni::where('angkatan', $angkatan)->count() - ($bekerja + $kuliah);

            // Masukkan ke grafik
            $chartData[] = [$angkatan, $bekerja, $kuliah, $lainnya];

            // Akumulasi untuk kartu
            $totalBekerja += $bekerja;
            $totalKuliah += $kuliah;
            $totalLainnya += $lainnya;
        }

        // Untuk Pie Chart Angkatan (jumlah alumni per angkatan)
        $angkatan = Alumni::select('angkatan', DB::raw('COUNT(*) as jumlah'))
                    ->groupBy('angkatan')
                    ->orderBy('angkatan')
                    ->get();

        return view('frontend/landing', $data,[
            // 'data' => $data,
            'jumlahAlumni' => $jumlahAlumni,
            'bekerja' => $totalBekerja,
            'kuliah' => $totalKuliah,
            'lainnya' => $totalLainnya,
            'chartData' => $chartData,
            'angkatan' => $angkatan,
        ]);
    }
    public function login()
    {
        return view('login');
    }
}
