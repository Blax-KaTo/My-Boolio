<?php
session_start();

// Include your config.php file for the database connection
require_once('config.php');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page
    header("Location: sign-in.php");
    exit();
}

// Function to retrieve all products with ingredients from the database
function getAllProducts()
{
    global $conn;
    
    $query = "SELECT p.*, i.name AS ingredient_name
              FROM products AS p
              LEFT JOIN product_ingredients AS pi ON p.id = pi.product_id
              LEFT JOIN ingredients AS i ON pi.ingredient_id = i.id";
              
    $result = mysqli_query($conn, $query);
    
    $products = array();
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Calculate total price based on quantity
            $quantity = 1; // Default quantity if not set
            if (isset($_POST['quantity'][$row['id']])) {
                $quantity = max(1, intval($_POST['quantity'][$row['id']]));
            }
            $totalPrice = $quantity * $row['price'];
            
            // Add product details and ingredients to the array
            $product = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'image' => $row['image'],
                'price' => $row['price'],
                'quantity' => $quantity,
                'totalPrice' => $totalPrice,
                'ingredients' => array()
            );
            
            if (!empty($row['ingredient_name'])) {
                $product['ingredients'][] = $row['ingredient_name'];
            }
            
            $products[] = $product;
        }
    }
    
    return $products;
}

$products = getAllProducts();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if products are selected
    if (!isset($_POST['selectedProducts']) || empty($_POST['selectedProducts'])) {
        $error = "Please choose at least one product.";
    } else {
        // Process selected products and redirect to ingredient.php
        $selectedProducts = $_POST['selectedProducts'];
        $_SESSION['selectedProducts'] = $selectedProducts;
        header("Location: ingredient.php");
        exit();
    }
}
?>
