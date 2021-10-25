<?php ob_start() ?>
<?php date_default_timezone_set('Africa/Algiers'); ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>
<?php include 'includes/sidebar.php' ?>
<?php include '../includes/functions.php' ?>

<div id="layoutSidenav_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">Users</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">View Users</li>
                </ol>

                <?php
                
                if (isset($_GET['delete_id'])) :

                    $user_id = $_GET['delete_id'];
                ?>
                    <form action='' method='GET'>
                        <div class='form-group'>
                            <h3>Are you sure you want to delete this User Account?</h3>
                        </div>
                        <div class='form-group'>
                            <button class='btn btn-danger' type='submit' name='yes' value='<?php echo $user_id ?>'>Yes</button>
                            <input class='btn btn-info' type='submit' name='no' value="No">
                        </div>
                    </form>
                <?php endif ?>

                <?php
                if (isset($_GET['yes'])) {

                    $user_id = $_GET['yes'];
                    deleteData('users', 'user_id', $user_id);
                } else {
                };

                if (isset($_GET['edit_id'])) :

                    $user_id = $_GET['edit_id'];
                    $clause = "INNER JOIN roles ON role_id = user_role_id 
                    INNER JOIN emails ON email_id = user_email_id WHERE user_id = $user_id";
                    selectData('users',$clause);

                    while ($row = mysqli_fetch_assoc($selectData)) :

                        $user_id = $row['user_id'];
                        $edit_firstname = $row['user_firstname'];
                        $edit_lastname = $row['user_lastname'];
                        $edit_email = $row['email'];
                        $edit_username = $row['username'];
                        $edit_password = $row['user_password'];
                        $edit_image = $row['user_image'];
                        $edit_role_id = $row['role_id'];
                        $edit_role = $row['role'];
                        $edit_status = $row['user_status'];

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
                                <input type='password' class='form-control' name='user_password' value='<?php echo $edit_password ?>'>
                            </div>
                            <div class='form-group'>
                                <label for='confirm_password'>Confirm Password</label>
                                <input type='password' class='form-control' name='confirm_password' value='<?php echo $edit_password ?>'>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="user_role_id">Role</label><br><br><br>
                                    <select class="custom-select mr-sm-2" name="user_role_id">

                                        <option value='<?php echo $edit_role_id ?>' selected><?php echo $edit_role ?></option>

                                        <?php
                                        $clause ="WHERE role_id != $edit_role_id";
                                        selectData('roles', $clause);

                                        while ($row = mysqli_fetch_assoc($selectData)) {
                                            $role_id = $row['role_id'];
                                            $role = $row['role'];
                                        ?>
                                            <option value='<?php echo $role_id ?>'><?php echo $role ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for="edit_image">Picture</label>
                                    <div class="form-group">
                                        <div class="custom-editUser-img" name="edit_image" style="background-image: url(../images/<?php echo $edit_image ?>)"></div>
                                    </div>
                                    <div class="form-check" style="position: relative;left: 51px;">
                                        <input class="form-check-input" type="checkbox" id="default" name="default" value="Choose Default Picture">
                                        <label class="form-check-lable" for="default">Keep my picture</label>
                                    </div>
                                    <input type="file" class="custom-editUser-file form-control-file" name="user_image">
                                </div>
                            </div>
                            <div class='form-group'>
                                <input class='btn btn-primary' type='submit' name='update_account' value='Update Account'>
                            </div>
                        </form>
                    <?php endwhile ?>
                    <?php
                    if (isset($_POST['update_account'])) {
                        $user_id = $_GET['edit_id'];

                        if (empty($_POST['user_firstname']) or empty($_POST['user_lastname']) or empty($_POST['username']) or empty($_POST['user_password']) or empty($_POST['user_email'])or empty($_POST['user_role_id'])) {
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
                            $role_id = $_POST['user_role_id'];
                            $date = date('Y-m-d h:i:s');

                            if ($user_id == $_SESSION['user_id']) {
                                $status = 'Logged in';
                                
                            } elseif ($edit_status == 'Logged in') { 
                                $status = 'Logged in';
                            
                            } else {
                                $status = 'Logged out';
                            
                            }
                            // image set
                            if(!empty($_FILES['user_image']['name'])) {
                                $image = ($_FILES['user_image']['name']);
                                $tmp_image = ($_FILES['user_image']['tmp_name']);
                                move_uploaded_file($tmp_image, "../images/$image");

                            // default set
                            } elseif (isset($_POST['default'])) {
                                $image = $edit_image;
                            // no image no default
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
                            "$user_id, '$firstname', '$lastname', $email_id, '$username', '$password', $role_id, '$image', '$status'");

                            // Updating current user sessions
                            if ($user_id == $_SESSION['user_id']) {
                                // Updating sessions
                                $_SESSION['user_image'] = $image;
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['user_firstname'] = $firstname;
                                $_SESSION['user_lastname'] = $lastname;
                                $_SESSION['user_email'] = $email;
                                $_SESSION['username'] = $username;
                                $_SESSION['user_image'] = $image;
                                $_SESSION['user_role_id'] = $role_id;
                                $_SESSION['user_status'] = $status;
                                // Updating role session
                                $clause ="WHERE role_id = $role_id";
                                selectData('roles', $clause);
                                $row = mysqli_fetch_assoc($selectData);
                                $_SESSION['role'] = $row['role'];
                           
                            }

                            header("Location: view_users.php");
                        }
                    } 
                    ?>
                <?php else : ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width= 5%>Picture</th>
                                <th>Role</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $clause ="
                            INNER JOIN roles ON role_id = user_role_id 
                            INNER JOIN emails ON email_id = user_email_id ORDER BY role_id";
                            selectData('users', $clause);
                            while ($row = mysqli_fetch_assoc($selectData)) :

                                $user_id = $row['user_id'];
                                $username = $row['username'];
                                $firstname = $row['user_firstname'];
                                $lastname = $row['user_lastname'];
                                $email = $row['email'];
                                $role = $row['role'];
                                $image = $row['user_image'];
                                $status = $row['user_status'];
                            ?>
                                <tr>
                                    <td><div class="custom-viewUser-img" style="background-image: url(../images/<?php echo $image ?>)"></div></td>
                                    <td><?php echo $role ?></td>
                                    <td><?php echo $firstname ?></td>
                                    <td><?php echo $lastname ?></td>
                                    <td><?php echo $username ?></td>
                                    <td><?php echo $email ?></td>
                                    <td>
                                        <?php 
                                        if($status == 'Logged in'){
                                            echo '<span style="color: #02b702;">Logged in</span>';

                                        } else {
                                            echo '<span style="color: red;">Logged out</span>';
                                            
                                        }?>
                                    </td>
                                    <td><a href='view_users.php?edit_id=<?php echo $user_id ?>'><input type="button" class="btn btn-outline-info btn-sm" value="Edit"></a></td>
                                    <td><a href='view_users.php?delete_id=<?php echo $user_id ?>'><input type="button" class="btn btn-outline-danger btn-sm" value="Delete"></a></td>

                                    <!-- <?php if ($role == 'Approved') : ?>
                                        <td><a href="comments.php?status_id=unapprove&comment_id=<?php echo $comment_id ?>"><input type="button" class="btn btn-outline-secondary btn-sm" value="Unaprrove"></a></td>

                                    <?php else : ?>
                                        <td><a href="comments.php?status_id=approve&comment_id=<?php echo $comment_id ?>"><input type="button" class="btn btn-outline-success btn-sm" value="Approve"></a></td>

                                    <?php endif ?> -->
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                    <a href="add_users.php"><input type="button" class="btn btn-primary" name="unpublish" value="New User"></a>
                <?php endif ?>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php' ?>

    