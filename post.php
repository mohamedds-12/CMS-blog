<?php include 'includes\functions.php' ?>
<?php include 'includes\header.php' ?>

  <title>Post</title>
</head>

<body>

  <!-- Navigation -->
  <?php include 'includes\navigation.php' ?>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <?php

        if (isset($_GET['post_id'])) {
          $post_id = $_GET['post_id'];
          $clause = "WHERE post_id = $post_id ORDER BY post_id DESC";
          selectData('posts', $clause);

          while ($row = mysqli_fetch_assoc($selectData)) {
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_content = $row['post_content'];
            $post_image = $row['post_image'];
          }
        }

        ?>

        <!-- Title -->
        <h1 class="mt-4"><?php echo $post_title ?></h1>

        <!-- Author -->
        <p>
          by
          <a href="#"><?php echo $post_author ?></a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p>
          Posted on <?php echo substr($post_date, 0, 11) ?>
          at <?php echo substr($post_date, 10, 9) ?>
        </p>

        <hr>

        <!-- Preview Image -->
        <a href=<?php echo "./images/$post_image" ?>><img class="card-img-top rounded-sm" src=<?php echo "./images/$post_image" ?> alt=""></a>


        <hr>

        <!-- Post Content -->
        <p><?php echo $post_content ?></p>

        <hr>

        <!-- Comments Form -->
        <?php include 'includes/comments.php' ?>

      </div>

      <!-- Sidebar Widgets Column -->
      <?php include 'includes/sidebar.php' ?>

    </div><!-- /.row -->

  </div><!-- /.container -->


<!-- Footer -->
<?php include 'includes/footer.php' ?>