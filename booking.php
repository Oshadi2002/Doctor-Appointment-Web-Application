
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book Appointment - CarePoint</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #0a994f, #39e494);
      margin: 0;
      padding: 0;
    }
    .container {
      background-color: #fff;
      max-width: 500px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
    }
    h2 {
      text-align: center;
      color: #0a994f;
    }
    form input, form select, form textarea, form button {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    form button {
      background-color: #0a994f;
      color: #fff;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }
    form button:hover {
      background-color: #067e42;
    }
    textarea {
      resize: vertical;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Book an Appointment</h2>
    <form action="save-appointment.php" method="POST">
      <input type="text" name="name" placeholder="Your Name" required />
      <input type="email" name="email" placeholder="Your Email" required />
      <input type="tel" name="phone" placeholder="Your Phone Number" required />

      <?php
        $conn = new mysqli("localhost", "root", "", "carepoint_db");
        $result = $conn->query("SELECT * FROM doctors");
      ?>
      <select name="department" required>
        <option value="">Select Doctor</option>
        <?php while($row = $result->fetch_assoc()): ?>
          <option value="<?= $row['name'] ?>">
            <?= $row['name'] ?> (<?= $row['specialization'] ?>)
          </option>
        <?php endwhile; ?>
      </select>

      <input type="date" name="date" required />
      <input type="time" name="time" required />
      <textarea name="message" placeholder="Message (Optional)"></textarea>

      <button type="submit">Submit Appointment</button>
    </form>
  </div>
</body>
</html>

