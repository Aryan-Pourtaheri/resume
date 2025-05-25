<?php
include('../config/connection.php');
session_start();

// Handle registration form submission
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; // Get the role from the form

    // Customer-specific fields
    $address = $_POST['address'] ?? null;
    $city = $_POST['city'] ?? null;
    $country = $_POST['country'] ?? null;
    $phone = $_POST['phone'] ?? null;

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } 
    // Check if the password is strong
    elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $error = "Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } 
    else {
        // Check if email or username already exists
        $query = "SELECT id FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email or username already exists.";
        } else {
            // Handle file upload
            $profile_image = null;
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = '../uploads/profile_images/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
                }
                $file_name = uniqid() . '_' . basename($_FILES['profile_image']['name']);
                $target_file = $upload_dir . $file_name;

                // Validate file type and size
                $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($file_type, $allowed_types)) {
                    $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
                } elseif ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) { // 2MB limit
                    $error = "File size must not exceed 2MB.";
                } else {
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                        $profile_image = $file_name;
                    } else {
                        $error = "Failed to upload the profile image.";
                    }
                }
            }

            if (!$error) {
                // Hash the password
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user into the users table
                $query = "INSERT INTO users (first_name, last_name, email, username, password_hash, role, status, profile_image) VALUES (?, ?, ?, ?, ?, ?, 1, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssssss", $first_name, $last_name, $email, $username, $password_hash, $role, $profile_image);

                if ($stmt->execute()) {
                    $user_id = $conn->insert_id; // Get the ID of the newly inserted user

                    // If the role is "Customer," insert into the customers table
                    if ($role === 'customer') {
                        $query = "INSERT INTO customers (user_id, address, city, country, phone) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("issss", $user_id, $address, $city, $country, $phone);
                        if ($stmt->execute()) {
                            $success = "Registration successful! You can now log in.";
                        } else {
                            $error = "Failed to save customer details.";
                        }
                    } else {
                        $success = "Registration successful! You can now log in.";
                    }
                } else {
                    $error = "An error occurred. Please try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg my-5">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Create an Account</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required onchange="toggleCustomerFields(this.value)">
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="customer" <?php echo isset($_POST['role']) && $_POST['role'] === 'customer' ? 'selected' : ''; ?>>Customer</option>
                                    <option value="admin" <?php echo isset($_POST['role']) && $_POST['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                            <div id="customer-fields" style="display: <?php echo isset($_POST['role']) && $_POST['role'] === 'customer' ? 'block' : 'none'; ?>;">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                                </div>
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="City">
                                </div>
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="profile_image">Profile Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image" name="profile_image" accept="image/*">
                                    <label class="custom-file-label" for="profile_image">Choose file</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="login.php" class="small">Already have an account? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../js/register.js"></script>
       
</body>

</html>