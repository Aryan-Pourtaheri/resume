<?php
include('../config/connection.php');
session_start();

// Check if the user is already logged in
function isLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['role'] === 'admin') {
            header("Location: ../Admin/dashboard.php"); // Redirect to admin dashboard
        } else {
            header("Location: ../shop.php"); // Redirect to customer index
        }
        exit();
    }
}

isLoggedIn();

// Handle login form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier']; // Can be email or username
    $password = $_POST['password'];

    // Query to fetch user details by email or username
    $query = "SELECT id, first_name, last_name, password_hash, profile_image, role FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify user and password
    if ($user && password_verify($password, $user['password_hash'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['profile_image'] = $user['profile_image']; // Set profile image

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: ../Admin/dashboard.php");
        } elseif ($user['role'] === 'customer') {
            header("Location: ../shop.php");
        }
        exit();
    } else {
        $error = "Invalid email/username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg my-5">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Welcome Back!</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="identifier">Email or Username</label>
                                <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter Email or Username..." required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="forgot-password.php">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="register.php">Create an Account!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>