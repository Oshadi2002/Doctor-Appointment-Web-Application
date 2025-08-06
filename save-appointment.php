<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];

    // 2. Generate appointment number
    $appointment_no = "APT" . rand(1000, 9999);

    // 3. Save to database
    $conn = new mysqli("localhost", "root", "", "carepoint_db");

    if ($conn->connect_error) {
        die("DB Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone, department, date, time, message, appointment_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $phone, $department, $date, $time, $message, $appointment_no);
    $stmt->execute();

    // 4. Send confirmation email
    $subject = "Your Appointment Confirmation - CarePoint";
    $body = "Hi $name,\n\nYour appointment has been confirmed.\nAppointment No: $appointment_no\nDate: $date\nTime: $time\n\nThank you!";
    $headers = "From: carepoint@gmail.com";

    mail($email, $subject, $body, $headers);

    // 5. Redirect to success page
    header("Location: succes.php?apt_no=$appointment_no");
    exit();
}
?>
