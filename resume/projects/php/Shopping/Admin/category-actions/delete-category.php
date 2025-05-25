<?php
include('../../config/connection.php');

if (!isset($_GET['id'])) {
    header("Location: ../categories.php?error=Invalid category ID.");
    exit();
}

$category_id = $_GET['id'];

$query = "DELETE FROM categories WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $category_id);

if ($stmt->execute()) {
    header("Location: ../categories.php?success=Category deleted successfully!");
} else {
    header("Location: ../categories.php?error=Failed to delete category.");
}
exit();
?>