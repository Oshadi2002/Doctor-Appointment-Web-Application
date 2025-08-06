<?php
$apt_no = $_GET['apt_no'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment Success</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container success">
    <h2> Appointment Booked Successfully!</h2>
    <p>Your appointment number is: <strong><?= htmlspecialchars($apt_no) ?></strong></p>
    <p>We’ve also emailed your appointment details to you.</p>

    <!--  Two buttons: Book another & Go to home -->
    <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 30px;">
      <a href="booking.html" class="btn"> Book Another Appointment</a>
      <a href="index.html" class="btn" style="background-color: #39e494;"> Thank You! Go to Home</a>
    </div>
  </div>
</body>
</html>
