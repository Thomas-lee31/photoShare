<?php
  require("connect_db.php");
  session_start();
  $username = $_GET['username'];
  $session_username = $_SESSION['username'];
  $sql = "INSERT INTO followers (username, follower) VALUES ('$username', '$session_username')";
  $conn->exec($sql);
  header("Location: ./user.php?username=$username");
  exit();
?>