<?php
if (isset($_POST['image'])) {
  // Get the data URL of the image
  $dataUrl = $_POST['image'];

  // Remove the data URL scheme and data from the image data
  $parts = explode(',', $dataUrl);
  $data = $parts[1];

  // Decode the image data from base64
  $decodedData = base64_decode($data);

  // Generate a unique filename for the image
  $filename = uniqid() . '.png';

  // Set the path where the image will be saved
  $filepath = 'img/' . $filename;

  // Save the image to the server
  file_put_contents($filepath, $decodedData);

  echo 'Image saved successfully as ' . $filepath;
}
?>
