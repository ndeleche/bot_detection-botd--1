<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="icon" type="image/png" href="https://example.com/path/to/your-icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <style>
    .sidebar {
      background-color: #f8f9fa;
      padding: 20px;
      height: 100vh;
    }

    .content {
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php include 'navbar.php'; ?>
      <div class="col-md-9">
        <div class="content">
         <h1 style="color: green; text-align: center;">Welcome, <?php echo $_SESSION['username']; ?></h2>
          <!-- Add your content here -->
        </div>
      </div>
    </div>
  </div>
</body>
</html>
