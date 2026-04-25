<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Needs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .loader-container {
            text-align: center;
        }

        .loader {
            border: 5px solid rgba(255,255,255,0.2);
            border-top: 5px solid #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        h2 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            opacity: 0.8;
        }
    </style>
</head>
<body>

<div class="loader-container">
    <div class="loader"></div>
    <h2>Loading...</h2>
    <p>Please wait, we are fetching your travel data 🚀</p>
</div>
<!-- 
<script>
    // Simulate API / frontend loading
    setTimeout(function () {
        // After loading, redirect to home/dashboard
        window.location.href = "/home"; // change your route
    }, 3000);
</script> -->

</body>
</html>