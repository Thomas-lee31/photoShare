<!DOCTYPE html>
<html lang="en">

  <head>
    <?php session_start(); ?>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./node_modules/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    
    <!-- Bootstrap JS -->
    <script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>

    <title>Liked posts</title>
  </head>

<body class="bg-light">
  <?php require('nav.php'); ?>
  <div class="container">
    <div class="row">
    <div class="col-8">
    <?php
      require("connect_db.php");
      $username = $_SESSION['username'];

      $sql = "SELECT 
                posts.post_id,
                posts.photo_1,
                posts.photo_2,
                posts.photo_3,
                posts.photo_4,
                posts.photo_5,
                posts.message,
                posts.post_date,
                users.profile_picture,
                users.username
              FROM 
                posts 
                INNER JOIN post_likes ON post_likes.post_id = posts.post_id
                INNER JOIN users ON posts.username = users.username
              WHERE STRCMP(post_likes.username, ?) = 0
              ORDER BY post_date DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(1, $username);
      $stmt->execute();
      while($row = $stmt->fetch()){
        $post_user = $row['username'];
        $post_id = $row['post_id'];
        $message = $row['message'];
        $photo_1 = $row['photo_1'];
        $photo_2 = $row['photo_2'];
        $photo_3 = $row['photo_3'];
        $photo_4 = $row['photo_4'];
        $photo_5 = $row['photo_5'];
        $post_date = $row['post_date'];
        $profile_picture = $row['profile_picture'];
        if($profile_picture == NULL || $profile_picture == ""){
          $profile_picture = "./profile_pictures/blank-profile-picture.png";
        }
        else{
          $profile_picture = "./profile_pictures/$profile_picture";
        }

        require("select_post_likes.php");
        $from = "liked";

        require("select_post_comments.php");
        
        $_SESSION['previous'] = "liked_posts.php";

        require("post.php");
      }
    ?>
    </div>
    <div class="col-4">
    </div>
    </div>
  </div>
  <?php require('footer.php'); ?>
</body>
</html>