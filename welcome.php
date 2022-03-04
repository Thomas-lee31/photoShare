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

  <title>Welcome</title>
</head>

  <body style="background-color: rgb(248, 248, 248)">
    <div class="container">
      <div class="row">
          <div class="col text-center">
            <img src="./web_pictures/welcome_picture.png">
          </div>
          <div class="col">
            <div style="width: 60%" class="border border-1 mt-5 bg-white">
              <div class=" text-center my-4">
                <img src="./web_pictures/logo.png" alt="" width="65%" height="auto" class="mx-auto">
              </div>
              <form action="./login_handler.php" method="post" style="width: 75%" class="mx-auto">
                <div class="form-floating mb-1">
                  <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="login_info" value="<?php if(isset($_GET['login_info'])) echo $_GET['login_info'] ?>">
                  <label for="floatingInput">Username or email</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                  <label for="floatingPassword">Password</label>
                  <?php if(isset($_GET['error']) && $_GET['error'] == 3) echo '<p class="text-danger">Username, email, or password is incorrect</p>'?>
                </div>
                
                <button type="submit" class="btn btn-primary mb-3" style="width: 100%">Submit</button>
              </form>
            </div>
            <div style="width: 60%" class="border border-1 mt-3 bg-white text-center">
              <p class="my-3 fs-6">Don't have an account? <a href="sign_up.php" class="link-primary text-decoration-none">Sign up</a></p>
            </div>
          </div>
      </div>
    </div>
    <img type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#exampleModal" src="./web_pictures/upload_picture_icon.png" alt="" width="30">
              
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header text-center">
                      <h5 class="modal-title" id="exampleModalLabel">Create new post</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="post" action="./upload_handler.php">
                        <img src="./web_pictures/photos_icon.png" width="30%">
                        <div class="mb-3">
                          <label for="formFileMultiple" class="form-label">Upload photos here</label>
                          <input class="form-control" type="file" id="formFileMultiple" multiple>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Post">
                      </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                  </div>
                </div>
              </div>
  </body>
</html>