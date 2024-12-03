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


    <link rel="stylesheet" href="index.css">
    <section class="book-marquee-section">
        <h2 class="book-marquee-title">Explore Our Book Collection</h2>
        <div class="book-marquee-wrapper">
            <div class="book-marquee-container">
                <div class="book-marquee-animation">
                    <!-- First Set of Books -->
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book1.jpg);"></div>
                            <div class="book-side">Fiction</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Fiction</h3>
                            <p>Explore imaginative worlds and compelling narratives.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book2.jpg);"></div>
                            <div class="book-side">Non-Fiction</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Non-Fiction</h3>
                            <p>Discover real stories and informative insights.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book3.jpg);"></div>
                            <div class="book-side">Science</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Science</h3>
                            <p>Unravel the mysteries of the universe.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book4.jpg);"></div>
                            <div class="book-side">History</div>
                        </div>
                        <div class="book-overlay">
                            <h3>History</h3>
                            <p>Journey through time and past civilizations.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book5.jpg);"></div>
                            <div class="book-side">Biography</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Biography</h3>
                            <p>Explore inspiring life stories.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book6.jpg);"></div>
                            <div class="book-side">Technology</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Technology</h3>
                            <p>Stay ahead with cutting-edge innovations.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book7.jpg);"></div>
                            <div class="book-side">Mystery</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Mystery</h3>
                            <p>Uncover thrilling puzzles and suspenseful tales.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book8.jpg);"></div>
                            <div class="book-side">Fantasy</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Fantasy</h3>
                            <p>Immerse yourself in magical and extraordinary realms.</p>
                        </div>
                    </div>

                    <!-- Duplicate First Set of Books -->
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book9.jpg);"></div>
                            <div class="book-side">Fiction</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Fiction</h3>
                            <p>Explore imaginative worlds and compelling narratives.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book10.jpg);"></div>
                            <div class="book-side">Non-Fiction</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Non-Fiction</h3>
                            <p>Discover real stories and informative insights.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url(../image/book11.jpg);"></div>
                            <div class="book-side">Science</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Science</h3>
                            <p>Unravel the mysteries of the universe.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

    const marqueeWrapper = document.querySelector('.book-marquee-wrapper');
        const marqueeContainer = document.querySelector('.book-marquee-container');
        const marqueeAnimation = document.querySelector('.book-marquee-animation');
        
        // Pause animation on hover
        marqueeWrapper.addEventListener('mouseenter', () => {
            marqueeAnimation.style.animationPlayState = 'paused';
        });
        
        marqueeWrapper.addEventListener('mouseleave', () => {
            marqueeAnimation.style.animationPlayState = 'running';
        });
        
    </script>
</body>
</html>
