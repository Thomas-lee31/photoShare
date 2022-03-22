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

  <title>Sign up</title>
</head>
  <body>
    <div class="container mx-auto">
      <div style="width: 30%" class="border border-1 mt-5 bg-white mx-auto">
        <div class=" text-center my-4">
          <img src="./web_pictures/logo.png" alt="" width="65%" height="auto" class="mx-auto">
        </div>
        <form action="./sign_up_handler.php" method="post" style="width: 75%" class="mx-auto">
          <div class="form-floating mb-1">
            <input type="text" class="form-control" name="username" required placeholder="username" autofocus>
            <label class="form-label">Username</label>
            <?php if(isset($_GET['error']) && $_GET['error'] == 1) echo '<p class="text-danger">This username is already taken!</p>'?>
          </div>

          <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" required placeholder="name@example.com">
            <label class="form-label">Email</label>
            <?php if(isset($_GET['error']) && $_GET['error'] == 2) echo '<p class="text-danger">This email is already taken!</p>'?>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="first_name" required placeholder="first_name">
            <label class="form-label">First name</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" class="form-control" name="last_name" required placeholder="last_name">
            <label class="form-label">Last name</label>
          </div>

          <div class="form-floating mb-3">
            <input type="password" class="form-control" name="password" required placeholder="password">
            <label class="form-label">Password</label>
          </div>

          
          <?php
            if(isset($_GET['error'])){
              echo '<p class="error">Username, email, or password is incorrect</p>';
            }
          ?>
          <button type="submit" class="btn btn-primary mb-3" style="width: 100%">Sign up</button>
        </form>
      </div>
    </div>
  </body>
</html>