<?php
// Include the database connection
include('config.php');

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // Upload image
    $targetDir = "images/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Create the 'images/' directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir);
        }

        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars(basename($_FILES["image"]["name"])). " has been uploaded.";

            // Insert the new product into the database
            $query = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$targetFile')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Redirect back to the admin_products.php page
                header("Location: admin_products.php");
                exit();
            } else {
                // Handle query error
                echo "Error adding product: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Product</title>
    <link rel="stylesheet" type="text/css" href="style/add_product.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="admin-container">
        <h2 class="admin-title">Add New Product</h2>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit" class="admin-button">Add Product</button>
        </form>
    </div>

    <footer>
        <!-- Add your footer content here -->
    </footer>
</body>
</html>
