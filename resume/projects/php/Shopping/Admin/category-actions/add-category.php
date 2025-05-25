<?php
include('../../config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    if (empty($category_name) || empty($category_description)) {
        header("Location: ../categories.php?error=All fields are required.");
        exit();
    }

    $query = "INSERT INTO categories (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $category_name, $category_description);
        if ($stmt->execute()) {
            header("Location: ../categories.php?success=Category added successfully!");
        } else {
            header("Location: ../categories.php?error=Failed to add category.");
        }
    } else {
        die("SQL Error: " . $conn->error);
    }
    exit();
}
?>