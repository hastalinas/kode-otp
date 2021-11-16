<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(){
        return "Selamat anda berhasil menggunakan controller";
    }

    public function ulang(){
        $i = 0;
        while ($i < 5){
            echo $i + 1 . "<br>";
            $i++;
        }
    }
}