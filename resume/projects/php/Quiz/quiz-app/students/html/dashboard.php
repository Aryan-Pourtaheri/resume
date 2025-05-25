<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Teacher Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <script src="../../assets/js/config.js"></script>
  </head>

  <?php
    require_once "../../connection.php";
    session_start();
    if (!isset($_SESSION['user_id'])) {
      header("Location: ../../auth/auth-login.php");
      exit;
    }

    $userId = $_SESSION['user_id'];
    
    $stmt = $conn->query("SELECT exams.*, teachers.name AS teacher_name 
                          FROM exams 
                          JOIN teachers ON exams.teacher_id = teachers.id");
    $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                  <?php



                  $stmt = $conn->prepare("
                    SELECT exams.*, teachers.name AS teacher_name, classes.name AS class_name
                    FROM exams
                    JOIN teachers ON exams.teacher_id = teachers.id
                    JOIN classes ON exams.class_id = classes.id
                    WHERE exams.id NOT IN (
                        SELECT exam_id FROM user_exams WHERE user_id = ?
                    )
                  ");

                  $stmt->execute([$userId]);
                  $availableExams = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  ?>

                  <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                      <div class="col-12 mb-4">
                        <h4 class="fw-bold py-3 mb-4">Available Exams</h4>
                      </div>
                        <?php if (count($availableExams) > 0): ?>
                          <?php foreach ($availableExams as $exam): ?>
                            <div class="col-md-8 col-lg-8 mb-4">
                              <div class="card">
                                <div class="card-body">
                                  <h5 class="card-title"><?= htmlspecialchars($exam['exam_name']) ?></h5>
                                  <p><strong>Teacher:</strong> <?= htmlspecialchars($exam['teacher_name']) ?></p>
                                  <p class="mb-1"><strong>Class:</strong> <?= htmlspecialchars($exam['class_name']) ?></p>
                                  <p><strong>Date:</strong> <?= $exam['exam_date'] ?></p>
                                  <p><strong>Duration:</strong> <?= $exam['duration'] ?> min</p>
                                  <p><strong>Total Points:</strong> <?= $exam['total_points'] ?>%</p>

                                  <a href="start-exam.php?exam_id=<?= $exam['id'] ?>" class="btn btn-success w-100 mt-2">
                                    Start Exam
                                  </a>
                                </div>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <div class="col-12">
                            <div class="alert alert-info text-center">
                              🎉 You have completed all available exams!
                            </div>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>
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
  </body>
</html>
