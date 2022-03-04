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

<body class="bg-light">
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
      
      $username = $_SESSION['username'];
      $sql = "SELECT * FROM posts
              WHERE STRCMP(username, ?) = 0
              ORDER BY post_date DESC";
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
  <?php
    $profile_picture = $_SESSION['profile_picture'];
    if($profile_picture == NULL){
      $profile_picture = "./profile_pictures/blank-profile-picture.png";
    }
    else{
      $profile_picture = "./profile_pictures/$profile_picture";
    } 
    ?>
  <div class="container">
    <div class="row border-bottom my-3" style="height: 300px">

      <div class="col-3 d-flex align-items-center justify-content-center">
        <img src="<?php echo $profile_picture; ?>" role="button" style="width: 60%" class="rounded-3 border border-3" data-bs-toggle="modal" data-bs-target="#upload_profile_picture">
        
        <!-- Modal -->
        <div class="modal fade" id="upload_profile_picture" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Profile picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" action="./upload_profile_picture.php" enctype="multipart/form-data">
                  <div class="mb-3">
                    <input class="form-control" type="file" name="profile">
                  </div>
                  <div class="d-grid mb-3">
                    <a href="remove_profile_picture.php" class="btn btn-outline-danger" role="button">Remove profile picture</a>
                  </div>
                  <div class="text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Upload">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-5 d-flex align-items-center">
        <div class="container">
          <div>
            <h2><?php echo $_SESSION['username']; ?></h2>
          </div>
          <div class="row mb-2">
            <div class="col">
              <?php echo $postcnt.' posts'; ?>
            </div>
            <div class="col">
              <span data-bs-toggle="modal" data-bs-target="#followers" role="button"><?php echo $followers.' followers'; ?><span>
              <!-- Vertically centered modal -->
              <div class="modal fade" id="followers" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Followers</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <?php
                      try {
                          $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
                          //echo "Connected to database";
                          // set the PDO error mode to exception
                          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch(PDOException $e) {
                          echo "Connection failed: " . $e->getMessage();
                        }
                        $sql = "SELECT followers.username, followers.follower, users.username, users.first_name, users.last_name, users.profile_picture 
                                FROM followers LEFT JOIN users ON followers.follower = users.username
                                WHERE followers.username LIKE ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1, $username);
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                          //var_dump($row);
                          $follower = $row['follower'];
                          $first_name = $row['first_name'];
                          $last_name = $row['last_name'];
                          $follower_picture = $row['profile_picture'];
                          if($follower_picture == NULL || $follower_picture == ""){
                            $follower_picture = "./profile_pictures/blank-profile-picture.png";
                          }
                          else{
                            $follower_picture = "./profile_pictures/$follower_picture";
                          }
                          echo '<a href="user.php?username='.$follower.'" class="text-decoration-none">
                                  <div class="mt-3 border-top border-bottom py-2">
                                    <div class="row justify-content-start">
                                      <div class="col-2 d-flex align-items-center justify-content-center">
                                        <img src="'.$follower_picture.'" alt="" style="width: 40px" class="rounded-3 border border-3">
                                      </div>
                                      <div class="col-10 d-flex align-items-center p-0">
                                        <div class="d-flex align-items-center">
                                          <div class="me-5">
                                            <p class="text-body m-0">'.$follower.'</p>
                                            <p class="text-secondary me-5 mb-0">'.$first_name.' '.$last_name.'</p>
                                          </div>
                                          <div class="ms-5">
                                            <form method="get" action="remove_follower.php" class="ms-5">
                                              <input type="hidden" name="username" value="'.$follower.'">
                                              <input class="btn btn-outline-secondary btn-sm ms-5" type="submit" value="Remove">
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </a>';
                        }
                    ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col">
            <span data-bs-toggle="modal" data-bs-target="#following" role="button"><?php echo $following.' following'; ?><span>
              <!-- Vertically centered modal -->
              <div class="modal fade" id="following" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Following</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <?php
                      try {
                          $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
                          //echo "Connected to database";
                          // set the PDO error mode to exception
                          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        } catch(PDOException $e) {
                          echo "Connection failed: " . $e->getMessage();
                        }
                        $sql = "SELECT followers.username, followers.follower, users.username AS name, users.first_name, users.last_name, users.profile_picture 
                        FROM followers LEFT JOIN users ON followers.username = users.username 
                        WHERE followers.follower LIKE ?;
                        ";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(1, $username);
                        $stmt->execute();
                        while ($row = $stmt->fetch()) {
                          $user = $row['username'];
                          $first_name = $row['first_name'];
                          $last_name = $row['last_name'];
                          $picture = $row['profile_picture'];
                          if($picture == NULL || $picture == ""){
                            $picture = "./profile_pictures/blank-profile-picture.png";
                          }
                          else{
                            $picture = "./profile_pictures/$picture";
                          }
                          echo '<a href="user.php?username='.$user.'" class="text-decoration-none">
                                  <div class="mt-3 border-top border-bottom py-2">
                                    <div class="row justify-content-start">
                                      <div class="col-2 d-flex align-items-center justify-content-center">
                                        <img src="'.$picture.'" alt="" style="width: 40px" class="rounded-3 border border-3">
                                      </div>
                                      <div class="col-10 d-flex align-items-center p-0">
                                        <div class="d-flex align-items-center">
                                          <div class="me-5">
                                            <p class="text-body m-0">'.$user.'</p>
                                            <p class="text-secondary me-5 mb-0">'.$first_name.' '.$last_name.'</p>
                                          </div>
                                          <div class="ms-5">
                                            <form method="get" action="unfollow.php" class="ms-5">
                                              <input type="hidden" name="username" value="'.$follower.'">
                                              <input type="hidden" value="profile" name="from">
                                              <input class="btn btn-outline-primary btn-sm ms-5" type="submit" value="Unfollow">
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </a>';
                        }
                    ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div>
            <h6><?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?></h6>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <?php
      $sql = "SELECT * FROM posts WHERE STRCMP(username, ?) = 0";
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
        $post_user = $row['username'];
        $post_date = $row['post_date'];
        echo '<div class="border mx-auto mt-5 bg-white">
              <div class="px-3 py-2 d-flex align-items-center">
                <img src="'.$profile_picture.'" style="width: 30px" class="rounded-3 border me-2">
                <p class="fw-bold m-0">'.$post_user.'</p>
              </div>
              <div id="post_'.$post_no.'" class="carousel slide" width="60%" data-bs-ride="carousel">
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