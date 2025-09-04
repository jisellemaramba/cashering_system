<?php
require_once "../classes/Product.php";
$product = new Product();

// Handle product edit
if (isset($_POST['edit_product'])) {
    // Get the product ID from the URL
    $id = $_GET['id']; 
    
    // Get the form data for product updates
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Update the product in the database
    if ($product->editProduct($id, $product_name, $price, $quantity)) {
        // Redirect to the dashboard if successful
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        die("Failed to update the product.");
    }
}

// Handle product purchase logic
if (isset($_POST['buy_product'])) {
    $id = $_GET['id'];
    
    // Fetch product details
    $product_details = $product->displaySpecificProduct($id);

    if ($product_details === null) {
        die("Product not found. Please try again.");
    }

    $buy_quantity = $_POST['buy_quantity'];

    // Proceed with the purchase if stock is available
    if ($product->buyProduct($id, $buy_quantity)) {
        header("Location: ../views/dashboard.php");  // Redirect to dashboard on success
        exit;
    } else {
        die("Failed to purchase product.");
    }
}

// Handle adding a new product
if (isset($_POST['add_product'])) {
    // Get the form data
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Call the method to add the product
    if ($product->addProduct($product_name, $price, $quantity)) {
        // Redirect to the dashboard on success
        header("Location: ../views/manage-inventory.php");
        exit;
    } else {
        die("Failed to add product.");
    }
}

?>
