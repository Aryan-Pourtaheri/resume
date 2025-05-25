<?php
include('../config/connection.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $username, $user_id);

    if ($stmt->execute()) {
        $_SESSION['username'] = $username; // Update session username
        header("Location: profile.php?success=1");
    } else {
        header("Location: profile.php?error=1");
    }
    exit();
}
?>