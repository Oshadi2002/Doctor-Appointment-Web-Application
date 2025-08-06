<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "carepoint_db");

$id = $_GET['id'];

$conn->query("DELETE FROM doctors WHERE id=$id");

header("Location: admin-dashboard.php");
?>
