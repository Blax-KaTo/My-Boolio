<?php
// Include your database connection file (e.g., config.php)
include('config.php');

// Check if the product_id parameter is set
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Retrieve the ingredients for the specified product
    $ingredients = getProductIngredients($productId);

    // Return the ingredients as JSON response
    echo json_encode($ingredients);
} else {
    // Return an error response if product_id parameter is missing
    echo "Error: Missing product_id parameter.";
}

// Retrieve the ingredients for a specific product from the database
function getProductIngredients($productId)
{
    global $conn;

    // Implement your database query here to fetch ingredients for the specified product
    $query = "SELECT ingredients.* FROM ingredients
              JOIN product_ingredients ON ingredients.id = product_ingredients.ingredient_id
              WHERE product_ingredients.product_id = $productId";

    // Execute the query and return the results
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Fetch the results and return them as an array
        $ingredients = $result->fetch_all(MYSQLI_ASSOC);
        return $ingredients;
    } else {
        // Handle query error
        $error = "Error retrieving product ingredients: " . $conn->error;
        // Return the error as JSON response
        echo json_encode(['error' => $error]);
        exit(); // Terminate the script
    }
}
?>
