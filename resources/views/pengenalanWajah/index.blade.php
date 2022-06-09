<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script defer src="js/face-api.min.js"></script>
  <script defer src="js/scriptPengenalanWajah.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
  <title>Face Recognition</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      width: 100vw;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column
    }

    canvas {
      position: absolute;
      top: 0;
      left: 0;
    }
  </style>
</head>
<body>
  <input type="file" id="imageUpload">

  <video id="video" width="720" height="560" autoplay muted></video>
  
  <div id="camera" style="height:auto;width:auto; text-align:left;"></div>

  <!--FOR THE SNAPSHOT-->
  <input type="button" value="Take a Snap" id="btPic" onclick="takeSnapShot()" /> 
  <p id="snapShot"></p>
</body>
</html>