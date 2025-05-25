<?php include('../config/connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Orders</title>
    <?php include('../components/admin-header/head.php'); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('../components/admin-header/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../components/admin-header/topbar.php'); ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Manage Orders</h1>
                    <!-- Success Alert -->
                    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;">
                        <span id="successMsg"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addOrderModal">Add Order</button>
                    <table class="table table-bordered" id="ordersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ordersBody">
                            <?php
                            $result = $conn->query("SELECT orders.*, CONCAT(users.first_name, ' ', users.last_name) AS customer_name FROM orders LEFT JOIN customers ON orders.customer_id = customers.id LEFT JOIN users ON customers.user_id = users.id");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr id="order-<?php echo $row['id']; ?>">
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                        <td><?php echo $row['total']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn"
                                                data-id="<?php echo $row['id']; ?>"
                                                data-customer="<?php echo $row['customer_id']; ?>"
                                                data-total="<?php echo $row['total']; ?>"
                                                data-status="<?php echo $row['status']; ?>"
                                            >Edit</button>
                                            <button class="btn btn-danger btn-sm delete-btn"
                                                data-id="<?php echo $row['id']; ?>"
                                            >Delete</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No orders found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Order Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form id="addOrderForm">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add Order</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label>Customer</label>
                    <select name="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        <?php
                        $customers = $conn->query("SELECT customers.id, CONCAT(users.first_name, ' ', users.last_name) AS name FROM customers LEFT JOIN users ON customers.user_id = users.id");
                        while ($c = $customers->fetch_assoc()) {
                            echo "<option value='{$c['id']}'>" . htmlspecialchars($c['name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Total</label>
                    <input type="number" step="0.01" name="total" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Products</label>
                    <div id="products-list">
                        <?php
                        $products = $conn->query("SELECT id, name, price FROM products");
                        while ($p = $products->fetch_assoc()) {
                            ?>
                            <div class="form-row align-items-center mb-2">
                                <div class="col">
                                    <input type="checkbox" class="product-checkbox" name="products[]" value="<?php echo $p['id']; ?>">
                                    <?php echo htmlspecialchars($p['name']); ?> ($<?php echo $p['price']; ?>)
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="quantities[<?php echo $p['id']; ?>]" min="1" value="1" placeholder="Qty" style="width:80px;display:inline-block;">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Add Order</button>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!-- Edit Order Modal -->
    <div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form id="editOrderForm">
            <input type="hidden" name="id" id="edit_order_id">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Order</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                    <label>Customer</label>
                    <select name="customer_id" id="edit_customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        <?php
                        $customers = $conn->query("SELECT customers.id, CONCAT(users.first_name, ' ', users.last_name) AS name FROM customers LEFT JOIN users ON customers.user_id = users.id");
                        while ($c = $customers->fetch_assoc()) {
                            echo "<option value='{$c['id']}'>" . htmlspecialchars($c['name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Total</label>
                    <input type="number" step="0.01" name="total" id="edit_total" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Products</label>
                    <div id="products-list">
                        <?php
                        $products = $conn->query("SELECT id, name, price FROM products");
                        while ($p = $products->fetch_assoc()) {
                            ?>
                            <div class="form-row align-items-center mb-2">
                                <div class="col">
                                    <input type="checkbox" class="product-checkbox" name="products[]" value="<?php echo $p['id']; ?>">
                                    <?php echo htmlspecialchars($p['name']); ?> ($<?php echo $p['price']; ?>)
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="quantities[<?php echo $p['id']; ?>]" min="1" value="1" placeholder="Qty" style="width:80px;display:inline-block;">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </div>
        </form>
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

    <script>
    // Add Order
    $('#addOrderForm').on('submit', function(e){
        e.preventDefault();
        $.post('./order-actions/orders-actions.php', $(this).serialize() + '&action=add', function(res){
            let data = JSON.parse(res);
            if(data.success){
                $('#addOrderModal').modal('hide');
                $('#successMsg').text('Order added successfully!');
                $('#successAlert').fadeIn();
                setTimeout(() => { 
                    $('#successAlert').fadeOut();
                    location.reload();
                }, 1200); // Wait 1.2 seconds before reload
            } else {
                alert(data.message);
            }
        });
    });

    // Edit Order - open modal and fill fields
    $(document).on('click', '.edit-btn', function(){
        $('#edit_order_id').val($(this).data('id'));
        $('#edit_customer_id').val($(this).data('customer'));
        $('#edit_total').val($(this).data('total'));
        $('#edit_status').val($(this).data('status'));
        $('#editOrderModal').modal('show');
    });

    // Save Edit
    $('#editOrderForm').on('submit', function(e){
        e.preventDefault();
        $.post('./order-actions/orders-actions.php', $(this).serialize() + '&action=edit', function(res){
            let data = JSON.parse(res);
            if(data.success){
                $('#editOrderModal').modal('hide');
                $('#successMsg').text('Order updated successfully!');
                $('#successAlert').fadeIn();
                setTimeout(() => { 
                    $('#successAlert').fadeOut();
                    location.reload();
                }, 1200);
            } else {
                alert(data.message);
            }
        });
    });

    // Delete Order
    $(document).on('click', '.delete-btn', function(){
        if(confirm('Delete this order?')){
            $.post('./order-actions/orders-actions.php', {id: $(this).data('id'), action: 'delete'}, function(res){
                let data = JSON.parse(res);
                if(data.success){
                    $('#successMsg').text('Order deleted successfully!');
                    $('#successAlert').fadeIn();
                    setTimeout(() => { 
                        $('#successAlert').fadeOut();
                        $('#order-' + data.id).remove();
                    }, 1200);
                } else {
                    alert(data.message);
                }
            });
        }
    });
    </script>
</body>

</html>