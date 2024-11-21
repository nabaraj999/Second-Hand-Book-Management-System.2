<?php
// Database connection
include('../connection/connection.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch the book data for the given ID
    $sql = "SELECT * FROM books WHERE id = $book_id";
    $result = mysqli_query($conn, $sql);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $book_name = $row['book_name'];
        $author = $row['author'];
        $book_category = $row['book_category'];
        $price = $row['price'];
        $status = $row['status'];
    } else {
        echo "Book not found!";
        exit;
    }
} else {
    echo "No book ID provided!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated values from the form
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $book_category = $_POST['book_category'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Update the book data in the database
    $update_sql = "UPDATE books SET book_name='$book_name', author='$author', book_category='$book_category', price='$price', status='$status' WHERE id = $book_id";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "Book updated successfully!";
        header("Location: manage_books.php"); // Redirect to book management page
    } else {
        echo "Error updating book: " . mysqli_error($conn);
    }
}
?>

<!-- HTML Form for editing the book -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <head>
  <!-- Google Font - Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  <!-- Your custom CSS files -->
  <link rel="stylesheet" href="../view/index.css">
  <link rel="stylesheet" href="contact.css">
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="logo">
            <!-- Logo Section -->
            <a href="index.php">BookNest</a>
        </div>
        <div class="nav-links">
            <!-- Navigation Links -->
            <a href="adminsell.php">Sell</a>
            <a href="bookmanage.php">Buy</a>
            <a href="manage_users.php">User Management</a>
            <a href="manage_books.php">Edit Book</a>
            <a href="help.php">Help</a>
        </div>
        <div class="search-user">
            <!-- User Info Section -->
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
        // Logout Functionality
        function logout() {
            alert('You have been logged out.');
            window.location.href = 'logout.php'; // Redirect to logout page or handle accordingly
        }

        // Redirect to the profile page
        function redirectToProfile() {
            window.location.href = 'profile.php'; // Adjust as necessary based on your routing
        }
    </script>
</body>


    <div class="form-container">
        <h2>Edit Book Information</h2>
        <form action="edit_book.php?id=<?php echo $book_id; ?>" method="POST">
            <div class="form-group">
                <label for="book_name">Book Name:</label>
                <input type="text" id="book_name" name="book_name" value="<?php echo htmlspecialchars($book_name); ?>" required>
            </div>

            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($author); ?>" required>
            </div>

            <div class="form-group">
                <label for="book_category">Category:</label>
                <input type="text" id="book_category" name="book_category" value="<?php echo htmlspecialchars($book_category); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="pending" <?php echo $status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo $status == 'approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo $status == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                </select>
            </div>

            <div class="form-group">
                <input type="submit" value="Update Book">
            </div>
        </form>
    </div>


<style>


/* Set up the background and font */

/* Center the form in the viewport */
.form-container {
    max-width: 500px;
    margin: 0 auto;
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Header style */
h2 {
    text-align: center;
    color: #5c6bc0;
    margin-bottom: 20px;
}

/* Form group for spacing between fields */
.form-group {
    margin-bottom: 20px;
}

/* Label style */
label {
    font-weight: bold;
    margin-bottom: 8px;
    display: block;
    color: #5c6bc0;
}

/* Input fields and select styling */
input[type="text"], select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f9f9f9;
    box-sizing: border-box;
}

input[type="text"]:focus, select:focus {
    outline: none;
    border-color: #5c6bc0;
    background-color: #fff;
}

/* Submit button styling */
input[type="submit"] {
    background-color: #5c6bc0;
    color: #fff;
    font-size: 16px;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #4e57a3;
}

    </style>
</body>
</html>
