<!DOCTYPE html>
<html lang="en">

  <head>
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
      $username = $_SESSION['username'];
      $following_list = array();
      
      $stmt = $conn->query("SELECT * FROM followers WHERE STRCMP(follower, '$username') = 0");
      while ($row = $stmt->fetch()) {
        $user = $row['username'];
        $following_list[] = $user;
      }
      $sql = "SELECT * FROM posts LEFT JOIN users on posts.username = users.username ORDER by post_date DESC";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $post_no = 0;
      while($row = $stmt->fetch()){
        $post_user = $row['username'];
        if(!in_array($post_user, $following_list)) continue;
        $post_no++;
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
        echo '<div class="border mx-auto mt-5 bg-white">
              <a href="./user.php?username='.$post_user.'" class="text-decoration-none text-body">
                <div class="px-3 py-2 d-flex align-items-center">
                  <img src="'.$profile_picture.'" style="width: 30px" class="rounded-3 border me-2">
                  <p class="fw-bold m-0">'.$post_user.'</p>
                </div>
              </a>
              <div id="post_'.$post_no.'" class="carousel slide mx-auto" width="60%" data-bs-ride="carousel">
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
                <button class="carousel-control-prev" type="button" data-bs-target="#post_'.$post_no.'" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#post_'.$post_no.'" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              <div class="bg-white px-3 py-2">
                <p class="my-1">'.$message.'</p>
                <span style="font-size: 10px">'.$post_date.'<span>
              </div>
              </div>';
      }
    ?>
  </div>
  <?php require('footer.php'); ?>
</body>
</html>