<?php

session_start();

$username = $_SESSION['username'];

$post_id = $_GET['post_id'];

require("connect_db.php");

$sql = "DELETE FROM posts
        WHERE post_id='$post_id'";

$conn->exec($sql);

header("Location: ./profile.php");
exit();
?>
