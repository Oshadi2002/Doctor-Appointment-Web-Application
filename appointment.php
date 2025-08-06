<?php
$conn = new mysqli("localhost", "root", "", "carepoint_db");
$doctors = $conn->query("SELECT name, specialization FROM doctors");
?>

<form method="POST" action="https://sandbox.payhere.lk/pay/checkout">

  <!--  Required PayHere Fields -->
  <input type="hidden" name="merchant_id" value="1230763">
  <input type="hidden" name="return_url" value="http://localhost/success.php">
  <input type="hidden" name="cancel_url" value="http://localhost/cancel.php">
  <input type="hidden" name="notify_url" value="http://localhost/notify.php">

  <input type="hidden" name="order_id" value="APPT123">
  <input type="hidden" name="items" value="Doctor Appointment">
  <input type="hidden" name="amount" value="1500.00">

  <!--  Required Buyer Info -->
  First Name: <input name="first_name" required>
  Last Name: <input name="last_name" required>
  NIC: <input name="nic" required>
  Contact (Phone): <input name="phone" required>
  Email: <input name="email" required>
  Address: <input name="address" required>
  City: <input name="city" value="Colombo" required>
  Country: <input name="country" value="Sri Lanka" required>

  <!--  Appointment Info -->
  Select Doctor:
  <select name="doctor_name">
    <?php while($doc = $doctors->fetch_assoc()): ?>
      <option value="<?= $doc['name'] ?>"><?= $doc['name'] ?> - <?= $doc['specialization'] ?></option>
    <?php endwhile; ?>
  </select>

  Appointment Date: <input type="date" name="appointment_date" required>
  Appointment Time:
  <select name="appointment_time">
    <option>8:00 AM</option>
    <option>11:00 AM</option>
  </select>

  <button type="submit">💳 Pay & Book</button>
</form>
