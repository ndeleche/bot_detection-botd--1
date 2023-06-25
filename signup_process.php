<!-- signup_process.php -->

<?php
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

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into the database
$query = "INSERT INTO users (username, password) VALUES (:username, :password)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashedPassword);
$stmt->execute();

// Redirect to login page or display success message
header("Location: login.php");
exit();
?>
