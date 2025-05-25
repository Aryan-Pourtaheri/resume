<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Filter Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="px-3 py-1 rounded" style="background: #e53935; color: #fff;">Filter by Price</span>
            </h5>
            <div class="bg-light p-4 mb-30 rounded shadow-sm">
                <form method="GET" action="shop.php">
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-all" name="price" value="" <?php if (!isset($_GET['price']) || empty($_GET['price'])) echo 'checked'; ?>>
                        <label class="custom-control-label" for="price-all">All Prices</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-1" name="price" value="0-50" <?php if (isset($_GET['price']) && $_GET['price'] == '0-50') echo 'checked'; ?>>
                        <label class="custom-control-label" for="price-1">$0 - $50</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-2" name="price" value="50-100" <?php if (isset($_GET['price']) && $_GET['price'] == '50-100') echo 'checked'; ?>>
                        <label class="custom-control-label" for="price-2">$50 - $100</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-3" name="price" value="100-200" <?php if (isset($_GET['price']) && $_GET['price'] == '100-200') echo 'checked'; ?>>
                        <label class="custom-control-label" for="price-3">$100 - $200</label>
                    </div>
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-4" name="price" value="200" <?php if (isset($_GET['price']) && $_GET['price'] == '200') echo 'checked'; ?>>
                        <label class="custom-control-label" for="price-4">Above $200</label>
                    </div>
                    <button type="submit" class="btn btn-block" style="background: #e53935; color: #fff; font-weight: 600; border-radius: 2rem;">Apply Filters</button>
                </form>
            </div>
            <!-- Price Filter End -->

            <!-- Category Filter Start -->
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="px-3 py-1 rounded" style="background: #e53935; color: #fff;">Filter by Category</span>
            </h5>
            <div class="bg-light p-4 mb-30 rounded shadow-sm">
                <form method="GET" action="shop.php">
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="category-all" name="category" value="" <?php if (!isset($_GET['category']) || empty($_GET['category'])) echo 'checked'; ?>>
                        <label class="custom-control-label" for="category-all">All Categories</label>
                    </div>
                    <?php
                    include('./config/connection.php'); // Include database connection
                    $categories = $conn->query("SELECT id, name FROM categories");
                    while ($row = $categories->fetch_assoc()) {
                        $checked = (isset($_GET['category']) && $_GET['category'] == $row['id']) ? 'checked' : '';
                        echo "<div class='custom-control custom-radio d-flex align-items-center justify-content-between mb-3'>
                                <input type='radio' class='custom-control-input' id='category-{$row['id']}' name='category' value='{$row['id']}' $checked>
                                <label class='custom-control-label' for='category-{$row['id']}'>{$row['name']}</label>
                              </div>";
                    }
                    ?>
                    <button type="submit" class="btn btn-block" style="background: #e53935; color: #fff; font-weight: 600; border-radius: 2rem;">Apply Filters</button>
                </form>
            </div>
            <!-- Category Filter End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <?php
                // Build the query with filters
                $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category_name 
                          FROM products p
                          LEFT JOIN categories c ON p.category_id = c.id
                          WHERE p.stock > 0";

                // Apply category filter
                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $category_id = intval($_GET['category']);
                    $query .= " AND p.category_id = $category_id";
                }

                // Apply price filter
                if (isset($_GET['price']) && !empty($_GET['price'])) {
                    $price_range = $_GET['price'];
                    if ($price_range == '0-50') {
                        $query .= " AND p.price BETWEEN 0 AND 50";
                    } elseif ($price_range == '50-100') {
                        $query .= " AND p.price BETWEEN 50 AND 100";
                    } elseif ($price_range == '100-200') {
                        $query .= " AND p.price BETWEEN 100 AND 200";
                    } elseif ($price_range == '200') {
                        $query .= " AND p.price > 200";
                    }
                }

                $query .= " ORDER BY p.created_at DESC";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) {
                        ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="card h-100 shadow-sm border-0" style="border-radius: 1rem;">
                                <img class="card-img-top" src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height:220px;object-fit:cover;border-top-left-radius:1rem;border-top-right-radius:1rem;">
                                <div class="card-body text-center">
                                    <h5 class="card-title font-weight-bold" style="color:#e53935;"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    <p class="card-text text-muted mb-1"><?php echo htmlspecialchars($product['category_name']); ?></p>
                                    <p class="card-text font-weight-bold text-danger mb-2">$<?php echo number_format($product['price'], 2); ?></p>
                                    <form method="POST" action="add-to-cart.php" class="d-inline">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" name="add_to_cart" class="btn btn-outline-danger btn-sm rounded-pill px-3" style="font-weight:600;">Add to Cart</button>
                                    </form>
                                    <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm rounded-pill px-3 ml-2" style="font-weight:600;">View Details</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="text-center w-100">No products found.</p>';
                }
                ?>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->