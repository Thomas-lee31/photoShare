<?php
  require("connect_db.php");
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