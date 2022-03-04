<?php
    
    session_start();
    
    try {
      $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
      //echo "Connected to database";
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "SELECT * FROM users WHERE STRCMP(username, ?) = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $username);
    $stmt->execute();

    while($row = $stmt->fetch()){
      header("Location: ./sign_up.php?error=2");
      exit();
    }

    $sql = "SELECT * FROM users WHERE STRCMP(email, ?) = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $email);
    $stmt->execute();

    while($row = $stmt->fetch()){
      $error = 2;
      header("Location: ./sign_up.php?error=2");
      exit();
    }

    $sql = "INSERT INTO users (username, email, first_name, last_name, password) VALUES ('$username', '$email', '$first_name', '$last_name', '$password')";
    $conn->exec($sql);
    
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['first_name'] = $row['first_name'];
    $_SESSION['last_name'] = $row['last_name'];
    $_SESSION['profile_picture'] = NULL;

    header("Location: ./index.php");
    exit();
  ?>