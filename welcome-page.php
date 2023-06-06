<?php

session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style/welcome.css">
	<?php include("header.php"); ?>
	<div class="main-content">
		<div class="text-content">
			<p>Welcome to <i>My</i> <b>Boolio</b>,</p>
			<p>a <b>food</b> website.</p>
			<p>Owned by a little <i>girl</i>.</p>
		</div>
		<div class="btn-cont">
			<button id="get-started-btn">Get Started_</button>
		</div>
		<p style="color: #ccc"><i>a <b>Vwok</b> CORP product.</i></p>
	</div>
	<div class="pop-up">
	</div>
	<div class="modal-content">
			<button id="sign-up-btn">Sign Up</button>
			<button id="sign-in-btn">Sign In</button>
		</div>
	<script>
		var getStartedBtn = document.querySelector("#get-started-btn");
		var popUp = document.querySelector(".pop-up");
		var modal = document.querySelector(".modal-content");
		var btn1 = document.querySelector("#sign-up-btn");
		var btn2 = document.querySelector("#sign-in-btn");

		getStartedBtn.addEventListener("click", function() {
			popUp.style.display = "block";
			modal.style.display = "flex";

			popUp.addEventListener("click", function() {
				popUp.style.display = "none";
				modal.style.display = "none";
			});
		});

		btn1.addEventListener("click", function() {
			window.location = "sign-up.php";
		});

		btn2.addEventListener("click", function() {
			window.location = "sign-in.php";
		});

	</script>
</body>
</html>