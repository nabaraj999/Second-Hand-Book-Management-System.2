<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../view/index.css">
  <link rel="stylesheet" href="contact.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>
<body>
    <div class="navbar">
        <div class="logo">BookNest</div>
        <div class="nav-links">
            <!-- Updated Nav Links -->
            <a href="index.php">Home</a>
            <a href="adminsell.php">Sell</a>
            <a href="bookmanage.php">Buy</a>
            <a href="manage_users.php">User Manage</a>
            <a href="Addbook.php">Book Add</a>
            <a href="manage_books.php">Edit Book</a>
            <a href="finance.php">Finnance</a>
            <a href="help.php">Help</a>
        </div>
        <div class="search-user">
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

    <div class="dashboard-container">
        <div class="dashboard-card">
            <i class="fas fa-users dashboard-card-icon"></i>
            <div class="dashboard-card-number" id="total-users">
                <?php
                    // Start session and include database connection
                    
                    include '../connection/connection.php';
                    
                    // Fetch total number of users
                    $user_query = "SELECT COUNT(*) as user_count FROM users";
                    $user_result = mysqli_query($conn, $user_query);
                    $user_row = mysqli_fetch_assoc($user_result);
                    echo $user_row['user_count'];
                ?>
            </div>
            <div class="dashboard-card-title">Total Users</div>
        </div>

        <div class="dashboard-card">
            <i class="fas fa-book dashboard-card-icon"></i>
            <div class="dashboard-card-number" id="total-books">
                <?php
                    // Fetch total number of books
                    $book_query = "SELECT COUNT(*) as book_count FROM books";
                    $book_result = mysqli_query($conn, $book_query);
                    $book_row = mysqli_fetch_assoc($book_result);
                    echo $book_row['book_count'];
                ?>
            </div>
            <div class="dashboard-card-title">Total Books</div>
        </div>

        <div class="dashboard-card">
            <i class="fas fa-exchange-alt dashboard-card-icon"></i>
            <div class="dashboard-card-number" id="total-transactions">
                <?php
                    // Fetch total number of transactions
                    $transaction_query = "SELECT COUNT(*) as transaction_count FROM transactions";
                    $transaction_result = mysqli_query($conn, $transaction_query);
                    $transaction_row = mysqli_fetch_assoc($transaction_result);
                    echo $transaction_row['transaction_count'];
                ?>
            </div>
            <div class="dashboard-card-title">Total Transactions</div>
        </div>
    </div>

    <div class="reviews-section">
        <h2>Recent Reviews</h2>
        <?php
            // Fetch recent reviews from content_message table
            $reviews_query = "SELECT * FROM contact_messages ORDER BY submitted_at DESC LIMIT 5";
            $reviews_result = mysqli_query($conn, $reviews_query);
            
            while ($review = mysqli_fetch_assoc($reviews_result)) {
                echo "<div class='review-item'>";
                echo "<strong>" . htmlspecialchars($review['username'] ?? 'Anonymous') . "</strong>: ";
                echo htmlspecialchars($review['message']);
                echo "<br><small>" . htmlspecialchars($review['created_at']) . "</small>";
                echo "</div>";
            }
        ?>
    </div>

    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --background-color: #f4f4f4;
            --text-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 30px;
        }

        .dashboard-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card-icon {
            font-size: 48px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .dashboard-card-number {
            font-size: 36px;
            font-weight: 700;
            color: var(--secondary-color);
        }

        .dashboard-card-title {
            font-size: 18px;
            color: var(--text-color);
            margin-top: 10px;
        }

        .reviews-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin: 0 30px 30px;
            padding: 20px;
        }

        .review-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .review-item:last-child {
            border-bottom: none;
        }
        </style>
    <script>
         function logout() {
            alert('You have been logged out.'); 
            // Redirect to logout page or add logout logic
            window.location.href = 'logout.php';
        }
        </script>
</body>
</html>
