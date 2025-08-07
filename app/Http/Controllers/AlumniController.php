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
use Carbon\Carbon;

use App\Models\Admin;
use App\Models\Authe;
use App\Models\Alumni;
use App\Models\User;

class AlumniController extends Controller
{
    // SITE KEY: 6LegsZUkAAAAAD0t4nLwL-PRu2gxXgIMEFoQJA2y
    // SCREET KEY: 6LegsZUkAAAAAFzweC-e0d87fSgwIaHicJ6q5HQK
    public function __construct() {
        // $this->Admin = new Admin;
        $this->Authe  = new Authe;
        $this->Alumni = new Alumni;
        $this->Admin  = new Admin;
    }

    public function index()
    {
        $alumni = $this->Alumni->Profil(); // Ambil data alumni yang login
        $data = [];

        $allJadwal = $this->Admin->jadwal();
        $jadwalAktif = collect($allJadwal)->where('status', '1')->first();

        $data['jadwal'] = $jadwalAktif;
        $data['ada_jadwal'] = !is_null($jadwalAktif);

        // Cek apakah alumni sudah mengisi kuisioner pada periode aktif
        $sudah_mengisi = false;
        if ($jadwalAktif) {
            $sudah_mengisi = DB::table('jawaban')
                ->where('alumni_id', $alumni->id)
                ->where('jadwal_id', $jadwalAktif->periode)
                ->exists();
        }

        $data['sudah_mengisi'] = $sudah_mengisi;

        return view('backend/alumni/home', compact('data','alumni'));
    }

    // Aksi Login
    public function loginPost(Request $request)
    {
        // $captcha = $request->post('g-recaptcha-response');
        // $res = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdgDOYiAAAAAFUAU83qKlVvkuLXlI8oii8kFbMb&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        // $data = json_decode($res);
        // if($data->success != 1){
        //     return redirect('/auth')->with('error','Captcha tidak valid!');
        // }

        $akun = DB::table('alumni')
                ->where('email', $request->email)
                ->first();

        if (!empty($akun)) {
            $cek = Hash::check($request->password, $akun->password);
            if ($cek == '1' && $akun->status == 'AKTIF') {
                Session::flush();
                Session::put('id', $akun->id);
                Session::put('no_register', $akun->no_register);
                Session::put('hak_akses_id', $akun->hak_akses_id);
                Session::put('email', $akun->email);
                Session::put('akses', 'alumni');
                Session::put('nama', $akun->nama_alumni);
                Session::put('hak_akses', 'Alumni');

                if($akun->hak_akses_id==3){ //Alumni
                    return redirect('alumni/dashboard')->with('success','Anda lerhasil login!');
                }
            } else {
                return redirect('/auth')
                    ->with('error', 'Password anda salah / akun anda belum terdaftar');
            }
        } else {
            return redirect('/auth')
                ->with('error', 'Username tidak dikenali !');
        }
    }

