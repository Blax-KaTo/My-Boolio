<?php
// Include your admin_ingredients_process.php file
include('admin_ingredients_process.php');

// Retrieve the list of ingredients
$ingredients = getIngredients();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Boolio | Manage Ingredients</title>
    <link rel="stylesheet" type="text/css" href="style/admin_ingredients.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="admin-header">
        <h2 class="admin-title">Manage Ingredients</h2>
        <a href="add_ingredient.php" class="admin-button">Add New Ingredient</a>
    </div>

    <div class="ingredients-list">
        <?php if (count($ingredients) > 0): ?>
            <?php foreach ($ingredients as $ingredient): ?>
                <div class="ingredient-item">
                    <h3><?php echo $ingredient['name']; ?></h3>
                    <p>Product: <?php echo getProductName($ingredient['product_id']); ?></p>
                    <div class="ingredient-actions">
                        <a href="edit_ingredient.php?id=<?php echo $ingredient['id']; ?>" class="edit-button">Edit</a>
                        <form method="post" action="admin_ingredients_process.php" class="ingredient-form">
                            <input type="hidden" name="item_id" value="<?php echo $ingredient['id']; ?>">
                            <?php if ($ingredient['active']): ?>
                                <button type="submit" name="deactivate" class="deactivate-button">Deactivate</button>
                            <?php else: ?>
                                <button type="submit" name="activate" class="activate-button">Activate</button>
                            <?php endif; ?>
                            <button type="submit" name="delete" class="delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No ingredients found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <!-- Add your footer content here -->
    </footer>

    <script src="script/admin_ingredients.js"></script>
</body>
</html>
