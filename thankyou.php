<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve land details from session
$land_name = isset($_SESSION['land_name']) ? $_SESSION['land_name'] : 'Unknown Land';
$price = isset($_SESSION['price']) ? $_SESSION['price'] : 'N/A';

// Clear session variables if needed
unset($_SESSION['land_name']);
unset($_SESSION['price']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS -->
    <style>
        body {
            background-color: #f0f8ff;
            font-family: Arial, sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            color: #28a745;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thank You!</h1>
        <p>You have successfully purchased <strong><?php echo $land_name; ?></strong>.</p>
        <p>Total Price: <strong>$<?php echo $price; ?></strong></p>
        <p><a href="registry.php" class="btn">Register Your Land</a></p>
    </div>
</body>
</html>
