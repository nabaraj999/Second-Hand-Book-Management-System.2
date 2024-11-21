<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="index.css">
   <link rel="stylesheet" href="help.css">
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


    <div class="help-container">
    <!-- Header -->
    <div class="header">
      <h1>Help & Support</h1>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
      <h2>Frequently Asked Questions</h2>
      <ul class="faq-list">
        <li>
          <div class="faq-question" onclick="toggleAnswer(this)">
            1. How do I create an account on BOOKNEST?
          </div>
          <div class="faq-answer">
            To create an account, click the "Sign Up" button on the homepage, fill in your details, and submit the form.
          </div>
        </li>
        <li>
          <div class="faq-question" onclick="toggleAnswer(this)">
            2. How can I list a book for sale?
          </div>
          <div class="faq-answer">
            Go to your dashboard, click "Sell a Book," provide the required information, and upload images of your book.
          </div>
        </li>
        <li>
          <div class="faq-question" onclick="toggleAnswer(this)">
            3. How do I track my order?
          </div>
          <div class="faq-answer">
            Navigate to the "My Orders" section in your account to view the tracking details of your purchase.
          </div>
        </li>
        <li>
          <div class="faq-question" onclick="toggleAnswer(this)">
            4. What is the return policy for purchased books?
          </div>
          <div class="faq-answer">
            BOOKNEST allows returns within 7 days of delivery if the book is damaged or not as described.
          </div>
        </li>
        <li>
          <div class="faq-question" onclick="toggleAnswer(this)">
            5. How can I contact customer support?
          </div>
          <div class="faq-answer">
            You can contact us via email at support@booknest.com or call us at +1 800 123 4567.
          </div>
        </li>
        <li>
          <div class="faq-question" onclick="toggleAnswer(this)">
            6. How do I change my account information?
          </div>
          <div class="faq-answer">
            Go to your account settings and click "Edit Profile" to update your information.
          </div>
        </li>
      </ul>
    </div>

    <!-- Contact Us Section -->
    <div class="contact-section">
      <h2>Contact Us</h2>
      <p>If you need further assistance, please contact us:</p>
      <p><strong>Email:</strong> support@booknest.com</p>
      <p><strong>Phone:</strong> +1 800 123 4567</p>
      <p><strong>Hours:</strong> Monday - Friday, 9 AM - 5 PM</p>
    </div>

    <!-- Helpful Resources -->
    <div class="resources-section">
      <h2>Helpful Resources</h2>
      <div class="resources-buttons">
        <button>User Guide</button>
        <button>Detailed FAQs</button>
        <button>Video Tutorials</button>
        <button>Terms of Service</button>
        <button>Privacy Policy</button>
      </div>
    </div>
  </div>


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
    // Function to toggle the answer display
function toggleAnswer(questionElement) {
  const answerElement = questionElement.nextElementSibling;

  // Toggle visibility of the answer
  if (answerElement.classList.contains('visible')) {
    answerElement.classList.remove('visible');
  } else {
    answerElement.classList.add('visible');
  }
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
