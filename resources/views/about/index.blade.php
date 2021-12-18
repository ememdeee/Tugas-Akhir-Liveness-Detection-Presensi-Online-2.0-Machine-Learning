@extends('layouts.main')

@section('container')


<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
    @if(Auth::check())
    <h1 class="display-4 fw-normal">Halo, {{auth()->user()->name}}</h1>
    @else
    <h1 class="display-4 fw-normal">Halo!</h1>
    @endif
      <p class="lead fw-normal">welcome to the attendance aplication of Girisa Teknologi, make sure your location is less then 20m from your office.</p>

      @if (Auth::check())
      <a class="btn btn-outline-secondary" href="/absen">Absen</a>
      @else
      <a class="btn btn-outline-secondary" href="/login">Absen</a>
      @endif
      
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
  </div>

<!-- <h1>Ini akan jadi halaman perkenalan tentang web ini</h1>
<h3>orang pertama kali datang kalau belum login akan ke sini</h3> -->

@endsection