<?php
  try {
    $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
    //echo "Connected to database";
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  session_start();
  $post_id = $_POST['post_id'];
  $username = $_SESSION['username'];
  $sql = "DELETE FROM post_likes WHERE STRCMP(username, '$username') = 0 AND post_id = $post_id";
  $conn->exec($sql);
  header("Location: ./#post$post_id");
  exit();
?>