<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LivenessdetectionUi extends Controller
{
    public function index(Request $request){
        return view('livenessdetection.indexUi');
    }
}
