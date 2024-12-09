<?php
// Include your database connection file
require_once '../connection/connection.php';

// Fetch dashboard data from the database
$totalUsers = 0;
$totalAdmins = 0;
$totalPendings = 0;
$totalCompletes = 0;
$totalOrders = 0;
$newMessages = 0;
$productsAdded = 0;

$sql = "SELECT COUNT(*) as user_count, COUNT(CASE WHEN role = 'admin' THEN 1 END) as admin_count FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row["user_count"];
    $totalAdmins = $row["admin_count"];
}

$sql = "SELECT COUNT(*) as pending_count FROM books WHERE status = 'pending'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalPendings = $row["pending_count"];
}

$sql = "SELECT COUNT(*) as complete_count FROM books WHERE status = 'approved'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCompletes = $row["complete_count"];
}

$sql = "SELECT COUNT(*) as order_count FROM transactions";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalOrders = $row["order_count"];
}

$sql = "SELECT COUNT(*) as message_count FROM contact_messages WHERE message = 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newMessages = $row["message_count"];
}

$sql = "SELECT COUNT(*) as product_count FROM books";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $productsAdded = $row["product_count"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
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
            <a href="finance.php">Finance</a>
            <a href="help.php">Feedback</a>
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
    :root {
      --primary-color: #0077b6;
      --secondary-color: #00a65a;
      --background-color: #f1f1f1;
      --text-color: #333;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
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

    .dashboard-card-button {
      display: block;
      margin-top: 20px;
      padding: 8px 16px;
      background-color: var(--primary-color);
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .dashboard-card-button:hover {
      background-color: #005a87;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <div class="dashboard-card">
      <i class="fas fa-users dashboard-card-icon"></i>
      <div class="dashboard-card-number"><?php echo $totalUsers + $totalAdmins; ?></div>
      <div class="dashboard-card-title">Total Users</div>
      <a href="manage_users.php" class="dashboard-card-button">Manage Users</a>
    </div>

    <div class="dashboard-card">
      <i class="fas fa-book dashboard-card-icon"></i>
      <div class="dashboard-card-number"><?php echo $totalPendings + $totalCompletes; ?></div>
      <div class="dashboard-card-title">Total Books</div>
      <a href="manage_books.php" class="dashboard-card-button">Manage Books</a>
    </div>

    <div class="dashboard-card">
      <i class="fas fa-exchange-alt dashboard-card-icon"></i>
      <div class="dashboard-card-number"><?php echo $totalOrders; ?></div>
      <div class="dashboard-card-title">Total Transactions</div>
      <a href="finance.php" class="dashboard-card-button">View Transactions</a>
    </div>

    <div class="dashboard-card">
      <i class="fas fa-user-shield dashboard-card-icon"></i>
      <div class="dashboard-card-number"><?php echo $totalAdmins; ?></div>
      <div class="dashboard-card-title">Total Admins</div>
      <a href="manage_users.php" class="dashboard-card-button">Manage Admins</a>
    </div>

    <div class="dashboard-card">
      <i class="fas fa-clock dashboard-card-icon"></i>
      <div class="dashboard-card-number"><?php echo $totalPendings; ?></div>
      <div class="dashboard-card-title">Pending Books</div>
      <a href="adminsell.php" class="dashboard-card-button">View Pending</a>
    </div>

    <div class="dashboard-card">
      <i class="fas fa-check-circle dashboard-card-icon"></i>
      <div class="dashboard-card-number"><?php echo $totalCompletes; ?></div>
      <div class="dashboard-card-title">Accepted Books</div>
      <a href="adminsell.php" class="dashboard-card-button">View Accepted</a>
    </div>

    <div class="dashboard-card">
      <i class="fas fa-envelope dashboard-card-icon"></i>
      <div class="dashboard-card-number"><?php echo $newMessages; ?></div>
      <div class="dashboard-card-title">New Feedback</div>
      <a href="help.php" class="dashboard-card-button">View Feedback</a>
    </div>

    <div class="dashboard-card">
      <i class="fas fa-plus-circle dashboard-card-icon"></i>
      <div class="dashboard-card-number"><?php echo $productsAdded; ?></div>
      <div class="dashboard-card-title">Products Added</div>
      <a href="Addbook.php" class="dashboard-card-button">Add Products</a>
    </div>
  </div>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</body>
</html>