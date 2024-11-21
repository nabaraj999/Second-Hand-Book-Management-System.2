<?php
// Database connection
include('../connection/connection.php');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Delete the book from the database
    $delete_sql = "DELETE FROM books WHERE id = $book_id";
    
    if (mysqli_query($conn, $delete_sql)) {
        echo "Book deleted successfully!";
        header("Location: manage_books.php"); // Redirect back to the book management page
    } else {
        echo "Error deleting book: " . mysqli_error($conn);
    }
} else {
    echo "No book ID provided!";
}

mysqli_close($conn);
?>
