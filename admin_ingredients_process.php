<?php
// Include your database connection file (e.g., config.php)
include('config.php');

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["activate"])) {
        $ingredientId = $_POST["item_id"];
        activateIngredient($ingredientId);
    } elseif (isset($_POST["deactivate"])) {
        $ingredientId = $_POST["item_id"];
        deactivateIngredient($ingredientId);
    } elseif (isset($_POST["delete"])) {
        $ingredientId = $_POST["item_id"];
        deleteIngredient($ingredientId);
    }
}

// Function to activate an ingredient
function activateIngredient($ingredientId)
{
    global $conn;

    // Implement your database query to update the ingredient's active status to true
    $query = "UPDATE ingredients SET active = 1 WHERE id = $ingredientId";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Redirect back to the admin_ingredients.php page
        header("Location: admin_ingredients.php");
        exit();
    } else {
        // Handle query error
        echo "Error activating ingredient: " . $conn->error;
    }
}

// Function to deactivate an ingredient
function deactivateIngredient($ingredientId)
{
    global $conn;

    // Implement your database query to update the ingredient's active status to false
    $query = "UPDATE ingredients SET active = 0 WHERE id = $ingredientId";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Redirect back to the admin_ingredients.php page
        header("Location: admin_ingredients.php");
        exit();
    } else {
        // Handle query error
        echo "Error deactivating ingredient: " . $conn->error;
    }
}

// Function to delete an ingredient
function deleteIngredient($ingredientId)
{
    global $conn;

    // Implement your database query to delete the ingredient
    $query = "DELETE FROM ingredients WHERE id = $ingredientId";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        // Redirect back to the admin_ingredients.php page
        header("Location: admin_ingredients.php");
        exit();
    } else {
        // Handle query error
        echo "Error deleting ingredient: " . $conn->error;
    }
}

// Retrieve the list of ingredients
function getIngredients()
{
    global $conn;

    // Implement your database query here to fetch ingredients
    $query = "SELECT * FROM ingredients";

    // Execute the query and return the results
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // Fetch the results and return them as an array
        $ingredients = $result->fetch_all(MYSQLI_ASSOC);
        return $ingredients;
    } else {
        // Handle query error or no ingredients found
        echo "Error retrieving ingredients: " . $conn->error;
        return [];
    }
}

// Retrieve the product name for a specific ingredient
function getProductName($productId)
{
    global $conn;

    // Implement your database query here to fetch the product name for the specified ingredient
    $query = "SELECT name FROM products WHERE id = $productId";

    // Execute the query and return the product name
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    } else {
        // Handle query error or no product found
        return "Unknown";
    }
}
?>
