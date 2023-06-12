<?php
session_start();
include('config.php');

// Fetch blog posts from the database
$blogQuery = "SELECT id, title, post_date, total_views FROM blog_posts ORDER BY post_date DESC";
$blogResult = mysqli_query($conn, $blogQuery);

if (!$blogResult) {
    $errorMessage = "Failed to fetch blog posts.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Blog</title>
    <link rel="stylesheet" type="text/css" href="style/blog.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="blog-page">
        <h1>Blog</h1>
        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?= $errorMessage ?></p>
        <?php } ?>
        <?php if (mysqli_num_rows($blogResult) === 0) { ?>
            <p class="no-posts-message">No posts available.</p>
        <?php } else { ?>
            <?php while ($post = mysqli_fetch_assoc($blogResult)) {
                // Get total comments for the post from the comments table
                $postId = $post['id'];
                $commentsQuery = "SELECT COUNT(*) AS total_comments FROM comments WHERE post_id = $postId";
                $commentsResult = mysqli_query($conn, $commentsQuery);
                $commentsData = mysqli_fetch_assoc($commentsResult);
                $totalComments = $commentsData['total_comments'];

                // Get unique views for the post from the post_views table
                $viewsQuery = "SELECT COUNT(DISTINCT user_id) AS unique_views FROM post_views WHERE post_id = $postId";
                $viewsResult = mysqli_query($conn, $viewsQuery);
                $viewsData = mysqli_fetch_assoc($viewsResult);
                $uniqueViews = $viewsData['unique_views'];
            ?>
                <div class="blog-post">
                    <h2><?= $post['title'] ?></h2>
                    <p class="post-date">Posted on <?= $post['post_date'] ?></p>
                    <p class="total-views">Total Views: <?= $post['total_views'] ?></p>
                    <p class="total-comments">Total Comments: <?= $totalComments ?></p>
                    <p class="unique-views">Unique Views: <?= $uniqueViews ?></p>
                    <a href="admin_view_counts.php?post_id=<?= $post['id'] ?>" class="btn">View Counts</a>
                    <a href="admin_view_comments.php?post_id=<?= $post['id'] ?>" class="btn">View Comments</a>
                </div>
            <?php } ?>
        <?php } ?>
        <a href="index.php" class="btn">Back</a>
    </div>

    <!-- Rest of the content... -->

    <script src="script/script.js"></script>
</body>
</html>
