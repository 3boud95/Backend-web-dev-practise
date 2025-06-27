<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}
require_once "../config/db.php";

// Fetch students
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>
<h2>Student List</h2>
<a href="add.php">+ Add New Student</a>
<table border="1" cellpadding="10">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Age</th>
    <th>Email</th>
    <th>GPA</th>
    <th>Major</th>
    <th>Actions</th>
  </tr>

  <?php while ($row = $result->fetch_assoc()) : ?>
    <tr>
      <td><?= $row["id"] ?></td>
      <td><?= $row["name"] ?></td>
      <td><?= $row["age"] ?></td>
      <td><?= $row["email"] ?></td>
      <td><?= $row["gpa"] ?></td>
      <td><?= $row["major"] ?></td>
      <td>
        <a href="edit.php?id=<?= $row["id"] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row["id"] ?>" onclick="return confirm('Delete student?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>
<a href="../auth/logout.php">Logout</a>
