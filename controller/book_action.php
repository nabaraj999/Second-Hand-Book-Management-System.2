<?php
include('../connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    // Fetch the seller's name and book details
    $sqlFetch = "SELECT seller_name, book_name, photo, author, price, discount, book_category FROM books WHERE id=$id";
    $result = $conn->query($sqlFetch);

    if ($result === FALSE) {
        die("Error: " . $conn->error);
    }

    $row = $result->fetch_assoc();

    $sellerName = $row['seller_name'];
    $bookName = $row['book_name'];
    $photo = $row['photo'];
    $author = $row['author'];
    $price = $row['price'];
    $discount = $row['discount'];
    $category = $row['book_category'];

    if ($action == 'approve') {
        $sql = "UPDATE books SET status='approved' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            // Email content
            $subject = "Your Book has been Successfully Listed on Booknest";
            $message = "
            Dear $sellerName,

            We are excited to inform you that your book '$bookName' has been successfully listed in the Booknest buy section.

            Thank you for choosing Booknest to sell your books.

            Best regards,
            Booknest Team
            ";
            $headers = "From: no-reply@booknest.com"; // Adjust this as necessary

            // Send the email to the seller
            mail('nabarajacharya999@gmail.com', $subject, $message, $headers);

            echo "Book approved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($action == 'reject') {
        $sql = "UPDATE books SET status='rejected' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Book rejected successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
    // Redirect to the admin panel after the action is performed
    header("Location: adminsell.php");
    exit();
}
?>
