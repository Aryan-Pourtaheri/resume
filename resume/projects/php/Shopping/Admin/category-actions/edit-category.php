<?php
include('../../config/connection.php');

if (!isset($_GET['id'])) {
    header("Location: categories.php?error=Invalid category ID.");
    exit();
}

$category_id = $_GET['id'];
$query = "SELECT * FROM categories WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];
    $category_description = $_POST['category_description'];

    if (empty($category_name) || empty($category_description)) {
        header("Location: edit-category.php?id=$category_id&error=All fields are required.");
        exit();
    }

    $query = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $category_name, $category_description, $category_id);

    if ($stmt->execute()) {
        header("Location: ../categories.php?success=Category updated successfully!");
    } else {
        header("Location: edit-category.php?id=$category_id&error=Failed to update category.");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Category</title>
    <?php include('../../components/admin-header/head.php'); ?>
    <!-- Add Bootstrap CSS if not already included -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Edit Category</h3>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="category_description">Category Description</label>
                        <textarea class="form-control" id="category_description" name="category_description" rows="3" required><?php echo htmlspecialchars($category['description']); ?></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="../categories.php" class="btn btn-secondary">Cancel</a>
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