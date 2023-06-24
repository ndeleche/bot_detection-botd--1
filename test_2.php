<!-- Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="chart">
  <canvas id="HUman_bot_Chart">
 

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

// Retrieve
$sql = "SELECT locatio, COUNT(*) AS total_reports FROM crimeinfo GROUP BY location";
$result = $conn->query($sql);

$chart_data = array();

// Process the query result
if ($result->num_rows > 0) {
while ($row = $result->fetch_assoc()) {
$chart_data[] = array(
'location' => $row['location'],
'reports' => $row['total_reports']
);
}
}

// Close the database connection
$conn->close();
?>
  </canvas>
  </div>


  // script for that chart 
  <script>
    // Retrieve crime data from PHP
    var crimeData = <?php echo json_encode($chart_data); ?>;

    // Prepare chart labels and data
    var chartLabels = [];
    var chartData = [];

    crimeData.forEach(function(row) {
        chartLabels.push(row.location);
        chartData.push(row.reports);
    });

    // Generate Chart.js chart
    var ctx = document.getElementById('crimeChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Total Reports',
                data: chartData,
                backgroundColor: '#5bc0de'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    stepSize: 1
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