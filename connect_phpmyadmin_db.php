<?php
try {
  $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
  //echo "Connected to database";
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>