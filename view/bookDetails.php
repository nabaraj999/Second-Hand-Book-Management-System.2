<?php
session_start(); // Ensure this is at the top before any output
include('../connection/connection.php');

if (isset($_GET['book_id'])) {
    $bookId = $_GET['book_id'];

    // Fetch book details from the database using the book ID
    $sql = "SELECT * FROM books WHERE id='$bookId' AND status='approved'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit();
    }
} else {
    echo "No book ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details | BookNest</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="bookDetails.css">
</head>
<body>
    <!-- Navbar -->
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
            <!-- Cart Icon -->
            <button class="cart-icon" onclick="location.href='cart.php'">
                🛒 
                <span class="cart-count">
                    <?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?>
                </span>
            </button> 
            <!-- Username -->
            <span class="username">
                <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
            </span>
            <!-- Profile Icon -->
            <button class="profile-icon" onclick="redirectToProfile()">
                <i class="fas fa-user"></i>
            </button>
            <!-- Logout Button -->
            <button class="logout" onclick="logout()">Logout</button>
        </div>
    </div>

    <!-- Book Details Section -->
    <div class="book-details">
        <?php 
        $photoPath = '../uploads/' . $book['photo'];
        if (!empty($book['photo']) && file_exists($photoPath)): ?>
            <img id="bookPhoto" src="<?php echo htmlspecialchars($photoPath); ?>" alt="Book Image">
        <?php else: ?>
            <img id="bookPhoto" src="default-book.jpg" alt="Default Book Image">
        <?php endif; ?>
        <div class="details">
            <h1><?php echo htmlspecialchars($book['book_name']); ?></h1>
            <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
            <p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
            <p>Description: <?php echo htmlspecialchars($book['description']); ?></p>
            <p>Category: <?php echo htmlspecialchars($book['book_category']); ?></p>
            <p>Level: <?php echo htmlspecialchars($book['level']); ?></p>
            <p>Class: <?php echo htmlspecialchars($book['class']); ?></p>
            <p class="price">Price: Rs <?php echo htmlspecialchars($book['price']); ?></p>
            <p class="discount">Discount: <?php echo htmlspecialchars($book['discount']); ?>%</p>
            <!-- Add to Cart Button -->
            <button class="add-to-cart" onclick="addToCart()">Add to Cart</button>
        </div>
        <input type="hidden" id="bookId" value="<?php echo htmlspecialchars($book['id']); ?>">
        <input type="hidden" id="bookName" value="<?php echo htmlspecialchars($book['book_name']); ?>">
        <input type="hidden" id="bookPrice" value="<?php echo htmlspecialchars($book['price']); ?>">
    </div>

    <script>
        function addToCart() {
            var bookId = document.getElementById("bookId").value;
            var bookName = document.getElementById("bookName").value;
            var bookPrice = document.getElementById("bookPrice").value;

            if (bookId && bookName && bookPrice) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "add_to_cart.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        alert("Book added to cart!");
                        document.querySelector(".cart-count").textContent = xhr.responseText;
                    } else {
                        alert("Error: " + xhr.responseText);
                    }
                };

                xhr.onerror = function () {
                    alert("An error occurred while connecting to the server.");
                };

                xhr.send(
                    "book_id=" +
                    encodeURIComponent(bookId) +
                    "&book_name=" +
                    encodeURIComponent(bookName) +
                    "&book_price=" +
                    encodeURIComponent(bookPrice)
                );
            } else {
                alert("Book details are missing.");
            }
        }

        function logout() {
            window.location.href = "logout.php";
        }

        function redirectToProfile() {
            window.location.href = "profile.php";
        }
    </script>
</body>
</html>
