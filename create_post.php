<?php
session_start();
include('config.php');

// // Check if the user is logged in and is an admin
// if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.php');
//     exit();
// }

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Prepare the INSERT statement using a prepared statement
    $insertQuery = "INSERT INTO blog_posts (title, content, post_date) VALUES (?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $insertQuery);

    // Bind the parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, 'ss', $title, $content);

    // Execute the prepared statement
    $insertResult = mysqli_stmt_execute($stmt);

    if ($insertResult) {
        $successMessage = "Blog post created successfully.";
        $title = '';
        $content = '';
    } else {
        $errorMessage = "Failed to create the blog post: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Post | My Boolio</title>
    <link rel="stylesheet" type="text/css" href="style/create-post.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="create-post-page">
        <h1>Create New Post</h1>
        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?= $errorMessage ?></p>
        <?php } ?>
        <?php if (isset($successMessage)) { ?>
            <p class="success-message"><?= $successMessage ?></p>
        <?php } ?>
        <form method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?= $title ?? '' ?>" required>
            <label for="content">Content</label>
            <textarea id="content" name="content" required><?= $content ?? '' ?></textarea>
            <button type="submit" class="btn">Create Post</button>
        </form>
        <a href="admin_blog.php" class="btn">Back to Admin Blog</a>
    </div>

    <!-- Rest of the content... -->

    <script src="script/script.js"></script>
</body>
</html>
