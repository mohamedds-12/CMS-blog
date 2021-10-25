<?php ob_start() ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>
<?php include 'includes/sidebar.php' ?>
<?php include '../includes/functions.php' ?>

<div id="layoutSidenav_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">Categories</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Categories</li>
                </ol>
            </div>

            <div class="col-sm-6">

                <?php if (isset($_POST['new_category'])) { ?>

                    <form action='' method='POST'>
                        <div class='form-group'>
                            <label for='category'>Category</label>
                            <input type='text' class='form-control' name='category' placeholder="Enter Catagory">
                        </div>
                        <div class='form-group'>
                            <input class='btn btn-outline-info' type='submit' name='submit' value='Add Category'>
                        </div>
                    </form>

                <?php } elseif (isset($_GET['edit_id'])) {

                    $category_id = $_GET['edit_id'];
                    $clause ="WHERE category_id = $category_id";
                    selectData('categories', $clause);

                    while ($row = mysqli_fetch_assoc($selectData)) {
                        $category = $row['category'];

                    ?>
                        <form action='' method='POST'>
                            <div class='form-group'>
                                <label for='category'>Edit Category</label>
                                <input type='text' class='form-control' name='category' value='<?php echo $category ?>'>
                            </div>
                            <div class='form-group'>
                                <input class='btn btn-outline-info' type='submit' name='update' value='Update Category'>
                            </div>
                        </form>

                    <?php } ?>

                    <?php 
                    if (isset($_POST['update'])) {
                        if (!empty($_POST['category'])) {
                            foreach ($_POST as $key => $value) {
                                            
                                $_POST[$key] = mysqli_real_escape_string($connection, $value);
                            }
                            $category = $_POST['category'];
                            $clause ="category = '$category' where category_id = $category_id";
                            updateOneData('categories', $clause);

                            header("location: categories.php");

                        } else { 
                            echo '<h5 style="color:red;">Category submission failed! Please Try Again.</h5>';
                        }
                    }
                } elseif (isset($_GET['delete_id'])) {

                    $category_id = $_GET['delete_id'];
                    $clause ="WHERE post_id = $category_id";
                    selectData('posts', $clause);

                    $row = mysqli_fetch_assoc($selectData);
                    if (!empty($row)) {
                        echo '<h5 style="color:red;">Category Containes Posts! Please Try Again.</h5>';
                    } else {

                    ?>
                        <form action='categories.php' method='GET'>
                            <div class='form-group'>
                                <h4>Are you sure you want to delete this Category?</h4>
                            </div>
                            <div class='form-group'>
                                <button class='btn btn-danger' type='submit' name='yes' value='<?php echo $category_id ?>'>Yes</button>
                                <input class='btn btn-info' type='submit' name='no' value="No">
                            </div>
                        </form>

                    <?php } ?>
                <?php } ?>

                <?php
                if (isset($_POST['submit'])) {
                    if (!empty($_POST['category'])) {
                        foreach ($_POST as $key => $value) {
                                           
                            $_POST[$key] = mysqli_real_escape_string($connection, $value);
                        }
                        $category = $_POST['category'];
                        insertOneData('categories', 'category', $category);
                        header("location: categories.php");
                    } else {
                        echo '<h5 style="color:red">Category Submission Failed! Please Try Again.</h5>';
                    }
                }
                if (isset($_GET['yes'])) {

                    $category_id = $_GET['yes'];
                    deleteData('categories', 'category_id', $category_id);
                } elseif (isset($_GET['no'])) {
                };

                ?>
            </div>

            <div class="col-sm-6">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $clause ="ORDER BY category_id ASC";
                        selectData('categories', $clause);
                        while ($row = mysqli_fetch_assoc($selectData)) {

                            $category_id = $row['category_id'];
                            $category = $row['category'];
                        ?>
                            <tr>
                                <td style="width: 30%"><?php echo $category ?></td>
                                <td style="width: 10%"><a href='categories.php?edit_id=<?php echo $category_id ?>'><input type="button" class="btn btn-outline-info btn-sm " name="edit" value="Edit"></a></td>
                                <td style="width: 10%"><a href='categories.php?delete_id=<?php echo $category_id ?>'><input type="button" class="btn btn-outline-danger btn-sm" name="delete" value="Delete"></a></td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
                <form action="" method="POST">
                    <input type="submit" class="btn btn-primary" value="New Category" name="new_category">
                </form>
            </div>

        </div>
    </div>

    <?php include 'includes/footer.php' ?>