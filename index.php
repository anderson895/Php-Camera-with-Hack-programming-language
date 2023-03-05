<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Camera Capture</title>
  </head>
  <body>

  <button id="camera-toggle">Open Camera</button>

<script>
    // start code for open and close camera
  var cameraPreview = document.getElementById('camera-preview');
  var captureButton = document.getElementById('capture-button');
  var saveButton = document.getElementById('save-button');
  var statusContainer = document.getElementById('status-container');
  var imageContainer = document.getElementById('image-container');
  var capturedImage = document.getElementById('captured-image');
  var cameraToggle = document.getElementById('camera-toggle');

  var constraints = { video: { facingMode: "user" } };

  var stream = null;

  cameraToggle.onclick = function() {
    if (cameraToggle.innerText === 'Open Camera') {
      // Request access to the camera
      navigator.mediaDevices.getUserMedia(constraints)
        .then(function(s) {
          stream = s;
          // Attach the camera stream to the preview element
          cameraPreview.srcObject = stream;
          captureButton.disabled = false;
          cameraToggle.innerText = 'Close Camera';
        })
        .catch(function(error) {
          console.error('Could not access camera: ' + error.message);
        });
    } else {
      if (stream) {
        stream.getTracks().forEach(function(track) {
          track.stop();
        });
        cameraPreview.srcObject = null;
        captureButton.disabled = true;
        cameraToggle.innerText = 'Open Camera';
      }
    }
  };

  var hideCameraButton = document.getElementById('hide-camera');

  hideCameraButton.onclick = function() {
    cameraPreview.style.display = 'none';
  };
// end code for open and close camera
</script>


    <div id="camera-container">
      <video id="camera-preview" autoplay></video>
      <button id="capture-button" disabled>Capture Image</button>
    </div>
    <div id="save-container" style="display: none;">
      <button id="save-button">Save Image</button>
    </div>
    <div id="status-container"></div>
    <div id="image-container" style="display: none;">
      <img id="captured-image">
    </div>
    <script>
      var cameraPreview = document.getElementById('camera-preview');
      var captureButton = document.getElementById('capture-button');
      var saveButton = document.getElementById('save-button');
      var statusContainer = document.getElementById('status-container');
      var imageContainer = document.getElementById('image-container');
      var capturedImage = document.getElementById('captured-image');

      // Use constraints to ask for front camera on mobile devices
      var constraints = { video: { facingMode: "user" } };

      // Request access to the camera
      navigator.mediaDevices.getUserMedia(constraints)
        .then(function(stream) {
          // Attach the camera stream to the preview element
          cameraPreview.srcObject = stream;
          captureButton.disabled = false;
        })
        .catch(function(error) {
          console.error('Could not access camera: ' + error.message);
        });

      // Capture the image when the capture button is clicked
      captureButton.onclick = function() {
        // Create a canvas element to draw the captured image
        var canvas = document.createElement('canvas');
        canvas.width = cameraPreview.videoWidth;
        canvas.height = cameraPreview.videoHeight;
        var context = canvas.getContext('2d');
        context.drawImage(cameraPreview, 0, 0, canvas.width, canvas.height);

        // Get the image data from the canvas as a base64-encoded PNG
        var dataUrl = canvas.toDataURL('image/png');

        // Display the captured image
        capturedImage.src = dataUrl;
        imageContainer.style.display = 'block';

        // Save the image data in a global variable to be used later
        window.savedImage = dataUrl;

        // Hide the camera preview and show the save button
        document.getElementById('camera-container').style.display = 'none';
        document.getElementById('save-container').style.display = 'block';
      };

      // Save the image when the save button is clicked
      saveButton.onclick = function() {
        // Send the image data to the server to be saved
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'save.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            statusContainer.innerHTML = 'Image saved successfully as ' + xhr.responseText;

            alert('Save Images Successfully .');window.location='index.php';
          }
        };
        xhr.send('image=' + encodeURIComponent(window.savedImage));
      };
    </script>

 
  </body>
</html>
