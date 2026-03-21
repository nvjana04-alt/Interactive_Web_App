<?php
// browse.php - Browse Profiles

require_once 'includes/functions.php';
requireAuth();

$profiles = getAllProfiles($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Profiles - SoulMate</title>
    <link rel="icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="browse-page">

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
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="browse.php">Browse</a></li>
                    <li class="nav-item"><a class="nav-link" href="auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="padding-top: 76px;">
        <!-- Page Header -->
        <div class="page-header">
            <div class="container text-center">
                <h2 class="fw-bold mb-2">🔍 Browse Profiles</h2>
                <p class="mb-0">Discover verified members and find your perfect match</p>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <?php 
                $localImages = [
                    1 => 'profile1.jpeg',
                    2 => 'profile2.jpeg',
                    3 => 'profile3.jpeg',
                    4 => 'profile4.jpeg',
                    5 => 'profile5.jpeg',
                    6 => 'profile6.jpeg'
                ];
                
                foreach ($profiles as $profile): 
                    $profileAge = calculateAge($profile['birthdate']);
                    
                    if (!empty($profile['profile_image']) && file_exists($profile['profile_image'])) {
                        $imgSrc = $profile['profile_image'];
                    } elseif (isset($localImages[$profile['id']])) {
                        $imgSrc = 'images/' . $localImages[$profile['id']];
                    } elseif ($profile['gender'] == 'female') {
                        $imgSrc = 'images/profile2.jpeg';
                    } else {
                        $imgSrc = 'images/profile1.jpeg';
                    }
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card profile-card h-100 shadow-sm">
                        <img src="<?php echo $imgSrc; ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($profile['first_name']); ?>" 
                             style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($profile['first_name'] . ' ' . $profile['last_name']); ?></h5>
                            <p class="card-text text-muted">
                                <i class="bi bi-calendar"></i> <?php echo $profileAge; ?> years<br>
                                <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($profile['location']); ?><br>
                                <i class="bi bi-briefcase"></i> <?php echo htmlspecialchars($profile['occupation'] ?? 'Not specified'); ?>
                            </p>
                            <a href="profile.php?id=<?php echo $profile['id']; ?>" class="btn btn-primary w-100">
                                View Profile <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
