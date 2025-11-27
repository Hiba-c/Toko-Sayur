<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    //membuat function berandaBackend
    public function berandaBackend()
    {
        return view ('backend.v_beranda.index',[
            'judul'=>'Halaman Beranda',
        ]);
    }
}
