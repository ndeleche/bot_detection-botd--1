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
  <title>Bot detection Request_id</title>
  <link rel="icon" type="image/png" href="https://example.com/path/to/your-icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">
  <style>
    .sidebar {
      background-color: #f8f9fa;
      padding: 5px;
      padding: left 50px;
      height: 800vh;
    }

    .content {
      padding: 70px;
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
    #heading{
    text-align: center;}
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php include 'navbar.php'; ?>
      <div class="col-md-9">
        <div class="content">
        <h1 id = "heading"> HUMAN & BOT BAR CHART </h1>
          <!-- Add your content here -->
         <!-- Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="chart">
  <canvas id="humanbotChart"></canvas>
</div>

<!-- PHP code to fetch data from the database -->
<?php
// Replace with your database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bot_db";

// Create a new mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the "admin" and "human" tables
$sql = "SELECT 'bot' AS table_name, COUNT(*) AS count FROM admin GROUP BY type
        UNION ALL
        SELECT 'human' AS table_name, COUNT(*) AS count FROM human";
$result = $conn->query($sql);

$chart_data = array();

// Process the query result
if ($result->num_rows > 0) {
  $total_count = 0;

  // Calculate the total count for percentage calculation
  while ($row = $result->fetch_assoc()) {
    $total_count += $row['count'];
  }

  // Calculate the percentage for each table and type
  mysqli_data_seek($result, 0); // Reset the result pointer
  while ($row = $result->fetch_assoc()) {
    $percentage = ($row['count'] / $total_count) * 100;

    $chart_data[] = array(
      'table_name' => $row['table_name'],
      'percentage' => $percentage
    );
  }
}

// Close the database connection
$conn->close();
?>

<script>
  // Retrieve data from PHP
  var chartData = <?php echo json_encode($chart_data); ?>;

  // Prepare chart labels and data
  var chartLabels = [];
  var chartDataPoints = [];
  var chartColors = [];

  chartData.forEach(function(row) {
    chartLabels.push(row.table_name);
    chartDataPoints.push(row.percentage);

    // Set color based on table name
    var color = row.table_name === 'bot' ? 'rgba(255, 0, 0, 0.8)' : 'rgba(0, 255, 0, 0.8)';
    chartColors.push(color);
  });

  // Generate Chart.js chart
  var ctx = document.getElementById('humanbotChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: chartLabels,
      datasets: [{
        label: 'Percentage',
        data: chartDataPoints,
        backgroundColor: chartColors
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          precision: 0,
          stepSize: 10,
          max: 100
        }
      },
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });
</script>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
