<?php
require_once "../../connection.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if (!isset($_GET['exam_id'])) {
    echo "No exam selected.";
    exit();
}

$examId = (int)$_GET['exam_id'];
$userId = $_SESSION['user_id'];

// Get exam info
$stmt = $conn->prepare("SELECT exams.*, teachers.name AS teacher_name 
                        FROM exams 
                        JOIN teachers ON exams.teacher_id = teachers.id 
                        WHERE exams.id = ?");
$stmt->execute([$examId]);
$exam = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$exam) {
    echo "Exam not found.";
    exit();
}

// Get exam questions
$stmt = $conn->prepare("SELECT * FROM questions WHERE exam_id = ?");
$stmt->execute([$examId]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($exam['exam_name']) ?> - Start Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .exam-container {
            max-width: 800px;
            margin: auto;
            margin-top: 50px;
        }

        .question-box {
            background: #fff;
            border: 1px solid #dee2e6;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: 0.3s ease-in-out;
        }

        .question-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .question-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .form-check-label {
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
        }

        .back-btn {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="container exam-container">
        <div class="mb-4 text-center">
            <h2 class="fw-bold"><?= htmlspecialchars($exam['exam_name']) ?></h2>
            <p><strong>Teacher:</strong> <?= htmlspecialchars($exam['teacher_name']) ?></p>
            <div class="mb-3 text-center">
                <h5 class="text-danger fw-semibold">⏳ Time Remaining: <span id="timer"></span></h5>
            </div>
        </div>

        <form action="submit-exam.php" method="POST">
            <input type="hidden" name="exam_id" value="<?= $examId ?>">

            <?php if (count($questions) > 0): ?>
                <?php foreach ($questions as $index => $q): ?>
                    <div class="question-box">
                        <div class="question-title">
                            Q<?= $index + 1 ?>: <?= htmlspecialchars($q['question_text']) ?>
                        </div>
                        <?php foreach (['A', 'B', 'C', 'D', 'E'] as $option): ?>
                            <?php $optionText = $q["option_$option"]; ?>
                            <?php if (!empty($optionText)): ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio"
                                           name="answers[<?= $q['id'] ?>]"
                                           value="<?= $option ?>" id="q<?= $q['id'] . $option ?>" required>
                                    <label class="form-check-label" for="q<?= $q['id'] . $option ?>">
                                        <?= $option ?>. <?= htmlspecialchars($optionText) ?>
                                    </label>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary submit-btn mt-4">
                    ✅ Submit Exam
                </button>
            <?php else: ?>
                <div class="alert alert-info">No questions available for this exam.</div>
            <?php endif; ?>
        </form>

        <!-- Back to Dashboard Button -->
        <a href="dashboard.php" class="btn btn-secondary back-btn">← Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const examDuration = <?= (int)$exam['duration'] ?>; // in minutes
        let timeInSeconds = examDuration * 60;

        const timerDisplay = document.getElementById('timer');
        const examForm = document.querySelector('form');

        function updateTimerDisplay() {
            const hours = Math.floor(timeInSeconds / 3600);
            const minutes = Math.floor((timeInSeconds % 3600) / 60);
            const seconds = timeInSeconds % 60;

            timerDisplay.textContent = 
                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function countdown() {
            if (timeInSeconds <= 0) {
                clearInterval(timerInterval);
                alert('⏰ Time is up! Your exam will now be submitted.');
                examForm.submit(); // auto-submit the form
            } else {
                updateTimerDisplay();
                timeInSeconds--;
            }
        }

        updateTimerDisplay();
        const timerInterval = setInterval(countdown, 1000);
    </script>

</body>
</html>
