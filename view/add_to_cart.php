<?php
session_start();
include('../connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Ensure the request method is POST
    if (isset($_POST['book_id'], $_POST['book_name'], $_POST['book_price'])) {
        $bookId = $_POST['book_id'];
        $bookName = $_POST['book_name'];
        $bookPrice = $_POST['book_price'];

        // Initialize cart in session if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add book to cart
        $_SESSION['cart'][$bookId] = [
            'name' => $bookName,
            'price' => $bookPrice
        ];

        // Update cart count
        $_SESSION['cart_count'] = count($_SESSION['cart']);

        // Respond with success and the updated cart count
        echo $_SESSION['cart_count'];
    } else {
        http_response_code(400);
        echo "Missing required parameters.";
    }
} else {
    http_response_code(405); // Method not allowed
    echo "Invalid request method.";
}
?>
