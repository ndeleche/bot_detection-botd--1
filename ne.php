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
