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
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
      <a class="navbar-brand" href="./index.php">
        <img src="./web_pictures/logo.png" alt="" width="125" height="auto">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            
          </li>
          <li class="nav-item">
            <img type="button" class="btn p-0 d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModal" src="./web_pictures/upload_picture_icon.png" alt="" width="30">
            
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
                        <input class="form-control" type="file" name="file[]" multiple>
                      </div>
                      <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Add descriptions</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                      </div>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" value="Post">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" href="" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="./profile_pictures/blank-profile-picture.png" alt="" class="rounded border border-1" width="28">
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="./profile.php">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
        
      </div>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
      </form>
    </div>
  </nav>
  <div class="container">
    <h1>User not found</h1>
  </div>
  
</body>
</html>