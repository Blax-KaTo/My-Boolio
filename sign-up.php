<?php

include("sign-up-process.php");

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header('Location: index.php');
	// echo "You have alreaady logged in. To log in with another account you should first log out.";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style/sign.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My Boolio | Sign Up</title>
</head>
	<div class="main-content">
		<div class="form-cont">
			<h2>Sign Up</h2>
			<form action="sign-up.php" method="POST">
				<label>
					First Name: <br>
					<input type="text" name="firstname" placeholder="Mwape" value="<?= htmlspecialchars($firstname)?>">
					<p><i><?= $error["fname"] ?></i></p>
				</label>
				<label>
					Last Name: <br>
					<input type="text" name="lastname" placeholder="Chisala" value="<?= htmlspecialchars($lastname)?>">
					<p><i><?= $error["lname"] ?></i></p>
				</label>
				<label>
					Username: <br>
					<input type="text" name="username" placeholder="MwapeCEO" value="<?= htmlspecialchars($username)?>">
					<p><i><?= $error["uname"] ?></i></p>
				</label>
				<label>
					Phone: <br>
					<input type="phone" name="phone" placeholder="0768..." value="<?= htmlspecialchars($phone)?>">
					<p><i><?= $error["phon"] ?><i></p>
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