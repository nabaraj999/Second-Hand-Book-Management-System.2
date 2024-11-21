<?php
include('../connection/connection.php');
session_start();

// Ensure the session is started and the user is logged in
if (!isset($_SESSION['username'])) {
    echo "You need to log in first.";
    exit();
}

$username = $_SESSION['username'];

function displayBook($row, $isSellSection) {
    $statusClass = '';
    $statusMessage = '';

    if ($isSellSection) {
        if ($row['status'] == 'approved') {
            $statusClass = 'status-approved';
            $statusMessage = 'Approved - Waiting for a buyer';
        } else if ($row['status'] == 'pending') {
            $statusClass = 'status-pending';
            $statusMessage = 'Pending admin approval';
            // Show cancel button if status is pending
            echo "<form action='cancel_order.php' method='POST' style='display:inline-block;'>";
            echo "<input type='hidden' name='book_id' value='" . htmlspecialchars($row['id']) . "'>";
            echo "<button type='submit'>Cancel Order</button>";
            echo "</form>";
        } else if ($row['buyer_purchased']) {
            $statusClass = 'status-sold';
            $statusMessage = 'Sold';
        }
    } else {
        $statusClass = 'status-purchased';
        $statusMessage = 'Purchased';
    }

    echo "<div class='book'>";
    echo "<img src='../uploads/" . htmlspecialchars($row['photo']) . "' alt='Book Photo'>";
    echo "<div>";
    echo "<h2>" . htmlspecialchars($row['book_name']) . "</h2>";
    echo "<p class='$statusClass'>Status: $statusMessage</p>";
    echo "</div>"; // End of book details
    echo "</div>"; // End of book
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Section</title>
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
        

        .order-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
           margin-top : 10px;
        }

        .section-title {
            font-size: 2em;
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }

        .book {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
        }

        .book img {
            max-width: 100px;
            margin-right: 20px;
        }

        .book h2 {
            font-size: 1.5em;
            margin: 0;
        }

        .book p {
            margin: 5px 0;
        }

        button {
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #e53935;
        }

        .status-approved {
            color: green;
            font-weight: bold;
        }

        .status-pending {
            color: orange;
            font-weight: bold;
        }

        .status-sold {
            color: red;
            font-weight: bold;
        }

        .status-purchased {
            color: blue;
            font-weight: bold;
        }
        
        .coming-soon {
            font-size: 1.5em;
            color: #666;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="order-container">
        <!-- Sell Section -->
        <h1 class="section-title">Your Listed Books</h1>
        <?php
        // Fetch books where the current user is the seller
        $sql = "SELECT * FROM books WHERE seller_name = ? AND status IN ('approved', 'pending')";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "<p>Error preparing the SQL statement: " . htmlspecialchars($conn->error) . "</p>";
            exit();
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                displayBook($row, true);
            }
        } else {
            echo "<p>No books found in your sell section.</p>";
        }

        $stmt->close();
        ?>

        <!-- Buy Section -->
    </div>

    <script>
        function logout() {
            alert('You have been logged out.');
            // Redirect to logout page or add logout logic
            window.location.href = 'logout.php';
        }

        function redirectToProfile() {
        window.location.href = 'profile.php';
    }
    </script>
</body>
</html>
