<?php
session_start();

include('home-process.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Home</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="main-content">
        <div class="tooltip-cont">
            <?php if (isset($_SESSION['username'])) : ?>
                <p>Hey, <b><?php echo $_SESSION['username']; ?></b>.</p>
            <?php else : ?>
                <p style="font-size: 14px">You are not logged in. <a href="sign-in.php">Log In</a></p>
            <?php endif; ?>
            <div><button class="btn" id="tooltip-btn"><b>Tooltip.</b></button></div>
        </div>
        <div><hr></div>
        <div class="orders-cont">Weekly Orders: <b class="weekly-orders">128</b> </div>
        <div class="orders-cont">Monthly Orders: <b class="monthly-orders">924</b> </div>
        <div class="orders-cont">Orders from when we started: <b class="all-orders">8,742</b> </div>
        <div class="btn-cont">
            <a class="btn" href="myorders.php"><p>My Orders</p></a>
            <a class="btn" href="menu.php"><p>Make an <b>Order</b></p></a>
        </div>

        <footer><p><b>Vwok</b> CORP.</footer>
    </div>

    <div class="bg-pannel">
        <div class="pop-up">
            <div class="pop-up-header">
                <p>Tools</p>
                <div class="PH-btn-right" id="cancel-btn">
                    <title>Cancel</title>
                    <div class="h-icon-right">
                        <img title="Cancel" src="icons/3917189.png">
                    </div>
                </div>
            </div>
            <div class="pannel-cont">
                <div class="pannel">
                    <div class="pannel-btns" id="order-btn">
                        <div class="h-icon-center">
                            <p>Menu</p>
                        </div>
                    </div>
                    <div class="pannel-btns" id="post-btn">
                        <div class="h-icon-center">
                            <p>About</p>
                        </div>
                    </div>
                    <div class="pannel-btns" id="blog-btn">
                        <div class="h-icon-center">
                            <p>Blog</p>
                        </div>
                    </div>
                    <div class="pannel-btns" id="account-btn">
                        <div class="h-icon-center">
                            <p>Account</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer><p><b>Vwok</b> CORP.</footer>
    </div>

    <script src="script/script.js"></script>
</body>
</html>
