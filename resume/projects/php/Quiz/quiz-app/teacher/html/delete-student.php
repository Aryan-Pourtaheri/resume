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

// Delete related user_exams first (if needed)
$stmt = $conn->prepare("DELETE FROM user_exams WHERE user_id = ?");
$stmt->execute([$student_id]);

// Delete user
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$student_id]);

header("Location: tables.php");
exit;
