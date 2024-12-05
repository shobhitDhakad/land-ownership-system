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

// Check if the land ID is provided in the URL
if (isset($_GET['id'])) {
    $land_id = $_GET['id'];

    // Sanitize the land_id to prevent SQL injection
    $land_id = mysqli_real_escape_string($conn, $land_id);

    // Fetch the land details
    $query = "SELECT * FROM lands WHERE id = $land_id";
    $result = mysqli_query($conn, $query);

    // Check if the land exists
    if ($result && mysqli_num_rows($result) > 0) {
        $land = mysqli_fetch_assoc($result);
        $land_name = htmlspecialchars($land['land_name']);  // Sanitize for HTML output
        $price = number_format($land['price'], 2); // Format price to 2 decimal places

        // Retrieve the logged-in user's ID
        $user_id = $_SESSION['user_id'];

        // Example purchase query
        $purchase_query = "INSERT INTO purchases (user_id, land_id, purchase_date) VALUES ('$user_id', '$land_id', NOW())";

        // Execute the purchase query and check for errors
        if (mysqli_query($conn, $purchase_query)) {
            // Store land details in session for thank you page
            $_SESSION['land_name'] = $land_name;
            $_SESSION['price'] = $price;

            // Optionally update land status to "sold"
            $update_land_status = "UPDATE lands SET is_sold = 1 WHERE id = $land_id";
            mysqli_query($conn, $update_land_status);

            // Store land ID in session for later use
            $_SESSION['land_id'] = $land_id;

            // Redirect to the thank you page
            header("Location: thankyou.php");
            exit();
        } else {
            echo "Error processing your purchase: " . mysqli_error($conn);
        }
    } else {
        echo "Land not found.";
    }
} else {
    echo "Invalid land selection.";
}

// Close the database connection
mysqli_close($conn);
?>
