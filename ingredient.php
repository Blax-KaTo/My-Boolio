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

// Process the ingredient selection and redirect to order.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selected ingredients for each product
    $selectedIngredients = array();

    foreach ($selectedProducts as $productId) {
        $productIngredients = $_POST['selectedIngredients'][$productId];
        $selectedIngredients[$productId] = $productIngredients;
    }

    // Store the selected ingredients in the session
    $_SESSION['selectedIngredients'] = $selectedIngredients;

    // Redirect to order.php
    header("Location: order.php");
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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Ingredients</title>
    <link rel="stylesheet" type="text/css" href="style/ingredient.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="main-content">
        <h1>Ingredients</h1>

        <!-- Display the products and their ingredients -->
        <form action="" method="post">
            <?php foreach ($products as $key => $product) : ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-details">
                        <h3><?php echo $product['name']; ?></h3>
                        <p><?php echo $product['description']; ?></p>
                        <!-- Retrieve ingredients for the product -->
                        <?php
                        $ingredientQuery = "SELECT i.id, i.name FROM product_ingredients pi INNER JOIN ingredients i ON pi.ingredient_id = i.id WHERE pi.product_id = '{$product['id']}'";
                        $ingredientResult = mysqli_query($conn, $ingredientQuery);
                        while ($ingredient = mysqli_fetch_assoc($ingredientResult)) {
                            ?>
                            <input type="checkbox" name="selectedIngredients[<?php echo $product['id']; ?>][]" value="<?php echo $ingredient['id']; ?>">
                            <?php echo $ingredient['name']; ?>
                            <br>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <button type="submit">Proceed to Order</button>
        </form>
    </div>
    <script src="script/ingredient.js"></script>
</body>
</html>
