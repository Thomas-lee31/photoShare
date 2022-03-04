<?php

var_dump($_FILES);

// echo $_FILES['myUpload']['name'];

session_start();

$username = $_SESSION['username'];

try {
  $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
  //echo "Connected to database";
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 

catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$_SESSION['profile_picture'] = NULL;

$sql = "UPDATE users
        SET profile_picture = NULL
        WHERE username='$username'";

$conn->exec($sql);

header("Location: ./profile.php");
exit();
?>
