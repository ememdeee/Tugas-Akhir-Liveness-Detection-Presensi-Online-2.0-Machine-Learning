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

    <!-- face recognition, ekspresi detection, object detectetion needs -->
    <link rel="stylesheet" href="css/style_liveness.css">
    <title>Hello, world!</title>
    @laravelPWA
  </head>
  <body>
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

        
        <video id="video" class="embed-responsive embed-responsive-4by3" autoplay muted></video>
        
        <H1 class="text-center">Lakukan Ekspresi</H1>
        
        <div class="container px-4">
          <div class="row gx-5">
            <div class="col text-center">
              <p id="countdown">Wait...</p>
              <h3 id="point">5</h3>
              <H2 class="border p-2" id="belum">Benar/Salah</H2>
            </div>
            <div class="col">
              <image class="exprextionDemo border" src="\exprestionImage\angry.png"></image>
              <H2 class="text-center" id="demo">ekspresi</H2>
            </div>
          </div>
        </div>
        <div id="camera" style="height:auto;width:auto; text-align:left;"></div>
        
        <script src="js/sketch.js"></script>
        
        <!--FOR THE SNAPSHOT-->
        <input type="button" value="Take a Snap" id="btPic" onclick="takeSnapShot()" /> 
        <p id="snapShot"></p>

        <!-- nama -->
        <h1 id="nama1">nama</H2>

        
  <!-- END -->

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