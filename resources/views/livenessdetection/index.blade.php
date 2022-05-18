<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script defer src="face-api.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" /> 
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
    
    <!-- face recognition, ekspresi detection, object detectetion needs -->
    <script defer src="js/face-api.min.js"></script>
    <script defer src="js/script.js"></script>
    <link rel="stylesheet" href="css/style_liveness.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
    <!-- ml5 object detection -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.1.9/p5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.1.9/addons/p5.sound.min.js"></script>
    <script src="https://unpkg.com/ml5@0.5.0/dist/ml5.min.js"></script>
    <!-- face recognition, ekspresi detection, object detectetion needs -->
    <title>Hello, world!</title>
    @laravelPWA
  </head>
  <body>
  <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <main>
      <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
      <div class="container">
          <a class="navbar-brand" href="/">Absensi Online</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
              <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/">Home</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="/absen">Absen</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="/dashboard">Dashboard</a>
              </li>
              <li class="nav-item">
              <a class="nav-link disabled">Disabled</a>
              </li>
          </ul>

          <ul class="navbar-nav ms-auto">
          @auth         
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Hi, {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="/absen">Absen</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
              <form action="/logout" method="post">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
              </form>
              </li>
            </ul>
          </li>
              </li>
          @else 
          
              <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
              </li>
          @endauth
          </ul>
          </div>
      </div>
      </nav>

      <div class="container mt-4">

        <!-- ----------------------------------------------------------------------------- -->


        <!-- LIVENESS Detection -->
        <script>
          var point=0;
        </script>

        <!-- yapa carae loading screen ini hilang ketika semua fitur udah ke load -->
        <!-- <div class="loader-wrapper"> -->
          <!-- Loading square for squar.red network -->
          <!-- <span class="loader"><span class="loader-inner"></span></span> -->
        <!-- </div> -->


        <input type="file" id="imageUpload">

        
        <video id="video" width="720" height="560" autoplay muted></video>
        
        <H1>Lakukan Ekspresi</H1>
        <H2 id="demo"></H2>
        <h3 id="point"></h3>
        
        <div id="camera" style="height:auto;width:auto; text-align:left;"></div>
        
        <script src="js/sketch.js"></script>
        
        <!--FOR THE SNAPSHOT-->
        <input type="button" value="Take a Snap" id="btPic" onclick="takeSnapShot()" /> 
        <p id="snapShot"></p>

        <!-- nama -->
        <h1 id="nama1">nama</H2>

        
  <!-- END -->


  <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
            <!-- <div class="col-md-5 p-lg-5 mx-auto my-5">
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
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div> -->
            <h1>Halo world, {{ auth()->user()->name }}!</h1>

            <form action="/livenessdetection" method="post" id="form">
              @csrf
              <h4 id="test">nama akun yang kedetek di liveness detection</h4>
              <input type="text" name="nama" id="nama">
              <br>
              <h4>nama akun sebenarnya:</h3>
              <input type="" name="namaReal" id="namaReal" value="{{auth()->user()->name}}">
              <br>
              <button class='bg-white text-yellow-50 p-3 rounded-md mx-auto'>Liveness Detection Berhasil</button>
              <h5>Jarak</h5>
              <input type="" name="jarak" value="{{$jarak ?? 'jarak akan tertera disini setelah menekan tombol absen'}}" id="jarak">
            </form>
            <br>
            <h5>apakah nama yang kedetek di liveness detection sama dengan nama akun anda?</h5>
            <input type="" name="zaza" value="{{$nama ?? 'tekan untuk melihat nama yang kedetek'}}" id="zaza">
            

          </div>

        <!-- <h1>Ini akan jadi halaman perkenalan tentang web ini</h1>
        <h3>orang pertama kali datang kalau belum login akan ke sini</h3> -->

        yang perlu dilakukan adalah <br>
        1. masukan liveness detection ke sini yang berhasil sampe step akhir. <br>
        2. nama user yang ke detek di step akhir liveness detection yaitu Face recognition dimasukan ke dalam input type id:nama dan button ter execute. (selanjutnya udah normal insyaallah!)<br> 
        yang jika dibandingkan sama dengan nama Real / nama akun yang login, maka proses liveness detection baru sepenuhnya berhasil dan dikirim ke halaman absensi untuk disimpan datanya <br>
        3. UI/UX dari liveness Detectionnya dibenerkan TERAKHIR aja. <br>

        <br><br><h3>done</h3>
        <br>
        controller yang diabsensi ada yang perlu dipindah ke controller liveness detection, karek mindah haruse. bismillah.
        <br>

        <br>

        Di absensi juga <br>
        1. Setelah dicek jarak apabila memenuhi, akan dilempar ke halaman liveness detection metode get sepertinya dengan DATA BELUM DISIMPAN TERLEBIH DAHULUS. <br>
        2.setelah berhasil liveness detection e baru disimpan data absensinya. (ini yang berat, gimana carae cek data yang dipegang disimpan semeptara sek dan blom di fix kan sampek selesai liveness.)
      </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</main>

</body>
</html>