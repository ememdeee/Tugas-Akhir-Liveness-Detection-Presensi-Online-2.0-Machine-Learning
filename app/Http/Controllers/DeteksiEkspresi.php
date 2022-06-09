<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeteksiEkspresi extends Controller
{
    public function index(){
        return view('deteksiEkspresi.index');
    }
}
