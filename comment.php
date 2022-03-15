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
    $username = $_POST['from'];
    header("Location: ./user.php?username=$username#post$post_id");
    exit();
  }
?>