<?php
// Include the database connection
include('db_connect.php');

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the land ID is provided in the session
if (!isset($_SESSION['land_id'])) {
    header("Location: index.php"); // Redirect if no land ID
    exit();
}

$land_id = $_SESSION['land_id'];

// Fetch land details for registration
$query = "SELECT * FROM lands WHERE id = $land_id";
$result = mysqli_query($conn, $query);
$land = mysqli_fetch_assoc($result);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Registration</title>
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
            max-width: 500px;
            width: 100%;
        }

        h1 {
            color: #28a745;
        }

        label {
            display: block;
            margin-top: 10px;
            text-align: left;
        }

        input[type="text"], input[type="number"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
        <h1>Land Registration</h1>
        <form action="process_registration.php" method="POST">
            <label for="owner_name">Owner's Name:</label>
            <input type="text" id="owner_name" name="owner_name" required>

            <label for="land_name">Land Name:</label>
            <input type="text" id="land_name" name="land_name" value="<?php echo htmlspecialchars($land['land_name']); ?>" readonly>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $land['price']; ?>" readonly>

            <label for="registration_date">Registration Date:</label>
            <input type="date" id="registration_date" name="registration_date" required>

            <input type="hidden" name="land_id" value="<?php echo $land_id; ?>">
            <button type="submit" class="btn">Submit Registration</button>
        </form>
    </div>
</body>
</html>
