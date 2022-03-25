<?php
  require("connect_db.php");
  session_start();
  $post_id = $_POST['post_id'];
  $username = $_SESSION['username'];
  $sql = "INSERT INTO post_likes (post_id, username) VALUES ('$post_id', '$username')";
  $conn->exec($sql);
  if($_POST['from'] == 'home'){
    header("Location: ./#post$post_id");
    exit();
  }
  else if($_POST['from'] == 'profile'){
    header("Location: ./profile.php#post$post_id");
    exit();
  }
  else if($_POST['from'] == 'liked'){
    header("Location: ./liked_posts.php");
    exit();
  }
  else{
    $username = $_POST['from'];
    header("Location: ./user.php?username=$username#post$post_id");
    exit();
  }
?>