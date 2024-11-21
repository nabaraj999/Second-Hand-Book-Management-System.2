<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updated Navbar</title>
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="index.css">
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
                session_start();
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


    <section class="hero-section">
  <div class="hero-content">
    <h1>Discover the Best Deals on Second-Hand Books!</h1>
    <p>Find pre-loved books at great prices and give them a new home.</p>
    <div class="cta-buttons">
      <a href="buy.php" class="btn">Buy Now</a>
      <a href="sell.php" class="btn btn-secondary">Sell Your Books</a>
    </div>
  </div>
</section>


<section class="features-section">
        <div class="container">
            <h1>Features</h1>
            <div class="features-row">
                <div class="feature-box">
                    <div class="icon">
                        <i class="fas fa-book-open"></i> <!-- Book icon -->
                    </div>
                    <h2>Buy Books at Half Price!</h2>
                    <p>Find pre-loved books at incredible discounts—up to half the price of new books!</p>
                </div>

                <div class="feature-box">
                    <div class="icon">
                        <i class="fas fa-users"></i> <!-- Users icon -->
                    </div>
                    <h2>Anyone Can Buy or Sell</h2>
                    <p>Whether you're a student, teacher, or avid reader, you can buy or sell second-hand books.</p>
                </div>

                <div class="feature-box">
                    <div class="icon">
                        <i class="fas fa-leaf"></i> <!-- Eco-friendly icon -->
                    </div>
                    <h2>Eco-Friendly and Sustainable</h2>
                    <p>Buying second-hand books helps reduce waste and supports a more sustainable future.</p>
                </div>

                <div class="feature-box">
                    <div class="icon">
                        <i class="fas fa-th-large"></i> <!-- Categories icon -->
                    </div>
                    <h2>Wide Selection of Categories</h2>
                    <p>From fiction to textbooks, find books across various categories that fit your needs.</p>
                </div>
            </div>
        </div>
    </section>


    <section class="stats-section">
    <div class="stats-container">
      <!-- Members -->
      <div class="stat-item">
        <img src="https://img.icons8.com/color/50/conference-call.png" alt="Members Icon">
        <h2 class="counter" data-target="500">0</h2>
        <p>Joined Members</p>
      </div>
      <!-- Books -->
      <div class="stat-item">
        <img src="https://img.icons8.com/color/50/books.png" alt="Books Icon">
        <h2 class="counter" data-target="1500">0</h2>
        <p>Books</p>
      </div>
      <!-- Happy Clients -->
      <div class="stat-item">
        <img src="https://img.icons8.com/color/50/happy.png" alt="Happy Icon">
        <h2 class="counter" data-target="300">0</h2>
        <p>Happy Clients</p>
      </div>
      <!-- Best Deals -->
      <div class="stat-item">
        <img src="https://img.icons8.com/color/50/idea.png" alt="Best Deals Icon">
        <h2 class="counter" data-target="50">0</h2>
        <p>Best Deals Weekly</p>
      </div>
      <!-- Add Additional Stat (Optional) -->
      <div class="stat-item">
        <img src="https://img.icons8.com/color/50/customer-support.png" alt="Support Icon">
        <h2 class="counter" data-target="1453">0</h2>
        <p>Hours of Support</p>
      </div>
    </div>
  </section>

  <footer>
  <div class="footer-container">
    <!-- Social Media Links -->
    <div class="footer-section">
      <h3>Follow Us</h3>
      <div class="social-icons">
        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" title="GitHub"><i class="fab fa-github"></i></a>
      </div>
    </div>

    <!-- Contact Details -->
    <div class="footer-section">
      <h3>Contact</h3>
      <p>chapagaun-10, Lalitpur</p>
      <p>01-5900401</p>
      <p>+9779845889271</p>
      <p><a href="mailto:hiredriver@example.com">booknestjbc@example.com</a></p>
    </div>

    <!-- Navigation Links -->
    <div class="footer-section">
      <h3>Links</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Sell</a></li>
        <li><a href="#">Buy</a></li>
        <li><a href="#">Order</a></li>
        <li><a href="#">Help</a></li>
      </ul>
    </div>

    <!-- Articles Section -->
    <div class="footer-section">
      <h3>Articles</h3>
      <ul>
        <li><a href="#">Online Books Nepal</a></li>
        <li><a href="#">Booknest.com</a></li>
        <li><a href="#">onlinebooksnep.com</a></li>
      </ul>
    </div>
  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <p>© 2024 - BOOKNEST | Powered by BOOKNEST</p>
  </div>
</footer>


    <script>
        function logout() {
            alert('You have been logged out.');
            // Redirect to logout page or add logout logic
            window.location.href = 'logout.php';
        }

        function redirectToProfile() {
        window.location.href = 'profile.php';
    }
    
        const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
      const animate = () => {
        const target = +counter.getAttribute('data-target'); // Get target number
        const current = +counter.innerText; // Get current displayed number
        const increment = target / 100; // Increment value

        if (current < target) {
          counter.innerText = Math.ceil(current + increment); // Increment number
          setTimeout(animate, 20); // Call animate function repeatedly
        } else {
          counter.innerText = target; // Ensure the number stops at the target
        }
      };
      animate();
    });

   
    </script>
</body>
</html>
