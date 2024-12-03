<?php
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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="adminsell.css"> <!-- Link to your CSS file -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../view/index.css">
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
    <div class="admin-container">
    
            </a>
        </div>
        <div class="content">
            <table class="book-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Seller Name</th>
                        <th>Email Address</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Category</th>
                        <th>Bank Name</th>
                        <th>Account Number</th>
                        <th>Wallet Name</th>
                        <th>Wallet Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP code to fetch data from the database and display it -->
                    <?php
                    include('../connection/connection.php');
                    $sql = "SELECT * FROM books";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                            <td>
    <img src="<?php echo htmlspecialchars('../uploads/' . $row['photo']); ?>" class="book-photo" alt="Book Photo">
</td>

                                <td><?php echo htmlspecialchars($row['seller_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                <td><?php echo htmlspecialchars($row['price']); ?></td>
                                <td><?php echo htmlspecialchars($row['discount']); ?>%</td>
                                <td><?php echo htmlspecialchars($row['book_category']); ?></td>
                                <td><?php echo htmlspecialchars($row['bank_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['account_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['wallet_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['wallet_number']); ?></td>
                                <td>
                                    <form action="book_action.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

                                        <!-- Approve Button -->
                                        <button type="submit" name="action" value="approve"
                                                <?php echo ($row['status'] == 'approved' || $row['status'] == 'rejected') ? "disabled style='color:green;'" : ""; ?>>
                                            <?php echo ($row['status'] == 'approved') ? "✔ Approved" : "Approve"; ?>
                                        </button>

                                        <!-- Reject Button -->
                                        <button type="submit" name="action" value="reject"
                                                <?php echo ($row['status'] == 'rejected' || $row['status'] == 'approved') ? "disabled style='color:red;'" : ""; ?>>
                                            <?php echo ($row['status'] == 'rejected') ? "✖ Rejected" : "Reject"; ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr><td colspan="12">No books found</td></tr> <!-- Adjusted colspan to match columns -->
                        <?php
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function logout() {
            alert('You have been logged out.');
            // Redirect to logout page or add logout logic
            window.location.href = 'logout.php';
        }
        </script>
</body>
</html>
