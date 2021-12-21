<?php

namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Presensi;
use App\Config;
use Debugbar;
use Illuminate\Support\Facades\DB;

class Dashboard2Controller extends Controller
{
    public function index()
    {
        $hasil=User::where('name',"admin")->first();
        // $presensi=Presensi::whereDate('created_at',Carbon::today());

        // $from = '2019-01-01';
        // $to = '2020-04-01';
        $from = Carbon::now()->startOfMonth();
        $to = Carbon::now();
        $period = CarbonPeriod::create($from, '1 day', $to);

        return view('dashboard.index2');
    }

    public function pilihUser(Request $request)
    {
        if ($request->has('gantiLok')) {
            $request->session()->forget('tampilkan');
            
            $lokasi = Config::first();
            $lokasi-> lat = $request->lat;
            $lokasi-> lon = $request->lon;
            $lokasi-> save();
            
            $request->session()->flash('gantiLok',"Lokasi kantor berhasil diupdate!");
            return view('dashboard.index2');
        }

        $hasil=User::where('name',$request->userName)->first();
        if($hasil==null)
        {
            return back()->with('nameError', 'Name not registered!');
        }
        // $presensi=Presensi::whereDate('created_at',Carbon::today());
        $from = $request->startTanggal;
        $to = $request->endTanggal;
        $period = CarbonPeriod::create($from, '1 day', $to);

        $request->session()->flash('tampilkan');
        return view('dashboard.index2',['user' => $hasil, 'date' => $period]);
        // dd($request->tanggal);
        // Debugbar::info($request-> tanggal);
        // return view('dashboard.index',['users' => $hasil, 'date' => Carbon::today()]);
    }
}
