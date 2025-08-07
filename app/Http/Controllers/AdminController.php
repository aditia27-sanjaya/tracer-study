<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Admin;
use App\Models\Authe;
use App\Models\Alumni;
use App\Models\User;

class AdminController extends Controller
{
    // SITE KEY: 6LegsZUkAAAAAD0t4nLwL-PRu2gxXgIMEFoQJA2y
    // SCREET KEY: 6LegsZUkAAAAAFzweC-e0d87fSgwIaHicJ6q5HQK
    public function __construct() {
        // $this->Admin = new Admin;
        $this->Authe    = new Authe;
        $this->Admin    = new Admin;
    }

    public function index()
    {
        // Semua data alumni
        $data = Alumni::latest()->take(5)->get();

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

        return view('backend/admin/home', [
            'data' => $data,
            'jumlahAlumni' => $jumlahAlumni,
            'bekerja' => $totalBekerja,
            'kuliah' => $totalKuliah,
            'lainnya' => $totalLainnya,
            'chartData' => $chartData,
            'angkatan' => $angkatan,
        ]);
    }

    // Aksi Jadwal
    public function jadwal()
    {
        $data['jadwal'] = $this->Admin->jadwal();
        return view('backend/admin/jadwal', $data);
    }
    public function addJadwal(Request $request)
    {
        $request->validate([
            'tgl_buka'  => 'required|date',
            'tgl_tutup' => 'required|date',
            'periode'   => 'required|int',
            'status'    => 'required|in:0,1',
        ]);
        DB::table('jadwal')->where('status', '1')->update(['status' => '0']);
        DB::table('jadwal')->insert([
            'tgl_buka'  => $request->tgl_buka,
            'tgl_tutup' => $request->tgl_tutup,
            'periode'   => $request->periode,
            'status'    => $request->status,
        ]);
        return redirect()->back()->with('success', 'Jadwal telah ditambah..');
    }
    public function editJadwal(Request $request)
    {
        $request->validate([
            'tgl_buka'  => 'required|date',
            'tgl_tutup' => 'required|date',
            'periode'   => 'required|int',
            'status'    => 'required|in:0,1',
        ]);

        $id = $request->id;
        if ($request->status == '1') {
            DB::table('jadwal')->where('status', '1')->update(['status' => '0']);
        }

        DB::table('jadwal')->where('id', $id)->update([
            'tgl_buka'  => $request->tgl_buka,
            'tgl_tutup' => $request->tgl_tutup,
            'periode'   => $request->periode,
            'status'    => $request->status,
        ]);

        return redirect()->back()->with('warning', 'Jadwal berhasil diperbarui.');
    }
    public function deleteJadwal(Request $request)
    {
        $id = $request->id;
        DB::table('jadwal')->where('id', $id)->delete();
        return redirect()->back()->with('danger', 'Jadwal berhasil dihapus.');
    }

