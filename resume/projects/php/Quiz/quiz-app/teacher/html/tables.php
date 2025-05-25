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

    <title>Students</title>

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

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <script src="../../assets/js/config.js"></script>
  </head>
  <?php
      require_once "../../connection.php";
      session_start();
  
      if (!isset($_SESSION['teacher_id'])) {
        header("Location: ../../auth/auth-login.php");
        exit;
      }
  
      $teacher_id = $_SESSION['teacher_id'];
  ?>
  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?php include('../components/menu.php'); ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <?php include('../components/navbar.php'); ?>
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

              <div class="card">
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Name and Surname</th>
                        <th>Teacher</th>
                        <th>Point</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <?php
                      include('../../connection.php'); // Ensure correct path

                      $sql = "SELECT 
                                CONCAT(users.first_name, ' ', users.last_name) AS student_name,
                                users.id AS student_id,
                                teachers.name AS teacher_name,
                                user_exams.user_exam_score
                              FROM user_exams
                              JOIN users ON user_exams.user_id = users.id
                              JOIN exams ON user_exams.exam_id = exams.id
                              JOIN teachers ON exams.teacher_id = teachers.id
                              WHERE users.role_id = 1 AND exams.teacher_id = :teacher_id";

                      $stmt = $conn->prepare($sql);
                      $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
                      $stmt->execute();
                      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>


                    <tbody class="table-border-bottom-0">
                      <?php foreach ($results as $row): ?>
                        <tr>
                          <td><strong><?= htmlspecialchars($row['student_name']) ?></strong></td>
                          <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                          <td><?= htmlspecialchars($row['user_exam_score']) ?></td>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="edit-student.php?id=<?= $row['student_id'] ?>">
                                  <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                <a class="dropdown-item" href="delete-student.php?id=<?= $row['student_id'] ?>" onclick="return confirm('Are you sure?')">
                                  <i class="bx bx-trash me-1"></i> Delete
                                </a>
                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>

                  </table>
                </div>
              </div>


              


              
            </div>

            

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>

    <script src="../../assets/js/main.js"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
