<?php
require_once "../../connection.php";

if (!isset($_GET['exam_id'])) {
    die("Exam ID is required.");
}

$exam_id = $_GET['exam_id'];
$stmt = $conn->prepare("SELECT * FROM questions WHERE exam_id = ?");
$stmt->execute([$exam_id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Questions</title>
  <link rel="stylesheet" href="../../assets/vendor/css/core.css">
  <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css">
</head>
<body class="container py-4">
  <h3 class="mb-4">Manage Questions</h3>

  <?php foreach ($questions as $question): ?>
    <div class="card mb-3">
      <div class="card-body">
        <h5><?= htmlspecialchars($question['question_text']) ?></h5>
        <p>
          A) <?= $question['option_A'] ?> <br>
          B) <?= $question['option_B'] ?> <br>
          C) <?= $question['option_C'] ?> <br>
          D) <?= $question['option_D'] ?><br>
          E) <?= $question['option_E'] ?><br>
        </p>
        <a href="edit-question.php?id=<?= $question['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="delete-question.php?id=<?= $question['id'] ?>&exam_id=<?= $exam_id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
      </div>
    </div>
  <?php endforeach; ?>

      <a href="./dashboard.php" class="inline-block mb-4 text-blue-600 hover:underline">&larr; Back to Dashboard</a>
</body>
</html>
