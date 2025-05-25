<?php
include('../config/connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch logged-in user's details
$user_id = $_SESSION['user_id'];
$query = "SELECT first_name, last_name, email, username, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If no user is found, handle the error
if (!$user) {
    die("Error: User not found.");  
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    // Handle profile image upload
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
        // Update user details in the database
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ?";
        $params = [$first_name, $last_name, $email, $username];

        // Add profile_image to the query if a new image was uploaded
        if ($profile_image) {
            $query .= ", profile_image = ?";
            $params[] = $profile_image;

            // Update the session with the new profile image
            $_SESSION['profile_image'] = $profile_image;
        }

        $query .= " WHERE id = ?";
        $params[] = $user_id;

        $stmt = $conn->prepare($query);
        $stmt->bind_param(str_repeat("s", count($params) - 1) . "i", ...$params);

        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
        } else {
            $error = "Failed to update profile.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <?php include('../components/admin-header/head.php'); ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('../components/admin-header/sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../components/admin-header/topbar.php'); ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Profile</h1>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <form action="profile.php" method="POST" enctype="multipart/form-data">
                                <div class="text-center mb-4">
                                    <img src="<?php echo isset($_SESSION['profile_image']) && $_SESSION['profile_image'] ? '../uploads/profile_images/' . htmlspecialchars($_SESSION['profile_image']) . '?t=' . time() : '../img/default_profile.jpg'; ?>" 
                                         alt="Profile Picture" 
                                         class="rounded-circle" 
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <div class="form-group">
                                    <label for="profile_image">Change Profile Photo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="profile_image" name="profile_image" accept="image/*">
                                        <label class="custom-file-label" for="profile_image">Choose file</label>
                                    </div>
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
                        </div>
                    </div>
                </div>
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
        // Update the file input label with the selected file name
        document.addEventListener('DOMContentLoaded', function () {
            const profileImageInput = document.getElementById('profile_image');
            profileImageInput.addEventListener('change', function () {
                const fileName = this.files[0]?.name || 'Choose file';
                const label = this.nextElementSibling;
                label.textContent = fileName;
            });
        });
    </script>
</body>

</html>