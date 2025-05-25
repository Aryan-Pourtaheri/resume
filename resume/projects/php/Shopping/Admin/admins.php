<?php include('../config/connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Users</title>
    <?php include('../components/admin-header/head.php'); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('../components/admin-header/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../components/admin-header/topbar.php'); ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Admin Users</h1>

                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                    <?php endif; ?>

                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAdminModal">Add Admin</button>

                    <!-- Add Admin Modal -->
                    <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="admin-actions/add-admin.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAdminModalLabel">Add Admin</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image</label>
                                            <input type="file" class="form-control-file" id="profile_image" name="profile_image" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Add Admin</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query to fetch admin users
                            $result = $conn->query("SELECT id, username, email FROM users WHERE role = 'admin'");
                            if ($result) {
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                            ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td>
                                                <a href="admin-actions/edit-admin.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="admin-actions/delete-admin.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No admin users found</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>Error: " . $conn->error . "</td></tr>";
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