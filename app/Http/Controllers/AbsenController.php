<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Debugbar;
use App\Presensi;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function index (Request $request)
    {
        return view('absen.index');
    }

    public function submitabsen (Request $request)
    {
        Debugbar::info($request['lat']);
        Debugbar::info($request['lon']);

        //cek apakah sudah absen
        // if(Presensi::where("user_id", Auth::id())->whereDate('waktu_datang',Carbon::today())->exists()){
        //     // dd("gol");
        //     $request->session()->flash('sudahAbsen','You already submited your attendence');
        //     return view("absen.index");
        // };
            
        
        $lokasiUser = collect([
            'lat' => $request['lat'],
            'lon' => $request['lon'],
        ]);

        $jarak = $this->hitungJarak($lokasiUser);

        //mengecek jarak antar user
        if ($jarak > 20) {
            Debugbar::info('jauh');
            $request->session()->flash('lokasiJauh','Your location is too far from Girisa Teknologi!  ');
            $request->session()->flash('jarak',$jarak);
            return view("absen.index",['jarak' => $jarak]);
        }

        $presensi = Presensi::whereDate('waktu_datang',Carbon::today())->where('user_id',Auth::id())->first();

        Debugbar::info($presensi);

        // cek apakah belom absen
        if($presensi === null){
            //jika belom absen berarti dia baru datang
            $userId = Auth::id();


            $presensi = Presensi::create([
                'user_id' => $userId,
                'waktu_datang' => null,
            ]);
            $request->session()->flash('absenMasuk','Your attendance already submited');
        }

        // cek apakah belom istirahat
        if ($presensi->waktu_datang === null){
            $presensi->waktu_datang= Carbon::now();
            $presensi->save();

            return view("absen.index");
        }
        else if($presensi->waktu_istirahat === null){
            //jika belom absen berarti dia baru datang

            //update baris yang sudah ada bukan nambah baru
            $presensi->waktu_istirahat = Carbon::now();
            $presensi->save();

            $request->session()->flash('absenMasuk','Happy Istirahat');
            return view("absen.index",['jarak' => $jarak]);
        }

        // cek apakah belom selesai istirahat
        else if($presensi->waktu_setelah_istirahat === null){
            //jika belom absen berarti dia baru datang
 
            $presensi->waktu_setelah_istirahat = Carbon::now();
            $presensi->save();

            $request->session()->flash('absenMasuk','Happy work!');
            return view("absen.index",['jarak' => $jarak]);
        }

        // cek apakah belom pulang
        else if(!Presensi::where("user_id", Auth::id())->whereDate('waktu_pulang',Carbon::today())->exists()){
            //jika belom absen berarti dia baru datang

            $presensi->waktu_pulang = Carbon::now();
            $presensi->save();

            $request->session()->flash('absenMasuk','ati ati dijalan!');
            return view("absen.index",['jarak' => $jarak]);
        }

        //jika sudah, abaikan
        //jika belum, simpan data

        $request->session()->flash('absenMasuk','Sudah absen woy');

        return view('absen.index',['jarak' => $jarak]);
    }

    private function hitungJarak($lokasiUser){
        $lokasiKantor = collect([
            'lat' => -7.9359853260984465, 
            'lon' => 112.62616865529099,
            // yang diatas punya girisa
            // 'lat' => -7.9526481,
            // 'lon' => 112.6079343,
        ]);
        $radiusBumi = 6371000; //meter

        $dLat = deg2rad($lokasiKantor['lat'] - $lokasiUser['lat']);
        $dLon = deg2rad($lokasiKantor['lon'] - $lokasiUser['lon']);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lokasiUser['lat']))*cos(deg2rad($lokasiKantor['lat']))*sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $jarak = $radiusBumi*$c;
        Debugbar::info($jarak);
        return $jarak;
    }
}
