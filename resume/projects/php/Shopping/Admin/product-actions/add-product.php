<?php
include('../../config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $image = null;

        // Validate inputs
        if (empty($category_id) || empty($name) || empty($price) || empty($stock)) {
            header("Location: ../products.php?error=All fields are required.");
            exit();
        }

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/products/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
            }
            $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_file = $upload_dir . $file_name;

            // Validate file type and size
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($file_type, $allowed_types)) {
                header("Location: ../products.php?error=Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.");
                exit();
            } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) { // 2MB limit
                header("Location: ../products.php?error=Image size must not exceed 2MB.");
                exit();
            } else {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image = $file_name;
                } else {
                    header("Location: ../products.php?error=Failed to upload image.");
                    exit();
                }
            }
        }

        // Insert the new product into the database
        $query = "INSERT INTO products (category_id, name, description, price, stock, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("issdis", $category_id, $name, $description, $price, $stock, $image);
            if ($stmt->execute()) {
                header("Location: ../products.php?success=Product added successfully!");
            } else {
                header("Location: ../products.php?error=Failed to add product.");
            }
        } else {
            die("SQL Error: " . $conn->error);
        }
    } elseif (isset($_POST['category_name'])) {
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
    }
    exit();
}
?>