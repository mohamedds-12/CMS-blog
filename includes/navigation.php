
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">

      <a class="navbar-brand" href="./index.php">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div>
          <ul class="navbar-nav ml-auto">
            <?php 
            $clause='ORDER BY category_id DESC';
            selectData('categories', $clause);
            
            while( $row = mysqli_fetch_assoc($selectData)) {
              $category = $row['category'];
              $category_id = $row['category_id'];

              echo "<li class='nav-item'>
                <a class='nav-link' href='index.php?id=$category_id'>$category
                <span class='sr-only'>(current)</span></a>
              </li>";
            }
            ?>
          </ul>
        </div>
        <div>
          <ul class="navbar-nav" style="position: absolute;right: 16px;top: 8px;">
            <?php if(!isset($_SESSION['user_role_id'])){ ?>
              <li class="nav-item">
                <a class="nav-link" href="includes/login.php">Login</a>
              </li>

            <?php } else { ?>
              <li class="nav-item dropdown-hover">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div id="navImg" name="navImg" style="background-image: url(./images/<?php echo $_SESSION['user_image'] ?>)"></div>
                  <?php echo $_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname']?>

                  <!-- <svg class="svg-inline--fa fa-user fa-w-14 fa-fw" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 500" data-fa-i2svg="" style="max-inline-size: 14px;margin-left: 4px;">
                  <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg> -->
                </a>
                <div style="right: 6px;top: 48px;"class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  <?php if($_SESSION['role'] !== 'Subscriber') { ?>
                    <a class="dropdown-item" href="./admin/index.php">
                      <svg xmlns="http://www.w3.org/2000/svg" style="position: relative;bottom: 2px;" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                        <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                      </svg>
                      CMS
                    </a>
                  <?php } else {} ?>
                  <a class="dropdown-item"style="position: relative;left: 2px;" href="./admin/profile.php">
                    <div class="fas fa-user" style="position:relative;"></div>
                    <span>Profile</span>
                  </a>
                  <div class="dropdown-divider"></div>
                  <form style="margin-bottom: -21px;" action="./includes/login.php" method="POST">
                    <input class="dropdown-item" style="position: relative;left: 0;padding: 0px 0px 4px 48px;" name="logout" type="submit" value="Log out">
                    <span style="position: relative;bottom: 27px;left: 26px;" class="fas fa-power-off"></span>
                  </form>
                </div>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>

    </div>
  </nav>
  