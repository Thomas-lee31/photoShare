<?php
echo '<div class="bg-white px-3 pt-3 pb-1 d-flex justify-content-start align-items-center">';
if(!$liked){
  echo '<form method="post" action="./like.php">
          <input type="hidden" name="from" value="'.$from'">
          <input type="hidden" name="post_id" value="'.$post_id.'">
          <input type="submit" class="bg-white rounded-pill" name="like" value="Like">
        </form>';
}
else{
  echo '  <form method="post" action="./unlike.php">
            <input type="hidden" name="from" value="'.$from'">
            <input type="hidden" name="post_id" value="'.$post_id.'">
            <input type="submit" class="bg-white rounded-pill" value="Unlike">
          </form>';
}
echo '  <span class="ms-2">'
          .$likes_cnt.' people liked this post
        </span>
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
                    <a href="./delete_comment.php?comment_id='.$comment_id.'" class="link-danger">delete</a>
                  </div>';
  }
  echo '        </div>';
  }
                
  echo '        </div>
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
            <input type="text" class="form-control border-0" id="floatingInput" placeholder="Add a comment..." name="comment" required>
            <button type="submit" class="btn btn-outline-primary">Post</button>
          </div>
        </form>
      </div>
      </div>';

?>