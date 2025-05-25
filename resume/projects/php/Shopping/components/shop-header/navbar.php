<?php
include('./config/connection.php'); // Include database connection

// Fetch categories from the database
$query = "SELECT id, name FROM categories";
$result = $conn->query($query);

// Initialize cart count
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!-- Navbar Start -->
<div class="container-fluid bg-white shadow-sm mb-5">
    <div class="row px-xl-5 align-items-center">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between" 
               style="background: #e53935; color: #fff; height: 50px; padding: 0 24px; border-radius: 0.75rem;" 
               data-toggle="collapse" href="#navbar-vertical">
                <h6 class="m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                <i class="fa fa-angle-down"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical align-items-start p-0 mt-2"
                 id="navbar-vertical"
                 style="width: 90%; z-index: 999; background: #fff; border-left: 3px solid #e53935; border-radius: 0 0 0.75rem 0.75rem;">
                <div class="navbar-nav w-100">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($category = $result->fetch_assoc()): ?>
                            <a href="shop.php?category_id=<?php echo $category['id']; ?>" class="nav-item nav-link" style="color: #e53935; font-weight: 500;">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">No categories available</p>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" style="border-color: #e53935;">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="shop.php" class="nav-item nav-link font-weight-bold" style="color: #e53935;">Shop</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0">
                        <a href="cart.php" class="btn position-relative ml-3" style="background: #fff; border: 1.5px solid #e53935; border-radius: 2rem;">
                            <i class="fas fa-shopping-cart" style="color: #e53935; font-size: 1.2rem;"></i>
                            <span class="badge badge-pill" style="background: #e53935; color: #fff; position: absolute; top: -8px; right: -8px; font-size: 0.8rem;">
                                <?php echo $cart_count; ?>
                            </span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
