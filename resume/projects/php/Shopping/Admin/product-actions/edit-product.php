<?php
include('../../config/connection.php');

if (!isset($_GET['id'])) {
    header("Location: ../products.php?error=Invalid product ID.");
    exit();
}

$product_id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $product['image']; // Keep the existing image by default

    // Validate inputs
    if (empty($category_id) || empty($name) || empty($price) || empty($stock)) {
        header("Location: edit-product.php?id=$product_id&error=All fields are required.");
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
            header("Location: edit-product.php?id=$product_id&error=Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.");
            exit();
        } elseif ($_FILES['image']['size'] > 2 * 1024 * 1024) { // 2MB limit
            header("Location: edit-product.php?id=$product_id&error=Image size must not exceed 2MB.");
            exit();
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Delete the old image if a new one is uploaded
                if (!empty($product['image']) && file_exists($upload_dir . $product['image'])) {
                    unlink($upload_dir . $product['image']);
                }
                $image = $file_name;
            } else {
                header("Location: edit-product.php?id=$product_id&error=Failed to upload image.");
                exit();
            }
        }
    }

    // Update the product in the database
    $query = "UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issdiss", $category_id, $name, $description, $price, $stock, $image, $product_id);

    if ($stmt->execute()) {
        header("Location: ../products.php?success=Product updated successfully!");
    } else {
        header("Location: edit-product.php?id=$product_id&error=Failed to update product.");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <?php include('../../components/admin-header/head.php'); ?>
    <!-- Add Bootstrap CSS if not already included -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Edit Product</h3>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <?php
                            $categories = $conn->query("SELECT id, name FROM categories");
                            while ($row = $categories->fetch_assoc()) {
                                $selected = $row['id'] == $product['category_id'] ? 'selected' : '';
                                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                        <?php if (!empty($product['image'])): ?>
                            <img src="../../uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="img-thumbnail mt-2" style="max-width: 150px;">
                        <?php endif; ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="../products.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>