<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "booknest";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the record
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $delete_query = "DELETE FROM financial_records WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: your_transactions_page.php?success=Transaction deleted successfully");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}
?>
