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

    <title><?php $_GET['username']; ?></title>
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
    $profile_picture = "";
    $first_name = "";
    $last_name = "";
    while($row = $stmt->fetch()){
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $profile_picture = $row['profile_picture'];
    }
    if($profile_picture == NULL){
      $profile_picture = "./profile_pictures/blank-profile-picture.png";
    }
    else{
      $profile_picture = "./profile_pictures/$profile_picture";
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
        <img src="<?php echo $profile_picture; ?>" alt="" style="width: 60%" class="rounded-3 border border-3">
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
      while($row = $stmt->fetch()){
        $post_user = $row['username'];
        $message = $row['message'];
        $post_id = $row['post_id'];
        $photo_1 = $row['photo_1'];
        $photo_2 = $row['photo_2'];
        $photo_3 = $row['photo_3'];
        $photo_4 = $row['photo_4'];
        $photo_5 = $row['photo_5'];
        $post_date = $row['post_date'];
        require("select_post_likes.php");
        $from = "user";
        
        require("select_post_comments.php");

        require("post.php");
      }
    ?>
  </div>
  <?php require('footer.php'); ?>
  
</body>
</html>