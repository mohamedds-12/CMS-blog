      <div class="col-md-4 position-fixed" style="right:88px; max-width: 30.333333%;">

        <!-- Search Widget -->
        <div class="card my-4 ">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <form action="../search.php" method="post">
            <div class="input-group">
              <input name="search" type="text"  class="form-control" placeholder="Search for...">
              <span class="input-group-append">
                <button name="submit" class="btn btn-primary" type="submit">Go!</button>
              </span>
            </div>
            </form>
          </div>
        </div>

        <!-- Categories Widget -->

        <?php 

        $clause = "LIMIT 6";
        selectData('categories', $clause);

        ?>
        <?php
        if(isset($_SESSION['user_role_id'])){

        } else {

        ?>
        <!-- Login Widget -->
        <div class="card my-4">
          <h5 class="card-header">Login</h5>
          <div class="card-body">
          <form action="includes/login.php" method="post">
            <div class="form-group">
              <input name="username" type="text"  class="form-control" placeholder="Enter Username">
            </div>
            <div class="input-group">
              <input name="user_password" type="password"  class="form-control" placeholder="Enter Password">
              <span class="input-group-append">
                <button name="index_login" class="btn btn-primary" type="submit">Sign in</button>
              </span>
            </div>
            </form>
          </div>
        </div>
        
        <?php } ?>

        <div class="card my-4">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">

                  <?php while( $row = mysqli_fetch_assoc($selectData) ) {
                    $category = $row['category'];
                    $category_id = $row['category_id'];

                    echo "<li><a href='index.php?id=$category_id'>$category</a></li>";
                    
                  ?>

                </ul>
              </div>
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  <?php }  ?>  
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <!-- <div class="card my-4">
          <h5 class="card-header">Side Widget</h5>
          <div class="card-body">
            You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
          </div>
        </div> -->


      </div>