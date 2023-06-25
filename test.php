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
    $type = $responseData['products']['botd']['data']['bot']['type'];
  
    // Prepare and execute the SQL query to insert data into the database
    $query = "INSERT INTO admin (request_id, result, type) VALUES (?, ?, ?)";
    $statement = $pdo->prepare($query);
    $statement->execute([$requestId, $result, $type]);

    echo "Data inserted into the database successfully!" . PHP_EOL;
  } catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>API Form</title>
</head>
<body>
  <form method="POST">
    <label for="request_id">Request ID:</label>
    <input type="text" name="request_id" id="request_id" required>
    <button type="submit">Submit</button>
  </form>
</body>
</html>
