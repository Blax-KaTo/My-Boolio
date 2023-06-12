<?php
session_start();
include('config.php');

// Fetch blog posts from the database
$blogQuery = "SELECT blog_posts.id, blog_posts.title, blog_posts.post_date, COUNT(post_views.id) AS total_views
              FROM blog_posts
              LEFT JOIN post_views ON blog_posts.id = post_views.post_id
              GROUP BY blog_posts.id
              ORDER BY blog_posts.post_date DESC";
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
            <?php while ($post = mysqli_fetch_assoc($blogResult)) { ?>
                <div class="blog-post">
                    <h2><?= $post['title'] ?></h2>
                    <p class="post-date">Posted on <?= $post['post_date'] ?></p>
                    <p class="total-views">Total Views: <?= $post['total_views'] ?></p>
                    <a href="view_post.php?id=<?= $post['id'] ?>" class="btn">View Post</a>
                </div>
            <?php } ?>
        <?php } ?>
        <a href="index.php" class="btn">Back</a>
    </div>

    <!-- Rest of the content... -->

    <script src="script/script.js"></script>
</body>
</html>
