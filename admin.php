<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Admin</title>
    <link rel="stylesheet" type="text/css" href="style/admin.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="admin_products.php">Products</a></li>
                <li><a href="#">Customers</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="#">Accounts</a></li> <!-- Added "Accounts" page -->
            </ul>
        </div>

        <div class="content">
            <h2>Welcome, User!</h2>
            <p>This is your dashboard. You can manage your orders, products, customers, and generate reports from here.</p>

            <div class="quote-section">
                <h3>Daily Motivation</h3>
                <form action="save_quote.php" method="POST">
                    <textarea name="quote" rows="4" cols="50" placeholder="Write a new quote"></textarea>
                    <br>
                    <button type="submit">Save Quote</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
