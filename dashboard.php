<?php
// dashboard.php - User Dashboard

require_once 'includes/functions.php';
requireAuth();

$user = getUserById($_SESSION['user_id']);
$age = calculateAge($user['birthdate']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SoulMate</title>
    <link rel="icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard-page">

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
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="browse.php">Browse</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="auth/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="padding-top: 100px;">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center">
                            <?php 
                            if (!empty($user['profile_image']) && file_exists($user['profile_image'])) {
                                $imgSrc = $user['profile_image'];
                            } elseif (file_exists('images/profile' . $user['id'] . '.jpeg')) {
                                $imgSrc = 'images/profile' . $user['id'] . '.jpeg';
                            } elseif (file_exists('images/profile' . $user['id'] . '.jpg')) {
                                $imgSrc = 'images/profile' . $user['id'] . '.jpg';
                            } elseif (file_exists('images/profile' . $user['id'] . '.png')) {
                                $imgSrc = 'images/profile' . $user['id'] . '.png';
                            } else {
                                $imgSrc = ($user['gender'] == 'female') ? 'images/profile2.jpeg' : 'images/profile1.jpeg';
                            }
                            ?>
                            <img src="<?php echo $imgSrc; ?>" 
                                 class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                            <h4><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h4>
                            <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Verified</span>
                            <hr>
                            <p><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                            <p><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($user['location']); ?></p>
                            <a href="profile.php?id=<?php echo $user['id']; ?>" class="btn btn-primary w-100">View Public Profile</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-person-circle"></i> My Profile</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Age:</strong> <?php echo $age; ?> years</p>
                                    <p><strong>Gender:</strong> <?php echo ucfirst($user['gender']); ?></p>
                                    <p><strong>Education:</strong> <?php echo htmlspecialchars($user['education'] ?? 'Not specified'); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Occupation:</strong> <?php echo htmlspecialchars($user['occupation'] ?? 'Not specified'); ?></p>
                                    <p><strong>Religion:</strong> <?php echo htmlspecialchars($user['religion'] ?? 'Not specified'); ?></p>
                                    <p><strong>Looking for:</strong> <?php echo ucfirst($user['looking_for'] ?? 'Not specified'); ?></p>
                                </div>
                            </div>
                            <hr>
                            <h6>About Me</h6>
                            <p><?php echo nl2br(htmlspecialchars($user['bio'] ?? 'No bio added yet.')); ?></p>
                            
                            <?php if ($user['interests']): ?>
                            <h6 class="mt-3">Interests</h6>
                            <div>
                                <?php foreach (explode(',', $user['interests']) as $interest): ?>
                                    <span class="badge me-1" style="background: linear-gradient(135deg, #4a3f8c 0%, #6b5ab8 100%);"><?php echo htmlspecialchars(trim($interest)); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header" style="background: linear-gradient(135deg, #2d9d5d 0%, #3db974 100%);">
                            <h5 class="mb-0"><i class="bi bi-people"></i> Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-4 mb-3">
                                    <a href="browse.php" class="btn btn-outline-primary w-100">
                                        <i class="bi bi-search fs-3 d-block mb-2"></i>
                                        Browse Profiles
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="contact.php" class="btn btn-outline-success w-100">
                                        <i class="bi bi-envelope fs-3 d-block mb-2"></i>
                                        Contact Support
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="#" class="btn btn-outline-info w-100">
                                        <i class="bi bi-gear fs-3 d-block mb-2"></i>
                                        Settings
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
