const video = document.getElementById('video')
const imageUpload = document.getElementById('imageUpload')

let labeledFaceDescriptors = null
let faceMatcher = null

let container, image, canvas = null;

Promise.all([
  faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
  faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
]).then(start)

function startVideo() {
  navigator.getUserMedia(
    { video: {} },
    stream => video.srcObject = stream,
    err => console.error(err)
  )
}
async function start() {
  container = document.createElement('div')
  container.style.position = 'relative'
  document.body.append(container)
  labeledFaceDescriptors = await loadLabeledImages()
  faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.6)
  document.body.append('Loaded')
  imageUpload.addEventListener('change', async (e) => {
    console.log('on input change')
    if (image) image.remove()
    if (canvas) canvas.remove()
    console.log(imageUpload.files[0]);
    image = await faceapi.bufferToImage(imageUpload.files[0])
    // image = await faceapi.bufferToImage(imageBuffer)
    container.append(image)
    canvas = faceapi.createCanvasFromMedia(image)
    container.append(canvas)
    const displaySize = { width: image.width, height: image.height }
    faceapi.matchDimensions(canvas, displaySize)
    const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
    results.forEach((result, i) => {
      const box = resizedDetections[i].detection.box
      const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
      drawBox.draw(canvas)
    })
  })
  startVideo()
}

function loadLabeledImages() {
  const labels = ['Genta', 'Gus', 'Jerrie', 'Kcw', 'Muhammad', 'Yoga']
  return Promise.all(
    labels.map(async label => {
      const descriptions = []
      for (let i = 1; i <= 2; i++) {
        const img = await faceapi.fetchImage(`https://raw.githubusercontent.com/ememdeee/Face-Recognition-JavaScript/master/labeled_images/${label}/${i}.jpg`)
        const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
        descriptions.push(detections.descriptor)
      }

      return new faceapi.LabeledFaceDescriptors(label, descriptions)
    })
  )
}

// CAMERA SETTINGS.
Webcam.set({
  width: 220,
  height: 190,
  image_format: 'jpeg',
  jpeg_quality: 100
});
Webcam.attach('#camera');

// SHOW THE SNAPSHOT.
takeSnapShot = function () {
    Webcam.snap(function (data_uri) {
        document.getElementById('snapShot').innerHTML = 
            '<img src="' + data_uri + '" width="70px" height="50px" />';
        imageBuffer = data_uri;
        console.log(data_uri)
        recognize2(data_uri);
    });
}

async function base64ToBlob(base64){
    const res = await fetch(base64)
    return await res.blob()
}

async function recognize2(data){
  if (image) image.remove()
  if (canvas) canvas.remove()

  image = await faceapi.bufferToImage(await base64ToBlob(data));
  canvas = faceapi.createCanvasFromMedia(image);
  
  container.append(image);
  container.append(canvas);
  
  const displaySize = {width: image.width, height: image.height};
  faceapi.matchDimensions(canvas, displaySize)
  const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
  const resizedDetections = faceapi.resizeResults(detections, displaySize)
  const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
  results.forEach((result, i) => {
    const box = resizedDetections[i].detection.box
    const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
    drawBox.draw(canvas)
  })
}



// Daftarin Wajah.
takeSnapShot2 = function () {
  Webcam.snap(function (data_uri) {
      document.getElementById('snapShot').innerHTML = 
          '<img src="' + data_uri + '" width="70px" height="50px" />';
      imageBuffer = data_uri;
      console.log(data_uri);
  });
}