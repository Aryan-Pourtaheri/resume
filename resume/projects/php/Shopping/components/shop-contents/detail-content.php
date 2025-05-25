<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div class="bg-light p-3 rounded shadow-sm">
                <img class="img-fluid w-100" src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="border-radius:1rem;">
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-4 rounded shadow-sm">
                <h3 class="font-weight-bold" style="color:#e53935;"><?php echo htmlspecialchars($product['name']); ?></h3>
                <p class="text-muted">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
                <h3 class="font-weight-semi-bold mb-4 text-danger">$<?php echo number_format($product['price'], 2); ?></h3>
                <p class="mb-4"><?php echo htmlspecialchars($product['description']); ?></p>
                <p class="text-muted">Stock: <?php echo $product['stock'] > 0 ? $product['stock'] : '<span class="text-danger font-weight-bold">Out of Stock</span>'; ?></p>
                <form method="POST" action="add-to-cart.php">
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-danger btn-minus" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="number" name="quantity" class="form-control bg-white border-danger text-center" value="1" min="1" max="<?php echo $product['stock']; ?>">
                            <div class="input-group-btn">
                                <button class="btn btn-danger btn-plus" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-danger px-3 rounded-pill font-weight-bold" <?php echo $product['stock'] > 0 ? '' : 'disabled'; ?>>
                            <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="px-3 py-1 rounded" style="background: #e53935; color: #fff;">You May Also Like</span>
    </h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                <?php
                // Fetch related products from the same category
                $related_query = "SELECT id, name, price, image 
                                  FROM products 
                                  WHERE category_id = ? AND id != ? AND stock > 0 
                                  ORDER BY RAND() LIMIT 6";
                $stmt = $conn->prepare($related_query);
                $stmt->bind_param("ii", $product['category_id'], $product['id']);
                $stmt->execute();
                $related_result = $stmt->get_result();

                if ($related_result->num_rows > 0) {
                    while ($related_product = $related_result->fetch_assoc()) {
                        ?>
                        <div class="product-item bg-light rounded shadow-sm">
                            <div class="product-img position-relative overflow-hidden" style="border-radius:1rem 1rem 0 0;">
                                <img class="img-fluid w-100" src="uploads/products/<?php echo htmlspecialchars($related_product['image']); ?>" alt="<?php echo htmlspecialchars($related_product['name']); ?>">
                                <div class="product-action">
                                    <form method="POST" action="detail.php?id=<?php echo $related_product['id']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $related_product['id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" name="add_to_cart" class="btn btn-outline-danger btn-square">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                    <a class="btn btn-danger btn-square" href="detail.php?id=<?php echo $related_product['id']; ?>"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="detail.php?id=<?php echo $related_product['id']; ?>" style="color:#e53935;"><?php echo htmlspecialchars($related_product['name']); ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5 class="text-danger">$<?php echo number_format($related_product['price'], 2); ?></h5>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="text-center">No related products found.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Products End -->