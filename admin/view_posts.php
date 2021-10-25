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
                <h1 class="mt-4">Posts</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">View Posts</li>
                </ol>

                <?php
                if (isset($_GET['delete_id'])) {

                    $post_id = $_GET['delete_id'];
                ?>

                    <form action='view_posts.php' method='GET'>
                        <div class='form-group'>
                            <h3>Are you sure you want to delete this post?</h3>
                        </div>
                        <div class='form-group'>
                            <button class='btn btn-danger' type='submit' name='yes' value='<?php echo $post_id ?>'>Yes</button>
                            <input class='btn btn-info' type='submit' name='no' value="No">
                        </div>
                    </form>
                <?php } ?>
                <?php
                if (isset($_GET['yes'])) {
                    $post_id = $_GET['yes'];
                    deleteData('posts', 'post_id', $post_id);

                } else {}
                
               
                if (isset($_GET['status_id'])) {
                    $status_id = $_GET['status_id'];
                    $post_id = $_GET['post_id'];
                    
                    switch ($status_id) {
                        case 'publish':
                            // Update status
                            $clause = "post_status = 'Published' WHERE post_id = $post_id";
                            updateOneData('posts', $clause);
                            // Update date
                            $date = date('Y-m-d H:i:s');
                            $clause = "post_date = '$date' WHERE post_id = $post_id";
                            updateOneData('posts', $clause);
                            break;         
                        case 'unpublish':
                            $clause = "post_status = 'Draft' WHERE post_id = $post_id";
                            updateOneData('posts', $clause);
                            break
                        ;
                    }
                }
                
                if (isset($_GET['edit_id'])) :
                    $post_id = $_GET['edit_id'];

                    $clause = "INNER JOIN categories ON category_id = post_category_id WHERE post_id = $post_id ORDER BY post_id DESC";
                    selectData('posts', $clause);

                    while ($row = mysqli_fetch_assoc($selectData)) :

                        $post_id = $row['post_id'];
                        $post_category_id = $row['post_category_id'];
                        $edit_title = $row['post_title'];
                        $edit_author = $row['post_author'];
                        $edit_content = $row['post_content'];
                        $edit_image = $row['post_image'];
                        $edit_status = $row['post_status'];
                        $edit_date = $row['post_date'];
                        $edit_category = $row['category'];
                        $edit_category_id = $row['category_id'];

                    ?>
            
                        <h4 class="custom-h4">Edit Post</h4>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo $edit_title ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="title">Author</label>
                                    <input type="text" class="form-control" name="author" value="<?php echo $edit_author ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="title">Category</label><br><br><br><br>
                                    <div class="form-group">
                                        <select class="custom-select mr-sm-2" name="post_category_id" id="category">
                                            <option value='<?php echo $edit_id ?>' selected><?php echo $edit_category ?></option>
                                            
                                            <?php
                                            $clause = "WHERE category != '$edit_category'";
                                            selectData('categories', $clause);
                                            while ($row = mysqli_fetch_assoc($selectData)) {
                                                $category = $row['category'];
                                                $category_id = $row['category_id'];
                                            ?>
                                                <option value='<?php echo $category_id ?>'><?php echo $category ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_image">Image</label><br>
                                    <div class="form-group">
                                        <div name="edit_image" class="custom-editPost-img rounded-sm" style="max-height: 62.5px; background-image: url(../images/<?php echo $edit_image ?>)"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="file" class="custom-editPost-file form-control-file " name="image">
                                    </div>
                                </div>
                            </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control" name="status" readonly value="<?php echo $edit_status ?>">
                                </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea type="text" class="form-control" name="content" id="" cols="30" rows="10"><?php echo $edit_content ?></textarea>
                            </div>
                            <div class="form-group">
                                <?php if ($edit_status == 'Published') { ?>

                                    <input class="btn btn-primary" type="submit" name="update" value="Update Post">
                                    <input class="btn btn-outline-secondary" type="submit" type="submit" name="save_edit" value="Save Post">
                                <?php } else { ?>

                                    <input class="btn btn-primary" type="submit" name="publish_edit" value="Publish Post">
                                    <input class="btn btn-outline-secondary" type="submit" name="save_edit" value="Save Post">
                                <?php } ?>
                            </div>
                        </form>
                    <?php endwhile ?>
                    <?php
                    if (isset($_POST['update']) or isset($_POST['save_edit']) or isset($_POST['publish_edit'])) {
                        $post_id = $_GET['edit_id'];
    
                        if (empty($_POST['author']) or empty($_POST['title']) or empty($_POST['content'])) {
    
                            echo "<h5 class='custom-h5'>Post Not Updated! Please Try Again.</h5>";
                        } else {
                            foreach ($_POST as $key => $value) {

                                $_POST[$key] = mysqli_real_escape_string($connection, $value);
                            }
                            $title = $_POST['title'];
                            $category_id = $_POST['post_category_id'];
                            $author = $_POST['author'];
                            $content = $_POST['content'];
                            
                            // if(isset($_POST['save_edit'])) {
                            //     $date = $edit_date;
                            // } else {
                            //     // $date = date('Y-m-d h:i:s');
                            // }
    
                            if (!empty($_FILES['image']['name'])) {
                                $image = ($_FILES['image']['name']);
                                $tmp_image = ($_FILES['image']['tmp_name']);
                                move_uploaded_file($tmp_image, "../images/$image");
    
                            } else {
                                $image = $edit_image;
                            } 
                            if (isset($_POST['publish_edit']) or isset($_POST['update'])) {
                                $status = 'Published';
    
                            } else {
                                $status = 'Draft';
                            }
    
                            updateMultiData('posts', 'post_id, post_category_id, post_title, post_author, post_content, post_image, post_status',
                            "$post_id, $post_category_id, '$title', '$author', '$content', '$image', '$status'");

                            header("Location: view_posts.php");
                        }
                    } 
                    ?>
                <?php else : ?>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Author</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $clause = "INNER JOIN categories ON category_id = post_category_id ORDER BY post_date DESC";
                            selectData('posts', $clause);
                            while ($row = mysqli_fetch_assoc($selectData)) :

                                $post_id = $row['post_id'];
                                $author = $row['post_author'];
                                $category_id = $row['category_id'];
                                $category = $row['category'];
                                $title = $row['post_title'];
                                $image = $row['post_image'];
                                $status = $row['post_status'];
                                $comments = $row['post_comments'];
                                $date = date_create($row['post_date']);

                            ?>
                                <tr>
                                    <td><?php echo $author ?></td>
                                    <td>
                                        <a href="../post.php?post_id=<?php echo $post_id ?>" target="_blank">
                                            <?php echo $title ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../index.php?id=<?php echo $category_id ?>" target="_blank">
                                            <?php echo $category ?>
                                        </a>
                                    </td>
                                    <td><div class="custom-viewPost-img rounded-sm" style="background-image: url(../images/<?php echo $image ?>)"></div></td>
                                    <td>
                                        <?php 
                                        if($status == 'Published'){
                                            echo '<span style="color: #02b702;">Published</span>';
                                            
                                        } else {
                                            echo '<span style="color: gray;">Draft</span>';
                                            
                                        }?>
                                    </td>
                                    <td><?php echo $comments ?></td>
                                    <td style="width: 10%"><?php echo date_format($date, 'd/m/Y h:i A') ?></td>
                                    <?php if ($status == 'Published') : ?>
                                        <td><a href="view_posts.php?status_id=unpublish&post_id=<?php echo $post_id ?>"><input type="button" class="btn btn-outline-secondary btn-sm" name="unpublish" value="Unpublish"></a></td>
                                    <?php else : ?>
                                        <td><a href="view_posts.php?status_id=publish&post_id=<?php echo $post_id ?>"><input type="button" class="btn btn-outline-success btn-sm" name="publish" value="Publish"></a></td>
                                    <?php endif ?>
                                    <td><a href='view_posts.php?edit_id=<?php echo $post_id ?>'><input type="button" class="btn btn-outline-info btn-sm" value="Edit"></a></td>
                                    <td><a href='view_posts.php?delete_id=<?php echo $post_id ?>'><input type="button" class="btn btn-outline-danger btn-sm" value="Delete"></a></td>

                                </tr>

                            <?php endwhile ?>
                        </tbody>
                    </table>
                    <form action="add_posts.php" method="POST">
                        <input type="submit" class="btn btn-primary" name="add_post" value="New Post">
                    </form>
                <?php endif ?>

            </div>
        </div>
    </div>

    <?php include 'includes/footer.php' ?>