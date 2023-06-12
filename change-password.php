<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header('Location: welcome-page.php');
    exit();
}

$username = $_SESSION['username'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Retrieve the current password from the database
    $passwordQuery = "SELECT password FROM users WHERE username = '$username'";
    $passwordResult = mysqli_query($conn, $passwordQuery);

    if ($passwordResult) {
        $passwordRow = mysqli_fetch_assoc($passwordResult);
        $storedPassword = $passwordRow['password'];

        // Verify the current password
        if (password_verify($currentPassword, $storedPassword)) {
            // Validate the new password
            if ($newPassword === $confirmPassword) {
                // Update the password in the database
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE username = '$username'";
                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {
                    $successMessage = "Password updated successfully.";
                    header('Location: account.php');
                } else {
                    $errorMessage = "Failed to update the password.";
                }
            } else {
                $errorMessage = "New password and confirm password do not match.";
            }
        } else {
            $errorMessage = "Current password is incorrect.";
        }
    } else {
        $errorMessage = "Failed to fetch the current password.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Change Password</title>
    <link rel="stylesheet" type="text/css" href="style/change-password.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="change-password-page">
        <h1>Change Password</h1>
        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?= $errorMessage ?></p>
        <?php } ?>
        <?php if (isset($successMessage)) { ?>
            <p class="success-message"><?= $successMessage ?></p>
        <?php } ?>
        <form method="POST">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit" class="btn">Change Password</button>
        </form>
        <a href="account.php" class="btn">Back to Account</a>
    </div>

    <!-- Rest of the content... -->

    <script src="script/script.js"></script>
</body>
</html>
