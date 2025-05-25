<?php
require_once "../../connection.php";
session_start();

if (!isset($_SESSION['teacher_id'])) {
  header("Location: ../../auth/auth-login.php");
  exit;
}

$teacher_id = $_SESSION['teacher_id'];

// Fetch teachers
$teacher_stmt = $conn->query("SELECT id, name FROM teachers");
$teachers = $teacher_stmt->fetchAll(PDO::FETCH_ASSOC);

$classes_stmt = $conn->query("SELECT id, name FROM classes");
$classes = $classes_stmt->fetchAll(PDO::FETCH_ASSOC);

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $exam_name = $_POST["exam_name"];
    $teacher_id = $_POST["teacher_id"];
    $exam_date = $_POST["exam_date"];
    $duration = $_POST["duration"];
    $total_points = $_POST["total_points"];
    $num_questions = $_POST["num_questions"];
    $class_id = $_POST["class_id"];

    $stmt = $conn->prepare("INSERT INTO exams (exam_name, teacher_id, exam_date, duration, total_points, num_questions, class_id) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$exam_name, $teacher_id, $exam_date, $duration, $total_points, $num_questions, $class_id]);

    $success_message = "Quiz created successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Quiz</title>
  
  <!-- Bootstrap core -->
  <link rel="stylesheet" href="../../assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" />
  <link rel="stylesheet" href="../../assets/css/demo.css" />
  <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

  <!-- Required helpers -->
  <script src="../../assets/vendor/js/helpers.js"></script>
  <script src="../../assets/js/config.js"></script>
</head>

<body class="bg-light">
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    <?php include('../components/menu.php'); ?>

    <div class="layout-page">
      <?php include('../components/navbar.php'); ?>

      <div class="content-wrapper">
        <div class="container mt-5">
          <div class="card">
            <div class="card-header bg-id text-white text-center">
              <h4 class="mb-0">Add New Quiz</h4>
            </div>
            <div class="card-body">
              <?php if ($success_message): ?>
                <div class="alert alert-success"><?= $success_message ?></div>
              <?php endif; ?>

              <form method="POST">
                <div class="mb-3">
                  <label class="form-label">Quiz Name</label>
                  <input type="text" name="exam_name" class="form-control" required placeholder="e.g., Math Quiz 1" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Teacher</label>
                  <select name="teacher_id" class="form-control" required>
                    <option value="">Select Teacher</option>
                    <?php foreach ($teachers as $teacher): ?>
                      <option value="<?= $teacher['id'] ?>"><?= htmlspecialchars($teacher['name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Exam Date</label>
                  <input type="date" name="exam_date" class="form-control" required min="<?= date('Y-m-d') ?>" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Duration (minutes)</label>
                  <input type="number" name="duration" class="form-control" required min="5" max="180" placeholder="Min: 5, Max: 180" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Total Points</label>
                  <input type="number" name="total_points" class="form-control" required min="1" max="100" placeholder="e.g., 100" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Number of Questions</label>
                  <input type="number" name="num_questions" class="form-control" required min="1" max="100" placeholder="Max: 100" />
                </div>

                <div class="mb-3">
                  <label class="form-label">Classes</label>
                  <select name="class_id" class="form-control" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class): ?>
                      <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <button type="submit" class="btn btn-success w-100">Create Quiz</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Core JS -->
  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/js/menu.js"></script>
  <script src="../../assets/js/main.js"></script>
</div>
</body>
</html>
