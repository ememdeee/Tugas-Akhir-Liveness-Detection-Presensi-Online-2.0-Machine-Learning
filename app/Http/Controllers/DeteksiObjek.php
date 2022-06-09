<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeteksiObjek extends Controller
{
    public function index(){
        return view('deteksiObjek.index');
    }
}
