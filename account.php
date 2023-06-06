<?php
session_start();

if (isset($_SESSION['username'])) {
    $displayUsername = '<p>Username: ' . $_SESSION["username"] . '</p>';
    $logoutBtn = '<button name="logout" class="btn">Logout</button>';
} else {
    $displayError = "You are currently logged out!";
    $goToWelcomeBtn = '<a href="welcome-page.php" class="btn">Go To Welcome Page</a>';
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: welcome-page.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Account</title>
    <link rel="stylesheet" type="text/css" href="style/account.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="account-page">
        <h1>Welcome to Your Account Page</h1>
        <?= $displayUsername ?? '' ?>
        <?= $displayError ?? '' ?><br><br>
        <form method="POST">
            <a href="index.php" class="btn">Back</a>
            <?= $logoutBtn ?? '' ?>
            <?= $goToWelcomeBtn ?? '' ?>
        </form>
    </div>

    <!-- Rest of the content... -->

    <script src="script/script.js"></script>
</body>
</html>