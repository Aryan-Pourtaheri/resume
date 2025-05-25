<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr"
      data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>

  <!-- CSS & Fonts -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

  <!-- JS Config -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>

  <?php
    require '../connection.php';

    $error = '';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $first_name = trim($_POST['first_name']);
      $last_name = trim($_POST['last_name']);
      $username = trim($_POST['username']);
      $email = trim($_POST['email']);
      $password = $_POST['password'];
      $role_id = $_POST['role'];
      $status = 1;
      $created_at = date("Y-m-d H:i:s");
      $created_by = 'system';

      if (!isset($_POST['terms'])) {
        $error = "You must agree to the terms and conditions.";
      } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $error = "Password must be at least 8 characters long and include a letter and a number.";
      } else {
        $checkUsername = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $checkUsername->execute([$username]);
        $usernameExists = $checkUsername->fetchColumn();

        $checkEmail = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        $emailExists = $checkEmail->fetchColumn();

        if ($usernameExists > 0) {
          $error = "Username already taken.";
        } elseif ($emailExists > 0) {
          $error = "Email is already registered.";
        } else {
          // Securely hash password

          // Insert user
          $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password_hash, role_id, status, created_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $stmt->execute([$first_name, $last_name, $username, $email, $password, $role_id, $status, $created_at, $created_by]);

          $newUserId = $conn->lastInsertId();

          // If teacher, insert into teachers table
          if ($role_id == 2) {
            $fullName = $first_name . ' ' . $last_name;
            $teacherStmt = $conn->prepare("INSERT INTO teachers (id, name) VALUES (?, ?)");
            $teacherStmt->execute([$newUserId, $fullName]);
          }elseif ($role_id == 3) {
            $fullName = $first_name . ' ' . $last_name;
            $studentStmt = $conn->prepare("INSERT INTO students (id, name) VALUES (?, ?)");
            $studentStmt->execute([$newUserId, $fullName]);
          }

          header("Location: auth-login.php");
          exit;
        }
      }
    }

    // Load roles
    $roles = $conn->query("SELECT id, role_name FROM roles")->fetchAll(PDO::FETCH_ASSOC);
  ?>
</head>

<body>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
            <div class="app-brand justify-content-center">
              <a href="index.php" class="app-brand-link gap-2">
                <span class="app-brand-text demo text-body fw-bolder">Sign Up</span>
              </a>
            </div>

            <h4 class="mb-2">Create your account 🧑‍🎓</h4>

            <?php if (!empty($error)): ?>
              <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
              </div>
            <?php endif; ?>

            <form method="POST" class="mb-3" id="formAuthentication">
              <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" required />
              </div>

              <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" required />
              </div>

              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required />
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required />
              </div>

              <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" name="role" required>
                  <option selected disabled value="">Choose a role</option>
                  <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['role_name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    class="form-control"
                    name="password"
                    required
                    pattern="^(?=.*[A-Za-z])(?=.*\d).{8,}$"
                    title="At least 8 characters with letters and numbers"
                  />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>

              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="terms" name="terms" required />
                <label class="form-check-label" for="terms">
                  I agree to the <a href="#">privacy policy & terms</a>
                </label>
              </div>

              <button type="submit" class="btn btn-primary d-grid w-100">Register</button>
            </form>

            <p class="text-center">
              <span>Already have an account?</span>
              <a href="auth-login.php">Sign in</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/js/main.js"></script>
</body>
</html>
