<?php
// Start the session
session_start();

// Include database connection
include('db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$success_message = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get land details from the form
    $land_name = mysqli_real_escape_string($conn, $_POST['land_name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $user_id = $_SESSION['user_id'];  // Get the logged-in user's ID

    // Handle image file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";

        // Check if the uploads folder exists, create it if not
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                $error_message = "Failed to create uploads directory.";
            }
        }

        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate if the uploaded file is an image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Check if the file already exists
            if (file_exists($target_file)) {
                $error_message = "Sorry, file already exists.";
            } elseif ($_FILES["image"]["size"] > 5000000) {
                $error_message = "Sorry, your file is too large.";
            } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                $error_message = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
            } else {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Insert land details into the database, including user_id
                    $sql = "INSERT INTO lands (land_name, location, size, price, image, user_id) VALUES ('$land_name', '$location', '$size', '$price', '$target_file', '$user_id')";

                    if ($conn->query($sql) === TRUE) {
                        $success_message = "Land has been listed for sale successfully!";
                    } else {
                        $error_message = "Error: " . $conn->error;
                    }
                } else {
                    $error_message = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $error_message = "File is not an image.";
        }
    } else {
        $error_message = "Please upload an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Land</title>
    <link rel="stylesheet" href="styles.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Sell Your Land</h1>

        <!-- Display success or error messages -->
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Form to submit land details -->
        <form action="sell_land.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="land_name" class="form-label">Land Name</label>
                <input type="text" class="form-control" id="land_name" name="land_name" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <div class="mb-3">
                <label for="size" class="form-label">Size (e.g., 60x80)</label>
                <input type="text" class="form-control" id="size" name="size" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
