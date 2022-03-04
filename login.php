<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="./js/bootstrap.js"></script>

    <title>Login</title>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="./web_pictures/logo.png" alt="" width="125" height="auto">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <?php
              session_start();

              if(isset($_SESSION['username'])){
                  echo '<li class="nav-item">
                          <a class="nav-link" href="./profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="./logout.php>Logout"</a>
                        </li>';
              }

              else{
                  echo '<li class="nav-item">
                          <a class="nav-link" href="./index.php">Home</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="./sign_up.php">Sign up</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="./login.php">Login</a>
                        </li>';
              }
            ?>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="./profile_pictures/blank-profile-picture.png" alt="" class="rounded border border-1" width="30" height="auto">
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
      <form action="./login_handler.php" method="post">
        <div class="mb-3">
          <label class="form-label">Username or email</label>
        <input type="text" class="form-control" name="login_info" aria-describedby="emailHelp" value="<?php if(isset($_GET['login_info'])) echo $_GET['login_info'] ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password">
          <?php if(isset($_GET['error']) && $_GET['error'] == 3) echo '<p class="text-danger">Username, email, or password is incorrect</p>'?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    
    
    
  </body>
</html>

