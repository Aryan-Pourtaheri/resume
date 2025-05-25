<?php
require_once "../../connection.php";
session_start();

// Optional: check if user is logged in and is a teacher/admin
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("⚠️ Invalid or missing exam ID.");
}

$exam_id = (int)$_GET['id'];

try {
    // Begin transaction
    $conn->beginTransaction();

    // Delete related user exam results
    $stmt1 = $conn->prepare("DELETE FROM user_exams WHERE exam_id = ?");
    $stmt1->execute([$exam_id]);

    // Delete related questions
    $stmt2 = $conn->prepare("DELETE FROM questions WHERE exam_id = ?");
    $stmt2->execute([$exam_id]);

    // Delete the exam itself
    $stmt3 = $conn->prepare("DELETE FROM exams WHERE id = ?");
    $stmt3->execute([$exam_id]);

    // Commit all
    $conn->commit();

    // Redirect with success message (optional)
    header("Location: dashboard.php?deleted=1");
    exit;
} catch (PDOException $e) {
    // Rollback if any step fails
    $conn->rollBack();
    die("❌ Failed to delete exam: " . $e->getMessage());
}
?>
