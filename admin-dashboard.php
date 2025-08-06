<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "carepoint_db");

// Doctor CRUD
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $conn->query("INSERT INTO doctors (name, specialization) VALUES ('$name', '$specialization')");
    header("Location: admin-dashboard.php"); exit();
}
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $conn->query("UPDATE doctors SET name='$name', specialization='$specialization' WHERE id=$id");
    header("Location: admin-dashboard.php"); exit();
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM doctors WHERE id=$id");
    header("Location: admin-dashboard.php"); exit();
}
if (isset($_GET['delete_apt'])) {
    $id = $_GET['delete_apt'];
    $conn->query("DELETE FROM appointments WHERE id=$id");
    header("Location: admin-dashboard.php"); exit();
}

$doctors = $conn->query("SELECT * FROM doctors");
$edit_doc = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_doc = $conn->query("SELECT * FROM doctors WHERE id=$edit_id")->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #0a994f, #39e494);
      margin: 0;
      padding: 2rem;
    }
    .admin-box {
      background: #fff;
      border-radius: 1rem;
      padding: 2rem;
      margin-bottom: 4rem;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    h2 { color: #0a994f; }
    form input, form button {
      width: 100%;
      padding: 1rem;
      margin: 0.5rem 0;
      border-radius: 0.5rem;
      border: 1px solid #ccc;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1.5rem;
    }
    th, td {
      padding: 1rem;
      border: 1px solid #ccc;
      text-align: left;
    }
    th { background: #0a994f; color: white; }
    .btn-action {
      padding: 5px 10px;
      border-radius: 5px;
      color: white;
      text-decoration: none;
      font-size: 0.9rem;
    }
    .edit { background-color: #007bff; }
    .delete { background-color: #dc3545; }
    .accordion {
      cursor: pointer;
      padding: 1rem;
      background-color: #eee;
      border: none;
      text-align: left;
      outline: none;
      font-size: 1.2rem;
      transition: 0.3s;
      margin-bottom: 0.5rem;
    }
    .active, .accordion:hover {
      background-color: #ccc;
    }
    .panel {
      display: none;
      overflow: hidden;
      padding: 0 1rem;
      background-color: white;
      border-left: 3px solid #0a994f;
    }
  </style>
</head>
<body>
  <div class="admin-box">
    <h2><?= $edit_doc ? "Edit Doctor" : "Add Doctor" ?></h2>
    <form action="" method="POST">
      <?php if ($edit_doc): ?>
        <input type="hidden" name="id" value="<?= $edit_doc['id'] ?>">
        <input type="text" name="name" value="<?= $edit_doc['name'] ?>" required>
        <input type="text" name="specialization" value="<?= $edit_doc['specialization'] ?>" required>
        <button type="submit" name="update">Update Doctor</button>
      <?php else: ?>
        <input type="text" name="name" placeholder="Doctor's Name" required>
        <input type="text" name="specialization" placeholder="Specialization" required>
        <button type="submit" name="add">Add Doctor</button>
      <?php endif; ?>
    </form>
  </div>

  <div class="admin-box">
    <h2>Doctor List</h2>
    <table>
      <tr><th>ID</th><th>Name</th><th>Specialization</th><th>Actions</th></tr>
      <?php foreach ($doctors as $doc): ?>
      <tr>
        <td><?= $doc['id'] ?></td>
        <td><?= $doc['name'] ?></td>
        <td><?= $doc['specialization'] ?></td>
        <td>
          <a href="?edit=<?= $doc['id'] ?>" class="btn-action edit">Edit</a>
          <a href="?delete=<?= $doc['id'] ?>" class="btn-action delete" onclick="return confirm('Delete doctor?')">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <div class="admin-box">
    <h2>Doctor-wise Appointments</h2>
    <?php foreach ($doctors as $doc): ?>
      <button class="accordion">Dr. <?= $doc['name'] ?> (<?= $doc['specialization'] ?>)</button>
      <div class="panel">
        <?php
        $dname = $doc['name'];
        $aps = $conn->query("SELECT * FROM appointments WHERE department = '$dname' ORDER BY id DESC");
        ?>
        <?php if ($aps->num_rows > 0): ?>
          <table>
            <tr>
              <th>Apt No</th><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Time</th><th>Message</th><th>Action</th>
            </tr>
            <?php while($a = $aps->fetch_assoc()): ?>
              <tr>
                <td><?= $a['appointment_no'] ?></td>
                <td><?= $a['name'] ?></td>
                <td><?= $a['email'] ?></td>
                <td><?= $a['phone'] ?></td>
                <td><?= $a['date'] ?></td>
                <td><?= $a['time'] ?></td>
                <td><?= $a['message'] ?></td>
                <td>
                  <a href="?delete_apt=<?= $a['id'] ?>" class="btn-action delete" onclick="return confirm('Delete appointment?')">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </table>
        <?php else: ?>
          <p>No appointments found for this doctor.</p>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <script>
    const acc = document.querySelectorAll(".accordion");
    acc.forEach(btn => {
      btn.addEventListener("click", function () {
        this.classList.toggle("active");
        const panel = this.nextElementSibling;
        panel.style.display = panel.style.display === "block" ? "none" : "block";
      });
    });
  </script>
</body>
</html>
