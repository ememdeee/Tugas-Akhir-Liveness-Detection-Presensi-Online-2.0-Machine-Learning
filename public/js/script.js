const video = document.getElementById('video')
const imageUpload = document.getElementById('imageUpload')

let labeledFaceDescriptors = null
let faceMatcher = null

let container, image, canvas = null;

Promise.all([
  faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
  faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
  faceapi.nets.ssdMobilenetv1.loadFromUri('/models'),
  faceapi.nets.faceExpressionNet.loadFromUri('/models')
]).then(start)

function startVideo() {
  navigator.getUserMedia(
    { video: {} },
    stream => video.srcObject = stream,
    err => console.error(err)
  )
  point=0;
  console.log('oi')
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

//perlu flag biar generate random angka buat ekspresi tidak terkena pengulangan pada deteksi ekspresi yang terus menerus.
let flag = 0;
let happyFlag=0;
let surprisedFlag=0;
let angryFlag=0;
let disgustedFlag=0;
// let point=0;
console.log("deklarasi flag & point 0");

//ekspresi
video.addEventListener('play', () => {
  const canvas = faceapi.createCanvasFromMedia(video)
  document.body.append(canvas)
  const displaySize = { width: video.width, height: video.height }
  faceapi.matchDimensions(canvas, displaySize)
  setInterval(async () => {
    const detections = await faceapi.detectAllFaces(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceExpressions()
    
    //dirandom disini dan if dibawah e, trus dalam iff e ya yang dibawah ini, cek ekspresie dan klo iya console dulu aja gapap, klo berhasil ganti ke score
    
    //buat perintah ekspresi/ buat elemen baru
    const pBaru = document.createElement('h3');
    
    //flag agar dijalan kan random 1 kali dan setelah ditetapkan ekspresi apa yang digunakan dan membuka flag lainya untuk dilakukan pengecekan eksprresi user apakah benar.
    if (flag==0){
      flag=1;
      //generate random number (1-4)
      let rand= Math.floor(Math.random() * 4) + 1; 
      let ekspresi="a";
      if (rand == 1){
        ekspresi= "senang";
        happyFlag=1;
      }
      if (rand == 2){
        ekspresi= "surprised";
        surprisedFlag=1;
      }
      if (rand == 3){
        ekspresi= "angry";
        angryFlag=1;
      }
      if (rand == 4){
        ekspresi= "disgusted";
        disgustedFlag=1;
    }
    console.log("atas");
    document.getElementById("demo").innerHTML = ekspresi;
    document.getElementById("point").innerHTML = point;
    console.log("bawah");
    // const teksPBaru = document.createTextNode(ekspresi);
    // pBaru.appendChild(teksPBaru);
    // const sectionA= document.getElementById('a');
    // sectionA.appendChild(pBaru);
  }
  //buat perintah ekspresi/ buat elemen baru sampe sini
    

    // console.log(detections[0].expressions.surprised)
    // if (detections[0].expressions.surprised > 0.8) {
    //   console.log('allah')
    // }

    if (happyFlag==1){
      if (detections[0].expressions.happy > 0.8) {
        console.log('allah, masuk ke happy')
        happyFlag=0;
        flag=0;
        point++;
      }
    }
    if (surprisedFlag==1){
      if (detections[0].expressions.surprised > 0.8) {
        console.log('allah, masuk ke surprised')
        surprisedFlag=0;
        flag=0;
        point++;
      }
    }
    if (angryFlag==1){
      if (detections[0].expressions.angry > 0.8) {
        console.log('allah, masuk ke angry')
        angryFlag=0;
        flag=0;
        point++;
      }
    }
    if (disgustedFlag==1){
      if (detections[0].expressions.disgusted > 0.5) {
        console.log('allah, masuk ke disgusted')
        disgustedFlag=0;
        flag=0;
        point++;
      }
    }
    if (point==5){
      takeSnapShot();
      point=0;
      document.getElementById("point").innerHTML = point;
      
    }
    const resizedDetections = faceapi.resizeResults(detections, displaySize)
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height)
    faceapi.draw.drawDetections(canvas, resizedDetections)
    faceapi.draw.drawFaceLandmarks(canvas, resizedDetections)
    faceapi.draw.drawFaceExpressions(canvas, resizedDetections)
  }, 100)
  console.log('loh')
})
//sampe sini



function loadLabeledImages() {
  const labels = ['Black Widow', 'Captain America', 'Captain Marvel', 'Hawkeye', 'Jim Rhodes', 'Thor', 'Tony Stark','Muhammad']
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
        a= result.toString();
        // mendapatkan nama
        b=a.substring (0, a.length-7)
        document.getElementById("nama1").innerHTML = b;
        // ngisi input form
        window.onload=document.getElementById("nama");
        var element_jam = document.getElementById("nama");
        element_jam.value = b;
        console.log("print nama");
    })
}
// SHOW THE SNAPSHOT sampe sini.


// Daftarin Wajah.
takeSnapShot2 = function () {
  Webcam.snap(function (data_uri) {
      document.getElementById('snapShot').innerHTML = 
          '<img src="' + data_uri + '" width="70px" height="50px" />';
      imageBuffer = data_uri;
      console.log(data_uri);
  });
}