<!DOCTYPE html>
<html>
<head>
    <title>Loading...</title>
    <link rel="icon" type="image/png" href="https://example.com/path/to/your-icon.png">
    <style>
        /* CSS for the page loader */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader .loader-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 6px solid #3498db;
            border-top-color: transparent;
            animation: spin 1.5s linear infinite;
        }

        .loader .loader-text {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333333;
            margin-top: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loader">
        <div class="loader-circle"></div>
        <div class="loader-text">Loading...</div>
    </div>

    <script>
        // Delay before hiding the loader (in milliseconds)
        const delay = 2000; // Adjust this value to set the desired duration

        // Show the loader
        document.querySelector('.loader').style.display = 'flex';

        // Hide the loader after a delay
        setTimeout(function() {
            document.querySelector('.loader').style.display = 'none';
        }, delay);
    </script>
</body>
</html>
