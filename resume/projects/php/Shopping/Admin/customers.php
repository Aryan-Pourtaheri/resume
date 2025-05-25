<?php include('../config/connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Customers</title>
    <?php include('../components/admin-header/head.php'); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('../components/admin-header/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../components/admin-header/topbar.php'); ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Manage Customers</h1>

                    <!-- Customer Table -->
                    <table class="table table-bordered" id="customerTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT 
                                    customers.id AS customer_id, 
                                    CONCAT(users.first_name, ' ', users.last_name) AS name, 
                                    users.email, 
                                    customers.phone, 
                                    customers.city 
                                FROM customers 
                                LEFT JOIN users ON customers.user_id = users.id
                            ";
                            $result = $conn->query($query);

                            if ($result) {
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                            ?>
                                        <tr id="customer-<?php echo $row['customer_id']; ?>">
                                            <td><?php echo $row['customer_id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['city']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning edit-btn" 
                                                    data-id="<?php echo $row['customer_id']; ?>" 
                                                    data-name="<?php echo $row['name']; ?>" 
                                                    data-email="<?php echo $row['email']; ?>" 
                                                    data-phone="<?php echo $row['phone']; ?>" 
                                                    data-city="<?php echo $row['city']; ?>">Edit</button>
                                                <button class="btn btn-sm btn-danger delete-btn" 
                                                    data-id="<?php echo $row['customer_id']; ?>">Delete</button>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No customers found</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Error: " . $conn->error . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCustomerForm">
                    <div class="modal-body">
                        <input type="hidden" name="customer_id" id="edit_customer_id">
                        <div class="form-group">
                            <label for="edit_first_name">First Name</label>
                            <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_last_name">Last Name</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_phone">Phone</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_city">City</label>
                            <input type="text" class="form-control" id="edit_city" name="city" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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

    <script>
        // Populate form for editing
        $(document).on('click', '.edit-btn', function () {
            const id = $(this).data('id');
            const nameParts = $(this).data('name').split(' ');
            $('#edit_customer_id').val(id);
            $('#edit_first_name').val(nameParts[0]);
            $('#edit_last_name').val(nameParts[1]);
            $('#edit_email').val($(this).data('email'));
            $('#edit_phone').val($(this).data('phone'));
            $('#edit_city').val($(this).data('city'));
            $('#editCustomerModal').modal('show');
        });

        // Handle Edit Customer
        $('#editCustomerForm').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.post('customer-actions/customer-actions.php', formData, function (response) {
                const data = JSON.parse(response);
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert(data.message);
                }
            });
        });

        // Handle Delete Customer
        $(document).on('click', '.delete-btn', function () {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this customer?')) {
                $.post('customer-actions/customer-actions.php', { delete_customer_id: id }, function (response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        alert(data.message);
                        $(`#customer-${id}`).remove(); // Remove the row dynamically
                    } else {
                        alert(data.message);
                    }
                });
            }
        });
    </script>
</body>

</html>