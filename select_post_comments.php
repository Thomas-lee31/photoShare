<?php
$sql1 = "SELECT
          post_comments.username,
          post_comments.comment,
          post_comments.comment_id,
          users.profile_picture
        FROM post_comments 
          INNER JOIN users ON users.username = post_comments.username
        WHERE post_id = ?
        ORDER BY comment_date DESC";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(1, $post_id);
$stmt1->execute();
$comment_cnt = 0;
$comments = array();
while($row1 = $stmt1->fetch()){
  $comment_cnt++;
  $comments[] = $row1;
}
?>