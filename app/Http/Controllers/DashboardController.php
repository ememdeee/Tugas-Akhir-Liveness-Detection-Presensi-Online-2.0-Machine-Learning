<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Presensi;
use Debugbar;

class DashboardController extends Controller
{
    public function index()
    {
        $hasil=User::all();
        // $presensi=Presensi::whereDate('created_at',Carbon::today());
        return view('dashboard.index',['users' => $hasil, 'date' => Carbon::today()]);
    }

    public function pilihTanggal(Request $request)
    {
        $hasil=User::all();
        // $presensi=Presensi::whereDate('created_at',Carbon::today());
        
        $date = Carbon::createFromFormat('Y-m-d',$request->tanggal)->startOfDay();
        return view('dashboard.index',['users' => $hasil, 'date' => $date]);
        // dd($request->tanggal);
        Debugbar::info($request-> tanggal);
        // return view('dashboard.index',['users' => $hasil, 'date' => Carbon::today()]);
    }
}
