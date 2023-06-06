<?php
// Include your database connection file (e.g., config.php)
include('config.php');

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $productId = $_POST["product_id"];

    // Call the addIngredient function
    addIngredient($name, $productId);
}

// Function to add a new ingredient
function addIngredient($name, $productId) {
    global $conn;

    // Implement your database query to insert a new ingredient
    $query = "INSERT INTO ingredients (name, product_id) VALUES ('$name', '$productId')";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Get the ID of the newly inserted ingredient
        $ingredientId = $conn->insert_id;

        // Call a function to insert the ingredient into the product_ingredients table
        insertProductIngredient($productId, $ingredientId);

        // Redirect back to the admin_ingredients.php page
        header("Location: admin_ingredients.php");
        exit();
    } else {
        // Handle query error
        echo "Error adding ingredient: " . $conn->error;
    }
}

// Function to insert a product-ingredient relationship into the product_ingredients table
function insertProductIngredient($productId, $ingredientId) {
    global $conn;

    // Implement your database query to insert a new product-ingredient relationship
    $query = "INSERT INTO product_ingredients (product_id, ingredient_id) VALUES ('$productId', '$ingredientId')";

    // Execute the query
    if ($conn->query($query) !== TRUE) {
        // Handle query error
        echo "Error adding product-ingredient relationship: " . $conn->error;
    }
}

// Retrieve the list of products
function getProducts() {
    global $conn;

    // Implement your database query here to fetch products
    $query = "SELECT * FROM products";

    // Execute the query and return the results
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Fetch the results and return them as an array
        $products = $result->fetch_all(MYSQLI_ASSOC);
        return $products;
    } else {
        // Handle query error or no products found
        echo "Error retrieving products: " . $conn->error;
        return [];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Add Ingredient</title>
    <link rel="stylesheet" type="text/css" href="style/add_ingredient.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h2 class="admin-title">Add New Ingredient</h2>
        </div>

        <div class="ingredient-form">
            <form method="post" action="add_ingredient.php">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required>

                <label for="product">Product:</label>
                <select name="product_id" id="product" required>
                    <?php
                    // Retrieve the list of products
                    $products = getProducts();

                    // Loop through the products and display them as options
                    foreach ($products as $product) {
                        echo '<option value="' . $product['id'] . '">' . $product['name'] . '</option>';
                    }
                    ?>
                </select>

                <button type="submit" class="add-button">Add Ingredient</button>
            </form>
        </div>
    </div>

    <footer>
        <!-- Add your footer content here -->
    </footer>

    <script src="script/add_ingredient.js"></script>
</body>
</html>
