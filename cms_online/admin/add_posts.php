<?php ob_start() ?>
<?php date_default_timezone_set('Africa/Algiers') ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>
<?php include 'includes/sidebar.php' ?>
<?php include '../includes/functions.php' ?>

<div id="layoutSidenav_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">Add Posts</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Add Posts</li>
                </ol>

                <?php
                if (isset($_POST['publish']) or isset($_POST['save'])) {

                    if (empty($_POST['author']) or empty($_POST['title']) or empty($_POST['content'])or empty($_POST['post_category_id']) or empty($_FILES['image']['name'])) {

                        echo '<h5 style="color:red">Post Submission Failed! Please Try Again</h5>';
                    } else {
                        foreach ($_POST as $key => $value) {
                                           
                            $_POST[$key] = mysqli_real_escape_string($connection, $value);
                        }
                        $title = $_POST['title'];
                        $category = $_POST['post_category_id'];
                        $author = $_POST['author'];
                        $content = $_POST['content'];
                        $date = date('Y-m-d h:i:s');

                        $image = ($_FILES['image']['name']);
                        $tmp_image = ($_FILES['image']['tmp_name']);
                        move_uploaded_file($tmp_image, "../images/$image");

                        if (isset($_POST['publish'])) {
                            $status = 'Published';
                        } else {
                            $status = 'Draft';
                        }

                        insertMultiData('posts','post_author, post_title, post_category_id, post_content, post_image, post_date ,post_status',
                        "'$author', '$title', '$category','$content', '$image', '$date', '$status'");
                        
                        header("Location: view_posts.php");
                    }
                }
                ?>

                <form action='' method='POST' enctype='multipart/form-data'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label for='title'>Title</label>
                            <input type='text' class='form-control' name='title' placeholder='Enter title'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='author'>Author</label>
                            <input type='text' class='form-control' name='author' placeholder='Enter author'>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category">Category</label>
                            <select class='custom-select mr-sm-2' name="post_category_id" id="">

                                <option value=''>Select Category</option>
                                <?php
                                
                                selectData('categories', '');
                                while ($row = mysqli_fetch_assoc($selectData)) {

                                    $category = $row['category'];
                                    $category_id = $row['category_id'];
                                ?>

                                    <option value='<?php echo $category_id ?>'><?php echo $category ?></option>

                                <?php } ?>

                            </select>
                        </div>
                        <div class='form-group col-md-6'>
                            <label for='image'>Image</label>
                            <input type='file' class='custom-newPost-file form-control-file' name='image'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='content'>Content</label>
                        <textarea type='text' class='form-control' name='content' id='' cols='30' rows='10' placeholder='Enter content'></textarea>
                    </div>
                    <div class='form-group'>
                        <input class='btn btn-primary' type='submit' name='publish' value='Publish Post'>
                        <input class='btn btn-outline-secondary' type='submit' name='save' value='Save Post'>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php' ?>