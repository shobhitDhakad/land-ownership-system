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

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $land_name = mysqli_real_escape_string($conn, $_POST['land_name']); // Ensure this is correctly assigned
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $registration_date = mysqli_real_escape_string($conn, $_POST['registration_date']);
    $land_id = mysqli_real_escape_string($conn, $_POST['land_id']);

    // Insert the registration details into the database
    $registration_query = "INSERT INTO land_registrations (user_id, land_id, owner_name, land_name, price, registration_date) VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = mysqli_prepare($conn, $registration_query)) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'iissss', $_SESSION['user_id'], $land_id, $owner_name, $land_name, $price, $registration_date);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "<h1>Registration Successful!</h1>";
            echo "<p>Thank you, <strong>$owner_name</strong>. Your land <strong>$land_name</strong> has been successfully registered.</p>";
        } else {
            echo "Error registering land: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
