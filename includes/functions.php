<?php
// includes/functions.php - Helper Functions

require_once 'db.php';

session_start();

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Redirect to login page if not authenticated
 */
function requireAuth() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = "Please login to access this page.";
        header("Location: auth/login.php");
        exit();
    }
}

/**
 * Redirect to dashboard if already logged in
 */
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header("Location: dashboard.php");
        exit();
    }
}

/**
 * Sanitize user input
 * @param string $data
 * @return string
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Display session messages
 * @param string $type (success, error, warning)
 */
function showMessage($type = 'success') {
    $key = $type . '_msg';
    if (isset($_SESSION[$key])) {
        $alertClass = $type === 'error' ? 'danger' : $type;
        echo '<div class="alert alert-' . $alertClass . ' alert-dismissible fade show" role="alert">';
        echo $_SESSION[$key];
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
        unset($_SESSION[$key]);
    }
}

/**
 * Validate email format
 * @param string $email
 * @return bool
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Calculate age from birthdate
 * @param string $birthdate
 * @return int
 */
function calculateAge($birthdate) {
    $today = new DateTime();
    $dob = new DateTime($birthdate);
    $diff = $today->diff($dob);
    return $diff->y;
}

/**
 * Generate CSRF token
 * @return string
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * @param string $token
 * @return bool
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Upload profile image
 * @param array $file $_FILES array
 * @return string|false filename or false on error
 */
function uploadProfileImage($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowedTypes)) {
        return false;
    }
    
    if ($file['size'] > $maxSize) {
        return false;
    }
    
    $uploadDir = '../uploads/profiles/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $filename = uniqid() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return 'uploads/profiles/' . $filename;
    }
    
    return false;
}

/**
 * Get user by ID
 * @param int $userId
 * @return array|false
 */
function getUserById($userId) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch();
}

/**
 * Get all profiles (for browse page)
 * @param int $excludeUserId
 * @return array
 */
function getAllProfiles($excludeUserId = null) {
    $pdo = getDBConnection();
    $sql = "SELECT id, first_name, last_name, gender, birthdate, location, occupation, education, bio, interests, profile_image FROM users WHERE is_verified = 1";
    $params = [];
    
    if ($excludeUserId) {
        $sql .= " AND id != ?";
        $params[] = $excludeUserId;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Log user activity
 * @param int $userId
 * @param string $action
 */
function logActivity($userId, $action) {
    // Optional: Implement activity logging
    error_log("User $userId: $action");
}
?>