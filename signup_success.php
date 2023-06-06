<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login-btn'])) {
        // Handle login
		header('Location: sign-in.php');
    }

    if (isset($_POST['try-btn'])) {
        // Redirect to the sign-up page
        header('Location: sign-up.php');
        exit();
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style/signup_success.css">
    <?php include("header.php"); ?>
</head>
<body>
	<div class="main-content">
		<h2>Sign Up</h2>
		<?php $loginBtn = ''; $tryBtn = ''; ?>
		<?php if (!empty($_SESSION['username'])) : ?>
			<p>You have <b>successfully</b> <i>created</i> your account with the username: <b><?= htmlspecialchars($_SESSION['username']) ?>.</b></p>
			<p>You can now log in using your username/phone and password.</p>
			<?php $loginBtn = "<form method='POST'><button name='login-btn'>Login</button></form>"; ?>
		<?php else : ?>
			<p>Your account registration was unsuccessful.</p>
			<?php $tryBtn = "<form method='POST'><button name='try-btn'>Try Again</button></form>"; ?>
		<?php endif; ?>
	</div>
	<div class="btn-cont">
		<?= $loginBtn ?>
		<?= $tryBtn ?>
	</div>
</body>
</html>