  <?php date_default_timezone_set('Africa/Algiers'); ?>
  <?php if(isset($_SESSION['user_id'])):?>
    <div class="card my-4">
      <h5 class="card-header">Leave a Comment:</h5>
      <div class="card-body">
        <form action='#' method="POST">
          <!-- <div class="form-group"> -->
          <div class="media">
            <div class="d-flex mr-3 custom-editUser-img" style="background-image: url(./images/<?php echo $_SESSION['user_image'] ?>)"></div>
            <div class="media-body">
              <h5 class="mt-0"><?php echo $_SESSION['user_firstname'] .' '. $_SESSION['user_lastname'] ?></h5>
              <div class="form-group">
                <textarea class="form-control" name="comment_content" rows="3" placeholder="Enter comment"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>  
          </div>
        </form>
      </div>
    </div>
  <?php else:?>
    <div class="card my-4">
      <h5 class="card-header">Leave a Comment:</h5>
      <div class="card-body">
        <form action='#' method="POST">
          <div class="form-group">
            <label for="comment_author">Author</label>
            <input class="form-control" type="text" name="comment_author" placeholder="Enter name">
          </div>
          <div class="form-group">
            <label for="comment_email">Email</label>
            <input class="form-control" type="email" name="comment_email" placeholder="Enter email address">
          </div>
          <div class="form-group">
            <label for="comment_content">Your comment</label>
            <textarea class="form-control" name="comment_content" rows="3" placeholder="Enter comment"></textarea>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  <?php endif ?>


  <!-- Single Comment -->
  <?php

  if (isset($_POST['submit'])) {
    if(isset($_SESSION['user_id'])) {
      /* ------------------- Registered user --------------------- */
      if (!empty($_POST['comment_content'])) {
        $comment_post_id = $_GET['post_id'];

        foreach ($_POST as $key => $value) {
                                           
          $_POST[$key] = mysqli_real_escape_string($connection, $value);
        }

        $comment_email = $_SESSION['user_email'];
        // submit comment
        $comment_content = $_POST['comment_content'];
        $comment_email_id = $_SESSION['user_email_id'];
        $comment_author = $_SESSION['user_firstname'] .' '. $_SESSION['user_lastname'];
        $comment_user_role_id = $_SESSION['user_role_id'];
        $comment_user_id = $_SESSION['user_id'];

        if($_SESSION['user_role_id'] != '4' and $_SESSION['user_role_id'] != '3') {
          $comment_status = 'Approved';
        } else {
          $comment_status = 'Unapproved';
        }
        insertMultiData('comments', 'comment_content, comment_post_id, comment_email_id, comment_author, comment_status, comment_user_role_id, comment_user_id', 
        "'$comment_content', '$comment_post_id', $comment_email_id, '$comment_author', '$comment_status', '$comment_user_role_id', '$comment_user_id'");
      
        /* Changing comment count on table posts */
        $clause = "post_comments = post_comments + 1 WHERE post_id = $comment_post_id";
        updateOneData('posts', $clause);
      }
    } else { 
      /*-------------- Unregistered user -------------*/
      if (!empty($_POST['comment_content']) || !empty($_POST['comment_email']) || !empty($_POST['comment_author'])) {
        $comment_post_id = $_GET['post_id'];

        foreach ($_POST as $key => $value) {
                                           
          $_POST[$key] = mysqli_real_escape_string($connection, $value);
        }

        $comment_email = $_POST['comment_email'];

        // Checking if email exists
        $clause ="WHERE email = '$comment_email'";
        selectData('emails', $clause);
        $num = mysqli_num_rows($selectData);
        if($num != 0) {
          // If email exists, get its id
          $row = mysqli_fetch_assoc($selectData);
          $email_id = $row['email_id'];
        } else {
          // If email doesn't exist, insert it and get it's id
          insertOneData('emails', 'email', $comment_email);
          // Getting email id
          $clause ="WHERE email = '$comment_email'";
          selectData('emails', $clause);
          $row = mysqli_fetch_assoc($selectData);
          $email_id = $row['email_id'];
        }

        // Submiting comment by email id
        $comment_content = $_POST['comment_content'];
        $comment_email_id = $email_id;
        $comment_author = $_POST['comment_author'];

        insertMultiData('comments', 'comment_content, comment_post_id, comment_email_id, comment_author', 
        "'$comment_content', '$comment_post_id', $comment_email_id, '$comment_author'");
      }
    }
    header("location: #");
  }
  ?>

  <?php
  if(isset($_SESSION['user_id'])):

    $post_id = $_GET['post_id'];

    /* Selecting registered comments */
    $clause = "INNER JOIN users ON user_id  = comment_user_id
    WHERE comment_post_id = $post_id ORDER BY comment_id DESC"; 
     
    selectData('comments', $clause);
    while ($row = mysqli_fetch_assoc($selectData)):
      $comment_author = $row['comment_author'];
      $comment_content = $row['comment_content'];
      $comment_status = $row['comment_status'];
      $comment_user_role_id = $row['comment_user_role_id'];
      $commenter_image = $row['user_image'];
      
      if ($comment_status == 'Approved'):
        
        ?>
        <div class="media mb-4">
          <div class="d-flex mr-3 custom-editUser-img" style="background-image: url(./images/<?php echo $commenter_image ?>)"></div>
          <div class="media-body">
            <h5 class="mt-0"><?php echo $comment_author ?></h5>
            <?php echo $comment_content ?>
          </div>
        </div>
      <?php endif ?>
    <?php endwhile ?>
    <?php 
    /* Selecting unregistered comments */
    $clause = "WHERE comment_post_id = $post_id AND comment_user_role_id = 5 ORDER BY comment_id DESC";
    selectData('comments', $clause);
    while ($row01 = mysqli_fetch_assoc($selectData)):
      $comment_author01 = $row01['comment_author'];
      $comment_content01 = $row01['comment_content'];
      $comment_status01 = $row01['comment_status'];

      if ($comment_status01 == 'Approved'):
        ?>
        <div class="media mb-4">
          <div class="d-flex mr-3 custom-editUser-img" style="background-image: url(./images/user.jpg)"></div>
          <div class="media-body">
            <h5 class="mt-0"><?php echo $comment_author01 ?></h5>
            <?php echo $comment_content01 ?>
          </div>
        </div>
      <?php endif ?>
    <?php endwhile ?>
  <?php endif ?>

  <!-- Comment with nested comments -->
  <!-- <div class="media mb-4">
    <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
    <div class="media-body">
      <h5 class="mt-0">Commenter Name</h5>
      Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.

      <div class="media mt-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
          <h5 class="mt-0">Commenter Name</h5>
          Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
        </div>
      </div>
.
      <div class="media mt-4">
        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
        <div class="media-body">
          <h5 class="mt-0">Commenter Name</h5>
          Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
        </div>
      </div>

    </div>
  </div> -->