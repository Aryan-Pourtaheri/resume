<?php
include('./config/connection.php');

// Enable error reporting for debugging (can be disabled in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error'] = "You must be logged in to place an order.";
        header("Location: ./_auth/login.php");
        exit();
    }

    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        // Verify if the customer exists and fetch the customer_id
        $customer_check_query = "SELECT id FROM customers WHERE user_id = ?";
        $stmt_check = $conn->prepare($customer_check_query);
        $stmt_check->bind_param("i", $_SESSION['user_id']);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows === 0) {
            $_SESSION['error'] = "Invalid customer ID. Please log in again.";
            header("Location: ./_auth/login.php");
            exit();
        }

        $customer = $result_check->fetch_assoc();
        $customer_id = $customer['id']; // Get the correct customer_id

        // Collect billing details (sanitize inputs)
        $first_name = htmlspecialchars(trim($_POST['first_name']));
        $last_name = htmlspecialchars(trim($_POST['last_name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $mobile = htmlspecialchars(trim($_POST['mobile']));
        $payment_method = htmlspecialchars(trim($_POST['payment']));

        // Calculate total order amount
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $total += 10; // Add $10 shipping

        // Insert order details into the `orders` table
        $order_query = "INSERT INTO orders (customer_id, order_date, total, status) 
                        VALUES (?, NOW(), ?, 'pending')";
        $stmt = $conn->prepare($order_query);
        if (!$stmt) {
            die("Order Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("id", $customer_id, $total);
        if (!$stmt->execute()) {
            die("Order Execute failed: " . $stmt->error);
        }
        $order_id = $stmt->insert_id;

        // Insert order items into the `order_items` table
        $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                             VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($order_item_query);
        if (!$stmt) {
            die("Item Prepare failed: " . $conn->error);
        }
        foreach ($_SESSION['cart'] as $item) {
            $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
            if (!$stmt->execute()) {
                die("Item Execute failed: " . $stmt->error);
            }
        }

        // Clear the cart
        unset($_SESSION['cart']);

        // Redirect to a success page
        header("Location: order-success.php?order_id=$order_id");
        exit();
    } else {
        $_SESSION['error'] = "Your cart is empty.";
    }
}
?>

<!-- Checkout Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="px-3 py-1 rounded" style="background: #e53935; color: #fff;">Billing Address</span>
            </h5>
            <div class="bg-light p-30 mb-5 rounded shadow-sm">
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>First Name</label>
                            <input class="form-control border-danger" type="text" name="first_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Last Name</label>
                            <input class="form-control border-danger" type="text" name="last_name" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control border-danger" type="email" name="email" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Mobile No</label>
                            <input class="form-control border-danger" type="text" name="mobile" required>
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="px-3 py-1 rounded" style="background: #e53935; color: #fff;">Order Total</span>
            </h5>
            <div class="bg-light p-30 mb-5 rounded shadow-sm">
                <div class="border-bottom pb-2">
                    <h6 class="mb-3">Products</h6>
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <div class="d-flex justify-content-between">
                                <p><?php echo htmlspecialchars($item['name']); ?> (x<?php echo $item['quantity']; ?>)</p>
                                <p class="text-danger font-weight-bold">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Your cart is empty.</p>
                    <?php endif; ?>
                </div>
                <div class="border-bottom pt-3 pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 class="text-danger">
                            $<?php
                            $subtotal = 0;
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $item) {
                                    $subtotal += $item['price'] * $item['quantity'];
                                }
                            }
                            echo number_format($subtotal, 2);
                            ?>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium text-danger">$10.00</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 class="text-danger">$<?php echo number_format($subtotal + 10, 2); ?></h5>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="px-3 py-1 rounded" style="background: #e53935; color: #fff;">Payment</span>
                </h5>
                <div class="bg-light p-30 rounded shadow-sm">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" value="Paypal" id="paypal" required>
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" value="Direct Check" id="directcheck" required>
                            <label class="custom-control-label" for="directcheck">Direct Check</label>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" value="Bank Transfer" id="banktransfer" required>
                            <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                        </div>
                    </div>
                    <button type="submit" name="place_order" class="btn btn-block btn-danger font-weight-bold py-3 rounded-pill">Place Order</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<!-- Checkout End -->



