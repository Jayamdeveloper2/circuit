<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
        }

        h1 {
            margin-top: -20px;
            font-size: 2.5em;
            color: #7084a0;
        }

        img {
            max-width: 650px;
            height: auto;
            margin-bottom: 20px;
        }

        p {
            margin-top: -10px;
            font-size: 1.2em;
            color: #7084a0;
            margin-bottom: 20px;
        }

        a {
            background: #7084a0;
            padding: 10px 15px;
            color: #ffffff;
            border-radius: 4px;
            text-decoration: none;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }
            p {
                font-size: 1em;
            }
            img {
                max-width: 100%;
                width: 80%;
            }
            a {
                padding: 8px 12px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.8em;
            }
            p {
                font-size: 0.9em;
            }
            img {
                max-width: 100%;
                width: 100%;
            }
            a {
                padding: 6px 10px;
            }
        }
    </style>
</head>
<body>

    <img src="<?= CSS_PATH ?>/images/403.png" alt="403 Forbidden">
    <h1>We are Sorry...</h1>
    <p>The page you're trying to access has restricted access.<br>
        Please refer to your system administrator</p>

    <a href="<?=base_url('/dashboard')?>">Go to Dashboard</a>
</body>
</html>
