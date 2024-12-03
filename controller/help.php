<?php
include '../connection/connection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../Login/login.php");
    exit();
}

// Get the username from the session
$username = htmlspecialchars($_SESSION['username']);

// Fetch user feedback data
$result = mysqli_query($conn, "SELECT * FROM contact_messages");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../view/index.css">
    <link rel="stylesheet" href="contact.css">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

     
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f0e68c;
        }

        .btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">BookNest</div>
        <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="adminsell.php">Sell</a>
            <a href="bookmanage.php">Buy</a>
            <a href="manage_users.php">User Manage</a>
            <a href="Addbook.php">Book Add</a>
            <a href="manage_books.php">Edit Book</a>
            <a href="help.php">Help</a>
        </div>
        <div class="search-user">
            <span class="username"><?php echo $username; ?></span>
            <button class="profile-icon" onclick="redirectToProfile()">
                <i class="fas fa-user"></i>
            </button>
            <button class="logout" onclick="logout()">Logout</button>
        </div>
    </div>

    <div class="container">
        <h2>User Feedback</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Feedback</th>
                <th>Date</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <script>
        function logout() {
            alert('You have been logged out.');
            window.location.href = 'logout.php';
        }

        function redirectToProfile() {
            window.location.href = 'profile.php';
        }
    </script>
</body>
</html>
