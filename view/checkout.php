<?php
// Include the database connection file
include('../connection/connection.php');

// Start the session
session_start();

// Check if the cart is set in the session
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
    echo "Your cart is empty.";
    exit();
}

// Retrieve cart items from the session
$cart = $_SESSION['cart'];

// Initialize total amount
$totalAmount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | BookNest</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="checkout.css"> <!-- Link to custom CSS -->
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
            <span class="username">
                <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
            </span>
            <button class="logout" onclick="logout()">Logout</button>
        </div>
    </div>

    <div class="checkout-container">
        <h1>Checkout</h1>
        <table class="checkout-table">
            <thead>
                <tr>
                    <th>Book Name</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $bookId => $cartItem): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cartItem['book_name']); ?></td>
                        <td>Rs <?php echo number_format($cartItem['price'], 2); ?></td>
                        <td>Rs <?php echo number_format($cartItem['price'], 2); ?></td>
                        <td>
                            <form method="POST" action="remove_from_cart.php">
                                <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
                                <button type="submit" class="remove-btn">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php $totalAmount += $cartItem['price']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="checkout-summary">
            <h2>Total: Rs <?php echo number_format($totalAmount, 2); ?></h2>
            <button class="checkout-btn" onclick="proceedToCheckout()">Proceed to Payment</button>
        </div>
    </div>

    <script>
        function proceedToCheckout() {
            window.location.href = 'payment.php';
        }

        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
