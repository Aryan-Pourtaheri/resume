<?php
session_start();
require_once '../connection.php'; // Adjust the path as needed

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Look for the token in the users table
        $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password_hash = ?, reset_token = NULL WHERE id = ?");
            $update->execute([$hashedPassword, $user['id']]);
            $success = "Password successfully reset. <a href='auth-login.php'>Login here</a>.";
        } else {
            $error = "Invalid or expired reset link.";
        }
    }
}

// Get token from GET or POST
$token = $_GET['token'] ?? $_POST['token'] ?? '';
?>

<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password</title>
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
</head>
<body>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <div class="card">
          <div class="card-body">
            <div class="app-brand justify-content-center mb-3">
            </div>
            <h4 class="mb-2">Reset Your Password 🔒</h4>
            <p class="mb-4">Enter your new password below to reset your account password</p>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php elseif (!empty($success)): ?>
              <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form action="reset-password.php" method="POST">
              <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" />
              <div class="mb-3">
                <label class="form-label" for="password">New Password</label>
                <input type="password" id="password" name="password" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label" for="confirm">Confirm Password</label>
                <input type="password" id="confirm" name="confirm" class="form-control" required />
              </div>
              <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
            </form>

            <div class="text-center mt-3">
              <a href="auth-login.php"><i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i> Back to login</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
</body>
</html>
