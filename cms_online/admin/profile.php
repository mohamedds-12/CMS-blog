<?php ob_start() ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>
<?php include 'includes/sidebar.php' ?>
<?php include '../includes/functions.php' ?>

<div id="layoutSidenav_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">Profile</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>

                <?php

                    $user_id = $_SESSION['user_id'];
                    $edit_firstname = $_SESSION['user_firstname'];
                    $edit_lastname = $_SESSION['user_lastname'];
                    $edit_email = $_SESSION['user_email'];
                    $edit_username = $_SESSION['username'];
                    $edit_image = $_SESSION['user_image'];
                    $edit_role_id = $_SESSION['user_role_id'];
                    $edit_role = $_SESSION['role'];
                    $edit_status = $_SESSION['user_status'];

                    ?>
                        <h4 class="custom-h4">Edit Account</h4>
                        <form action='' method='POST' enctype='multipart/form-data'>
                            <div class='form-row'>
                                <div class='form-group col-md-6'>
                                    <label for='user_firstname'>First Name</label>
                                    <input type='text' class='form-control' name='user_firstname' value='<?php echo $edit_firstname ?>'>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='user_lastname'>Last Name</label>
                                    <input type='text' class='form-control' name='user_lastname' value='<?php echo $edit_lastname ?>'>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for='user_email'>Email</label>
                                    <input type='email' class='form-control' name='user_email' value='<?php echo $edit_email ?>'>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" value='<?php echo $edit_username ?>'>
                                </div>
                            </div>
                            <div class='form-group'>
                                <label for='user_password'>Password</label>
                                <input type='password' class='form-control' name='user_password' placeholder='Enter password'>
                            </div>
                            <div class='form-group'>
                                <label for='confirm_password'>Confirm Password</label>
                                <input type='password' class='form-control' name='confirm_password' placeholder='Confirm password'>
                            </div>
                            <div class="form-row">
                                <div class='form-group col-md-6'>
                                    <label for="edit_image">Picture</label>
                                    <div class="form-group">
                                        <div class="custom-editUser-img" name="edit_image" style="background-image: url(../images/<?php echo $edit_image ?>)"></div>
                                    </div>
                                    <input type="file" class="custom-editUser-file form-control-file" name="user_image">
                                </div>
                            </div>
                            <div class='form-group'>
                                <input class='btn btn-primary' type='submit' name='update_account' value='Update Account'>
                            </div>
                        </form>
                    <?php
                    if (isset($_POST['update_account'])) {
                        $user_id = $_SESSION['user_id'];

                        if (empty($_POST['user_firstname']) or empty($_POST['user_lastname']) or empty($_POST['username']) or empty($_POST['user_password']) or empty($_POST['user_email'])) {
                            echo "<h5 class='custom-h5'>Account Not Updated! Please Try Again.</h5>";

                        } elseif($_POST['user_password'] !== $_POST['confirm_password']) {
                            echo "<h5 class='custom-h5'>Password doesn't match! Please Try Again.</h5>";

                        } else {
                            foreach ($_POST as $key => $value) {
                                           
                                $_POST[$key] = mysqli_real_escape_string($connection, $value);
                            }
                            $firstname = $_POST['user_firstname'];
                            $lastname = $_POST['user_lastname'];
                            $email = $_POST['user_email'];
                            $username = $_POST['username'];
                            $password = $_POST['user_password'];
                            $role_id = $_SESSION['user_role_id'];

                            if ($user_id == $_SESSION['user_id']) {
                                $status = 'Logged in';
                                
                            } elseif ($edit_status == 'Logged in') { 
                                $status = 'Logged in';
                            
                            } else {
                                $status = 'Logged out';
                            
                            }
                            if(!empty($_FILES['user_image']['name'])) {
                                $image = ($_FILES['user_image']['name']);
                                $tmp_image = ($_FILES['user_image']['tmp_name']);
                                move_uploaded_file($tmp_image, "../images/$image");

                            } else {
                                $image = $edit_image;

                            } 
                            
                            /* Selecting previous email, updating it, getting it's id */
                            
                            // selecting previous email
                            $clause = "WHERE email = '$edit_email'";
                            selectData('emails', $clause);
                            $row = mysqli_fetch_assoc($selectData);
                            $email_id = $row['email_id'];
                            // updating email
                            $clause = "email = '$email' WHERE email_id = $email_id";
                            updateOneData('emails', $clause);
                            // getting email id
                            $clause = "WHERE email = '$email'";
                            selectData('emails', $clause);
                            $row = mysqli_fetch_assoc($selectData);
                            $email_id = $row['email_id'];

                            updateMultiData('users', 'user_id, user_firstname, user_lastname, user_email_id, username, user_password, user_role_id, user_image, user_status',
                            "$user_id, '$firstname', '$lastname', $email_id, '$username', '$password', '$role_id', '$image', '$status'");
                            
                            // Updating sessions
                            $_SESSION['user_image'] = $image;
                            $_SESSION['user_id'] = $user_id;
                            $_SESSION['user_firstname'] = $firstname;
                            $_SESSION['user_lastname'] = $lastname;
                            $_SESSION['user_email'] = $email;
                            $_SESSION['username'] = $username;
                            $_SESSION['user_image'] = $image;
                            $_SESSION['user_status'] = $status;
                           
                            header("Location: index.php");
                        }
                    } 
                ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php' ?>

    