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
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <title>BookNest</title>
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


        <link rel="stylesheet" href="buy.css">
        <div>
            <!-- PHP logic to handle book filtering and searching -->
            <?php
            include('../connection/connection.php');

            // Initialize variables
            $categoryFilter = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
            $searchQuery = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

            // SQL query to filter by category and search term
            $sql = "SELECT * FROM books WHERE status='approved'";

            if ($categoryFilter) {
                $sql .= " AND book_category='$categoryFilter'";
            }

            if ($searchQuery) {
                $sql .= " AND (book_name LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%')";
            }

            $result = $conn->query($sql);

            // Check for query execution errors
            if ($result === FALSE) {
                echo "Error executing query: " . $conn->error;
                exit();
            }
            ?>

            <div class="filter-container">
                <!-- Book Category Filter -->
                <div class="form-group">
                    <label for="bookCategory">Book Category</label>
                    <select id="bookCategory" name="category" onchange="handleCategoryChange()" required>
                        <option value="">All Categories</option>
                        <option value="Academic" <?php echo $categoryFilter == 'Academic' ? 'selected' : ''; ?>>Academic</option>
                        <option value="Literature" <?php echo $categoryFilter == 'Literature' ? 'selected' : ''; ?>>Literature</option>
                        <option value="History" <?php echo $categoryFilter == 'History' ? 'selected' : ''; ?>>History</option>
                        <option value="Other" <?php echo $categoryFilter == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <!-- Search Bar -->
                <div class="form-group">
                    <label for="searchBar">Search</label>
                    <input type="text" id="searchBar" name="search" placeholder="Search by book name or author" value="<?php echo htmlspecialchars($searchQuery); ?>">
                    <button type="button" onclick="handleSearch()">Search</button>
                </div>
            </div>

            <div class="book-grid">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="book-card">';
                    echo '<img src="../uploads/' . htmlspecialchars($row['photo']) . '" alt="Book Photo">';
                    echo '<h2>' . htmlspecialchars($row['book_name']) . '</h2>';
                    echo '<p>Author: ' . htmlspecialchars($row['author']) . '</p>';
                    echo '<p>Price: Rs ' . htmlspecialchars($row['price']) . '</p>';
                    echo '<p class="discount">Discount: ' . htmlspecialchars($row['discount']) . '%</p>';
                    
                    // Embedded form and button for buying the book
                    echo '<form id="buyForm_' . $row['id'] . '" action="bookDetails.php" method="get">';
                    echo '<input type="hidden" name="book_id" value="' . $row['id'] . '">';
                    echo '<button type="button" class="buy-button" onclick="buyNow(' . $row['id'] . ')">Buy</button>';
                    echo '</form>';

                    echo '</div>';
                }
            } else {
                echo '<p>No books found.</p>';
            }

            $conn->close();
            ?>
            </div>
        </div>
    </div>

    <!-- Contact Details -->

    
  <footer>
  <div class="footer-container">
    <!-- Social Media Links -->
    <div class="footer-section">
      <h3>Follow Us</h3>
      <div class="social-icons">
        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
      </div>
    </div>

    <!-- Contact Details -->
    <div class="footer-section">
      <h3>Contact</h3>
      <p>chapagaun-10, Lalitpur</p>
      <p>01-5900401</p>
      <p>+9779845889271</p>
      <p><a href="mailto:hiredriver@example.com">booknestjbc@example.com</a></p>
    </div>

    <!-- Navigation Links -->
    <div class="footer-section">
      <h3>Links</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Sell</a></li>
        <li><a href="#">Buy</a></li>
        <li><a href="#">Order</a></li>
        <li><a href="#">Help</a></li>
      </ul>
    </div>

    <!-- Articles Section -->
    <div class="footer-section">
      <h3>Articles</h3>
      <ul>
        <li><a href="#">Online Books Nepal</a></li>
        <li><a href="#">Booknest.com</a></li>
        <li><a href="#">onlinebooksnep.com</a></li>
      </ul>
    </div>
  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <p>© 2024 - BOOKNEST | Powered by BOOKNEST</p>
  </div>
</footer>



    <script>
        function handleCategoryChange() {
            const selectedCategory = document.getElementById('bookCategory').value;
            const searchQuery = document.getElementById('searchBar').value;

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('category', selectedCategory);
            urlParams.set('search', searchQuery);

            window.location.search = urlParams.toString();
        }

        function handleSearch() {
            const selectedCategory = document.getElementById('bookCategory').value;
            const searchQuery = document.getElementById('searchBar').value;

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('category', selectedCategory);
            urlParams.set('search', searchQuery);

            window.location.search = urlParams.toString();
        }

        function buyNow(bookId) {
            document.getElementById('buyForm_' + bookId).submit();
        }

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
