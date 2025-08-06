<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "carepoint_db");

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM doctors WHERE id=$id");
$doctor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Doctor</title>
  <style>
    body { font-family: Arial; padding: 40px; background-color: #f9f9f9; }
    form { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
    input, button { width: 100%; padding: 12px; margin-top: 15px; border-radius: 6px; }
    button { background: #0a994f; color: white; border: none; cursor: pointer; }
    button:hover { background: #067e42; }
  </style>
</head>
<body>
  <h2>Edit Doctor</h2>
  <form action="update-doctor.php" method="POST">
    <input type="hidden" name="id" value="<?= $doctor['id'] ?>">
    <input type="text" name="name" value="<?= $doctor['name'] ?>" placeholder="Doctor's Name" required>
    <input type="text" name="specialization" value="<?= $doctor['specialization'] ?>" placeholder="Specialization" required>
    <button type="submit">Update Doctor</button>
  </form>
</body>
</html>