    // Aksi Kuisioner
    public function kuisioner()
    {
        $data['pertanyaan'] = $this->Admin->pertanyaan();
        $pilihan = [];
        foreach ($this->Admin->pilihanGanda() as $key => $p){
            $pilihan[$p->pertanyaan_id][$key] = [
                'id_pg'  => $p->id_pg,
                'label'  => $p->label,
                'ket'    => $p->ket
            ];
        }
        $data['pilihan'] = $pilihan;
        return view('backend/admin/kuisioner', $data);
    }
    public function addKuisioner(Request $request)
    {
        try {
            DB::table('pertanyaan')->insert([
                'pertanyaan' => $request->pertanyaan,
            ]);
            return redirect('pimpinan/kuisioner')->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            return redirect('pimpinan/kuisioner')->with('error', 'Data gagal disimpan!');
        }
    }
    public function editKuisioner(Request $request)
    {
        try {
            DB::table('pertanyaan')->where('id_pertanyaan', $request->id_pertanyaan)->update([
                'pertanyaan' => $request->pertanyaan
            ]);
            return redirect('pimpinan/kuisioner')->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            return redirect('pimpinan/kuisioner')->with('error', 'Data gagal disimpan!');
        }
    }
    public function deleteKuisioner(Request $request)
    {
        try {
            // Cek pilihan ganda
            $jumlah = DB::table('pilihan_ganda')
                        ->where('pertanyaan_id', $request->id_pertanyaan)
                        ->count();

            if ($jumlah > 0) {
                return redirect('pimpinan/kuisioner')->with('error', 'Hapus Opsi Jawaban terlebih dahulu!');
            }

            DB::table('pertanyaan')->where('id_pertanyaan', $request->id_pertanyaan)->delete();
            return redirect('pimpinan/kuisioner')->with('success', 'Data berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect('pimpinan/kuisioner')->with('error', 'Data gagal dihapus!');
        }
    }
    public function aksiPilihanGanda(Request $request)
    {
        try {
            foreach ($request->label as $key => $p) {
                DB::table('pilihan_ganda')->insert([
                    'pertanyaan_id' => $request->pertanyaan_id,
                    'label'         => $request->label[$key],
                    'ket'           => $request->ket[$key],
                ]);
            }
            return redirect('pimpinan/kuisioner')->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            return redirect('pimpinan/kuisioner')->with('error', 'Data berhasil disimpan!');
        }
    }
    public function editPilihan(Request $request)
    {
        try {
            DB::table('pilihan_ganda')
                ->where('id_pg', $request->id_pg)
                ->update([
                    'label' => strtoupper($request->label),
                    'ket'   => strtoupper($request->ket),
                ]);

            return redirect('pimpinan/kuisioner')->with('success', 'Data berhasil diperbarui!');
        } catch (\Throwable $th) {
            return redirect('pimpinan/kuisioner')->with('error', 'Data gagal diperbarui!');
        }
    }
    public function deletePilihan($id)
    {
        try {
            DB::table('pilihan_ganda')->where('id_pg', $id)->delete();
            return redirect('pimpinan/kuisioner')->with('success', 'Data berhasil di hapus!');
        } catch (\Trhowable $th) {
            return redirect('pimpinan/kuisioner')->with('error', 'Data gagal di hapus!');
        }
    }

    // Aksi Data Admin
    public function AkunAdmin()
    {
        $data['hak_akses_id'] = '2';
        $data['pengguna'] = 'Administrator';
        $data['data'] = $this->Admin->akun($data['hak_akses_id']);
        return view('backend/admin/user',$data);
    }
    public function addAdmin(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'password2' => 'required|same:password',
            'status'    => 'required|in:0,1',
        ]);
        DB::table('users')->insert([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'is_login'      => $request->status,
            'hak_akses_id'  => 2,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
        return redirect()->back()->with('success', 'User Admin berhasil ditambahkan.');
    }
    public function updateAdmin(Request $request)
    {
        $request->validate([
            'id'       => 'required|exists:users,id',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'status'   => 'required|in:0,1',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        $user = User::findOrFail($request->id);
        $user->name     = $request->name;
        $user->is_login = $request->status;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->back()->with('warning', 'Data Admin berhasil diperbarui.');
    }
    public function deleteAdmin(Request $request)
    {
        $id = $request->id;
        DB::table('users')->where('id', $id)->delete();
        return redirect()->back()->with('danger', 'User Admin berhasil dihapus.');
    }

    // Aksi Data Alumni
    public function AkunAlumni()
    {
        $alumni = Alumni::all();
        $pertanyaan = DB::table('pertanyaan')->get();
        $pilihan = DB::table('pilihan_ganda')->get()
            ->groupBy('pertanyaan_id');

        $jawaban = DB::table('jawaban AS j')
            ->leftJoin('pertanyaan AS p', 'j.pertanyaan_id', '=', 'p.id_pertanyaan')
            ->leftJoin('pilihan_ganda AS pg', 'j.pilihan_ganda_id', '=', 'pg.id_pg')
            ->select('j.*', 'p.pertanyaan', 'pg.label', 'pg.ket')
            ->get()
            ->groupBy('alumni_id');

        return view('backend/admin/alumni', compact('alumni', 'jawaban', 'pertanyaan', 'pilihan'));
    }

    // Aksi Ganti Password
    public function passForm()
    {
        return view('backend/admin/password');
    }
    public function passUpdate(Request $request)
    {
        $akun = $this->Authe->loginAct(session('email'));
        $pass = Hash::check($request->password, $akun->password);
        if ($pass == 1) {
            if($request->password_new!=$request->password_new2){
                return redirect()->back()->with('error', 'Ketik ulang password tidak sama!');
            }
            DB::table('users')->where('id', session('id'))->update([
                'password'  => Hash::make($request->password_new),
            ]);
            return redirect()->back()->with('success', 'Password berhasil dirubah..');
        }else{
            return redirect()->back()->with('error', 'Password gagal dirubah, password lama anda salah!');
        }

    }

}
