<?php
session_start();
require_once "../../connection.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Make sure form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['exam_id'], $_POST['answers'])) {
    echo "<div class='alert alert-danger'>Invalid exam submission.</div>";
    exit;
}

$exam_id = intval($_POST['exam_id']);
$submitted_answers = $_POST['answers'];

// Fetch all correct answers for this exam
$stmt = $conn->prepare("SELECT id, correct_answer, points FROM questions WHERE exam_id = ?");
$stmt->execute([$exam_id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalScore = 0;
$totalPossible = 0;

// Calculate score
foreach ($questions as $question) {
    $qid = $question['id'];
    $correct = strtoupper($question['correct_answer']);
    $points = intval($question['points']);
    $totalPossible += $points;

    if (isset($submitted_answers[$qid]) && strtoupper($submitted_answers[$qid]) === $correct) {
        $totalScore += $points;
    }
}

// Save result to user_exams
$answers_json = json_encode($submitted_answers);

$stmt = $conn->prepare("
    INSERT INTO user_exams (user_id, exam_id, user_exam_score, answers)
    VALUES (?, ?, ?, ?)
");
$stmt->execute([$user_id, $exam_id, $totalScore, $answers_json]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exam Submitted</title>
  <link rel="stylesheet" href="../../assets/vendor/css/core.css">
  <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css">
</head>
<body>
  <div class="container mt-5">
    <div class="alert alert-success">
      🎉 <strong>Exam Submitted Successfully!</strong><br>
      Your Score: <strong><?= $totalScore ?> / <?= $totalPossible ?></strong>
    </div>
    <a href="dashboard.php" class="btn btn-primary">← Back to Dashboard</a>
  </div>
</body>
</html>
