<?php
session_start();
include('config.php');

// Check if the post ID is provided in the URL
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Fetch the blog post from the database
    $postQuery = "SELECT * FROM blog_posts WHERE id = $postId";
    $postResult = mysqli_query($conn, $postQuery);

    if ($postResult) {
        $post = mysqli_fetch_assoc($postResult);

        // Increment the total views for the post
        $incrementViewsQuery = "UPDATE blog_posts SET total_views = total_views + 1 WHERE id = $postId";
        mysqli_query($conn, $incrementViewsQuery);

        // Check if the viewer has already viewed the post
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $checkViewQuery = "SELECT id, view_count FROM post_views WHERE post_id = $postId AND user_id = $userId";
            $checkViewResult = mysqli_query($conn, $checkViewQuery);

            if ($checkViewResult && mysqli_num_rows($checkViewResult) > 0) {
                // The viewer has already viewed the post, update the view count
                $viewData = mysqli_fetch_assoc($checkViewResult);
                $viewId = $viewData['id'];
                $viewCount = $viewData['view_count'];

                $updateViewQuery = "UPDATE post_views SET view_count = view_count + 1 WHERE id = $viewId";
                mysqli_query($conn, $updateViewQuery);
            } else {
                // The viewer is viewing the post for the first time, insert a new view record
                $insertViewQuery = "INSERT INTO post_views (post_id, user_id) VALUES ($postId, $userId)";
                mysqli_query($conn, $insertViewQuery);
            }
        }
    } else {
        $errorMessage = "Failed to fetch the blog post.";
    }
} else {
    header("Location: blog.php");
    exit();
}

// Check if the comment form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $comment = $_POST['comment'];

        $insertCommentQuery = "INSERT INTO comments (post_id, user_id, comment) VALUES ($postId, $userId, '$comment')";
        $insertCommentResult = mysqli_query($conn, $insertCommentQuery);

        if ($insertCommentResult) {
            $successMessage = "Comment added successfully.";
        } else {
            $errorMessage = "Failed to add the comment.";
        }
    } else {
        $errorMessage = "You must be logged in to add a comment.";
    }
}

// Fetch comments for the post from the database
$commentsQuery = "SELECT comments.comment, comments.comment_date, users.username
                  FROM comments
                  INNER JOIN users ON comments.user_id = users.user_id
                  WHERE comments.post_id = $postId
                  ORDER BY comments.comment_date DESC";
$commentsResult = mysqli_query($conn, $commentsQuery);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | View Post</title>
    <link rel="stylesheet" type="text/css" href="style/view-post.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="view-post-page">
        <div class="post">
            <h1><?= $post['title'] ?></h1>
            <p class="post-date"><?= $post['post_date'] ?></p>
            <p class="post-content"><?= $post['content'] ?></p>
        </div>

        <h2>Comments</h2>
        <?php if (mysqli_num_rows($commentsResult) === 0) { ?>
            <p class="no-comments-message">No comments available.</p>
        <?php } else { ?>
            <?php while ($comment = mysqli_fetch_assoc($commentsResult)) { ?>
                <div class="comment">
                    <p class="comment-date"><?= $comment['comment_date'] ?></p>
                    <p class="comment-author"><?= $comment['username'] ?></p>
                    <p class="comment-content"><?= $comment['comment'] ?></p>
                </div>
            <?php } ?>
        <?php } ?>

        <h2>Add a Comment</h2>
        <?php if (isset($_SESSION['user_id'])) { ?>
            <?php if (isset($errorMessage)) { ?>
                <p class="error-message"><?= $errorMessage ?></p>
            <?php } ?>
            <?php if (isset($successMessage)) { ?>
                <p class="success-message"><?= $successMessage ?></p>
            <?php } ?>
            <form method="POST">
                <textarea name="comment" placeholder="Enter your comment" required></textarea>
                <button type="submit" class="btn">Add Comment</button>
            </form>
        <?php } else { ?>
            <p class="comment-login-message">Please <a href="login.php">login</a> to add a comment.</p>
        <?php } ?>

        <a href="blog.php" class="btn">Back to Blog</a>
    </div>

    <!-- Rest of the content... -->

    <script src="script/script.js"></script>
</body>
</html>
