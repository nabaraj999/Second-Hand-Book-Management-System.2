<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: ../Login/login.php");
    exit();
}

// Get the username from the session
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Payment Integration</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<body class="m-4">
    <?php

    // Check if product and customer details exist
    if (!isset($_SESSION['product_details']) || !isset($_SESSION['customer_details'])) {
        echo "<h2 class='text-danger'>No checkout data found. Please return to the cart.</h2>";
        exit();
    }

    // Fetch product and customer details from session
    $productDetails = $_SESSION['product_details'];
    $customerDetails = $_SESSION['customer_details'];
    ?>

    <h1 class="text-center">Khalti Payment Integration</h1>
    <div class="d-flex justify-content-center mt-3">
        <form class="row g-3 w-50 mt-4" action="payment-request.php" method="POST">
            <label for="">Product Details:</label>
            <div class="col-md-6">
                <label for="inputAmount4" class="form-label">Amount</label>
                <input type="text" class="form-control" id="inputAmount4" name="inputAmount4" 
                       value="<?php echo htmlspecialchars($productDetails['amount']); ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="inputPurchasedOrderId4" class="form-label">Purchased Order ID</label>
                <input type="text" class="form-control" id="inputPurchasedOrderId4" name="inputPurchasedOrderId4" 
                       value="<?php echo htmlspecialchars($productDetails['order_id']); ?>" readonly>
            </div>
            <div class="col-12">
                <label for="inputPurchasedOrderName" class="form-label">Purchased Order Name</label>
                <input type="text" class="form-control" id="inputPurchasedOrderName" name="inputPurchasedOrderName" 
                       value="<?php echo htmlspecialchars($productDetails['order_name']); ?>" readonly>
            </div>
            <label for="">Customer Details:</label>
            <div class="col-12">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" name="inputName"
                       value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" class="form-control" id="inputEmail" name="inputEmail">
                
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="inputPhone" name="inputPhone">
                       
            </div>
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Pay with Khalti</button>
            </div>
        </form>
    </div>
</body>

</html>
