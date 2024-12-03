<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
   header("Location: ../Login/login.php");
    exit();
}

// Get the username from the session
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard | BookNest</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../view/index.css">
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
  <style>
    /* Form Container */
    .sell-form {
      max-width: 600px;
      background-color: #f9f9f9;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin: 20px auto;
      padding: 20px;
    }
    .sell-form h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }

    /* Form Group Styling */
    .sell-form .form-group {
      margin-bottom: 15px;
    }
    .sell-form .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #555;
    }
    .sell-form .form-group input,
    .sell-form .form-group select,
    .sell-form .form-group textarea {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    .sell-form .form-group input:focus,
    .sell-form .form-group select:focus,
    .sell-form .form-group textarea:focus {
      border-color: #4CAF50;
      outline: none;
    }
    .sell-form .form-group textarea {
      resize: vertical;
      height: 100px;
    }

    /* Academic Fields Group */
    #academicFields {
      display: none;
      margin-top: 10px;
    }

    /* Submit Button */
    .sell-form button[type="submit"] {
      width: 100%;
      padding: 12px;
      background-color: #4CAF50;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 18px;
      cursor: pointer;
    }
    .sell-form button[type="submit"]:hover {
      background-color: #45a049;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
      .sell-form {
        padding: 10px;
      }
      .sell-form .form-group input,
      .sell-form .form-group select,
      .sell-form .form-group textarea {
        font-size: 14px;
      }
      .sell-form button[type="submit"] {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>


<div class="sell-form">
      <form id="bookSellForm" action="../view/sells.php" method="POST" enctype="multipart/form-data">
          <h2>Sell Your Book</h2>

          <!-- Seller Name (Read-only, populated from session) -->
          <div class="form-group">
              <label for="sellerName">Seller Name</label>
              <input type="text" id="sellerName" name="sname" value="<?php echo $username; ?>" readonly>
          </div>

          <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" required>
          </div>

          <div class="form-group">
              <label for="bookCategory">Book Category</label>
              <select id="bookCategory" name="bookCategory" onchange="handleCategoryChange()" required>
                  <option value="">Select Category</option>
                  <option value="Academic">Academic</option>
                  <option value="Literature">Literature</option>
                  <option value="History">History</option>
                  <option value="Other">Other</option>
              </select>
          </div>

          <div id="academicFields" style="display:none;">
              <div class="form-group">
                  <label for="level">Level</label>
                  <input type="text" id="level" name="level">
              </div>
              <div class="form-group">
                  <label for="class">Class</label>
                  <input type="text" id="class" name="class">
              </div>
          </div>

          <div class="form-group">
              <label for="bookName">Book Name</label>
              <input type="text" id="bookName" name="book_name" required>
          </div>

          <div class="form-group">
              <label for="author">Author</label>
              <input type="text" id="author" name="author" required>
          </div>

          <div class="form-group">
              <label for="price">Price (in Rs)</label>
              <input type="number" id="price" name="price" required>
          </div>

          <div class="form-group">
              <label for="discount">Discount (%)</label>
              <input type="number" id="discount" name="discount">
          </div>

          <div class="form-group">
              <label for="isbn">ISBN Number</label>
              <input type="text" id="isbn" name="isbn">
          </div>

          <div class="form-group">
              <label for="bookPhoto">Book Photo</label>
              <input type="file" id="bookPhoto" name="photo" required>
          </div>

          <div class="form-group">
              <label for="aboutBook">About the Book</label>
              <textarea id="aboutBook" name="description"></textarea>
          </div>

          <button type="submit">Submit</button>
      </form>
  </div>

<script>
  function handleCategoryChange() {
      var category = document.getElementById("bookCategory").value;
      var academicFields = document.getElementById("academicFields");
      academicFields.style.display = category === 'Academic' ? 'block' : 'none';
  }

  function logout() {
            alert('You have been logged out.');
            // Redirect to logout page or add logout logic
            window.location.href = 'logout.php';
        }

        function redirectToProfile() {
        window.location.href = 'profile.php';
    }
</script>
</body>
</html>
