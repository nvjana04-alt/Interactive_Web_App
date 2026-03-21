<?php
// contact.php - Contact Form with Database Storage

require_once 'includes/functions.php';

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all required fields.";
    } elseif (!isValidEmail($email)) {
        $error = "Please enter a valid email address.";
    } else {
        $pdo = getDBConnection();
        
        try {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $message]);
            
            $success = "Thank you for your message! We'll get back to you soon.";
            
            $name = $email = $phone = $message = '';
        } catch (PDOException $e) {
            error_log("Contact form error: " . $e->getMessage());
            $error = "Failed to send message. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - SoulMate</title>
    <link rel="icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="contact-page">

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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="auth/login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div style="padding-top: 76px;">
        <!-- Page Header -->
        <div class="page-header">
            <div class="container text-center">
                <h2 class="fw-bold mb-2">📧 Contact Us</h2>
                <p class="mb-0">We'd love to hear from you. Send us a message!</p>
            </div>
        </div>

        <div class="container mt-5">
            <!-- Contact Info Cards -->
            <div class="row mb-5">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 text-center p-4">
                        <i class="bi bi-geo-alt-fill fs-1 mb-3"></i>
                        <h5>Our Address</h5>
                        <p class="text-muted mb-0">Jaffna, Sri Lanka</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 text-center p-4">
                        <i class="bi bi-envelope-fill fs-1 mb-3"></i>
                        <h5>Email Us</h5>
                        <p class="text-muted mb-0">support@soulmate.com</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 text-center p-4">
                        <i class="bi bi-telephone-fill fs-1 mb-3"></i>
                        <h5>Call Us</h5>
                        <p class="text-muted mb-0">+94 77 123 4567</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="card-title mb-4 text-center">
                                <i class="bi bi-pencil-square text-primary"></i> Send us a Message
                            </h3>

                            <?php if ($success): ?>
                                <div class="alert alert-success"><?php echo $success; ?></div>
                            <?php endif; ?>
                            
                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php endif; ?>

                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Full Name *</label>
                                    <input type="text" class="form-control" name="name" required 
                                           value="<?php echo $name ?? ''; ?>" placeholder="Enter your full name">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email Address *</label>
                                    <input type="email" class="form-control" name="email" required
                                           value="<?php echo $email ?? ''; ?>" placeholder="Enter your email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Phone Number</label>
                                    <input type="tel" class="form-control" name="phone"
                                           value="<?php echo $phone ?? ''; ?>" placeholder="Enter your phone number (optional)">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Message *</label>
                                    <textarea class="form-control" name="message" rows="5" required 
                                              placeholder="How can we help you?"><?php echo $message ?? ''; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 btn-lg">
                                    <i class="bi bi-send"></i> Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
