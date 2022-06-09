const video = document.getElementById('video')

Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
  faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
  faceapi.nets.faceExpressionNet.loadFromUri('/models')
]).then(startVideo)

function startVideo() {
  navigator.getUserMedia(
    { video: {} },
    stream => video.srcObject = stream,
    err => console.error(err)
    )
    console.log('oi')
}

video.addEventListener('play', () => {
  const canvas = faceapi.createCanvasFromMedia(video)
  document.body.append(canvas)
  const displaySize = { width: video.width, height: video.height }
  faceapi.matchDimensions(canvas, displaySize)
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
    // console.log(detections[0].expressions.surprised)
    if (detections[0].expressions.surprised > 0.8) {
      console.log('allah');
      document.getElementById("result").innerHTML = "Surprised";
    }
    if (detections[0].expressions.happy > 0.8) {
      console.log('allah');
      document.getElementById("result").innerHTML = "Happy";
    }
    if (detections[0].expressions.angry > 0.8) {
      console.log('allah');
      document.getElementById("result").innerHTML = "Angry";
    }
    if (detections[0].expressions.disgusted > 0.8) {
      console.log('allah');
      document.getElementById("result").innerHTML = "disgusted";
    }
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    faceapi.draw.drawDetections(canvas, resizedDetections)
    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
  }, 100)
  console.log('loh')
})