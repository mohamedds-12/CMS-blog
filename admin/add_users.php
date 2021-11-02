<?php ob_start() ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>
<?php include 'includes/sidebar.php' ?>
<?php include '../includes/functions.php' ?>

<div id="layoutSidenav_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">Add Users</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Users</li>
                </ol>

                <?php
                if (isset($_POST['create_account'])) {
                    if (empty($_POST['user_firstname']) or empty($_POST['user_lastname']) or empty($_POST['username']) or empty($_POST['user_password']) or empty($_POST['user_email'])or empty($_POST['user_role_id'])) {
                        // check empty fields
                        echo "<h5 style='color:red'>Account submission failed! Please try again</h5>";

                    } elseif($_POST['user_password'] !== $_POST['confirm_password']) {
                        // check password matching
                        echo "<h5 style='color:red'>Password doesn't match! Please try again.</h5>";

                    } else {
                        // insert data to db
                        foreach ($_POST as $key => $value) {
                                           
                            $_POST[$key] = mysqli_real_escape_string($connection, $value);
                        }
                        $firstname = $_POST['user_firstname'];
                        $lastname = $_POST['user_lastname'];
                        $email = $_POST['user_email'];
                        $password = $_POST['user_password'];
                        $username = $_POST['username'];
                        $role_id = $_POST['user_role_id'];

                        if(!empty($_FILES['user_image']['name'])) {
                            $image = ($_FILES['user_image']['name']);
                            $tmp_image = ($_FILES['user_image']['tmp_name']);
                            move_uploaded_file($tmp_image, "../images/$image");
                        } else {
                            switch($role_id) {
                                case '1':
                                    $image = 'administrator.png';
                                    break;

                                case '2':
                                    $image = 'content_manager.png';
                                    break;

                                case '3':
                                    $image = 'content_editor.png';
                                    break;

                                case '4':
                                    $image = 'subscriber.png';
                                break;
                            }
                        }

                        // insert email, get it's id
                        insertOneData('emails', 'email', $email);
                        $clause = "WHERE email = '$email'";
                        selectData('emails', $clause);
                        $row = mysqli_fetch_assoc($selectData);
                        $email_id = $row['email_id'];

                        insertMultiData('users','user_firstname, user_lastname, user_email_id, user_password, username, user_role_id, user_image',
                        "'$firstname', '$lastname', $email_id,'$password', '$username', '$role_id', '$image'");

                        header("Location: view_users.php");
                    }
                }

                ?>

                <form action='' method='POST' enctype='multipart/form-data'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label for='user_firstname'>First Name</label>
                            <input type='text' class='form-control' name='user_firstname' placeholder='Enter first name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='user_lastname'>Last Name</label>
                            <input type='text' class='form-control' name='user_lastname' placeholder='Enter last name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='user_email'>Email</label>
                            <input type='email' class='form-control' name='user_email' placeholder='Enter email'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Enter username">
                        </div>  
                        </div>
                        <div class='form-group'>
                            <label for='password'>Password</label>
                            <input type='password' class='form-control' name='user_password' placeholder='Enter password'>
                        </div>
                        <div class='form-group'>
                            <label for='password'>Confirm Password</label>
                            <input type='password' class='form-control' name='confirm_password' placeholder='Confirm password'>
                        </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="role">Role</label>
                            <select class='custom-select mr-sm-2' name="user_role_id" id="">
                                <option value=''>Select Role</option>
                                <?php
                                $clause ="ORDER BY role_id ASC";
                                selectData('roles', $clause);
                                while ($row = mysqli_fetch_assoc($selectData)) {

                                    $role = $row['role'];
                                    $role_id = $row['role_id'];
                                ?>

                                    <option value='<?php echo $role_id ?>'><?php echo $role ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='image'>Picture</label><br>
                            <input type='file' class='custom-newUser-file form-control-file' name='user_image'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <input class='btn btn-primary' type='submit' name='create_account' value='Create Account'>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php' ?>