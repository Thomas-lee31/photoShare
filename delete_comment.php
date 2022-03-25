<?php

session_start();

$username = $_SESSION['username'];

$comment_id = $_POST['comment_id'];

require("connect_db.php");

$sql = "DELETE FROM post_comments
        WHERE comment_id='$comment_id'";

$conn->exec($sql);

header("Location: ./");
exit();
?>
