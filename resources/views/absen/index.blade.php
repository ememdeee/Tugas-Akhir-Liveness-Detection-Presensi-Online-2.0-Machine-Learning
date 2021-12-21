<?php
    $textButton = '';
    $buttonDisabled = false;
    $presensi = App\Presensi::whereDate('waktu_datang',Carbon\Carbon::today())->where('user_id',Illuminate\Support\Facades\Auth::id())->first();
    if ($presensi === null){
        $textButton = 'ABSEN MASUK';
    } else if ($presensi->waktu_istirahat === null){
        $textButton = 'ABSEN ISTIRAHAT';
    } else if ($presensi->waktu_setelah_istirahat === null){
        $textButton = "ABSEN SETELAH ISTIRAHAT";
    } else if ($presensi->waktu_pulang === null){
        $textButton = 'ABSEN PULANG';
    } else {
        $textButton = 'ABSEN';
        $buttonDisabled = true;
    }
?>
@extends('layouts.main')

@section('container')

    @if (session()->has('sudahAbsen'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session ('sudahAbsen') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session()->has('lokasiJauh'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session ('lokasiJauh') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session()->has('absenMasuk'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session ('absenMasuk') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    <!-- @if (session()->has('jarak'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session ('jarak') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif -->

    <!-- Mapdulu -->

    <div class="wrapper">
        <div id="render_map"> <h4> Map tidak tersedia, pastikan internet anda menyala.</h4></div>
    </div>

    <!-- barutombol -->

    <div class="absen">
        <p class="text-red-500">hello ayo absen</p>
        <form action="/absen" method="post" id="form">
            @csrf
            <button class='bg-white text-yellow-50 p-3 rounded-md mx-auto ' @if($buttonDisabled) disabled @endif>{{ $textButton }}</button>
            <div class="my-2">
                <input type="" name="lat" value="0" id="lat">
                <input type="" name="lon" value="0" id="lon">
                <input type="" name="jarak" value="{{$jarak ?? 'Tekan absen untuk mengetahui jarak'}}" id="jarak">
            </div>
        </form>
    </div>
    

    <script>

        //tambahkan halaman ini ke cache list
        let authPages = [
            '/absen',
            '/dashboard',
        ]

        caches.keys()
            .then(function(cacheNames){
                cacheNames.filter(cacheName => cacheName.startsWith('pwa-'))
                    .map(cacheName => {
                        caches.open(cacheName)
                            .then(cache => {
                                cache.addAll(authPages)
                                console.log('sukses tambah ke cache')
                            })
                            .catch(e => console.error('gagal menambahkan cache'))
                    })
            })

        // caches.open(staticCacheName)
        //     .then(function(cache){
        //         return cache.addAll(['/absen', '/dashboard']);
        //     });

        // dapetin lokasi longitude dan latittudenya.

        const updateForm = function(position){
            
            var lat1 = position.coords.latitude;
            var lon1 = position.coords.longitude;

            var inputLat = document.getElementById('lat');
            var inputLon = document.getElementById('lon');

            inputLat.value = lat1;
            inputLon.value = lon1;

            // buat map
             // Maps Leaflet
            const DEFAULT_COORD =[{{App\Config::first()->lat}},{{App\Config::first()->lon}}]
            const USER_COORD =[lat1,lon1]

            const Map =L.map("render_map")

            // inital osm title url
            const osmTileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"

            const attrib= "halo <a href='https://www.google.com/'> halo <a>"

            const osmTile = new L.TileLayer(osmTileUrl, { minZoom: 1, maxZoom:19, attribution: attrib})

            Map.setView(new L.LatLng(DEFAULT_COORD[0], DEFAULT_COORD[1]), 17)
            Map.addLayer(osmTile)

            //custom icon
            var custom_icon;
            custom_icon= L.icon({
                iconUrl:'home.png',
                iconSize: [20,20],
                iconAnchor: [10,29],
                popupAnchor: [0,-29]
            });
            
            //direction
            L.Routing.control({
                waypoints: [
                    L.latLng(DEFAULT_COORD[0],DEFAULT_COORD[1]),
                    L.latLng(USER_COORD[0],USER_COORD[1])
                    ],draggableWaypoints: false,
                    routeWhileDragging: false
                    }).addTo(Map);

            //marker lama (no line)
            // const MarkerToko = L.marker((DEFAULT_COORD),{icon:custom_icon}).addTo(Map) //icon berhasil
            // const MarkerToko = L.marker(DEFAULT_COORD).addTo(Map)
            // const MarkerUser = L.marker(USER_COORD).addTo(Map)

        }

        function getLocation(){

            if (navigator.geolocation){
                navigator.geolocation.getCurrentPosition(updateForm);
            } else {
                console.log("lokasinya mati")
            }
        }
        getLocation();

        function submit(event){
            if (window.navigator.onLine){
                console.log("status online")
            }
            else{
                event.preventDefault()
                alert('Internet Anda Mati! Nyalakan!')
            }
            
        }

        let form = document.getElementById('form')
        form.addEventListener('submit', submit)
    </script>
@endsection