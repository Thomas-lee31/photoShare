<?php

var_dump($_FILES);

// echo $_FILES['myUpload']['name'];

session_start();

$destinationFolder = "./profile_pictures/";

$username = $_SESSION['username'];

$file_name = $username.date('ymd_hms').$_FILES['profile']['name'];

$filepath = $destinationFolder.$file_name;

move_uploaded_file($_FILES['profile']['tmp_name'], $filepath);

require("connect_db.php");

$_SESSION['profile_picture'] = $file_name;

$sql = "UPDATE users
        SET profile_picture = '$file_name'
        WHERE username='$username'";

$conn->exec($sql);

header("Location: ./profile.php");
exit();
?>
