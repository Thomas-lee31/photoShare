<?php
  require("connect_db.php");
  session_start();
  $follower = $_GET['username'];
  $session_username = $_SESSION['username'];
  $sql = "DELETE FROM followers WHERE STRCMP(follower, '$follower') = 0 AND STRCMP(username, '$session_username') = 0";
  $conn->exec($sql);
  header("Location: ./profile.php");
  exit();
?>