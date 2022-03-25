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

    <title><?php echo 'Search - '.$_GET['search']; ?></title>
  </head>

<body style="background-color: rgb(248, 248, 248)">
  <?php require('nav.php'); ?>
  <div class="container">
    <?php
      require("connect_db.php");
      $search = $_GET['search'];
      $search = "%$search%";
      $sql = "SELECT * FROM users WHERE username LIKE ?";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(1, $search);
      $stmt->execute();
      while ($row = $stmt->fetch()) {
        $username = $row['username'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $profile_picture = $row['profile_picture'];
        
        if($username == $_SESSION['username']){
          continue;
        }
        if($profile_picture == NULL){
          $profile_picture = "./profile_pictures/blank-profile-picture.png";
        }
        else{
          $profile_picture = "./profile_pictures/$profile_picture";
        }
        echo '<a href="user.php?username='.$username.'" class="text-decoration-none">
                <div class="card mt-3">
                  <div class="card-body">
                    <div class="row justify-content-start">
                      <div class="col-3 d-flex align-items-center justify-content-center">
                        <img src="'.$profile_picture.'" alt="" style="width: 60%" class="rounded-3 border border-3">
                      </div>
                      <div class="col d-flex align-items-center">
                        <div>
                          <h2 class="text-body">'.$username.'</h2>
                          <h5 class="text-secondary">'.$first_name.' '.$last_name.'</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </a>';
      }
    ?>
  
  </div>
  
</body>
</html>