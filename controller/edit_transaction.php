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

// Fetch existing data
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM financial_records WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();
    $stmt->close();
}

// Update transaction
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $date = $_POST['record_date'];
    $type = $_POST['record_type'];
    $category = $_POST['record_category'];
    $amount = $_POST['record_amount'];
    $description = $_POST['record_description'];
    $payment_method = $_POST['record_payment_method'];

    $update_query = "UPDATE financial_records SET 
        date = ?, 
        type = ?, 
        category = ?, 
        amount = ?, 
        description = ?, 
        payment_method = ? 
        WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssdssi", $date, $type, $category, $amount, $description, $payment_method, $id);

    if ($stmt->execute()) {
        header("Location: your_transactions_page.php?success=Transaction updated successfully");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!-- HTML Form for Editing -->
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">
    <label>Date: <input type="date" name="record_date" value="<?php echo $transaction['date']; ?>"></label><br>
    <label>Type:
        <select name="record_type">
            <option value="income" <?php echo ($transaction['type'] == 'income') ? 'selected' : ''; ?>>Income</option>
            <option value="expense" <?php echo ($transaction['type'] == 'expense') ? 'selected' : ''; ?>>Expense</option>
        </select>
    </label><br>
    <label>Category: <input type="text" name="record_category" value="<?php echo $transaction['category']; ?>"></label><br>
    <label>Amount: <input type="number" step="0.01" name="record_amount" value="<?php echo $transaction['amount']; ?>"></label><br>
    <label>Description: <textarea name="record_description"><?php echo $transaction['description']; ?></textarea></label><br>
    <label>Payment Method: <input type="text" name="record_payment_method" value="<?php echo $transaction['payment_method']; ?>"></label><br>
    <button type="submit">Update Transaction</button>
</form>
