<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "carepoint_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$specialization = $_POST['specialization'];

$sql = "INSERT INTO doctors (name, specialization) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $specialization);

if ($stmt->execute()) {
    echo "<script>alert('Doctor added successfully!'); window.location.href='admin-dashboard.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}
?>
