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
  $username = $_GET['username'];
  $session_username = $_SESSION['username'];
  $sql = "DELETE FROM followers WHERE STRCMP(username, '$username') = 0 AND STRCMP(follower, '$session_username') = 0";
  $conn->exec($sql);
  if($_GET['from'] == "user"){
    header("Location: ./user.php?username=$username");
    exit();
  }
  else{
    header("Location: ./profile.php");
    exit();
  }
?>