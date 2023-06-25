<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bot_db";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get submitted credentials
$username = $_POST['username'];
$password = $_POST['password'];

// Check if registration form is submitted
if (isset($_POST['register'])) {
    // Insert new admin into the database
    $sql = "INSERT INTO admin_login (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login page
        header("Location: admin_login.php");
        exit();
    } else {
        // Error occurred during registration
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Check if password matches the specified value
    if ($password === 'admin12') {
        // Redirect to admin_dashboard.php on successful login
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Check if username exists
        $sql = "SELECT * FROM admin_login WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows === 0) {
            // Return error message on the admin login page for incorrect username
            header("Location: admin_login.php");
            echo '<p style="color: red;">Incorrect username</p>';
        } else {
             // Check if the password is incorrect for the entered username
        $row = $result->fetch_assoc();
        if ($row['password'] !== $password) {
            // Return error message on the admin login page for incorrect password
            header("Location: admin_login.php?error=true");
            exit();
}

            }
        }
    }

// Close the database connection
$conn->close();
?>
