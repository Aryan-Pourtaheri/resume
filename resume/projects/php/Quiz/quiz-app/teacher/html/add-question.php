<?php
session_start();
require_once "../../connection.php";

// ✅ Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../../login.php");
    exit;
}

$teacher_id = $_SESSION['teacher_id'];
$exam_id = isset($_GET['exam_id']) ? intval($_GET['exam_id']) : null;

if (!$exam_id) {
    echo "<div class='alert alert-danger'>No exam selected. Please go back and choose an exam.</div>";
    exit;
}

// ✅ Ensure the exam belongs to this teacher
$stmt = $conn->prepare("SELECT * FROM exams WHERE id = ? AND teacher_id = ?");
$stmt->execute([$exam_id, $teacher_id]);
$exam = $stmt->fetch();

if (!$exam) {
    die("<div class='alert alert-danger'>Unauthorized access to this exam.</div>");
}

// ✅ Get allowed number of questions
$maxQuestions = (int)$exam['num_questions'];

// ✅ Count current number of questions for this exam
$stmt = $conn->prepare("SELECT COUNT(*) FROM questions WHERE exam_id = ?");
$stmt->execute([$exam_id]);
$currentQuestionCount = $stmt->fetchColumn();
$canAddMore = $currentQuestionCount < $maxQuestions;

// ✅ Fetch departments
$deptStmt = $conn->query("SELECT id, name FROM departments");
$departments = $deptStmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Handle form submission
$successMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($canAddMore) {
        $department_id   = $_POST["department_id"];
        $topic           = $_POST["topic"];
        $question_text   = $_POST["question_text"];
        $option_A        = $_POST["option_A"];
        $option_B        = $_POST["option_B"];
        $option_C        = $_POST["option_C"];
        $option_D        = $_POST["option_D"];
        $option_E        = $_POST["option_E"];
        $correct_answer  = $_POST["correct_answer"];
        $points          = $_POST["points"];

        $sql = "INSERT INTO questions (
                    exam_id, department_id, topic, question_text, correct_answer,
                    option_A, option_B, option_C, option_D, option_E, points
                ) VALUES (
                    :exam_id, :department_id, :topic, :question_text, :correct_answer,
                    :option_A, :option_B, :option_C, :option_D, :option_E, :points
                )";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":exam_id"        => $exam_id,
            ":department_id"  => $department_id,
            ":topic"          => $topic,
            ":question_text"  => $question_text,
            ":correct_answer" => $correct_answer,
            ":option_A"       => $option_A,
            ":option_B"       => $option_B,
            ":option_C"       => $option_C,
            ":option_D"       => $option_D,
            ":option_E"       => $option_E,
            ":points"         => $points
        ]);

        $successMessage = "✅ Question added successfully!";
        $currentQuestionCount++;
        $canAddMore = $currentQuestionCount < $maxQuestions;
    } else {
        $successMessage = "⚠️ You’ve already added the maximum number of questions ($maxQuestions) for this exam.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Question</title>
    <link rel="stylesheet" href="../../assets/vendor/css/core.css">
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css">
    <link rel="stylesheet" href="../../assets/css/demo.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Question to Exam: <?= htmlspecialchars($exam['exam_name']) ?></h2>
        <p><strong>Questions added:</strong> <?= $currentQuestionCount ?> / <?= $maxQuestions ?></p>

        <?php if ($successMessage): ?>
            <div class="alert alert-info mt-3"><?= $successMessage ?></div>
        <?php endif; ?>

        <?php if ($canAddMore): ?>
            <form method="POST" class="mt-4">
                <div class="mb-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select name="department_id" id="department_id" class="form-select" required>
                        <option value="">Select Department</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="topic" class="form-label">Topic</label>
                    <input type="text" class="form-control" id="topic" name="topic" required>
                </div>

                <div class="mb-3">
                    <label for="question_text" class="form-label">Question</label>
                    <textarea class="form-control" id="question_text" name="question_text" rows="3" required></textarea>
                </div>

                <div class="mb-2"><strong>Options:</strong></div>
                <?php foreach (['A', 'B', 'C', 'D', 'E'] as $opt): ?>
                    <div class="mb-2">
                        <label for="option_<?= $opt ?>" class="form-label">Option <?= $opt ?></label>
                        <input type="text" class="form-control" name="option_<?= $opt ?>" id="option_<?= $opt ?>" required>
                    </div>
                <?php endforeach; ?>

                <div class="mb-3">
                    <label for="correct_answer" class="form-label">Correct Answer</label>
                    <select name="correct_answer" id="correct_answer" class="form-select" required>
                        <option value="">Select Correct Option</option>
                        <?php foreach (['A', 'B', 'C', 'D', 'E'] as $opt): ?>
                            <option value="<?= $opt ?>"><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="points" class="form-label">Points</label>
                    <input type="number" class="form-control" name="points" id="points" value="10" required>
                </div>

                <button type="submit" class="btn btn-primary">➕ Add Question</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning mt-4">
                ❌ You have reached the maximum number of questions (<?= $maxQuestions ?>) for this exam.
            </div>
        <?php endif; ?>

        <a href="dashboard.php" class="btn btn-secondary mt-4">← Back to Dashboard</a>
    </div>
</body>
</html>
