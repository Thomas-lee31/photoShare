<?php
  require("connect_db.php");
  session_start();
  $post_id = $_POST['post_id'];
  $username = $_SESSION['username'];
  $comment = $_POST['comment'];
  $sql = "INSERT INTO post_comments (comment, post_id, username) VALUES ('$comment', '$post_id', '$username')";
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
    $pu = $_POST['post_user'];
    header("Location: ./user.php?username=$pu#post$post_id");
    exit();
  }
?>