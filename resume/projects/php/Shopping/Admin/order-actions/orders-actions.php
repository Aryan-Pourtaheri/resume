<?php
include('../../config/connection.php');
header('Content-Type: application/json');

if ($_POST['action'] === 'add') {
    $customer_id = intval($_POST['customer_id']);
    $total = floatval($_POST['total']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, total, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $customer_id, $total, $status);
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;
        // Save order items
        if (!empty($_POST['products'])) {
            foreach ($_POST['products'] as $product_id) {
                $quantity = intval($_POST['quantities'][$product_id]);
                // Get product price
                $res = $conn->query("SELECT price FROM products WHERE id=$product_id");
                $price = $res->fetch_assoc()['price'];
                $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt2->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                $stmt2->execute();
            }
        }
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false, 'message'=>'Failed to add order']);
    }
    exit;
}

if ($_POST['action'] === 'edit') {
    $id = intval($_POST['id']);
    $customer_id = intval($_POST['customer_id']);
    $total = floatval($_POST['total']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET customer_id=?, total=?, status=? WHERE id=?");
    $stmt->bind_param("idsi", $customer_id, $total, $status, $id);
    if ($stmt->execute()) {
        // Remove old items
        $conn->query("DELETE FROM order_items WHERE order_id=$id");
        // Save new order items
        if (!empty($_POST['products'])) {
            foreach ($_POST['products'] as $product_id) {
                $quantity = intval($_POST['quantities'][$product_id]);
                $res = $conn->query("SELECT price FROM products WHERE id=$product_id");
                $price = $res->fetch_assoc()['price'];
                $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt2->bind_param("iiid", $id, $product_id, $quantity, $price);
                $stmt2->execute();
            }
        }
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false, 'message'=>'Failed to update order']);
    }
    exit;
}

if ($_POST['action'] === 'delete') {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM order_items WHERE order_id=$id");
    $stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['success'=>true, 'id'=>$id]);
    } else {
        echo json_encode(['success'=>false, 'message'=>'Failed to delete order']);
    }
    exit;
}

echo json_encode(['success'=>false, 'message'=>'Invalid request']);
?>

<!-- In your Add/Edit Order Modal -->
<div class="form-group">
    <label>Products</label>
    <div id="products-list">
        <?php
        $products = $conn->query("SELECT id, name, price FROM products");
        while ($p = $products->fetch_assoc()) {
            ?>
            <div class="form-row align-items-center mb-2">
                <div class="col">
                    <input type="checkbox" class="product-checkbox" name="products[]" value="<?php echo $p['id']; ?>" id="product_<?php echo $p['id']; ?>">
                    <label for="product_<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?> ($<?php echo $p['price']; ?>)</label>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="quantities[<?php echo $p['id']; ?>]" min="1" value="1" placeholder="Qty" style="width:80px;display:inline-block;" disabled>
                </div>
            </div>
        <?php } ?>
    </div>
</div>