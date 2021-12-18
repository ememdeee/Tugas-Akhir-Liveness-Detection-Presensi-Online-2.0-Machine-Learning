<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" /> 
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

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
          @yield('container')
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </main>

  </body>
</html>