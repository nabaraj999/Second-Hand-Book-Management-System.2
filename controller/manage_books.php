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
include('../connection/connection.php');

// Fetch all books from the database
$sql = "SELECT * FROM books";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="contact.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../view/index.css">
  <link rel="stylesheet" href="contact.css">
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
    <script>
         function logout() {
            alert('You have been logged out.');
            // Redirect to logout page or add logout logic
            window.location.href = 'logout.php';
        }
        </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            text-align: left;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .button {
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #2980b9;
        }

        .disabled {
            background-color: #95a5a6;
            pointer-events: none;
        }

        .button.disabled:hover {
            background-color: #95a5a6; /* Keep hover the same for disabled state */
        }

    </style>
</head>
<body>

    <div class="content">
        <h2>Manage Books</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td><?php echo htmlspecialchars($row['book_category']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'approved'): ?>
                                    <span style="color: green;">Accepted</span>
                                <?php else: ?>
                                    <span style="color: orange;"><?php echo ucfirst($row['status']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row['status'] != 'approved'): ?>
                                    <!-- Edit Book -->
                                    <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="button">Edit</a>
                                <?php else: ?>
                                    <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="button" title="This book is accepted and cannot be edited.">Edit</a>
                                <?php endif; ?>

                                <?php if ($row['status'] != 'approved'): ?>
                                    <!-- Delete Book -->
                                    <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="button" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                                <?php else: ?>
                                    <a href="delete_book.php?id=<?php echo $row['id']; ?>" class="button" title="This book is accepted and cannot be deleted.">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No books available.</p>
        <?php endif; ?>

    </div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
