<?php
  session_start();
  $message = "";

if (isset($_POST['submit'])){
    
  $fileName = $_FILES['imgToUpload']['tmp_name'];
  $destination = 'uploads/'.basename($_FILES['imgToUpload']['name']);
  $imgFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));
  $flag = 1;

  $check = getimagesize($fileName); //To check if the file being uploaded is image?
  if ($check == true){
    $message = "File is an image - ".$check["mime"].".";
    $flag = 1;
  }
  else{
    $mesage =  "File is not an image.";
    $flag = 0;
  }


  if (file_exists($destination)){ //to check if file already exists..
    $message = "File Already Exists.";
    $flag = 0;
  }
  elseif ($imgFileType != "png" && $imgFileType != "jpg" && $imgFileType != "jpeg" && $imgFileType != "gif"){
    $message =  "Only png, jpg, jpeg and gif files are supported";
    $flag = 0;
  }
  elseif ($flag == 0){
    $message = "File not uploaded..";
  }
  else{
    if (move_uploaded_file($fileName, $destination)){
      $_SESSION[$destination] = 1;
      $message = "Image uploaded successfully..";
    }
    else{
      $message = "Error while uploading image..";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>
<body>
  <div id="wrapper">
    <div id = "header">
      <h1>Image Gallery</h1>
      <p>This page displays the list of uploaded images.</p>
      <form action="" method = "post" enctype="multipart/form-data">
          <input type="file" name="imgToUpload">
          <input type="submit" name="submit" class = "submitBtn" value = "Upload More">
          <span>
            <?php echo $message; ?>
          </span>
      </form>
      <hr>
    </div>
    <div id="content">
      <?php
        foreach($_SESSION as $key => $value){
          echo "<div class = 'galleryDiv'><img src = '".$key."' class = 'image'><br><span>".ucfirst(basename($key))."</span></div>";
        }
      ?>
    </div>
      


    
    
  </div>
</body>
</html>