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

    <title><?php echo $_SESSION['first_name'].' '.$_SESSION['last_name'].' (@'.$_SESSION['username'].')'; ?></title>
  </head>

<body class="bg-light">
  <?php require('nav.php'); ?>
  <?php
    require("connect_db.php");
      
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
                      require("connect_db.php");
                      $sql = "SELECT followers.username, followers.follower, users.username, users.first_name, users.last_name, users.profile_picture 
                              FROM followers LEFT JOIN users ON followers.follower = users.username
                              WHERE followers.username LIKE ?";
                      $stmt = $conn->prepare($sql);
                      $stmt->bindParam(1, $username);
                      $stmt->execute();
                      while ($row = $stmt->fetch()) {
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
                        require("connect_db.php");
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
      while($row = $stmt->fetch()){
        $message = $row['message'];
        $post_id = $row['post_id'];
        $photo_1 = $row['photo_1'];
        $photo_2 = $row['photo_2'];
        $photo_3 = $row['photo_3'];
        $photo_4 = $row['photo_4'];
        $photo_5 = $row['photo_5'];
        $post_user = $row['username'];
        $post_date = $row['post_date'];
        // $sql1 = "SELECT * FROM post_likes WHERE post_id = ?";
        // $stmt1 = $conn->prepare($sql1);
        // $stmt1->bindParam(1, $post_id);
        // $stmt1->execute();
        // $likes_cnt = 0;
        // $liked = 0;
        // while($row1 = $stmt1->fetch()){
        //   $likes_cnt++;
        //   if($row1['username'] == $_SESSION['username']){
        //     $liked = 1;
        //   }
        // }

        require("select_post_likes.php");

        $from = "profile";

        require("select_post_comments.php");

        $_SESSION['previous'] = "profile.php";

        require("post.php");
        
      }
    ?>
  </div>
  <?php require('footer.php'); ?>
  
  
</body>
</html>