    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">CMS</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>

        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <!-- <li><a class="nav-link" href="../index.php">Home</a></li> -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div id="navImg" name="navImg" style="background-image: url(../images/<?php echo $_SESSION['user_image'] ?>)"></div>
                  <?php echo $_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname']; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown"style="top: 48px;right: 6px;">
                    <a class="dropdown-item" href="../index.php">
                        <div class="fas fa-home" style="position:relative;"></div>
                        <span>Home</span>
                    </a>
                    <a class="dropdown-item"style="position: relative;left: 3px;" href="./profile.php">
                        <div class="fas fa-user" style="position:relative; right: 1px;"></div>
                        <span>Profile</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <form style="margin-bottom: -21px;" action="../includes/login.php" method="POST">
                <input class="dropdown-item" style="position: relative;left: 0;padding: 0px 0px 4px 48px;" name="logout" type="submit" value="Log out">
                <span style="position: relative;bottom: 27px;left: 26px;" class="fas fa-power-off"></span>
                    </form>
                </div>
            </li>
        </ul>
    </nav>