<?php
include('../../config/connection.php');

if (!isset($_GET['id'])) {
    header("Location: ../products.php?error=Invalid product ID.");
    exit();
}

$product_id = $_GET['id'];

$query = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    header("Location: ../products.php?success=Product deleted successfully!");
} else {
    header("Location: ../products.php?error=Failed to delete product.");
}
exit();
?>