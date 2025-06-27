<?php

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

// get student id from URL
if (!isset($_GET["id"])) {
    die("No student ID provided.");
}

$id = $_GET["id"];

// fetch student data
$result = $conn->query("SELECT * FROM students WHERE id = $id");
$student = $result->fetch_assoc();

if(!$student) {
    die("Student not found.");
}

// handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $age = (int) $_POST["age"];
    $email = trim($_POST["email"]);
    $gpa = $_POST["gpa"];
    $major = trim($_POST["major"]);

    if (strlen($name) < 2) $errors[] = "Name must be at least 2 characters long";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email";
    if ($age < 10 || $age > 100) $errors[] = "Age must be between 10 and 100";
    if (!is_numeric($gpa) || $gpa < 0 || $gpa > 4.0) $errors[] = "GPA must be a number between 0 and 4.0";
    if (strlen($major) < 2) $errors[] = "Major is required";

    if (empty($errors)) {
    $stmt = $conn->prepare("UPDATE students SET name=?, age=?, email=?, gpa=?, major=? WHERE id=?");
    $stmt->bind_param("sisdsi", $name, $age, $email, $gpa, $major, $id);
    $stmt->execute();
    }

    header("Location: index.php");
    exit;
}
?>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h2>Edit Student</h2>
<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?= $student['name'] ?>" required><br><br>

    <label>Age:</label><br>
    <input type="number" name="age" value="<?= $student['age'] ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $student['email'] ?>" required><br><br>

    <label>GPA:</label><br>
    <input type="text" name="gpa" value="<?= $student['gpa'] ?>"><br><br>

    <label>Major:</label><br>
    <input type="text" name="major" value="<?= $student['major'] ?>"><br><br>

    <button type="submit">Update Student</button>
</form>