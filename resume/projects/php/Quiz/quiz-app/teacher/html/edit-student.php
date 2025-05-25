<?php
require_once "../../connection.php";
session_start();

if (!isset($_SESSION['teacher_id'])) {
  header("Location: ../../auth/auth-login.php");
  exit;
}

if (!isset($_GET['id'])) {
  die("Student ID not provided.");
}

$student_id = $_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];

  $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, updated_at = NOW(), updated_by = ? WHERE id = ?");
  $stmt->execute([$first_name, $last_name, $_SESSION['teacher_id'], $student_id]);

  header("Location: tables.php");
  exit;
}

// Fetch current student data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
  die("Student not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Student</title>
  <link rel="stylesheet" href="../../assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" />
  <link rel="stylesheet" href="../../assets/css/demo.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/bootstrap/bootstrap.min.css" />
</head>
<body>
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header">
        <h4 class="mb-0">Edit Student Information</h4>
      </div>
      <div class="card-body">
        <form method="POST">
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($student['first_name']) ?>" required>
          </div>

          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($student['last_name']) ?>" required>
          </div>

          <button type="submit" class="btn btn-primary">Save Changes</button>
          <a href="tables.php" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
  </div>

  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
</body>
</html>
