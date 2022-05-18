<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Debugbar;
use App\Presensi;
use App\Config;
use Carbon\Carbon;

class Livenessdetection extends Controller
{
    public function index(Request $request){
        // hebatnya ini bakal terdeklarasi hanya jika kita tidak membawa variabel jarak dari sebelumnya
        // jarak tidak lagi perlu dideklarasikan disini jika, akses ke facedetection hanya bisa melalui halaman abensi.
        $jarak="asd";
        return view('livenessdetection.index',['jarak' => $jarak]);
    }

    public function cekdatadiri(Request $request){
        // $nama adalah nama yang terdeteksi di face recognition, dan dibandingkan dengan nama akun ($namaReal). jika sama baru dikembalikan ke absensi dengan flash berhasil.
        $nama=$request['nama'];
        $namaReal=$request['namaReal'];
        $jarak=$request['jarak'];

        if ($nama===$namaReal){

            // dari sini aslie dari controller absen
            
            $presensi = Presensi::whereDate('waktu_datang',Carbon::today())->where('user_id',Auth::id())->first();

            Debugbar::info($presensi);

            // cek apakah belom absen
            if($presensi === null){
                //jika belom absen berarti dia baru datang, dan dibikinbaru
                $userId = Auth::id();


                $presensi = Presensi::create([
                    'user_id' => $userId,
                    'waktu_datang' => null,
                ]);
                $request->session()->flash('absenMasuk','Your attendance already submited');
            }

            // cek apakah kedatangan nya kosong, jika iya di isi.
            if ($presensi->waktu_datang === null){
                $presensi->waktu_datang= Carbon::now();
                $presensi->save();

                return view("absen.index",['jarak' => $jarak]);
            }
            else if($presensi->waktu_istirahat === null){

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
            
            // sampe sini aslie dari controller absen
            
            $request->session()->flash('livenessDetectionBerhasil','liveness detection Berhasil');
            return view("absen.index",['jarak' => $jarak]);
        }
        $request->session()->flash('livenessDetectionGagal','Nama wajah yang terdaftar tidak sama dengan nama akun!');
        return view("absen.index");
        
        // return view("livenessdetection.index", ['nama'=>"gagal"]);
    }
}
