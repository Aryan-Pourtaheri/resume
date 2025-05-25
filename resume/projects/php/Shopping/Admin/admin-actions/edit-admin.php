<?php
include('../../config/connection.php');

session_start();

if (!isset($_GET['id'])) {
    header("Location: admins.php");
    exit();
}

$admin_id = $_GET['id'];
$error = '';
$success = '';

// Fetch admin details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update admin details
    $query = "UPDATE users SET username = ?, email = ?";
    $params = [$username, $email];

    if (!empty($password)) {
        $query .= ", password = ?";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
    }

    $query .= " WHERE id = ?";
    $params[] = $admin_id;

    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat("s", count($params) - 1) . "i", ...$params);

    if ($stmt->execute()) {
        $success = "Admin updated successfully!";
    } else {
        $error = "Failed to update admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Admin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="h3 mb-4 text-gray-800">Edit Admin</h1>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password (Leave blank to keep current password)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Update Admin</button>
            <a href="../admins.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>