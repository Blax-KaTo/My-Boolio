<?php
session_start();
include('config.php');

if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    // Fetch post details from the blog_posts table
    $postQuery = "SELECT title FROM blog_posts WHERE id = $postId";
    $postResult = mysqli_query($conn, $postQuery);

    if ($postResult && mysqli_num_rows($postResult) > 0) {
        $post = mysqli_fetch_assoc($postResult);
        $postTitle = $post['title'];

        // Fetch comments for the selected post from the comments table
        $commentsQuery = "SELECT comments.comment, comments.comment_date, users.username
                          FROM comments
                          INNER JOIN users ON comments.user_id = users.user_id
                          WHERE comments.post_id = $postId
                          ORDER BY comments.comment_date DESC";
        $commentsResult = mysqli_query($conn, $commentsQuery);

        if (!$commentsResult) {
            $errorMessage = "Failed to fetch comments.";
        }
    } else {
        $errorMessage = "Invalid post ID.";
    }
} else {
    header("Location: admin_blog.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | View Comments</title>
    <link rel="stylesheet" type="text/css" href="style/admin.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="admin-view-comments-page">
        <h1>Admin | View Comments</h1>
        <h2><?= $postTitle ?></h2>
        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?= $errorMessage ?></p>
        <?php } ?>
        <?php if (mysqli_num_rows($commentsResult) === 0) { ?>
            <p class="no-comments-message">No comments available for this post.</p>
        <?php } else { ?>
            <ul class="comments-list">
                <?php while ($comment = mysqli_fetch_assoc($commentsResult)) { ?>
                    <li>
                        <p class="comment"><?= $comment['comment'] ?></p>
                        <p class="comment-info">Posted by <?= $comment['username'] ?> on <?= $comment['comment_date'] ?></p>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <a href="admin_blog.php" class="btn">Back to Blog</a>
    </div>

    <!-- Rest of the content... -->

    <script src="script/script.js"></script>
</body>
</html>
