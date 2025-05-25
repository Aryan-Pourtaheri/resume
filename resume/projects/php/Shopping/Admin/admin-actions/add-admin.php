<?php
include('../../config/connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'admin'; // Default role for admin users
    $profile_image = null; // Default profile image

    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password)) {
        header("Location: ../admins.php?error=All fields are required.");
        exit();
    }

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/profile_images/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
        }
        $file_name = uniqid() . '_' . basename($_FILES['profile_image']['name']);
        $target_file = $upload_dir . $file_name;

        // Validate file type and size
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_type, $allowed_types)) {
            header("Location: ../admins.php?error=Invalid profile image format. Only JPG, JPEG, PNG, and GIF are allowed.");
            exit();
        } elseif ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) { // 2MB limit
            header("Location: ../admins.php?error=Profile image size must not exceed 2MB.");
            exit();
        } else {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $profile_image = $file_name;
            } else {
                header("Location: ../admins.php?error=Failed to upload profile image.");
                exit();
            }
        }
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new admin into the database
    $query = "INSERT INTO users (first_name, last_name, username, email, password_hash, role, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssssss", $first_name, $last_name, $username, $email, $hashed_password, $role, $profile_image);

        if ($stmt->execute()) {
            header("Location: ../admins.php?success=Admin added successfully!");
        } else {
            header("Location: ../admins.php?error=Failed to add admin. SQL Error: " . $stmt->error);
        }
    } else {
        // Debugging: Output the SQL error
        die("SQL Error: " . $conn->error);
    }
    exit();
}

// Fetch the hashed password from the database
$query = "SELECT password FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($entered_password, $user['password'])) {
    // Password is correct
    echo "Login successful!";
} else {
    // Password is incorrect
    echo "Invalid username or password.";
}
?>