    // Aksi Registrasi
    public function regist()
    {
        return view('register');
    }
    public function registPost(Request $request)
    {
        $request->validate([
            'nama_alumni' => 'required|string|max:255',
            'email'       => 'required|email|unique:alumni,email',
            'password'    => 'required|min:6|confirmed',
        ]);
        $noRegister = strtoupper(uniqid());
        DB::table('alumni')->insert([
            'no_register'   => $noRegister,
            'hak_akses_id'  => 3,
            'nama_alumni'   => $request->nama_alumni,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'status'        => 'AKTIF',
            'created_at'    => now(),
            'updated_at'    => now()
        ]);
        return redirect('/auth')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Aksi Profil
    public function profil()
    {
        $data['data'] = $this->Alumni->Profil();
        return view('backend/alumni/profil', $data);
    }
    public function profilUpdate(Request $request)
    {
        try {
            if(!empty($request->foto)){
                $fileName = 'profil_'.time().'.'.$request->foto->extension();
                $request->foto->move(public_path('assets/backend/images/alumni/'), $fileName);
                File::delete(public_path('assets/backend/images/alumni/'.$request->foto2));
            }else{
                $fileName = $request->foto2;
            }
            if(!empty($request->password)){
                $pass = Hash::make($request->password);
            }else{
                $pass = $request->password2;
            }
                DB::table('alumni')->where('id', $request->id)->update([
                'email'       => $request->email,
                'nama_alumni' => $request->nama_alumni,
                'kelas'       => $request->kelas,
                'angkatan'    => $request->angkatan,
                'nisn'        => $request->nisn,
                'alamat'      => $request->alamat,
                'no_hp'       => $request->no_hp,
                'jenis_kl'    => $request->jenis_kl,
                'tgl_lahir'   => $request->tgl_lahir,
                'foto'        => $fileName,
                'password'    => $pass,
                'facebook'    => $request->facebook,
                'instagram'   => $request->instagram,
                'linkedin'    => $request->linkedin,
                // 'email'         => $request->email,
            ]);

            return redirect('/alumni/dashboard')->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            return redirect('/alumni/profil')->with('error', 'Data gagal disimpan!');
        }
    }

    // Aksi Kuisioner
    public function kuisioner()
    {
        $alumni = $this->Alumni->Profil();
        $jadwal = DB::table('jadwal')->where('status', 1)->first();

        // Cek apakah alumni sudah mengisi kuisioner di periode ini
        $sudah_mengisi = DB::table('jawaban')
            ->where('alumni_id', $alumni->id)
            ->where('jadwal_id', $jadwal->periode) // periode = tahun
            ->exists();

        $data['alumni']     = $alumni;
        $data['jadwal']     = $jadwal;
        $data['sudah_mengisi'] = $sudah_mengisi;

        $data['pertanyaan'] = $this->Admin->pertanyaan();
        $pilihan = [];
        foreach ($this->Admin->pilihanGanda() as $key => $p) {
            $pilihan[$p->pertanyaan_id][$key] = [
                'id_pg' => $p->id_pg,
                'label' => $p->label,
                'ket'   => $p->ket
            ];
        }
        $data['pilihan'] = $pilihan;

        return view('backend/alumni/kuisioner', $data);
    }
    public function jawaban(Request $request)
    {
        $alumni_id = $request->input('alumni_id');
        $jadwal_id = $request->input('jadwal_id');

        // Ambil nilai periode dari tabel jadwal
        $periode = DB::table('jadwal')->where('id', $jadwal_id)->value('periode');
        $waktu   = Carbon::now();

        // Simpan jawaban pilihan ganda
        if ($request->has('pilihan_ganda_id')) {
            foreach ($request->pilihan_ganda_id as $pertanyaan_id => $pilihan_id) {
                DB::table('jawaban')->insert([
                    'alumni_id'         => $alumni_id,
                    'pertanyaan_id'     => $pertanyaan_id,
                    'pilihan_ganda_id'  => $pilihan_id,
                    'jawaban'           => null,
                    'jadwal_id'         => $periode, // <-- simpan tahun (periode)
                    'created_at'        => $waktu,
                    'updated_at'        => $waktu
                ]);
            }
        }

        // Simpan jawaban isian teks
        if ($request->has('jawaban_text')) {
            foreach ($request->jawaban_text as $pertanyaan_id => $jawaban) {
                DB::table('jawaban')->insert([
                    'alumni_id'         => $alumni_id,
                    'pertanyaan_id'     => $pertanyaan_id,
                    'pilihan_ganda_id'  => null,
                    'jawaban'           => $jawaban,
                    'jadwal_id'         => $periode, // <-- simpan tahun (periode)
                    'created_at'        => $waktu,
                    'updated_at'        => $waktu
                ]);
            }
        }

        return redirect()->back()->with('success', 'Jawaban berhasil disimpan.');
    }


}
