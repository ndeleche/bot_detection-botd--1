<!-- login_process.php -->

<?php
session_start();

// Establish database connection
$dsn = "mysql:host=localhost;dbname=bot_db;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

// Retrieve the hashed password from the database based on the provided username
$query = "SELECT * FROM users WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify the password
if ($user && password_verify($password, $user['password'])) {
    // Password is correct, start a session and store user information
    $_SESSION['username'] = $user['username'];
    
    // Redirect to home page or display success message
    header("Location: admin_dashboard.php");
    exit();
} else {
    // Password is incorrect, redirect back to login page or display error message
    header("Location: login.php");
    echo '<p class="danger-message">Failed to Login!</p>';

}
?>
