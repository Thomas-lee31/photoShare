<?php
    session_start();
    require("connect_db.php");
    $array = array();
    $message = $_POST['description'];
    var_dump($_FILES);
    
    $names = $_FILES['pictures']['name'];
    var_dump($names);
    $countfiles = sizeof($names);

    for($i = 0; $i < $countfiles; $i++){
      $destinationFolder = "./post_pictures/";
      $filename = date('ymd_hms').$i.$_FILES['pictures']['name'][$i];
      $array[] = $filename;
      $filepath = $destinationFolder.$filename;
      move_uploaded_file($_FILES['pictures']['tmp_name'][$i], $filepath);
    }

    for($i = $countfiles; $i < 5; $i++){
      $array[] = NULL;
    }
    
    echo $message;
    var_dump($array);
    $photo_1 = $array[0]; $photo_2 = $array[1]; $photo_3 = $array[2]; $photo_4 = $array[3]; $photo_5 = $array[4];
    $username = $_SESSION['username'];
    $sql = "INSERT INTO posts (username, message, photo_1, photo_2, photo_3, photo_4, photo_5) VALUES ('$username', '$message', '$photo_1', '$photo_2', '$photo_3', '$photo_4', '$photo_5')";
    $conn->exec($sql);
    header("Location: ./profile.php");
    exit();
?>