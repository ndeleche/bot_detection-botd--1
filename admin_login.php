<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <link rel="icon" type="image/png" href="https://example.com/path/to/your-icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    .container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 100px;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .error-message {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Admin Login</h2>
    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Login</button>
      <?php
        if (isset($_GET['error'])) {
          echo '<p class="error-message">Incorrect username or password</p>';
        }
      ?>
    </form>
  </div>
</body>
</html>
