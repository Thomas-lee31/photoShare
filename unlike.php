<?php
  require('connect_db.php');
  session_start();
  $post_id = $_POST['post_id'];
  $username = $_SESSION['username'];
  $sql = "DELETE FROM post_likes WHERE STRCMP(username, '$username') = 0 AND post_id = $post_id";
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
    $post_user = $_POST['post_user'];
    header("Location: ./user.php?username=$post_user#post$post_id");
    exit();
  }
?>