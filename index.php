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

    <title>Home</title>
  </head>

<body class="bg-light">
  <?php require('nav.php'); ?>
  <div class="container">
    <div class="row">
    <div class="col-8">
    <?php
      try {
        $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
        //echo "Connected to database";
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
      $username = $_SESSION['username'];

      $sql = "SELECT 
                followers.username,
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
                followers 
                INNER JOIN posts ON followers.username = posts.username
                INNER JOIN users ON users.username = posts.username
              WHERE STRCMP(followers.follower, ?) = 0";
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
        $sql1 = "SELECT * FROM post_likes WHERE post_id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(1, $post_id);
        $stmt1->execute();
        $likes_cnt = 0;
        $liked = 0;
        while($row1 = $stmt1->fetch()){
          $likes_cnt++;
          if($row1['username'] == $_SESSION['username']){
            $liked = 1;
          }
        }
        echo '<div class="border mx-auto mt-5 bg-white" id="post'.$post_id.'">
              <a href="./user.php?username='.$post_user.'" class="text-decoration-none text-body">
                <div class="px-3 py-2 d-flex align-items-center">
                  <img src="'.$profile_picture.'" style="width: 30px" class="rounded-3 border me-2">
                  <p class="fw-bold m-0">'.$post_user.'</p>
                </div>
              </a>
              <div id="post_'.$post_id.'" class="carousel slide mx-auto" width="60%" data-bs-ride="carousel">
                <div class="carousel-indicators">';
        if($photo_1 != "" && $photo_1 != NULL)
          echo '  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-labl="Slide 1"></button>';
        if($photo_2 != "" && $photo_2 != NULL)
          echo '  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>';
        if($photo_3 != "" && $photo_3 != NULL)
          echo '  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>';
        if($photo_4 != "" && $photo_4 != NULL)
          echo '  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>';
        if($photo_5 != "" && $photo_5 != NULL)
          echo '  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>';
        echo '  </div>
                <div class="carousel-inner">';
        if($photo_1 != "" && $photo_1 != NULL)
          echo '  <div class="carousel-item active">
                    <img src="./post_pictures/'.$photo_1.'" class="d-block w-100" alt="...">
                  </div>';
        if($photo_2 != "" && $photo_2 != NULL)
          echo '  <div class="carousel-item">
                    <img src="./post_pictures/'.$photo_2.'" class="d-block w-100" alt="...">
                  </div>';
        if($photo_3 != "" && $photo_3 != NULL)
          echo '  <div class="carousel-item">
                    <img src="./post_pictures/'.$photo_3.'" class="d-block w-100" alt="...">
                  </div>';
        if($photo_4 != "" && $photo_4 != NULL)
          echo '  <div class="carousel-item">
                    <img src="./post_pictures/'.$photo_4.'" class="d-block w-100" alt="...">
                  </div>';
        if($photo_5 != "" && $photo_5 != NULL)
          echo '  <div class="carousel-item">
                    <img src="./post_pictures/'.$photo_5.'" class="d-block w-100" alt="...">
                  </div>';
        echo '  </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              <div class="bg-white px-3 pt-3 pb-1 d-flex justify-content-start align-items-center">';
        if(!$liked){
          echo '<form method="post" action="./like.php">
                  <input type="hidden" name="post_id" value="'.$post_id.'">
                  <input type="submit" class="bg-white rounded-pill" name="like" value="Like">
                </form>';
        }
        else{
          echo '  <form method="post" action="./unlike.php">
                    <input type="hidden" name="post_id" value="'.$post_id.'">
                    <input type="submit" class="bg-white rounded-pill" value="Unlike">
                  </form>';
        }
        echo '  <span class="ms-2">'
                  .$likes_cnt.' people liked this post
                </span>
              </div>
              <div class="bg-white px-3 pb-2">
                <p class="my-1">'.$message.'</p>
                <span style="font-size: 10px">'.$post_date.'<span>
              </div>
              </div>';
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