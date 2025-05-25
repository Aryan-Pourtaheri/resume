<?php
session_start();
include('./config/connection.php'); // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: ./_auth/login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$query = "SELECT first_name, last_name, email, username, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);

    // Handle profile picture upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = './uploads/profile_pictures/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_name = basename($_FILES['profile_image']['name']);
        $file_path = $upload_dir . $user_id . '_' . $file_name;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $file_path);

        // Update profile image in the database
        $update_image_query = "UPDATE users SET profile_image = ? WHERE id = ?";
        $stmt = $conn->prepare($update_image_query);
        $stmt->bind_param("si", $file_path, $user_id);
        $stmt->execute();

        // Update the profile image in the session
        $_SESSION['profile_image'] = $file_path;
        $user['profile_image'] = $file_path; // Update the profile image in the current session
    }

    // Update user details in the database
    $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $username, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully.";
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
    } else {
        $_SESSION['error'] = "Failed to update profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-lg my-5">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group text-center">
                                <label for="profile_image">Profile Picture</label>
                                <div class="mb-3">
                                    <img src="<?php echo $user['profile_image'] ? htmlspecialchars($user['profile_image']) : './uploads/profile_pictures/default.png'; ?>" 
                                         alt="Profile Picture" class="img-thumbnail" style="width: 150px; height: 150px;">
                                </div>
                                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="./shop.php">Back to Shop</a>
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