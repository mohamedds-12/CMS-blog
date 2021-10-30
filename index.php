<?php include 'includes\functions.php' ?>
<?php include 'includes\header.php' ?>

  <title>Home</title>
</head>

<body>

  <!-- Navigation -->
  <?php include 'includes\navigation.php' ?>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">

        <h1 class="my-4">The Most Beautiful Natural Wonders</h1>

        <?php
        // Get post by category
        if (isset($_GET['id'])):
          $post_id = $_GET['id'];
          $clause = "WHERE post_category_id = $post_id AND post_status = 'Published' ORDER BY post_id DESC";
          selectData('posts', $clause);

          while ($row = mysqli_fetch_assoc($selectData)):
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_content = $row['post_content'];
            $post_image = $row['post_image'];
            $post_date = $row['post_date'];
            $post_author = $row['post_author'];

        ?>

            <!-- Blog Post -->
            <div class="card mb-4">
              <div class="card-body">
                <h3 class="card-title"><?php echo $post_title ?></h3>
                <img style="width: px; height: 450px;"  class="card-img-top rounded-sm" src=<?php echo "./images/$post_image" ?> alt="Card image cap">
                <p class="card-text"><?php echo substr($post_content, 0, 200) ?>...</p>
                <a href='post.php?post_id=<?php echo $post_id ?>' class="btn btn-primary">Read More &rarr;</a>
              </div>
              <div class="card-footer text-muted">
                Posted on <?php echo substr($post_date, 0, 11) ?>
                at <?php echo substr($post_date, 10, 9) ?>
                by <?php echo $post_author ?>

              </div>
            </div>
          <?php endwhile ?>
        <?php else:
          $post_status = "'Published'";
          $clause = "WHERE post_status = $post_status";
          selectData('posts', $clause);

          while ($row = mysqli_fetch_assoc($selectData)):
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
                <img style="width: px; height: 450px;"  class="card-img-top rounded-sm" src=<?php echo "./images/$post_image" ?> alt="Card image cap">
                <p class="card-text"><?php echo substr($post_content, 0, 200) ?> .....</p>
                <a href="post.php?post_id=<?php echo $post_id ?>" class="btn btn-primary">Read More &rarr;</a>
              </div>
              <div class="card-footer text-muted">
                Posted on <?php echo substr($post_date, 0, 11) ?>
                at <?php echo substr($post_date, 10, 9) ?>
                by <?php echo $post_author ?>
              </div>
            </div>
          <?php endwhile ?>
        <?php endif ?>
      </div>

      <!-- Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php' ?>

    </div><!-- /.row -->

  </div><!-- /.container -->


<!-- Footer -->
<?php include 'includes\footer.php' ?>