<?php

var_dump($_FILES);

// echo $_FILES['myUpload']['name'];

session_start();

$username = $_SESSION['username'];

require("connect_db.php");
$_SESSION['profile_picture'] = NULL;

$sql = "UPDATE users
        SET profile_picture = NULL
        WHERE username='$username'";

$conn->exec($sql);

header("Location: ./profile.php");
exit();
?>
