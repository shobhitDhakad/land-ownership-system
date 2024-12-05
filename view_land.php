<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($land['name']); ?> - Land Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($land['name']); ?></h1>
    <p>Location: <?php echo htmlspecialchars($land['location']); ?></p>
    <p>Size: <?php echo htmlspecialchars($land['size']); ?></p>
    <p>Description: <?php echo htmlspecialchars($land['description']); ?></p>
    <p>Price: RS <?php echo number_format($land['price'], 2); ?></p> <!-- Updated line to show price in RS -->
    <img src="uploads/<?php echo htmlspecialchars($land['image']); ?>" alt="Land Image">
    
    <a href="buy_land.php?id=<?php echo htmlspecialchars($land['id']); ?>" class="btn btn-success">Buy Now</a>
</body>
</html>
