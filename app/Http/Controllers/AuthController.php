<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\Authe;
// use App\Models\Admin;

class AuthController extends Controller
{
    public function __construct() {
        $this->Authe = new Authe;
    }

    public function index()
    {
        return view('logadmin');
    }

    public function loginAct(Request $request)
    {
        // $captcha = $request->post('g-recaptcha-response');
        // $res = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdgDOYiAAAAAFUAU83qKlVvkuLXlI8oii8kFbMb&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        // $data = json_decode($res);
        // if($data->success != 1){
        //     return redirect('/auth')->with('error','Captcha tidak valid!');
        // }

        $akun = $this->Authe->loginAct($request->email);

        if($akun) {
            $pass = Hash::check($request->password, $akun->password);
            if ($pass == 1) {

                session::put('id', $akun->id);
                session::put('hak_akses_id', $akun->hak_akses_id);
                session::put('hak_akses', $akun->hak_akses);
                session::put('nama', $akun->name);
                session::put('email', $akun->email);
                session::put('foto', $akun->foto);

                if($akun->hak_akses_id==1){ //Super Admin
                    return redirect('pimpinan/dashboard')->with('success','Anda lerhasil login!');
                }elseif($akun->hak_akses_id==2){
                    return redirect('user/dashboard')->with('success','Anda lerhasil login!');
                }else{
                    return redirect('/logadmin')->with('error','Hak akses dibatasi!');
                }
            }else{
                  return redirect('/logadmin')->with('error','Email atau password anda salah!');
            }
        }else{
            return redirect('/logadmin')->with('error','Akun anda tidak ditemui!');
        }
    }

    public function Logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

}
