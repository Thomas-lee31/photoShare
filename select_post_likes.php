<?php
// select post likes
$sql1 = "SELECT 
          post_likes.post_id,
          post_likes.username,
          users.profile_picture,
          users.username
        FROM post_likes 
          INNER JOIN users ON post_likes.username = users.username
        WHERE post_id = ?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(1, $post_id);
$stmt1->execute();
$liked = 0;
$like_users = array();
while($row1 = $stmt1->fetch()){
  $like_users[] = $row1;
  if($row1['username'] == $_SESSION['username']){
    $liked = 1;
  }
}
?>