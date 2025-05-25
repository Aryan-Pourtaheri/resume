<?php
session_start();
include('./config/connection.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($product_id <= 0 || $quantity <= 0) {
        $_SESSION['error'] = "Invalid product or quantity.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Fetch product details from the database
    $query = "SELECT id, name, price, image, stock FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Check if the product is in stock
        if ($product['stock'] < $quantity) {
            $_SESSION['error'] = "Only {$product['stock']} items available in stock.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Initialize cart if not set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if product is already in the cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $product_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        // If not found, add new product to cart
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity
            ];
        }

        $_SESSION['success'] = "Product added to cart successfully!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $_SESSION['error'] = "Product not found.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>