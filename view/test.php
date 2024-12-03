<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest - Enhanced Book Marquee</title>
    <style>
        :root {
            --book-width: 200px;
            --book-height: 280px;
            --book-margin: 20px;
            --primary-color: #3a4f50;
            --secondary-color: #6b8e9f;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .book-marquee-section {
            background-color: #ffffff;
            padding: 60px 0;
            overflow: hidden;
            position: relative;
        }

        .book-marquee-title {
            text-align: center;
            margin-bottom: 40px;
            font-family: 'Georgia', serif;
            color: var(--primary-color);
            font-size: 2.5rem;
            letter-spacing: -1px;
        }

        .book-marquee-wrapper {
            width: 100%;
            overflow: hidden;
        }

        .book-marquee-container {
            display: flex;
            width: max-content;
        }

        .book-marquee-animation {
            display: flex;
            animation: marqueeLeft 15s linear infinite;
        }

        @keyframes marqueeLeft {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc(-50% - var(--book-width) - var(--book-margin)));
            }
        }

        .book-card {
            width: var(--book-width);
            height: var(--book-height);
            margin: 0 var(--book-margin);
            perspective: 1000px;
            position: relative;
            transition: all 0.4s ease;
            flex-shrink: 0;
        }

        .book-inner {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .book-front, .book-side {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 12px;
            transition: all 0.6s ease;
        }

        .book-front {
            background-size: cover;
            background-position: center;
            transform: rotateY(0deg);
            z-index: 2;
        }

        .book-side {
            background-color: var(--secondary-color);
            transform: rotateY(90deg);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 1;
        }

        .book-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.4s ease;
            color: white;
            text-align: center;
            padding: 15px;
            box-sizing: border-box;
            z-index: 3;
        }

        .book-card:hover .book-inner {
            transform: rotateY(-90deg);
        }

        .book-card:hover .book-overlay {
            opacity: 1;
        }

        .book-card:hover {
            transform: scale(1.05);
            z-index: 10;
        }
    </style>
</head>
<body>
    <section class="book-marquee-section">
        <h2 class="book-marquee-title">Explore Our Book Collection</h2>
        <div class="book-marquee-wrapper">
            <div class="book-marquee-container">
                <div class="book-marquee-animation">
                    <!-- First Set of Books -->
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">Fiction</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Fiction</h3>
                            <p>Explore imaginative worlds and compelling narratives.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">Non-Fiction</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Non-Fiction</h3>
                            <p>Discover real stories and informative insights.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">Science</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Science</h3>
                            <p>Unravel the mysteries of the universe.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">History</div>
                        </div>
                        <div class="book-overlay">
                            <h3>History</h3>
                            <p>Journey through time and past civilizations.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">Biography</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Biography</h3>
                            <p>Explore inspiring life stories.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">Technology</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Technology</h3>
                            <p>Stay ahead with cutting-edge innovations.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">Mystery</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Mystery</h3>
                            <p>Uncover thrilling puzzles and suspenseful tales.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
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
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">Fiction</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Fiction</h3>
                            <p>Explore imaginative worlds and compelling narratives.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
                            <div class="book-side">Non-Fiction</div>
                        </div>
                        <div class="book-overlay">
                            <h3>Non-Fiction</h3>
                            <p>Discover real stories and informative insights.</p>
                        </div>
                    </div>
                    <div class="book-card">
                        <div class="book-inner">
                            <div class="book-front" style="background-image: url('/api/placeholder/200/280');"></div>
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

    <script>
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