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

    <title><?php session_start(); echo $_SESSION['first_name'].' '.$_SESSION['last_name'].' (@'.$_SESSION['username'].')'; ?></title>
  </head>

<body style="background-color: rgb(248, 248, 248)">
  <?php require('nav.php'); ?>
  <?php
    try {
      $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
      //echo "Connected to database";
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    if(!isset($_GET['username'])){
      header("Location: ./user_not_found.php");
      exit();
    }
    if($_GET['username'] == $_SESSION['username']){
      header("Location: ./profile.php");
      exit();
    }
    $username = $_GET['username'];
    $sql = "SELECT * FROM users
            WHERE STRCMP(username, ?) = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $username);
    $stmt->execute();
    while($row = $stmt->fetch()){
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $profile_picture = $row['profile_picture'];
    }

    $sql = "SELECT * FROM posts WHERE STRCMP(username, ?) = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $username);
    $stmt->execute();
    $postcnt = 0;
    while($row = $stmt->fetch()){
      $postcnt++;
    }

    $followed = 0;
    $followers = 0;
    $following = 0;
    $stmt = $conn->query("SELECT * FROM followers");
    while ($row = $stmt->fetch()) {
        $user = $row['username'];
        $follower = $row['follower'];
        if($user == $username && $follower == $_SESSION['username']){
          $followed = 1;
        }
        if($user == $username){
          $followers++;
        }
        if($follower == $username){
          $following++;
        }
    }
  ?>
  <div class="container">
    <div class="row border-bottom my-3" style="height: 300px">
      <div class="col-3 d-flex align-items-center justify-content-center">
        <img src="./profile_pictures/<?php if($profile_picture == ""){echo "blank-profile-picture.png";} else{echo $profile_picture;} ?>" alt="" style="width: 60%" class="rounded-3 border border-3">
      </div>
      <div class="col-5 d-flex align-items-center">
        <div class="container">
          <div class="d-flex justify-content-start align-items-center">
            
              <?php
                echo '<h2>'.$username.'</h2>';
                if($followed == 0){
                  echo '<form method="get" action="./follow.php">
                          <input type="hidden" value="'.$username.'" name="username">
                          <input class="btn btn-primary btn-sm mx-3" type="submit" value="Follow" name="follow">
                        </form>';
                }
                else{
                  echo '<form method="get" action="./unfollow.php">
                          <input type="hidden" value="'.$username.'" name="username">
                          <input type="hidden" value="user" name="from">
                          <input class="btn btn-outline-primary btn-sm mx-3" type="submit" value="Unfollow" name="unfollow">
                        </form>';
                }
              ?>
          </div>
          <div class="row my-2">
            <div class="col">
              <h6><?php echo $postcnt.' posts'; ?></h6>
            </div>
            <div class="col">
              <h6><?php echo $followers.' followers'; ?></h6>
            </div>
            <div class="col">
              <h6><?php echo $following.' following'; ?></h6>
            </div>
          </div>
          <div>
            <h6><?php echo $first_name." ".$last_name; ?></h6>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <?php
      $sql = "SELECT * FROM posts
      WHERE STRCMP(username, ?) = 0
      ORDER BY post_date DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(1, $username);
      $stmt->execute();
      $post_no = 0;
      while($row = $stmt->fetch()){
        $post_no++;
        $message = $row['message'];
        $photo_1 = $row['photo_1'];
        $photo_2 = $row['photo_2'];
        $photo_3 = $row['photo_3'];
        $photo_4 = $row['photo_4'];
        $photo_5 = $row['photo_5'];
        echo '<div class="border mx-auto mt-5 bg-white">
              <a href="./user.php?username='.$username.'" class="text-decoration-none text-body">
                <div class="px-3 py-2 d-flex align-items-center">
                  <img src="'.$profile_picture.'" style="width: 30px" class="rounded-3 border me-2">
                  <p class="fw-bold m-0">'.$username.'</p>
                </div>
              </a>
              <div id="post_'.$post_no.'" class="carousel slide mx-auto mt-5" width="60%" data-bs-ride="carousel">
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