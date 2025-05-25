<?php

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Handle quantity updates and item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }

    // Update quantity
    if (isset($_POST['update_quantity'])) {
        $product_id = intval($_POST['product_id']);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

        if ($quantity !== false && $quantity > 0) {
            foreach ($_SESSION['cart'] as $index => $item) {
                if ($item['id'] === $product_id) {
                    $_SESSION['cart'][$index]['quantity'] = $quantity;
                    break;
                }
            }
        } else {
            $_SESSION['error'] = "Invalid quantity provided.";
        }
    }

    // Remove item
    if (isset($_POST['remove_item'])) {
        $product_id = intval($_POST['product_id']);
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($product_id) {
            return $item['id'] !== $product_id;
        });
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
    }
}
?>

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger" style="background: #ffcdd2; color: #b71c1c; border: 1px solid #e53935;">
                    <?php echo htmlspecialchars($_SESSION['error']); ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead style="background: #e53935;">
                    <tr>
                        <th class="text-white">Products</th>
                        <th class="text-white">Price</th>
                        <th class="text-white">Quantity</th>
                        <th class="text-white">Total</th>
                        <th class="text-white">Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    <?php if (count($_SESSION['cart']) > 0): ?>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td class="align-middle">
                                    <img src="uploads/products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 50px; border-radius: 0.5rem; border: 2px solid #e53935;">
                                    <span class="font-weight-bold text-danger ml-2"><?php echo htmlspecialchars($item['name']); ?></span>
                                </td>
                                <td class="align-middle text-danger font-weight-bold">$<?php echo number_format($item['price'], 2); ?></td>
                                <td class="align-middle">
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <div class="input-group quantity mx-auto" style="width: 200px;">
                                            <input type="number" name="quantity" class="form-control form-control-sm bg-white border-danger text-center" value="<?php echo $item['quantity']; ?>" min="1">
                                            <div class="input-group-append">
                                                <button type="submit" name="update_quantity" class="btn btn-sm btn-outline-danger font-weight-bold">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="align-middle text-danger font-weight-bold">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                <td class="align-middle">
                                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" name="remove_item" class="btn btn-sm btn-danger rounded-circle"><i class="fa fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Your cart is empty.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="px-3 py-1 rounded" style="background: #e53935; color: #fff;">Cart Summary</span>
            </h5>
            <div class="bg-light p-30 mb-5 rounded shadow-sm">
                <?php
                $subtotal = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                $shipping = 10.00;
                $total = $subtotal + $shipping;
                ?>
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 class="text-danger">$<?php echo number_format($subtotal, 2); ?></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium text-danger">$<?php echo number_format($shipping, 2); ?></h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 class="text-danger">$<?php echo number_format($total, 2); ?></h5>
                    </div>
                    <?php if (count($_SESSION['cart']) > 0): ?>
                        <a href="checkout.php" class="btn btn-block btn-danger font-weight-bold my-3 py-3 rounded-pill">Proceed To Checkout</a>
                    <?php else: ?>
                        <p class="text-center text-muted">Your cart is empty. Add items to proceed to checkout.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
