<?php date_default_timezone_set('Africa/Algiers'); ?>
<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>
<?php include 'includes/sidebar.php' ?>
<?php include '../includes/functions.php' ?>

<div id="layoutSidenav_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mt-4">Comments</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Comments</li>
                </ol>

                <?php
                if (isset($_GET['status_id'])) {
                    $status_id = $_GET['status_id'];
                    $comment_id = $_GET['comment_id'];

                    switch ($status_id) {
                        case 'approve':
                            // Updating comment status
                            $clause = "comment_status = 'Approved' WHERE comment_id = $comment_id";
                            updateOneData('comments', $clause);
                            // Updating comment date
                            $date = date('Y-m-d H:i:s');
                            $clause = "comment_date = '$date' WHERE comment_id = $comment_id";
                            updateOneData('comments', $clause);
                            /*----------- Increasing comment count on table posts -----------*/
                            // selecting post id
                            $clause ="WHERE comment_id = $comment_id ORDER BY comment_id DESC";
                            selectData('comments', $clause);
                            $row = mysqli_fetch_assoc($selectData);
                            $comment_post_id = $row['comment_post_id'];
                            // increasing comments count
                            $clause = "post_comments = post_comments + 1 WHERE post_id = $comment_post_id";
                            updateOneData('posts', $clause);
                        break;
                        case 'unapprove':
                            $clause = "comment_status = 'Unapproved' WHERE comment_id = $comment_id";
                            updateOneData('comments', $clause);
                            /*----------- Decreasing comment count on table posts ----------*/
                            // Selecting post id
                            $clause ="WHERE comment_id = $comment_id ORDER BY comment_id DESC";
                            selectData('comments', $clause);
                            $row = mysqli_fetch_assoc($selectData);
                            $comment_post_id = $row['comment_post_id'];
                            // Decreasing comment count
                            $clause = "post_comments = post_comments -1 WHERE post_id = $comment_post_id";
                            updateOneData('posts', $clause);
                        break
                        ;
                    }
                }

                if (isset($_GET['delete_id'])) {
                    $comment_id = $_GET['delete_id'];

                    ?>
                    <form action='comments.php' method='GET'>
                        <div class='form-group'>
                            <h3>Are you sure you want to delete this comment?</h3>
                        </div>
                        <div class='form-group'>
                            <button class='btn btn-danger' type='submit' name='yes' value='<?php echo $comment_id ?>'>Yes</button>
                            <input class='btn btn-info' type='submit' name='no' value="No">
                        </div>
                    </form>
                <?php } ?>

                <?php
                /* Delete comment, decrease comment count */
                if (isset($_GET['yes'])) {
                    $comment_id = $_GET['yes'];

                    // Selecting post id
                    $clause ="WHERE comment_id = $comment_id ORDER BY comment_id DESC";
                    selectData('comments', $clause);
                    $row = mysqli_fetch_assoc($selectData);
                    $comment_post_id = $row['comment_post_id'];
                    // Decreasing comment count
                    $clause = "post_comments = post_comments -1 WHERE post_id = $comment_post_id";
                    updateOneData('posts', $clause);

                    // Deleting comment
                    deleteData('comments', 'comment_id', $comment_id);
                } 
                ?>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Author Role</th>
                            <th>Author</th>
                            <th>Comment</th>
                            <th style="width: 10%;">Post</th>
                            <th>Status</th>
                            <th style="width: 10%;">Date</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $clause = "INNER JOIN posts ON post_id = comment_post_id 
                        INNER JOIN roles ON role_id = comment_user_role_id
                        INNER JOIN emails ON email_id = comment_email_id
                        ORDER BY comment_date DESC";
                        selectData('comments', $clause);
                        while ($row = mysqli_fetch_assoc($selectData)) {

                            $comment_id = $row['comment_id'];
                            $author_role = $row['role'];
                            $author = $row['comment_author'];
                            $content = $row['comment_content'];
                            $email_id = $row['comment_email_id'];
                            $post_id = $row['comment_post_id'];
                            $status = $row['comment_status'];
                            $date = date_create($row['comment_date']);
                            $post_title = $row['post_title'];

                        ?>
                            <tr>
                                <td><?php echo $author_role ?></td>
                                <td><?php echo $author ?></td>
                                <td><?php echo $content ?></td>
                                <td>
                                    <a href="../post.php?post_id=<?php echo $post_id ?>" target="_blank">
                                        <?php echo $post_title; ?>
                                    </a>
                                </td>
                                <td>
                                    <?php 
                                    if($status == 'Approved'){
                                        echo '<span style="color: #02b702;">Approved</span>';
                                    } else {
                                        echo '<span style="color: gray;">Unapproved</span>';
                                        
                                    }?>
                                </td>
                                <td><?php echo date_format($date,"d/m/Y h:i A") ?></td>
                                <?php if ($status == 'Approved') { ?>
                                    <td><a href="comments.php?status_id=unapprove&comment_id=<?php echo $comment_id ?>"><input type="button" class="btn btn-outline-secondary btn-sm" value="Unaprrove"></a></td>

                                <?php } else { ?>
                                    <td><a href="comments.php?status_id=approve&comment_id=<?php echo $comment_id ?>"><input type="button" class="btn btn-outline-success btn-sm" value="Approve"></a></td>

                                <?php } ?>
                                <td><a href='comments.php?delete_id=<?php echo $comment_id ?>'><input type="button" class="btn btn-outline-danger btn-sm" name="delete" value="Delete"></a></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php' ?>