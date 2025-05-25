<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Teacher Dashboard</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <script src="../../assets/js/config.js"></script>
  </head>

  <?php
  require_once "../../connection.php";
  session_start();

  // Check if teacher is logged in
  if (!isset($_SESSION['teacher_id'])) {
    header("Location: ../../auth/auth-login.php");
    exit;
  }

  $teacher_id = $_SESSION['teacher_id'];

  // Fetch the exams for the logged-in teacher
  $stmt = $conn->prepare("
    SELECT exams.*, teachers.name AS teacher_name, classes.name AS class_name
    FROM exams 
    JOIN teachers ON exams.teacher_id = teachers.id
    JOIN classes ON exams.class_id = classes.id
    WHERE exams.teacher_id = ?
  ");

  $stmt->execute([$teacher_id]);
  $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Function to format duration
  function formatDuration($minutes) {
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;

    $formatted = '';
    if ($hours > 0) {
      $formatted .= $hours . ' hour' . ($hours > 1 ? 's' : '');
    }
    if ($mins > 0) {
      if ($hours > 0) $formatted .= ' ';
      $formatted .= $mins . ' minute' . ($mins > 1 ? 's' : '');
    }

    return $formatted ?: '0 minutes';
  }
  ?>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <?php include('../components/menu.php');?>

        <!-- Layout container -->
        <div class="layout-page">
          <?php include('../components/navbar.php');?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                  <?php foreach ($exams as $exam): ?>
                    <div class="col-lg-6 col-md-6 col-12 mb-4">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="d-flex justify-content-between">
                            <div class="dropdown">
                              <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="manage-questions.php?exam_id=<?= $exam['id'] ?>">Manage Questions</a>
                                <a class="dropdown-item text-danger" href="delete-exam.php?id=<?= $exam['id'] ?>" onclick="return confirm('Are you sure you want to delete this entire exam and its questions?')">Delete Exam</a>
                              </div>
                            </div>
                          </div>

                          <h5 class="card-title mt-3"><?= htmlspecialchars($exam['exam_name']) ?></h5>
                          <p class="mb-1"><strong>Teacher:</strong> <?= htmlspecialchars($exam['teacher_name']) ?></p>
                          <p class="mb-1"><strong>Class:</strong> <?= htmlspecialchars($exam['class_name']) ?></p>    
                          <p class="mb-1"><strong>Date:</strong> <?= $exam['exam_date'] ?></p>
                          <p class="mb-1"><strong>Duration:</strong> <?= formatDuration($exam['duration']) ?></p> <!-- Duration formatting here -->
                          <p class="mb-3"><strong>Points:</strong> <?= $exam['total_points'] ?>%</p>

                          <a href="add-question.php?exam_id=<?= $exam['id'] ?>" class="btn btn-primary w-100">
                            <i class="bx bx-plus-circle me-1"></i> Add Questions
                          </a>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
          <!-- Overlay -->
          <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js ../assets/vendor/js/core.js -->
        <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
        <script src="../../assets/vendor/libs/popper/popper.js"></script>
        <script src="../../assets/vendor/js/bootstrap.js"></script>
        <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="../../assets/vendor/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

        <!-- Main JS -->
        <script src="../../assets/js/main.js"></script>

        <!-- Page JS -->
        <script src="../../assets/js/dashboards-analytics.js"></script>

        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
      </div>
    </body>
  </html>
