<?php include 'functions.php' ?>
<?php ob_start() ?>
<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
        if(isset($_POST['logout'])){
            // Logging out
            $user_id = $_SESSION['user_id'];
            $clause = "user_status = 'Logged out' WHERE user_id = $user_id";
            updateOneData('users', $clause);

            foreach($_SESSION as $key => $value) {
                // if($key !== 'user_id') {
                    unset($_SESSION[$key]); 
                // }
            }

        } 

        if(isset($_SESSION['user_id'])) {
            // if($_SESSION['user_status'] == 'Logged in') {
                header("Location: ../index.php");
            // }
        }
        ?>    
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-img">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="bg-img card shadow-lg border-0 rounded-lg mt-5 wr-white">

                                <?php 
                                
                                if(isset($_POST['login']) or isset($_POST['index_login'])){
                                    if(empty($_POST['username']) or empty($_POST['user_password'])) {
                                        echo '<h5 style=" color: red ">Please fill in the required fields</h5>';

                                    } else {
                                        foreach ($_POST as $key => $value) {
                                           
                                            $_POST[$key] = mysqli_real_escape_string($connection, $value);
                                        }
                                        $username = $_POST['username']; 
                                        $password = $_POST['user_password'];

                                        $clause = "INNER JOIN roles ON user_role_id = role_id 
                                        INNER JOIN emails ON email_id = user_email_id WHERE username = '$username' AND user_password = '$password'"; 
                                        selectData('users', $clause);

                                        $num_rows = mysqli_num_rows($selectData);
                                        if($num_rows == 0) {
                                            echo '<h5 style=" color: red ">Invalid username or password</h5>';

                                        } else {
                                            while($row = mysqli_fetch_assoc($selectData)) {
                                                $user_id = $row['user_id'];
                                                $firstname = $row['user_firstname'];
                                                $lastname = $row['user_lastname'];
                                                $email = $row['email'];
                                                $role_id = $row['user_role_id'];
                                                $image = $row['user_image'];
                                                $role = $row['role'];
                                                $email_id = $row['user_email_id'];

                                            }

                                            // Logged in
                                            $status = 'Logged in';
                                            $clause = "user_status = 'Logged in' WHERE user_id = $user_id";
                                            updateOneData('users', $clause);
                                            
                                            $_SESSION['user_id'] = $user_id;
                                            $_SESSION['user_firstname'] = $firstname;
                                            $_SESSION['user_lastname'] = $lastname;
                                            $_SESSION['username'] = $username;
                                            $_SESSION['user_email_id'] = $email_id;
                                            $_SESSION['user_email'] = $email;
                                            $_SESSION['user_role_id'] = $role_id;
                                            $_SESSION['role'] = $role;
                                            $_SESSION['user_image'] = $image;
                                            $_SESSION['user_status'] = $status;

                                            
                                            if($role == 'Content Editor' or $role == 'Content Manager' or $role == 'Administrator'){
                                                header("location: ../admin/index.php");
                                                
                                            } else {
                                                header("location: ../index.php");
                                            }

                                        }
                                    }
                                } 
                                
                                if(isset($_SESSION['signup'])) {
                                    echo "<h5 style='color:green'>Thank you for your registration! Your account is now ready to use.</h5>";
                                }
                                ?>
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="">
                                            <div class="form-group" >
                                                <label class="small mb-1" for="inputEmailAddress">Username</label>
                                                <input class="form-control py-4" name="username" id="inputEmailAddress" type="username" placeholder="Enter Username" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" name="user_password" id="inputPassword" type="password" placeholder="Enter Password" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.php">Forgot Password?</a>
                                                <input class='btn btn-primary' type='submit' name='login' value='Log in'>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="./register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="bg-img py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
