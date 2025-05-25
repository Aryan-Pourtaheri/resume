<?php
include('../../config/connection.php');
session_start();

if (!isset($_GET['id'])) {
    header("Location: ../admins.php?error=Invalid admin ID.");
    exit();
}

$admin_id = $_GET['id'];

$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);

if ($stmt->execute()) {
    header("Location: ../admins.php?success=Admin deleted successfully!");
} else {
    header("Location: ../admins.php?error=Failed to delete admin.");
}
exit();
?>