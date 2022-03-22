<?php
echo '<div class="border mx-auto mt-5 bg-white" id="post'.$post_id.'">
        <div class="px-3 py-2 d-flex align-items-center">
          <a href="./user.php?username='.$post_user.'" class="text-decoration-none text-body">
            <img src="'.$profile_picture.'" style="width: 30px" class="rounded-3 border me-2">
            <b>'.$post_user.'</b>
          </a>
        </div>';

echo '<div id="post_'.$post_id.'" class="carousel slide" width="60%" data-bs-ride="carousel">
        <div class="carousel-indicators">';
if($photo_1 != "" && $photo_1 != NULL)
  echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="0" class="active" aria-current="true" aria-labl="Slide 1"></button>';
if($photo_2 != "" && $photo_2 != NULL)
  echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="1" aria-label="Slide 2"></button>';
if($photo_3 != "" && $photo_3 != NULL)
  echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="2" aria-label="Slide 3"></button>';
if($photo_4 != "" && $photo_4 != NULL)
  echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="3" aria-label="Slide 4"></button>';
if($photo_5 != "" && $photo_5 != NULL)
  echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="4" aria-label="Slide 5"></button>';
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
        <button class="carousel-control-prev" type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>';

echo '<div class="bg-white px-3 pt-3 pb-1 d-flex justify-content-start align-items-center">';
if(!$liked){
  echo '<form method="post" action="./like.php">
          <input type="hidden" name="from" value="'.$from.'">
          <input type="hidden" name="post_id" value="'.$post_id.'">
          <input type="submit" class="bg-white rounded-pill" name="like" value="Like">
        </form>';
}
else{
  echo '<form method="post" action="./unlike.php">
          <input type="hidden" name="from" value="'.$from.'">
          <input type="hidden" name="post_id" value="'.$post_id.'">
          <input type="submit" class="bg-white rounded-pill" value="Unlike">
        </form>';
}
echo '  <span class="ms-2" data-bs-toggle="modal" data-bs-target="#likes'.$post_id.'" role="button">'.count($like_users).' likes</span>

        <div class="modal fade" id="likes'.$post_id.'" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Likes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">';
foreach($like_users as $u){
  $like_user = $u['username'];
  $like_profile = $u['profile_picture'];
  if($like_profile == NULL || $like_profile == ""){
    $like_profile = "./profile_pictures/blank-profile-picture.png";
  }
  else{
    $like_profile = "./profile_pictures/$like_profile";
  }
  
  echo '        <div class="d-flex flex-row">
                  <div class="d-flex align-items-center">    
                    <img src="'.$like_profile.'" style="width: 30px" class="rounded-3 border me-2">
                  </div>
                  <div class="d-flex align-items-center">
                    <b>'.$like_user.'</b>
                  </div>
                </div>';
}
 echo '       </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-white px-3 pb-2 border-bottom">
        <p class="my-1">'.$message.'</p>
        <span data-bs-toggle="modal" data-bs-target="#comments'.$post_id.'" role="button">View '.$comment_cnt.' comments<span><br>

        <div class="modal fade" id="comments'.$post_id.'" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">';
foreach($comments as $c){
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
  }
  echo '    
                <div class="d-flex flex-row">
                  <div class="d-flex align-items-center">    
                    <img src="'.$comment_profile.'" style="width: 30px" class="rounded-3 border me-2">
                  </div>
                  <div>
                    <b>'.$comment_user.'</b><br>'
                    .$comment.
                  '</div>';
  if($comment_user == $_SESSION['username']){
    echo '        <div class="d-flex align-items-center">
                    <form method="post" action="./delete_comment.php">
                      <input type="hidden" name="comment" value="'.$comment.'">
                      <input type="hidden" value="'.$comment_id.'" name="comment_id">
                      <input type="submit" class="btn btn-outline-danger" value="Delete">
                    </form>
                    <form method="post" action="./edit_comment.php">
                      <input type="hidden" name="comment" value="'.$comment.'">
                      <input type="hidden" value="'.$comment_id.'" name="comment_id">
                      <input type="submit" class="btn btn-outline-secondary" value="Edit">
                    </form>
                  </div>
                  <div class="d-flex align-items-end">
                    <small>'.$comment_date.'</small>
                  </div>';
  }
  echo '        </div>';
}
                
  echo '       </div>
            </div>
          </div>
        </div>
        <span style="font-size: 10px">'.$post_date.'<span>
      </div>
      <div class="bg-white px-3 py-2 d-flex justify-content-start align-items-center">
        <form method="post" action="./comment.php" class="w-100">
          <div class="d-flex">
            <input type="hidden" name="from" value="home">
            <input type="hidden" name="post_id" value="'.$post_id.'">
            <input type="text" class="form-control border-0 me-2" id="floatingInput" placeholder="Add a comment..." name="comment" required>
            <button type="submit" class="btn btn-outline-primary">Post</button>
          </div>
        </form>
      </div>
    </div>';

?>