<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
    @laravelPWA
</head>
<body>

    <div class="w-screen h-screen flex justify-center items-center flex-col">
        <a href="/login">Login</a>
        <p class="text-red-500">hello ayo absen</p>
        <button class='bg-black text-yellow-50 p-3 rounded-md mx-auto '>ABSEN</button>
    </div>
    

    <script>

        // dapetin lokasi longitude dan latittudenya.
        Number.prototype.toRad = function() {
            return this * Math.PI / 180;
        }

        const hitungJarak = function(position){
        
            var lat2 = -7.9359853260984465; 
            var lon2 = 112.62616865529097;
            var lat1 = position.coords.latitude;
            var lon1 = position.coords.longitude;

            console.log(position)

            var R = 6371; // radius bumi dalam KM
            //has a problem with the .toRad() method below.
            var x1 = lat2-lat1;
            var dLat = x1.toRad();  
            var x2 = lon2-lon1;
            var dLon = x2.toRad();  
            var a = Math.sin(dLat/2) * Math.sin(dLat/2) + 
                            Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * 
                            Math.sin(dLon/2) * Math.sin(dLon/2);  
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            let d = R * c; 
            console.log(lat1)
            console.log(lon1)
            console.log(lat2)
            console.log(lon2)
            console.log(d)
        }


        function getLocation(){

            if (navigator.geolocation){
                navigator.geolocation.getCurrentPosition(hitungJarak);
            } else {
                console.log("gaada")
            }
        }

        function showPosition(position) {
            // var location = {
            //     longitude: position.coords.longitude,
            //     latitude: position.coords.latitude
            // }
        }

        getLocation();
    </script>
</body>
</html>