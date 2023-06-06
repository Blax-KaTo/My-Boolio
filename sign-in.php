<?php

include('sign-in-process.php');

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style/sign.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My Boolio | Sign In</title>
</head>
	<div class="main-content">
		<div class="form-cont">
			<h2>Sign In</h2>
			<form action="sign-in.php" method="POST">
				<label>
					Username/ Phone: <br>
					<input type="text" name="username" placeholder="MwapeCEO/ 0768..." value="<?= htmlspecialchars($username)?>">
					<p><i><?= htmlspecialchars($error["uname"]) ?></i></p>
				</label>

				<label>
					Password: <br>
					<input type="password" name="password" placeholder="***" value="<?= htmlspecialchars($password)?>">
					<p><i><?= htmlspecialchars($error["pass"]) ?></i></p>
				</label>
				<a href="welcome-page.php"><button type="button">Back</button></a>
				<button type="submit" name="submit">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>