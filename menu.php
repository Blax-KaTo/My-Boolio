<?php
session_start();
include('config.php');

// Retrieve the list of available products from the database
$productQuery = "SELECT * FROM products WHERE active = 1";
$productResult = mysqli_query($conn, $productQuery);
$products = mysqli_fetch_all($productResult, MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected products and quantities
    $selectedProducts = $_POST['selectedProducts'];
    $quantities = $_POST['quantities'];

    // Store the selected products and quantities in session variables
    $_SESSION['selectedProducts'] = $selectedProducts;
    $_SESSION['quantities'] = $quantities;

    // Redirect to the ingredient selection page
    header("Location: ingredient.php");
    exit();
}
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
        <form action="" method="post">
            <?php foreach ($products as $product) : ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-details">
                        <h3><?php echo $product['name']; ?></h3>
                        <p><?php echo $product['description']; ?></p>
                        <label for="quantity_<?php echo $product['id']; ?>">Quantity:</label>
                        <input type="number" name="quantities[<?php echo $product['id']; ?>]" id="quantity_<?php echo $product['id']; ?>" value="1" min="1">
                        <input type="checkbox" name="selectedProducts[]" value="<?php echo $product['id']; ?>">
                        Select
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit">Proceed to Ingredients</button>
        </form>
    </div>
    <script src="script/menu.js"></script>
</body>
</html>
