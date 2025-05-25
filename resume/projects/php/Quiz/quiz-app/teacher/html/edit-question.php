<?php
require_once "../../connection.php";

if (!isset($_GET['id'])) {
    die("Question ID is required.");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->execute([$id]);
$question = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $text = $_POST['question_text'];
    $a = $_POST['option_a'];
    $b = $_POST['option_b'];
    $c = $_POST['option_c'];
    $d = $_POST['option_d'];
    $e = $_POST['option_e'];
    $correct = $_POST['correct_answer'];

    $update = $conn->prepare("UPDATE questions SET question_text=?, option_A=?, option_B=?, option_C=?, option_D=?,option_E=?, correct_answer=? WHERE id=?");
    $update->execute([$text, $a, $b, $c, $d, $e, $correct, $id]);

    header("Location: manage-questions.php?exam_id=" . $question['exam_id']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Question</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white shadow-lg rounded-xl p-8 max-w-xl w-full">
    <h3 class="text-2xl font-semibold mb-6 text-center text-gray-800">Edit Question</h3>
    <form method="post" class="space-y-4">
      <div>
        <label class="block text-gray-700 font-medium mb-1">Question</label>
        <textarea name="question_text" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($question['question_text']) ?></textarea>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Option A</label>
        <input type="text" name="option_a" value="<?= htmlspecialchars($question['option_A']) ?>" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Option B</label>
        <input type="text" name="option_b" value="<?= htmlspecialchars($question['option_B']) ?>" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Option C</label>
        <input type="text" name="option_c" value="<?= htmlspecialchars($question['option_C']) ?>" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Option D</label>
        <input type="text" name="option_d" value="<?= htmlspecialchars($question['option_D']) ?>" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Option E</label>
        <input type="text" name="option_e" value="<?= htmlspecialchars($question['option_E']) ?>" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Correct Option</label>
        <select name="correct_answer" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="A" <?= $question['correct_answer'] === 'A' ? 'selected' : '' ?>>A</option>
          <option value="B" <?= $question['correct_answer'] === 'B' ? 'selected' : '' ?>>B</option>
          <option value="C" <?= $question['correct_answer'] === 'C' ? 'selected' : '' ?>>C</option>
          <option value="D" <?= $question['correct_answer'] === 'D' ? 'selected' : '' ?>>D</option>
          <option value="E" <?= $question['correct_answer'] === 'E' ? 'selected' : '' ?>>E</option>
        </select>
      </div>

      <div class="text-center">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all">Update</button>
      </div>
    </form>
  </div>
</body>
</html>
