<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">

                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <div class="sb-sidenav-menu-heading">Interface</div>
                    <a 
                        class="nav-link collapsed" 
                        href="#" data-toggle="collapse" 
                        data-target="#collapsepostsLayouts" aria-expanded="false" 
                        aria-controls="collapsepostsLayouts">

                        <div class="sb-nav-link-icon"><i class="fas fa-align-left"></i></div>
                        Posts
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    
                    </a>
                    <div class="collapse" id="collapsepostsLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="./view_posts.php">View Posts</a>
                            <a class="nav-link" href="./add_posts.php">Add Posts</a>
                        </nav>
                    </div>
                    <?php if($_SESSION['role'] == 'Administrator' or $_SESSION['role'] == 'Content Manager' ) { ?>
                        <a class="nav-link" href="categories.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                            Categories
                        </a>
                
                        <a class="nav-link" href="./comments.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                            Comments
                        </a>
                    <?php } else {} ?>

                    <!-- <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Authentication
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="includes/templates/login.php">Login</a>
                                    <a class="nav-link" href="includes/templates/register.php">Register</a>
                                    <a class="nav-link" href="includes/templates/password.php">Forgot Password</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                Error
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="includes/templates/401.php">401 Page</a>
                                    <a class="nav-link" href="includes/templates/404.php">404 Page</a>
                                    <a class="nav-link" href="includes/templates/500.php">500 Page</a>
                                </nav>
                            </div>
                        </nav>
                    </div> -->
                    <div class="sb-sidenav-menu-heading">CMS</div>
                        <?php if($_SESSION['role'] == 'Administrator') { ?> 
                            <a 
                                class="nav-link collapsed" 
                                href="#" data-toggle="collapse" 
                                data-target="#collapseUsersLayouts" aria-expanded="false" 
                                aria-controls="collapseUsersLayouts">

                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Users
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            
                            <div class="collapse" id="collapseUsersLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="./view_users.php">View Users</a>
                                    <a class="nav-link" href="./add_users.php">Add Users</a>
                                </nav>
                            </div>
                        <?php } else {} ?>
                        <a class="nav-link" href="./profile.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Profile
                        </a>
                    <!-- </div> -->
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php echo $_SESSION['role'] ?>
            </div>
        </nav>
    </div>
    
   