<?php
include('admin_products_process.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Admin Products</title>
    <link rel="stylesheet" href="style/admin_products.css">
</head>
<body>
    <header>
        <h1>Admin Products</h1>
        <a href="add_product.php" class="add-button">Add New Item</a>
        <a href="admin_ingredients.php" class="manage-link">Manage Ingredients</a> <!-- Manage Ingredients link -->
    </header>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Active</th>
                    <th>Ingredients</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve the products from the database
                $products = getProducts();

                // Loop through the products and display them in the table
                foreach ($products as $product) {
                    $productId = $product['id'];
                    $productName = $product['name'];
                    $active = $product['active'];

                    // Retrieve the product's ingredients
                    $ingredients = getProductIngredients($productId);

                    echo "<tr>";
                    echo "<td>$productId</td>";
                    echo "<td>$productName</td>";
                    echo "<td>$active</td>";
                    echo "<td>";
                    echo "<button onclick=\"showIngredients($productId)\">View Ingredients</button>";
                    echo "</td>";
                    echo "<td>";
                    echo "<form method=\"post\">";
                    echo "<input type=\"hidden\" name=\"item_id\" value=\"$productId\">";
                    if ($active) {
                        echo "<button type=\"submit\" name=\"deactivate\">Deactivate</button>";
                    } else {
                        echo "<button type=\"submit\" name=\"activate\">Activate</button>";
                    }
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="ingredientsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Product Ingredients</h2>
            <ul id="ingredientsList"></ul>
        </div>
    </div>

    <script>
        // Get the modal element and other elements
        var modal = document.getElementById("ingredientsModal");
        var span = document.getElementsByClassName("close")[0];
        var container = document.querySelector(".container");

        // Function to show the modal and populate the ingredients list
        function showIngredients(productId) {
            // Retrieve the ingredients for the specified product via AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var ingredients = JSON.parse(this.responseText);

                    // Populate the ingredients list
                    var ingredientsList = document.getElementById("ingredientsList");
                    ingredientsList.innerHTML = "";
                    for (var i = 0; i < ingredients.length; i++) {
                        var ingredientName = ingredients[i].name;
                        var listItem = document.createElement("li");
                        listItem.textContent = ingredientName;
                        ingredientsList.appendChild(listItem);
                    }

                    // Show the modal
                    modal.style.display = "block";
                }
            };
            xhttp.open("GET", "get_product_ingredients.php?product_id=" + productId, true);
            xhttp.send();
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = "none";
        }

        // Event listener to close the modal when the <span> element is clicked
        span.addEventListener("click", closeModal);

        // Event listener to close the modal when the user clicks outside of it
        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                closeModal();
            }
        });

        // Add class to container based on screen size
        function addClassBasedOnScreenSize() {
            if (window.innerWidth <= 600) {
                container.classList.add("mobile-view");
            } else {
                container.classList.remove("mobile-view");
            }
        }

        // Call the function on page load and resize
        window.onload = addClassBasedOnScreenSize;
        window.onresize = addClassBasedOnScreenSize;
    </script>
</body>
</html>