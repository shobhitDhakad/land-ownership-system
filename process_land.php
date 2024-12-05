<?php
session_start();
include('db_connection.php'); // Assuming you have a separate file for database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Image handling
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = 'uploads/' . $image;

    if (move_uploaded_file($image_tmp, $image_folder)) {
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO lands (user_id, location, size, price, image) VALUES ('$user_id', '$location', '$size', '$price', '$image')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['success_message'] = 'Land listed for sale successfully!';
            header('Location: sell_land.php');
        } else {
            $_SESSION['error_message'] = 'Failed to list the land. Please try again.';
            header('Location: sell_land.php');
        }
    } else {
        $_SESSION['error_message'] = 'Failed to upload the image.';
        header('Location: sell_land.php');
    }
} else {
    header('Location: sell_land.php');
}
?>
