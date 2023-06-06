<?php
// Include your database connection file (e.g., config.php)
include('config.php');

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["activate"])) {
    $productId = $_POST["item_id"];
    activateProduct($productId);
  } elseif (isset($_POST["deactivate"])) {
    $productId = $_POST["item_id"];
    deactivateProduct($productId);
  }
}

// Function to activate a product
function activateProduct($productId)
{
  global $conn;

  // Implement your database query to update the product's active status to true
  $query = "UPDATE products SET active = 1 WHERE id = $productId";

  // Execute the query
  if ($conn->query($query) === TRUE) {
    // Redirect back to the admin_products.php page
    header("Location: admin_products.php");
    exit();
  } else {
    // Handle query error
    echo "Error activating product: " . $conn->error;
  }
}

// Function to deactivate a product
function deactivateProduct($productId)
{
  global $conn;

  // Implement your database query to update the product's active status to false
  $query = "UPDATE products SET active = 0 WHERE id = $productId";

  // Execute the query
  if ($conn->query($query) === TRUE) {
    // Redirect back to the admin_products.php page
    header("Location: admin_products.php");
    exit();
  } else {
    // Handle query error
    echo "Error deactivating product: " . $conn->error;
  }
}

// Retrieve the list of products from the database
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
    echo "Error retrieving product ingredients: " . $conn->error;
    return [];
  }
}
?>
