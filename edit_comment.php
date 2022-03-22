<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="./node_modules/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
  
  <!-- Bootstrap JS -->
  <script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>

  <title>Edit comment</title>
</head>
  <body>

    <?php
      session_start();
      if(isset($_POST['new_comment'])){
        try {
          $conn = new PDO("mysql:host=localhost;dbname=photo_sharing_app", 'root', '');
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
        $sql = "UPDATE post_comments
                SET comment = ?
                WHERE comment_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $_POST['new_comment']);
        $stmt->bindParam(2, $_POST['comment_id']);
        $stmt->execute();

        // redirect to session variable of previous page
        header("Location: ./".$_SESSION['previous']);
        exit();
      }
    ?>

    <div class="container mx-auto">
      <div style="width: 30%" class="border border-1 mt-5 bg-white mx-auto">
        <div class=" text-center my-4">
          <img src="./web_pictures/logo.png" alt="" width="65%" height="auto" class="mx-auto">
        </div>
        <form action="./edit_comment.php" method="post" style="width: 75%" class="mx-auto">
          <div class="form-floating">
            <input type="hidden" name="comment_id" value="<?php echo $_POST['comment_id']; ?>">
            <textarea class="form-control" placeholder="New comment" name="new_comment" id="floatingTextarea2" style="height: 300px" required><?php echo $_POST['comment']; ?></textarea>
            <label for="floatingTextarea2">New comment</label>
          </div>

          <a class="btn btn-secondary my-2" style="width: 100%" href="<?php echo './'.$_SESSION['previous']; ?>">Cancel</a>
          <button type="submit" class="btn btn-primary mb-3" style="width: 100%">Post</button>
        </form>
      </div>
    </div>
    
  </body>
</html>