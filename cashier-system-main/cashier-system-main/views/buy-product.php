<?php
require_once('../actions/require_login.php');
require_once "../classes/Product.php";

$product = new Product();

// Fetch the specific product by ID
$product_id = $_GET['id'];  // Changed from $_GET['product_id'] to $_GET['id']
$product_details = $product->displaySpecificProduct($product_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Buy <?= htmlspecialchars($product_details['product_name'], ENT_QUOTES, 'UTF-8') ?></h1>
        <form action="../actions/product-actions.php?id=<?= $product_id ?>" method="post">
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity Available: <?= htmlspecialchars($product_details['quantity'], ENT_QUOTES, 'UTF-8') ?></label>
                <input type="number" name="buy_quantity" id="buy_quantity" class="form-control" min="1" max="<?= $product_details['quantity'] ?>" required>
            </div>
            <button type="submit" name="buy_product" class="btn btn-success">Buy</button>
        </form>
    </div>
</body>
</html>
