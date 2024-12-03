<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="index.css">
   <link rel="stylesheet" href="contact.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">BookNest</div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="buy.php">Buy</a>
            <a href="sell.php">Sell</a>
            <a href="order_section.php">Order</a>
            <a href="contact.php">Contact</a>
            <a href="help.php">Help</a>
        </div>

        <div class="search-user">
        <button class="cart-icon" onclick="location.href='cart.php'">
        <i class="fas-fa-cart">🛒</i>
        <i class="fas fa-cart"></i>
        <span class="cart-count">
            <?php
                // Simulating the cart item count; replace with real value from the database/session
                echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
            ?>
    </button> 
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


  <div class="contact-container">
    <!-- Contact Form -->
    <div class="contact-form">
      <h2>Contact Us</h2>
      <form action="submit_contact_form.php" method="POST">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" placeholder="Enter subject" required>
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" name="message" placeholder="Write your message" rows="5" required></textarea>
        </div>
        <button type="submit" class="submit-btn">Send Message</button>
      </form>
    </div>

    <!-- Contact Details -->
    <div class="contact-info">
      <h2>Get in Touch</h2>
      <p>If you have any questions, feel free to reach out to us. We would love to hear from you!</p>
      <p><i class="fas fa-phone-alt"></i> (+1) 123-456-7890</p>
      <p><i class="fas fa-envelope"></i> contact@example.com</p>
      <p><i class="fas fa-map-marker-alt"></i> 1234 Fashion Ave, New York, NY 10001</p>
    </div>
  </div>

  <footer>
        <div class="footer-container">
            <!-- Social Media Links -->
            <div class="footer-section">
                <h3>Connect with Us</h3>
                <div class="social-icons">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
                </div>
                <p class="mt-3">Stay connected and get the latest updates!</p>
            </div>

            <!-- Contact Details -->
            <div class="footer-section">
                <h3>Contact Information</h3>
                <p><i class="fas fa-map-marker-alt mr-2"></i> Chapagaun-10, Lalitpur, Nepal</p>
                <p><i class="fas fa-phone mr-2"></i> +977 01-5900401</p>
                <p><i class="fas fa-mobile-alt mr-2"></i> +977 9845889271</p>
                <p><i class="fas fa-envelope mr-2"></i> <a href="mailto:booknestjbc@example.com">booknestjbc@example.com</a></p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About BookNest</a></li>
                    <li><a href="#">Sell Books</a></li>
                    <li><a href="#">Buy Books</a></li>
                    <li><a href="#">Book Orders</a></li>
                    <li><a href="#">Help Center</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div class="footer-section">
                <h3>Book Resources</h3>
                <ul>
                    <li><a href="#">Online Books Nepal</a></li>
                    <li><a href="#">Book Recommendations</a></li>
                    <li><a href="#">Reading Community</a></li>
                    <li><a href="#">Book Reviews</a></li>
                    <li><a href="#">Bestseller Lists</a></li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>© 2024 BOOKNEST - Your Ultimate Book Destination | Powered by BOOKNEST Technologies</p>
        </div>
    </footer>


  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
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
