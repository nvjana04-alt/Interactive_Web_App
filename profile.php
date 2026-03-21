<?php
// profile.php - View Individual Profile

require_once 'includes/functions.php';
requireAuth();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: browse.php");
    exit();
}

$profileId = (int)$_GET['id'];
$profile = getUserById($profileId);

if (!$profile) {
    header("Location: browse.php");
    exit();
}

$age = calculateAge($profile['birthdate']);

// Determine profile image
$imgSrc = 'images/profile1.jpeg'; // default
if (!empty($profile['profile_image']) && file_exists($profile['profile_image'])) {
    $imgSrc = $profile['profile_image'];
} else {
    // Map IDs to local images
    $localImages = [
        1 => 'profile1.jpeg',
        2 => 'profile2.jpeg', 
        3 => 'profile3.jpeg',
        4 => 'profile4.jpeg',
        5 => 'profile5.jpeg',
        6 => 'profile6.jpeg'
    ];
    if (isset($localImages[$profile['id']])) {
        $imgSrc = 'images/' . $localImages[$profile['id']];
    } elseif ($profile['gender'] == 'female') {
        $imgSrc = 'images/profile2.jpeg';
    } else {
        $imgSrc = 'images/profile1.jpeg';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile['first_name']); ?> - SoulMate</title>
    <link rel="icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="browse.php">Browse</a></li>
                    <li class="nav-item"><a class="nav-link" href="auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="padding-top: 100px;">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-5 text-center">
                    <img src="<?php echo $imgSrc; ?>" 
                         class="img-fluid rounded shadow" 
                         style="max-height: 500px; width: 100%; object-fit: cover;" 
                         alt="<?php echo htmlspecialchars($profile['first_name']); ?>">
                    <div class="mt-3">
                        <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Verified Profile</span>
                    </div>
                </div>

                <div class="col-md-7">
                    <h2 class="mb-3"><?php echo htmlspecialchars($profile['first_name'] . ' ' . $profile['last_name']); ?></h2>
                    
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p><i class="bi bi-calendar" style="color: #5b4dcc;"></i> <strong>Age:</strong> <?php echo $age; ?> years</p>
                                    <p><i class="bi bi-geo-alt" style="color: #5b4dcc;"></i> <strong>Location:</strong> <?php echo htmlspecialchars($profile['location']); ?></p>
                                    <p><i class="bi bi-gender-ambiguous" style="color: #5b4dcc;"></i> <strong>Gender:</strong> <?php echo ucfirst($profile['gender']); ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <p><i class="bi bi-briefcase" style="color: #5b4dcc;"></i> <strong>Profession:</strong> <?php echo htmlspecialchars($profile['occupation'] ?? 'Not specified'); ?></p>
                                    <p><i class="bi bi-mortarboard" style="color: #5b4dcc;"></i> <strong>Education:</strong> <?php echo htmlspecialchars($profile['education'] ?? 'Not specified'); ?></p>
                                    <p><i class="bi bi-circle" style="color: #5b4dcc;"></i> <strong>Religion:</strong> <?php echo htmlspecialchars($profile['religion'] ?? 'Not specified'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5><i class="bi bi-chat-quote" style="color: #5b4dcc;"></i> About Me</h5>
                            <p><?php echo nl2br(htmlspecialchars($profile['bio'] ?? 'No bio available.')); ?></p>
                        </div>
                    </div>

                    <?php if ($profile['interests']): ?>
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <h5><i class="bi bi-heart" style="color: #5b4dcc;"></i> Interests</h5>
                            <?php foreach (explode(',', $profile['interests']) as $interest): ?>
                                <span class="badge me-1 mb-1" style="background: linear-gradient(135deg, #5b4dcc 0%, #7c6af0 100%);"><?php echo htmlspecialchars(trim($interest)); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <button class="btn btn-primary btn-lg w-100 mb-2" onclick="showInterest()" style="background: linear-gradient(135deg, #5b4dcc 0%, #7c6af0 100%); border: none;">
                        <i class="bi bi-heart-fill"></i> Send Interest
                    </button>
                    
                    <a href="browse.php" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="bi bi-arrow-left"></i> Back to Browse
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showInterest() {
            alert('Interest sent successfully! ❤️ We will notify ' + <?php echo json_encode($profile['first_name']); ?>);
        }
    </script>
</body>
</html>
