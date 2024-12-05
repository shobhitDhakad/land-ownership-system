<?php
include("db_connect.php");
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Registration Portal</title>
    <link rel="stylesheet" href="styles.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header>
        <div class="container">
            <img src="img.jpg" alt="Logo" class="logo">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="sell_land.php" class="btn btn-success">Sell Land</a></li>
                        <li><a href="logout.php" class="btn btn-danger">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to the Land Registration Portal</h1>
            <p>Secure and efficient land registration at your fingertips.</p>
            <a href="register.php" class="btn">Get Started</a>
        </div>
    </section>

    <section class="featured-lands">
    <div class="container">
        <h2>Featured Lands</h2>
        <div class="lands-grid">
            <!-- Example Land 1 -->
           
            <?php
// Include database connection
include('db_connect.php');

// Execute the query to fetch land data
$query = "SELECT * FROM lands";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if ($result) {
    // Check if any land records exist
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $image = $row['image'];
            $land_name = $row['land_name'];
            $location = $row['location'];
            $size = $row['size'];
            $price = $row['price'];
            $id = $row['id'];

            echo "<div class='land-item'>
                <img src='$image' alt='$land_name'>
                
                <p>Location: $location, Size: $size, Price: Rs$price</p>
                
                <a href='buy_land.php?id=$id' class='btn btn-success'>Buy Now</a>
            </div>";
        }
    } else {
        echo "No land listings available.";
    }
} else {
    // If the query failed, display an error message
    echo "Error executing query: " . mysqli_error($conn);
}
?>

            

            <!-- Add more lands similarly with appropriate IDs -->
        </div>
    </div>
</section>

    <div class="card">
        <div class="card-header">
            Featured
        </div>
        <div class="card-body">
            <h5 class="card-title">Contact Us</h5>
            <p class="card-text">contact@parth.com</p>
        </div>
    </div>

    <script src="assets/js/scripts.js"></script>
</body>
</html>
