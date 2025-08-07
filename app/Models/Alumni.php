<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Alumni extends Model
{
    use HasFactory;
    protected $table = 'alumni';
    protected $guarded = [];

    public function loginPost($id)
    {
        return DB::table('alumni')
        ->orderBy('id', 'DESC')
        ->where('hak_akses_id', $id)
        ->get();
    }

    public function Profil()
    {
        return DB::table('alumni AS a')
                ->where('id', session('id'))
                ->first();
    }
}
