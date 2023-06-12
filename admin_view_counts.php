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

        // Fetch view counts for the selected post from the post_views table
        $viewCountsQuery = "SELECT users.username, COUNT(*) AS view_count
                            FROM post_views
                            INNER JOIN users ON post_views.user_id = users.user_id
                            WHERE post_views.post_id = $postId
                            GROUP BY post_views.user_id";
        $viewCountsResult = mysqli_query($conn, $viewCountsQuery);

        if (!$viewCountsResult) {
            $errorMessage = "Failed to fetch view counts.";
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
    <title>Admin | View Counts</title>
    <link rel="stylesheet" type="text/css" href="style/admin.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="admin-view-counts-page">
        <h1>Admin | View Counts</h1>
        <h2><?= $postTitle ?></h2>
        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?= $errorMessage ?></p>
        <?php } ?>
        <?php if (mysqli_num_rows($viewCountsResult) === 0) { ?>
            <p class="no-view-counts-message">No view counts available for this post.</p>
        <?php } else { ?>
            <table>
                <tr>
                    <th>Username</th>
                    <th>View Count</th>
                </tr>
                <?php while ($viewCount = mysqli_fetch_assoc($viewCountsResult)) { ?>
                    <tr>
                        <td><?= $viewCount['username'] ?></td>
                        <td><?= $viewCount['view_count'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
        <a href="admin_blog.php" class="btn">Back to Blog</a>
    </div>

    <!-- Rest of the content... -->

    <script src="script/script.js"></script>
</body>
</html>
