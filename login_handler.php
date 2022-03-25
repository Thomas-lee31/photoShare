<?php
    
    session_start();
    
    require("connect_db.php");

    $login_info = $_POST['login_info'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE STRCMP(username, ?) = 0 OR STRCMP(email, ?) = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $login_info);
    $stmt->bindParam(2, $login_info);
    $stmt->execute();
    $has_user = 0;
    while($row = $stmt->fetch()){
        $has_user = 1;
        $hash = $row['password'];
        if(password_verify($password, $hash)){
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['profile_picture'] = $row['profile_picture'];
            header("Location: ./index.php");
            exit();
        }
    }
    header("Location: ./welcome.php?error=3&login_info=$login_info");
    exit();
  ?>