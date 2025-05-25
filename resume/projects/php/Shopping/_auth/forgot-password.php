<?php
session_start();
include('../config/connection.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);

    // Check if the email exists in the database
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Generate a unique reset token
        $reset_token = bin2hex(random_bytes(32));
        $reset_expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store the reset token and expiry in the database
        $insert_query = "INSERT INTO password_resets (user_id, reset_token, reset_expiry) 
                         VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE reset_token = ?, reset_expiry = ?";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("issss", $user_id, $reset_token, $reset_expiry, $reset_token, $reset_expiry);
        $stmt->execute();

        // Send the reset email
        $reset_link = "http://localhost/Shopping/_auth/reset-password.php?token=$reset_token";
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n\n$reset_link\n\nThis link will expire in 1 hour.";
        $headers = "From: no-reply@shopping.com";

        if (mail($email, $subject, $message, $headers)) {
            $_SESSION['success'] = "A password reset link has been sent to your email.";
        } else {
            $_SESSION['error'] = "Failed to send the reset email. Please try again.";
        }
    } else {
        $_SESSION['error'] = "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forgot Password</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg border-0 my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Forgot Your Password?</h1>
                            <p class="mb-4">Enter your email address below, and we'll send you a link to reset your password.</p>
                        </div>
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block w-100">Send Reset Link</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="register.php">Create an Account</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="login.php">Already have an account? Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>