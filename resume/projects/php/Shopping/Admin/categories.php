<?php include('../config/connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Categories</title>
    <?php include('../components/admin-header/head.php'); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('../components/admin-header/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../components/admin-header/topbar.php'); ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Manage Categories</h1>
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($_GET['success']); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($_GET['error']); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <form action="category-actions/add-category.php" method="POST">
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" class="form-control mb-3" id="category_name" name="category_name" required>
                        </div>
                        <div class="form-group">
                            <label for="category_description">Category Description</label>
                            <textarea class="form-control mb-5" id="category_description" name="category_description" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mb-5">Add Category</button>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM categories");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td>
                                            <a href="category-actions/edit-category.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="category-actions/delete-category.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='3' class='text-center'>No categories found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->    
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>