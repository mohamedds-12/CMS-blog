<?php include 'functions.php' ?>
<?php ob_start() ?>
<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registration</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-img">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="wr-white col-lg-7">
                                <div class="bg-img card shadow-lg border-0 rounded-lg mt-5">
                                    <?php
                                    
                                    if(isset($_POST['signup'])) {
                                        if (empty($_POST['user_firstname']) or empty($_POST['user_lastname']) or empty($_POST['username']) or empty($_POST['user_password']) or empty($_POST['user_email'])) {
                                            echo "<h5 style='color:red'>Please fill in the required fields</h5>";
                    
                                        } elseif($_POST['user_password'] !== $_POST['confirm_password']) {
                                            echo "<h5 style='color:red'>Password doesn't match! Please try again</h5>";
                                            
                                        } else {
                                            foreach ($_POST as $key => $value) {
                                           
                                                $_POST[$key] = mysqli_real_escape_string($connection, $value);
                                            }
                                            $firstname = $_POST['user_firstname'];
                                            $lastname = $_POST['user_lastname'];
                                            $email = $_POST['user_email'];
                                            $password = $_POST['user_password'];
                                            $username = $_POST['username'];
                                            
                                            // inserting email to emails table
                                            insertOneData('emails', 'email', $email);
                                            // getting email id from emails table
                                            $clause = "WHERE email = '$email'";
                                            selectData('emails', $clause);
                                            $row = mysqli_fetch_assoc($selectData);
                                            $email_id = $row['email_id'];
                                            
                                            insertMultiData('users','user_firstname, user_lastname, user_email_id, user_password, username',
                                            "'$firstname', '$lastname', $email_id,'$password', '$username'");

                                            $_SESSION['signup'] = 'signup';

                                            header("location: login.php");
                                            
                                        }
                                    }
                                    ?>

                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Registration</h3></div>
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">First Name</label>
                                                        <input class="form-control py-4" name="user_firstname" id="inputFirstName" type="text" placeholder="Enter first name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputLastName">Last Name</label>
                                                        <input class="form-control py-4" name="user_lastname" id="inputLastName" type="text" placeholder="Enter last name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                        <input class="form-control py-4" name="user_email" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputUsername">Username</label>
                                                        <input class="form-control py-4" name="username" id="inputUsername" type="text" aria-describedby="emailHelp" placeholder="Enter username" />
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputPassword">Password</label>
                                                    <input class="form-control py-4" name="user_password" id="inputPassword" type="password" placeholder="Enter password" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                                    <input class="form-control py-4" name="confirm_password" id="inputConfirmPassword" type="password" placeholder="Confirm password" />
                                                </div>
                                            <div class="form-group mt-4 mb-0"><input class="btn btn-secondary btn-block" name="signup" type="submit" value="Sign Up"></div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
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
