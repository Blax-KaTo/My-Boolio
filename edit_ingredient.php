<?php
// Include your database connection file (e.g., config.php)
include('config.php');

// Check if ingredient ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $ingredientId = $_GET['id'];

    // Retrieve the ingredient details from the database
    $ingredient = getIngredient($ingredientId);

    // Check if the ingredient exists
    if ($ingredient) {
        // Handle the form submission
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"];
            $productId = $_POST["product_id"];

            // Update the ingredient
            updateIngredient($ingredientId, $name, $productId);
        }
    } else {
        echo "Ingredient not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Function to retrieve the ingredient details from the database
function getIngredient($ingredientId)
{
    global $conn;

    // Implement your database query here to fetch the ingredient details
    $query = "SELECT * FROM ingredients WHERE id = $ingredientId";

    // Execute the query and return the result
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Function to update the ingredient details
function updateIngredient($ingredientId, $name, $productId)
{
    global $conn;

    // Implement your database query to update the ingredient
    $query = "UPDATE ingredients SET name = '$name', product_id = '$productId' WHERE id = $ingredientId";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Redirect back to the admin_ingredients.php page
        header("Location: admin_ingredients.php");
        exit();
    } else {
        // Handle query error
        echo "Error updating ingredient: " . $conn->error;
    }

    // Update the product_ingredients table as well
    $updateProductQuery = "UPDATE product_ingredients SET product_id = '$productId' WHERE ingredient_id = $ingredientId";
    if ($conn->query($updateProductQuery) === FALSE) {
        // Handle query error
        echo "Error updating product ID in product_ingredients table: " . $conn->error;
    }
}




// Retrieve the list of products
function getProducts()
{
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
    <title>My Boolio | Edit Ingredient</title>
    <link rel="stylesheet" type="text/css" href="style/edit_ingredient.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="admin-header">
        <h2 class="admin-title">Edit Ingredient</h2>
    </div>

    <div class="ingredient-form">
        <form method="post" action="edit_ingredient.php?id=<?php echo $ingredientId; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $ingredient['name']; ?>" required>

            <label for="product">Product:</label>
            <select name="product_id" id="product" required>
                <?php
                // Retrieve the list of products
                $products = getProducts();

                // Loop through the products and display them as options
                foreach ($products as $product) {
                    $selected = ($product['id'] == $ingredient['product_id']) ? 'selected' : '';
                    echo '<option value="' . $product['id'] . '" ' . $selected . '>' . $product['name'] . '</option>';
                }
                ?>
            </select>

            <button type="submit" class="update-button">Update Ingredient</button>
        </form>
    </div>

    <footer>
        <!-- Add your footer content here -->
    </footer>

    <script src="script/edit_ingredient.js"></script>
</body>
</html>
