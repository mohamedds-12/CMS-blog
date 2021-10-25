<?php include 'includes/functions.php'?>
<?php include 'includes/header.php'?>

  <title>Home</title>
</head>

<body>

  <!-- Navigation -->
  <?php include 'includes/navigation.php' ?>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <?php 
        if( isset($_POST['submit']) ) {
          if( !empty($_POST['search']) ) {
            foreach ($_POST as $key => $value) {
                                           
              $_POST[$key] = mysqli_real_escape_string($connection, $value);
            }

            $search = $_POST['search'];
            searchAllData();
            
            // Checking search result
            $count = mysqli_num_rows($searchAllData);
            if($count == 0) {
              echo '<h4 class="my-4">NO RESULT WAS FOUND!</h1>';

            } else {
              echo '<h1 class="my-4">Search Result:</h4>';

              while($row = mysqli_fetch_assoc($searchAllData)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];

        ?>
    
                <!-- Blog Post -->
                <div class="card mb-4">
                  <div class="card-body">
                    <h3 class="card-title"><?php echo $post_title ?></h3>
                    <img class="card-img-top rounded" src=<?php echo "./images/" .$post_image ?> alt="Card image cap">
                    <p class="card-text"><?php echo $post_content ?></p>
                    <a href='post.php?post_id=<?php echo $post_id ?>' class="btn btn-primary">Read More &rarr;</a>
                  </div>
                  <div class="card-footer text-muted">
                    Posted on <?php echo substr($post_date, 0, 11) ?>
                    at <?php echo substr($post_date, 10, 9) ?>
                    by <?php echo $post_author ?>
                  </div>
                </div>

              <?php } ?>
            <?php } ?>
          <?php } else { echo '<h4 class="my-4">Empty Field! Please Try Again.</h4>'; }?>
        <?php } ?>
                

      </div>

      <!-- Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php' ?>

    </div><!-- /.row -->
   
  </div><!-- /.container -->

  
<!-- Footer -->
<?php include 'includes/footer.php' ?>
