<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengenalanWajah extends Controller
{
    public function index(){
        return view('pengenalanWajah.index');
    }
}
