<?php
session_start();
include('config.php');

// Retrieve selected products and quantities from session
if (isset($_SESSION['selectedProducts']) && !empty($_SESSION['selectedProducts'])) {
    $selectedProducts = $_SESSION['selectedProducts'];
    $quantities = $_SESSION['quantities'];
} else {
    // Redirect to menu.php if no products are selected
    header("Location: menu.php");
    exit();
}

// Retrieve selected ingredients from session
if (isset($_SESSION['selectedIngredients'])) {
    $selectedIngredients = $_SESSION['selectedIngredients'];
} else {
    // Redirect to ingredient.php if no ingredients are selected
    header("Location: ingredient.php");
    exit();
}

// Retrieve product details from the database
$products = array();

foreach ($selectedProducts as $productId) {
    // Retrieve product details
    $productQuery = "SELECT * FROM products WHERE id = '$productId'";
    $productResult = mysqli_query($conn, $productQuery);
    $product = mysqli_fetch_assoc($productResult);

    // Retrieve the quantity for the product
    $quantity = $quantities[$productId];

    // Add product details to the array based on the quantity
    for ($i = 0; $i < $quantity; $i++) {
        $products[] = $product;
    }
}

// Process the order with selected products and ingredients
// ...

// Clear the session data
unset($_SESSION['selectedProducts']);
unset($_SESSION['quantities']);
unset($_SESSION['selectedIngredients']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Order</title>
    <link rel="stylesheet" type="text/css" href="style/order.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="main-content">
        <h1>Order</h1>

        <!-- Display the selected products and ingredients -->
        <?php foreach ($products as $key => $product) : ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="product-details">
                    <h3><?php echo $product['name']; ?></h3>
                    <p><?php echo $product['description']; ?></p>
                    <div class="product-ingredients">
                        <h4>Selected Ingredients:</h4>
                        <ul>
                            <?php foreach ($selectedIngredients[$key] as $ingredientId) {
                                // Retrieve ingredient details
                                $ingredientQuery = "SELECT * FROM ingredients WHERE id = '$ingredientId'";
                                $ingredientResult = mysqli_query($conn, $ingredientQuery);
                                $ingredient = mysqli_fetch_assoc($ingredientResult);
                                ?>
                                <li><?php echo $ingredient['name']; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="script/order.js"></script>
</body>
</html>
