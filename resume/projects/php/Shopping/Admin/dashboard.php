<?php
session_start();
include('../config/connection.php'); // Include database connection

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../_auth/login.php"); // Adjust the path to your login page
    exit();
}

// Query to count the total number of products
$product_count_query = "SELECT COUNT(*) AS total_products FROM products";
$product_count_result = $conn->query($product_count_query);
$product_count = 0;
if ($product_count_result && $row = $product_count_result->fetch_assoc()) {
    $product_count = $row['total_products'];
}

// Query to count the total number of categories
$category_count_query = "SELECT COUNT(*) AS total_categories FROM categories";
$category_count_result = $conn->query($category_count_query);
$category_count = 0;
if ($category_count_result && $row = $category_count_result->fetch_assoc()) {
    $category_count = $row['total_categories'];
}

// Query to count the total number of orders
$order_count_query = "SELECT COUNT(*) AS total_orders FROM orders";
$order_count_result = $conn->query($order_count_query);
$order_count = 0;
if ($order_count_result && $row = $order_count_result->fetch_assoc()) {
    $order_count = $row['total_orders'];
}

// Query to count the total number of customers
$customer_count_query = "SELECT COUNT(*) AS total_customers FROM customers";
$customer_count_result = $conn->query($customer_count_query);
$customer_count = 0;
if ($customer_count_result && $row = $customer_count_result->fetch_assoc()) {
    $customer_count = $row['total_customers'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping Admin Dashboard</title>

    <?php include('../components/admin-header/head.php'); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include('../components/admin-header/sidebar.php')?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include('../components/admin-header/topbar.php')?>
                
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Total Products -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Products</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $product_count; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Categories -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Categories</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $category_count; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Orders -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Total Orders</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $order_count; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Customers -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Customers</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $customer_count; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Products Overview -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Products Overview</h6>
                                </div>
                                <div class="card-body">
                                    <p>Manage your products effectively. Add, edit, or delete products to keep your inventory up-to-date.</p>
                                    <a href="products.php" class="btn btn-primary btn-sm">Manage Products</a>
                                </div>
                            </div>
                        </div>

                        <!-- Orders Overview -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Orders Overview</h6>
                                </div>
                                <div class="card-body">
                                    <p>Track and manage customer orders. View order details and update their status.</p>
                                    <a href="orders.php" class="btn btn-success btn-sm">View Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Categories Overview -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Categories Overview</h6>
                                </div>
                                <div class="card-body">
                                    <p>Organize your products into categories for better navigation and management.</p>
                                    <a href="categories.php" class="btn btn-info btn-sm">Manage Categories</a>
                                </div>
                            </div>
                        </div>

                        <!-- Customers Overview -->
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Customers Overview</h6>
                                </div>
                                <div class="card-body">
                                    <p>View and manage customer information to improve customer relationships.</p>
                                    <a href="customers.php" class="btn btn-warning btn-sm">View Customers</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Shopping App 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
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