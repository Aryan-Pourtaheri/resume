<?php
include('./config/connection.php'); // Include database connection

// Check if the product ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: shop.php?error=Product not found.");
    exit();
}

$product_id = intval($_GET['id']);

// Fetch product details from the database
$query = "SELECT p.id, p.name, p.description, p.price, p.image, p.stock, c.name AS category_name 
          FROM products p
          LEFT JOIN categories c ON p.category_id = c.id
          WHERE p.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: shop.php?error=Product not found.");
    exit();
}

$product = $result->fetch_assoc();

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $quantity = intval($_POST['quantity']);
    if ($quantity > 0 && $quantity <= $product['stock']) {
        $cart_item = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'image' => $product['image']
        ];

        // Initialize cart if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $product['id']) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        // Add new product to the cart if not found
        if (!$found) {
            $_SESSION['cart'][] = $cart_item;
        }

        header("Location: cart.php?success=Product added to cart.");
        exit();
    } else {
        $error = "Invalid quantity.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($product['name']); ?> - Product Details</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Product Details" name="keywords">
    <meta content="Product Details" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php include('./components/shop-header/header.php'); ?>
    
    <!-- Product Detail Content -->
    <?php include('./components/shop-contents/detail-content.php'); ?>

    <?php include('./components/shop-footer/footer.php'); ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>