<!DOCTYPE html>
<html>
<head>
  <title>Charts</title>
  <link rel="icon" type="image/png" href="https://example.com/path/to/your-icon.png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css">

  <!-- Chart.js library -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    .sidebar {
      background-color: #f8f9fa;
      padding: 20px;
      height: 100vh;
    }

    .content {
      padding: 20px;
      padding-top: 150px;
      text-align: center;
    }

    .chart-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 400px;
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
          <h1>HUMAN & BOT BAR GRAPH</h1>
          <div class="chart-container">
            <canvas id="HUman_bot_Chart"></canvas>
          </div>

          <!-- PHP code to retrieve data -->
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

          // Retrieve data
          $sql = "SELECT result, type, COUNT(*) AS total_reports FROM admin GROUP BY result, type";
          $result = $conn->query($sql);

          $chart_data = array();

          // Process the query result
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $color = '';
              if ($row['result'] === 'bad' && $row['type'] === 'selenium') {
                $color = '#FF0000'; // Red color
              } else {
                $color = '#00FF00'; // Green color
              }
              $chart_data[] = array(
                'label' => $row['result'] . ' - ' . $row['type'],
                'reports' => $row['total_reports'],
                'color' => $color
              );
            }
          }

          // Close the database connection
          $conn->close();
          ?>

          <!-- Script for the chart -->
          <script>
            // Retrieve data from PHP
            var chartData = <?php echo json_encode($chart_data); ?>;

            // Prepare chart labels and data
            var chartLabels = [];
            var chartValues = [];
            var chartColors = [];

            chartData.forEach(function(row) {
              chartLabels.push(row.label);
              var percentage = (row.reports / <?php echo array_sum(array_column($chart_data, 'reports')); ?>) * 100;
              chartValues.push(percentage.toFixed(2));
              chartColors.push(row.color);
            });

            // Generate Chart.js chart
            var ctx = document.getElementById('HUman_bot_Chart').getContext('2d');
            var myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: chartLabels,
                datasets: [{
                  label: 'Total Reports',
                  data: chartValues,
                  backgroundColor: chartColors
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                      callback: function(value) {
                        return value + '%'; // Display values as percentages
                      }
                    }
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
