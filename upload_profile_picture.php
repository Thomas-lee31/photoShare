<?php

var_dump($_FILES);

// echo $_FILES['myUpload']['name'];

session_start();

$destinationFolder = "./profile_pictures/";

$username = $_SESSION['username'];

$file_name = $username.date('ymd_hms').$_FILES['profile']['name'];

$filepath = $destinationFolder.$file_name;

move_uploaded_file($_FILES['profile']['tmp_name'], $filepath);

try {
  $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
  //echo "Connected to database";
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 

catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$_SESSION['profile_picture'] = $file_name;

$sql = "UPDATE users
        SET profile_picture = '$file_name'
        WHERE username='$username'";

$conn->exec($sql);

header("Location: ./profile.php");
exit();
?>
