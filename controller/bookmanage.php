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

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booknest";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an action is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_id = $_POST['id'];
    $book_id = $_POST['book_id'];

    if (isset($_POST['accept'])) {
        // Compare book_id from both tables
        $sql_check = "SELECT * FROM books WHERE id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $book_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Delete the book from the `books` table
            $sql_delete = "DELETE FROM books WHERE id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $book_id);
            $stmt_delete->execute();

            // Update the status of the payment to "Accepted"
            $sql_update = "UPDATE buybooks_payment SET status = 'Accepted' WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("i", $payment_id);
            $stmt_update->execute();

            $message = "Payment accepted and book deleted.";
        } else {
            $message = "Book not found. Cannot accept the payment.";
        }
    } elseif (isset($_POST['reject'])) {
        // Update the status of the payment to "Rejected"
        $sql_update = "UPDATE buybooks_payment SET status = 'Rejected' WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("i", $payment_id);
        $stmt_update->execute();

        $message = "Payment rejected.";
    }
}

// Fetch payment details
$sql = "SELECT * FROM transactions";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Management</title>
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
            <a href="manage_users.php">User Management</a>
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

    <h1 class="pd">Payment Details</h1>
    <link rel="stylesheet" href="bookmanage.css">
    
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Reference Code</th>
                <th>Book Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Book ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['reference_code']; ?></td>
                        <td><?php echo $row['bookname']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['book_id']; ?></td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                    <button type="submit" name="accept">Accept</button>
                                    <button type="submit" name="reject">Reject</button>
                                </form>
                            <?php else: ?>
                                <span><?php echo $row['status']; ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
           function logout() {
            alert('You have been logged out.');
            // Redirect to logout page or add logout logic
            window.location.href = 'logout.php';
        }
        </script>
</body>
</html>

<?php
$conn->close();
?>
