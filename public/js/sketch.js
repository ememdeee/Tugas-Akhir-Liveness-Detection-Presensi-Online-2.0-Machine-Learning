// ml5.js: Object Detection with COCO-SSD (Webcam)
// The Coding Train / Daniel Shiffman
// https://thecodingtrain.com/learning/ml5/1.3-object-detection.html
// https://youtu.be/QEzRxnuaZCk

// p5.js Web Editor - Image: https://editor.p5js.org/codingtrain/sketches/ZNQQx2n5o
// p5.js Web Editor - Webcam: https://editor.p5js.org/codingtrain/sketches/VIYRpcME3
// p5.js Web Editor - Webcam Persistence: https://editor.p5js.org/codingtrain/sketches/Vt9xeTxWJ

// let img;
let videoml5;
let detector;
let detections = [];

function preload() {
  // img = loadImage('dog_cat.jpg');
  detector = ml5.objectDetector('cocossd');
}

function gotDetections(error, results) {
  if (error) {
    console.error(error);
  }
  detections = results;
  // console.log(results);
  // console.log(results[0]); INI CONSOLE LOG HASIL DETEKSI LIKE [PERSON OR CELL PHONE]
  if (results[0]?.label === 'cell phone'){
    point=0;
    document.getElementById("point").innerHTML = point;
    console.log("allah");
  }
  detector.detect(videoml5, gotDetections);
}

function setup() {
  createCanvas(640, 480);
  videoml5 = createCapture(videoml5);
  videoml5.size(640, 480);
  videoml5.hide();
  detector.detect(videoml5, gotDetections);
}


function draw() {
  image && image(videoml5, 0, 0);

  for (let i = 0; i < detections.length; i++) {
    let object = detections[i];
    stroke(0, 255, 0);
    strokeWeight(4);
    noFill();
    rect(object.x, object.y, object.width, object.height);
    noStroke();
    fill(255);
    textSize(24);
    text(object.label, object.x + 10, object.y + 24);
  }
}
