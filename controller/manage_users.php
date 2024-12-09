<?php
// Connect to the database
session_start();

// Check if the user is logged in
if(!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: ../Login/login.php");
    exit();
}

// Get the username from the session
$username = $_SESSION['username'];

include '../connection/connection.php';

// Handle form submission to add a new user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    if (mysqli_query($conn, $sql)) {
        echo "<p class='success-message'>User added successfully.</p>";
    } else {
        echo "<p class='error-message'>Error adding user: " . mysqli_error($conn) . "</p>";
    }
}

// Fetch users from the database
$result = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        
        .container {
            width: 800px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-left :350px;
            margin-top: 10px;
        }
        h2, h3 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-links a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 10px;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        .success-message, .error-message {
            font-size: 14px;
            color: #fff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success-message {
            background-color: #4CAF50;
        }
        .error-message {
            background-color: #f44336;
        }
    </style>
</head>
<body>
<link rel="stylesheet" href="Admin.css">
</head>
<body>
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
            <a href="finance.php">Finnance</a>
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

    

<div class="container">
    <h2>User Management</h2>

    <!-- Add User Form -->
    <form action="" method="POST">
        <h3>Add New User</h3>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <!-- Role Selection -->
        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="User">User</option>
            <option value="Admin">Admin</option>
        </select>
        
        <button type="submit" name="add_user">Add User</button>
    </form>

    <!-- Display Users -->
    <h3>Existing Users</h3>
    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td class="action-links">
    <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
    <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
    <a href="view_user.php?id=<?php echo $row['id']; ?>">View</a> <!-- New View Link -->
</td>

                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<script>   function logout() {
            alert('You have been logged out.');
            // Redirect to logout page or add logout logic
            window.location.href = 'logout.php';
        }
        </script>
</body>
</html>
