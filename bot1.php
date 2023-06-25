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
  <title>Identification Request_id</title>
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
    .container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      width: 100%;
    }

    .form-heading {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 4px;
    }

    .submit-btn {
      display: block;
      width: 100%;
      padding: 10px;
      text-align: center;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .submit-btn:hover {
      background-color: #0056b3;
    }
    
    .success-message {
      text-align: center;
      color: #28a745;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php include 'navbar.php'; ?>
      <div class="col-md-9">
        <div class="content">
          <!-- Add your content here -->
          <?php
require_once(__DIR__ . '/vendor/autoload.php');
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Database configuration
$host = 'localhost';
$dbName = 'bot_db';
$username = 'root'; 
$password = ''; 

// Establish database connection
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Database connection failed: " . $e->getMessage();
  exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the request ID from the form
  $requestId = $_POST['request_id'];

  // Initialize the Fingerprint API client
  $config = Configuration::getDefaultConfiguration(
    "3cQKAbhDAeh1hGrgxPTt", // Replace with your key
    Configuration::REGION_GLOBAL // Replace with your region
  );
  $client = new FingerprintApi(new Client(), $config);

  try {
    // Get the fingerprinting event
    $response = $client->getEvent($requestId);

    $responseData = json_decode($response->__toString(), true);

    // Extract the result and type from the response
    $result = $responseData['products']['botd']['data']['bot']['result'];
    // $type = $responseData['products']['botd']['data']['bot']['type'];
  
       // Prepare and execute the SQL query to insert data into the database
    $query = "INSERT INTO human (request_id, result) VALUES (?, ?)";
    $statement = $pdo->prepare($query);

    $statement->execute([$requestId, $result]);
    echo '<p class="success-message">Data inserted into the database successfully!</p>';
  } catch (Exception $e) {
    echo '<p class="danger-message">Failed to insert data into the database!</p>';
  }
}
        ?>
               <div class="container">
            <div class="form-container">
              <h2 class="form-heading">Enter Request ID</h2>
              <form method="POST">
                <div class="form-group">
                  <label for="request_id" class="form-label">Request ID:</label>
                  <input type="text" class="form-control" id="request_id" name="request_id" required>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>