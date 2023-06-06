<?php
session_start();
include('config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve selected products and quantities
    if (isset($_POST['selectedProducts'])) {
        $selectedProducts = $_POST['selectedProducts'];
        $quantities = $_POST['quantity'];

        // Store the selected products and quantities in session
        $_SESSION['selectedProducts'] = $selectedProducts;
        $_SESSION['quantities'] = $quantities;

        // Redirect to ingredient.php
        header("Location: ingredient.php");
        exit();
    }
}

// Retrieve all products from the database
$productQuery = "SELECT * FROM products";
$productResult = mysqli_query($conn, $productQuery);
$products = mysqli_fetch_all($productResult, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Menu</title>
    <link rel="stylesheet" type="text/css" href="style/menu.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="main-content">
        <h1>Menu</h1>

        <!-- Display the products and quantity form -->
<form action="menu.php" method="post">
    <?php foreach ($products as $product) : ?>
        <div>
            <input type="checkbox" name="selectedProducts[]" value="<?php echo $product['id']; ?>">
            <?php echo $product['name']; ?>
            <input type="number" name="quantity[<?php echo $product['id']; ?>]" min="1" value="1">
        </div>
    <?php endforeach; ?>
    <button type="submit">Submit</button>
</form>

        <footer><p><b>Vwok</b> CORP.</p></footer>
    </div>

    <script src="script/menu.js"></script>
</body>
</html>