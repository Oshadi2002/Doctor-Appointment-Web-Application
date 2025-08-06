<?php
session_start();
$conn = new mysqli("localhost", "root", "", "carepoint_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admins WHERE username=? AND password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['admin_logged_in'] = true;
    header("Location: admin-dashboard.php");
} else {
    echo "<script>alert('Invalid username or password'); window.location.href='admin-login.html';</script>";
}
?>
