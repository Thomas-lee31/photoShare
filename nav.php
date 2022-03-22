<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand" href="./">
      <img src="./web_pictures/logo.png" alt="" width="125" height="auto">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <?php
        $profile_picture = $_SESSION['profile_picture'];
        if($profile_picture == NULL || $profile_picture == ""){
          $profile_picture = "./profile_pictures/blank-profile-picture.png";
        }
        else{
          $profile_picture = "./profile_pictures/$profile_picture";
        }  
      ?>
      <img role="button" data-bs-toggle="modal" data-bs-target="#upload" src="./web_pictures/upload_picture_icon.png" alt="" width="30">
            
      <div class="modal fade" id="upload" tabindex="-1" aria-labelledby="upload" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Create new post</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="post" action="./upload_post.php" enctype="multipart/form-data" class="text-center p-3">
                <img src="./web_pictures/photos_icon.png" width="30%">
                <div class="mb-3">
                  <label class="form-label">Upload photos here</label>
                  <input class="form-control" type="file" name="pictures[]" multiple required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Add descriptions</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description"></textarea>
                </div>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Discard</button>
                <input type="submit" class="btn btn-primary" value="Post">
              </form>
            </div>
          </div>
        </div>
      </div>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo $profile_picture ?>" alt="" class="rounded border border-1" height="30">
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="./profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="./liked_posts.php">Liked posts</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="./logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
      
    </div>
    
    <form class="d-flex" method="get" action="./search_results.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    
  </div>
</nav>


