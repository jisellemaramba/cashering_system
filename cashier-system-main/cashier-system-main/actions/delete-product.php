<?php
require_once('../actions/require_login.php');
require_once "../classes/Product.php";

$product = new Product(); // Instantiate the Product class

// Check if the 'id' parameter is passed in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Call the deleteProduct method from the Product class
    if ($product->deleteProduct($product_id)) {
        // Redirect to the manage-inventory page after successful deletion
        header("Location: ../views/manage-inventory.php");
        exit;
    } else {
        die("Failed to delete product.");
    }
} else {
    die("Product ID not provided.");
}

// Debugging: Check if the method exists and product ID is correct
echo "Calling deleteProduct() for product ID: " . $product_id . "<br>";

if (method_exists($product, 'deleteProduct')) {
    echo "Method deleteProduct() exists in the Product class.<br>";
} else {
    die("Method deleteProduct() does not exist.");
}
?>
