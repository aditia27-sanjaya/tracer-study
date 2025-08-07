<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    public function akun($id)
    {
        return DB::table('users')
        ->orderBy('id', 'DESC')
        ->where('hak_akses_id', $id)
        ->get();
    }
    public function jadwal()
    {
        return DB::table('jadwal')
        ->orderBy('id', 'DESC')
        ->get();
    }
    public function pertanyaan()
    {
        return DB::table('pertanyaan')
        ->orderBy('id_pertanyaan', 'ASC')
        ->get();
    }
    public function pilihanGanda()
    {
        return DB::table('pilihan_ganda As a')
        ->join('pertanyaan AS b', 'a.pertanyaan_id', '=', 'b.id_pertanyaan')
        ->select('a.*')
        ->orderBy('a.label', 'ASC')
        ->get();
    }

}
