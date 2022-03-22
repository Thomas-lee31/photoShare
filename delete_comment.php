<?php

session_start();

$username = $_SESSION['username'];

$comment_id = $_POST['comment_id'];

try {
  $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
  //echo "Connected to database";
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 

catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$sql = "DELETE FROM post_comments
        WHERE comment_id='$comment_id'";

$conn->exec($sql);

header("Location: ./");
exit();
?>
