<?php
require_once "../../connection.php";

if (!isset($_GET['id']) || !isset($_GET['exam_id'])) {
    die("Required data missing.");
}

$id = $_GET['id'];
$exam_id = $_GET['exam_id'];

$stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
$stmt->execute([$id]);

header("Location: manage-questions.php?exam_id=$exam_id");
exit;
?>