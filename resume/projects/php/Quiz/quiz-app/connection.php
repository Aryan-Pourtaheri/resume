<?php
  $host = "localhost"; // Change if needed
  $dbname = "quiz"; // Database name
  $username = "root"; // Change to your MySQL username
  $password = ""; // Change to your MySQL password

  try {
      $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
      // Set PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
  }
?>
