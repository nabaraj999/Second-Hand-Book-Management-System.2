<?php
session_start();

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];

// Handle clear cart action
if (isset($_GET['clear_cart'])) {
    $_SESSION['cart'] = [];
    header('Location: cart.php');
    exit();
}

// Handle remove item action
if (isset($_GET['remove'])) {
    $bookId = $_GET['remove'];
    if (isset($_SESSION['cart'][$bookId])) {
        unset($_SESSION['cart'][$bookId]);
    }
    header('Location: cart.php');
    exit();
}

// User details
$username = $_SESSION['user']['name'] ?? 'Guest';
$email = $_SESSION['user']['email'] ?? 'guest@example.com';
$phone = $_SESSION['user']['phone'] ?? 'N/A';

// Save checkout data to session
if (isset($_POST['proceed_to_checkout'])) {
    $_SESSION['product_details'] = [
        'order_id' => uniqid('BN'),
        'order_name' => implode(', ', array_column($cart, 'name')),
        'amount' => array_sum(array_column($cart, 'price')),
    ];
    $_SESSION['customer_details'] = [
        'name' => $username,
        'email' => $email,
        'phone' => $phone,
    ];

    header('Location:../payment/checkout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">BookNest</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="buy.php">Buy</a>
            <a href="sell.php">Sell</a>
            <a href="order_section.php">Order</a>
            <a href="contact.php">Contact</a>
            <a href="help.php">Help</a>
        </div>

        <div class="search-user">
        <button class="cart-icon" onclick="location.href='cart.php'">
        <i class="fas-fa-cart">🛒</i>
        <i class="fas fa-cart"></i>
        <span class="cart-count">
            <?php
                // Simulating the cart item count; replace with real value from the database/session
                echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
            ?>
    </button> 
        <span class="username">
            <?php
            
                echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
            ?>
        </span>
        <!-- Profile Icon -->
        <button class="profile-icon" onclick="redirectToProfile()">
            <i class="fas fa-user"></i>
            
        </button>
        <!-- Logout Button -->
        <button class="logout" onclick="logout()">Logout</button>
    </div>
</div>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .cart-containera {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .cart-items {
            margin-top: 20px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }
        .cart-item h5 {
            margin: 0;
            font-size: 16px;
        }
        .cart-item .price {
            font-size: 16px;
            color: #007bff;
        }
        .cart-summary {
            margin-top: 30px;
            text-align: right;
        }
        .checkout-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .checkout-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="cart-containera">
    <div class="cart-header">
        <h1>Your Shopping Cart</h1>
        <a href="?clear_cart" onclick="return confirm('Are you sure you want to clear the cart?')">
            <button class="btn btn-danger">Clear Cart</button>
        </a>
    </div>

    <div class="cart-items">
        <?php if (!empty($cart)): ?>
            <?php foreach ($cart as $bookId => $book): ?>
                <div class="cart-item">
                    <h5><?php echo htmlspecialchars($book['name']); ?></h5>
                    <span class="price">Rs <?php echo htmlspecialchars($book['price']); ?></span>
                    <a href="?remove=<?php echo urlencode($bookId); ?>" class="btn btn-outline-danger btn-sm">Remove</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Your cart is empty!</p>
        <?php endif; ?>
    </div>

    <div class="cart-summary">
        <?php if (!empty($cart)): ?>
            <p><strong>Total Items:</strong> <?php echo count($cart); ?></p>
            <p><strong>Total Price:</strong> Rs <?php echo array_sum(array_column($cart, 'price')); ?></p>
            <form method="POST">
                <button type="submit" name="proceed_to_checkout" class="checkout-btn">Proceed to Checkout</button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
