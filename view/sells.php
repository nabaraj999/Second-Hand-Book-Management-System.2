<?php
// Include the database connection file
include('../connection/connection.php');

// Retrieve and sanitize form data
$seller_name = $_POST['sname'];
$email = $_POST['email'];
$book_category = $_POST['bookCategory'];
$level = isset($_POST['level']) ? $_POST['level'] : '';
$class = isset($_POST['class']) ? $_POST['class'] : '';
$book_name = $_POST['book_name'];
$author = $_POST['author'];
$price = $_POST['price'];
$discount = $_POST['discount'];
$isbn = $_POST['isbn'];
$description = $_POST['description'];

// Handle book photo upload
$photo = $_FILES['photo']['name'];
$photo_tmp = $_FILES['photo']['tmp_name'];
$photo_target = "../uploads/" . basename($photo);

// Move uploaded photo to target directory if a file exists
if ($photo) {
    if (move_uploaded_file($photo_tmp, $photo_target)) {
        echo "Photo uploaded successfully.";
    } else {
        echo "Error uploading photo.";
        exit(); // Stop execution if the photo upload fails
    }
} else {
    $photo_target = null; // or set a default photo path if needed
}

// Prepare SQL query to insert data into the database
$sql = "INSERT INTO books (seller_name, email, book_category, level, class, book_name, author, price, discount, isbn, photo, description)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = $conn->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param(
        'ssssssssssss',
        $seller_name, $email, $book_category, $level, $class, $book_name, $author, $price, $discount, $isbn, $photo_target, $description
    );

    // Execute and check
    if ($stmt->execute()) {
        echo "New record created successfully";
        header('Location: sell.php');
        exit(); // Exit after successful insertion and redirection
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: Could not prepare SQL statement. " . $conn->error;
}

// Close the database connection
$conn->close();
?>
