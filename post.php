      <div class="border mx-auto mt-5 bg-white" id="post<?php echo $post_id; ?>">
        <div class="px-3 py-2 d-flex align-items-center">
          <a href="./user.php?username=<?php echo $post_user; ?>" class="text-decoration-none text-body">
            <img src="<?php echo $profile_picture; ?>" style="width: 30px" class="rounded-3 border me-2">
            <b><?php echo $post_user; ?></b>
          </a>
        </div>

      <div id="post_<?php echo $post_id; ?>" class="carousel slide" width="60%" data-bs-ride="carousel">
        <div class="carousel-indicators">
<?php if($photo_1 != "" && $photo_1 != NULL): ?>
          <button type="button" data-bs-target="#post_<?php echo $post_id; ?>" data-bs-slide-to="0" class="active" aria-current="true" aria-labl="Slide 1"></button>
<?php endif; ?>
<?php if($photo_2 != "" && $photo_2 != NULL): ?>
          <button type="button" data-bs-target="#post_<?php echo $post_id; ?>" data-bs-slide-to="1" aria-label="Slide 2"></button>
<?php endif; ?>
<?php if($photo_3 != "" && $photo_3 != NULL): ?>
          <button type="button" data-bs-target="#post_<?php echo $post_id; ?>" data-bs-slide-to="2" aria-label="Slide 3"></button>
<?php endif; ?>
<?php if($photo_4 != "" && $photo_4 != NULL): ?>
          <button type="button" data-bs-target="#post_<?php echo $post_id; ?>" data-bs-slide-to="3" aria-label="Slide 4"></button>
<?php endif; ?>
<?php if($photo_5 != "" && $photo_5 != NULL): ?>
          <button type="button" data-bs-target="#post_<?php echo $post_id; ?>" data-bs-slide-to="4" aria-label="Slide 5"></button>
<?php endif; ?>
        </div>
        <div class="carousel-inner">
<?php if($photo_1 != "" && $photo_1 != NULL): ?>
          <div class="carousel-item active">
            <img src="./post_pictures/<?php echo $photo_1; ?>" class="d-block w-100" alt="...">
          </div>
<?php endif; ?>
<?php if($photo_2 != "" && $photo_2 != NULL): ?>
          <div class="carousel-item">
            <img src="./post_pictures/<?php echo $photo_1; ?>" class="d-block w-100" alt="...">
          </div>
<?php endif; ?>
<?php if($photo_3 != "" && $photo_3 != NULL): ?>
          <div class="carousel-item">
            <img src="./post_pictures/<?php echo $photo_1; ?>" class="d-block w-100" alt="...">
          </div>
<?php endif; ?>
<?php if($photo_4 != "" && $photo_4 != NULL): ?>
          <div class="carousel-item">
            <img src="./post_pictures/<?php echo $photo_1; ?>" class="d-block w-100" alt="...">
          </div>
<?php endif; ?>
<?php if($photo_5 != "" && $photo_5 != NULL): ?>
          <div class="carousel-item">
            <img src="./post_pictures/<?php echo $photo_1; ?>" class="d-block w-100" alt="...">
          </div>
<?php endif; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#post_<?php echo $post_id; ?>" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#post_<?php echo $post_id; ?>" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <div class="bg-white px-3 pt-3 pb-1 d-flex justify-content-start align-items-center">
<?php if(!$liked): ?>
        <form method="post" action="./like.php">
          <input type="hidden" name="post_user" value="<?php echo $post_user; ?>">
          <input type="hidden" name="from" value="<?php echo $from; ?>">
          <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
          <input type="submit" class="bg-white rounded-pill" name="like" value="Like">
        </form>
<?php else: ?>
        <form method="post" action="./unlike.php">
          <input type="hidden" name="post_user" value="<?php echo $post_user; ?>">
          <input type="hidden" name="from" value="<?php echo $from; ?>">
          <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
          <input type="submit" class="bg-white rounded-pill" value="Unlike">
        </form>
<?php endif; ?>
        <span class="ms-2" data-bs-toggle="modal" data-bs-target="#likes<?php echo $post_id; ?>" role="button"><?php echo count($like_users); ?> likes</span>

        <div class="modal fade" id="likes<?php echo $post_id; ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Likes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
<?php foreach($like_users as $u): 
  $like_user = $u['username'];
  $like_profile = $u['profile_picture'];
  if($like_profile == NULL || $like_profile == ""){
    $like_profile = "./profile_pictures/blank-profile-picture.png";
  }
  else{
    $like_profile = "./profile_pictures/$like_profile";
  }?>
  
                <div class="d-flex flex-row">
                  <div class="d-flex align-items-center">    
                    <img src="<?php echo $like_profile; ?>" style="width: 30px" class="rounded-3 border me-2">
                  </div>
                  <div class="d-flex align-items-center">
                    <b><?php echo $like_user; ?></b>
                  </div>
                </div>
<?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-white px-3 pb-2 border-bottom">
        <p class="my-1"><?php echo $message; ?></p>
        <span data-bs-toggle="modal" data-bs-target="#comments<?php echo $post_id; ?>" role="button">View <?php echo $comment_cnt; ?> comments<span><br>

        <div class="modal fade" id="comments<?php echo $post_id; ?>" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
<?php foreach($comments as $c):
  $comment_user = $c['username'];
  $comment_profile = $c['profile_picture'];
  $comment = $c['comment'];
  $comment_id = $c['comment_id'];
  $comment_date = $c['comment_date'];
  if($comment_profile == NULL || $comment_profile == ""){
    $comment_profile = "./profile_pictures/blank-profile-picture.png";
  }
  else{
    $comment_profile = "./profile_pictures/$comment_profile";
  }?>
                <div class="d-flex flex-row">
                  <div class="d-flex align-items-center">    
                    <img src="<?php echo $comment_profile; ?>" style="width: 30px" class="rounded-3 border me-2">
                  </div>
                  <div>
                    <b><?php echo $comment_user; ?></b><br>
                    <?php echo $comment; ?>
                  </div>
  <?php if($comment_user == $_SESSION['username']): ?>
                  <div class="d-flex align-items-center">
                    <form method="post" action="./delete_comment.php">
                      <input type="hidden" name="comment" value="<?php echo $comment ?>">
                      <input type="hidden" value="<?php echo $comment_id ?>" name="comment_id">
                      <input type="submit" class="btn btn-outline-danger" value="Delete">
                    </form>
                    <form method="post" action="./edit_comment.php">
                      <input type="hidden" name="comment" value="<?php echo $comment ?>">
                      <input type="hidden" value="<?php echo $comment_id ?>" name="comment_id">
                      <input type="submit" class="btn btn-outline-secondary" value="Edit">
                    </form>
                  </div>
                  <div class="d-flex align-items-end">
                    <small><?php echo $comment_date ?></small>
                  </div>
  <?php endif; ?>

                </div>
<?php endforeach; ?>
                
              </div>
            </div>
          </div>
        </div>
        <span style="font-size: 10px"><?php echo $post_date; ?><span>
      </div>
      <div class="bg-white px-3 py-2 d-flex justify-content-start align-items-center">
        <form method="post" action="./comment.php" class="w-100">
          <div class="d-flex">
            <input type="hidden" name="from" value="<?php echo $from; ?>">
            <input type="hidden" name="post_user" value="<?php echo $post_user; ?>">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="text" class="form-control border-0 me-2" id="floatingInput" placeholder="Add a comment..." name="comment" required>
            <button type="submit" class="btn btn-outline-primary">Post</button>
          </div>
        </form>
      </div>
    </div>