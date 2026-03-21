<?php
// index.php - Home Page

require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoulMate - Find Your Perfect Match</title>
    <link rel="icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top soulmate-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-heart-fill me-2"></i>
                SoulMate
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="browse.php">Browse</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="auth/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="browse.php">Browse</a></li>
                        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <div id="homeCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="carousel-image-wrapper">
                    <img src="images/hero-wedding.jpeg" class="d-block w-100" alt="Happy couple">
                    <div class="carousel-overlay"></div>
                </div>
                <div class="carousel-caption">
                    <h2>Connect with Hearts</h2>
                    <p>Thousands of verified profiles waiting for you</p>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-image-wrapper">
                    <img src="images/hero-couple2.jpg" class="d-block w-100" alt="Happy couple 2">
                    <div class="carousel-overlay"></div>
                </div>
                <div class="carousel-caption">
                    <h2>Find Your SoulMate</h2>
                    <p>Start your beautiful journey with us</p>
                </div>
            </div>
            <div class="carousel-item">
                <div class="carousel-image-wrapper">
                    <img src="images/hero-couple3.jpg" class="d-block w-100" alt="Happy couple 3">
                    <div class="carousel-overlay"></div>
                </div>
                <div class="carousel-caption">
                    <h2>Begin Your Love Story</h2>
                    <p>Where dreams meet destiny</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="container text-center">
            <h1>Welcome to SoulMate Matrimony</h1>
            <p class="lead">Find your perfect match! Browse profiles, connect, and explore.</p>
            
            <?php if (isLoggedIn()): ?>
                <a href="browse.php" class="btn btn-light btn-lg mt-3">
                    <i class="bi bi-search"></i> Browse Profiles
                </a>
            <?php else: ?>
                <a href="auth/login.php" class="btn btn-outline-light btn-lg mt-3 me-2">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
                <a href="auth/register.php" class="btn btn-light btn-lg mt-3">
                    <i class="bi bi-person-plus"></i> Register
                </a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-shield-check feature-icon"></i>
                        <h4>Verified Profiles</h4>
                        <p>All profiles are manually verified for your safety</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-heart-fill feature-icon"></i>
                        <h4>Smart Matching</h4>
                        <p>Advanced algorithm to find compatible matches</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bi bi-lock-fill feature-icon"></i>
                        <h4>Privacy Protected</h4>
                        <p>Your data is encrypted and secure</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 SoulMate Matrimony | Designed with <i class="bi bi-heart-fill text-danger"></i> in Sri Lanka</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
