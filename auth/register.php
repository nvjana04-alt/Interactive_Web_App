<?php
// auth/register.php - User Registration

require_once '../includes/functions.php';
redirectIfLoggedIn();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = "Invalid request. Please try again.";
    } else {
        $firstName = sanitize($_POST['firstName'] ?? '');
        $lastName = sanitize($_POST['lastName'] ?? '');
        $gender = sanitize($_POST['gender'] ?? '');
        $birthdate = sanitize($_POST['birthdate'] ?? '');
        $location = sanitize($_POST['location'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        $occupation = sanitize($_POST['occupation'] ?? '');
        $education = sanitize($_POST['education'] ?? '');
        $religion = sanitize($_POST['religion'] ?? '');
        $bio = sanitize($_POST['bio'] ?? '');
        $lookingFor = sanitize($_POST['lookingFor'] ?? '');
        $interests = sanitize($_POST['selectedInterests'] ?? '');
        $terms = isset($_POST['terms']);

        if (empty($firstName) || empty($lastName) || empty($gender) || 
            empty($birthdate) || empty($location) || empty($email) || 
            empty($password) || empty($confirmPassword)) {
            $error = "Please fill in all required fields.";
        } elseif (!isValidEmail($email)) {
            $error = "Please enter a valid email address.";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } elseif ($password !== $confirmPassword) {
            $error = "Passwords do not match.";
        } elseif (!$terms) {
            $error = "You must agree to the Terms of Service.";
        } else {
            $pdo = getDBConnection();
            
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error = "Email already registered. Please login instead.";
            } else {
                $profileImage = null;
                if (isset($_FILES['photoInput']) && $_FILES['photoInput']['error'] === UPLOAD_ERR_OK) {
                    $profileImage = uploadProfileImage($_FILES['photoInput']);
                }

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("
                    INSERT INTO users 
                    (first_name, last_name, email, password_hash, gender, birthdate, 
                     location, occupation, education, religion, bio, looking_for, 
                     interests, profile_image, is_verified) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
                ");

                try {
                    $stmt->execute([
                        $firstName, $lastName, $email, $passwordHash, $gender, 
                        $birthdate, $location, $occupation, $education, $religion,
                        $bio, $lookingFor, $interests, $profileImage
                    ]);

                    $_SESSION['success_msg'] = "Registration successful! Please login.";
                    header("Location: login.php");
                    exit();
                } catch (PDOException $e) {
                    error_log("Registration error: " . $e->getMessage());
                    $error = "Registration failed. Please try again.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SoulMate</title>
    <link rel="icon" href="../images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .form-step { display: none; }
        .form-step.active { display: block; animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
        .gender-option { cursor: pointer; padding: 20px; border: 2px solid #ddd; border-radius: 10px; text-align: center; transition: all 0.3s; }
        .gender-option:hover, .gender-option.selected { border-color: #5b4dcc; background: rgba(91, 77, 204, 0.1); }
        .gender-option i { font-size: 2rem; display: block; margin-bottom: 5px; color: #5b4dcc; }
        .interest-tag { display: inline-block; padding: 8px 16px; margin: 4px; border-radius: 20px; background: #f0f0f0; cursor: pointer; transition: all 0.3s; }
        .interest-tag.selected { background: linear-gradient(135deg, #5b4dcc 0%, #7c6af0 100%); color: white; }
        .photo-upload { width: 150px; height: 150px; border-radius: 50%; border: 3px dashed #5b4dcc; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer; margin: 0 auto; background: #f8f9fa; position: relative; overflow: hidden; }
        .photo-upload img { width: 100%; height: 100%; object-fit: cover; position: absolute; display: none; }
        .step-indicator { display: flex; justify-content: center; gap: 2rem; margin-bottom: 2rem; }
        .step { display: flex; align-items: center; gap: 0.5rem; color: #999; }
        .step.active { color: #5b4dcc; font-weight: bold; }
        .step-number { width: 30px; height: 30px; border-radius: 50%; background: #ddd; display: flex; align-items: center; justify-content: center; color: white; }
        .step.active .step-number { background: linear-gradient(135deg, #5b4dcc 0%, #7c6af0 100%); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top soulmate-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">
                <i class="bi bi-heart-fill me-2"></i>
                SoulMate
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="auth-section" style="padding-top: 120px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">
                    <div class="auth-card">
                        <div class="auth-header text-center">
                            <h3><i class="bi bi-heart-fill text-danger"></i> Create Your Account</h3>
                            <p class="text-muted">Join thousands of singles looking for love</p>
                        </div>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <div class="progress mb-4" style="height: 8px;">
                            <div class="progress-bar" id="progressBar" style="width: 33%; background: linear-gradient(135deg, #5b4dcc 0%, #7c6af0 100%);"></div>
                        </div>

                        <div class="step-indicator">
                            <div class="step active" id="step1Indicator">
                                <div class="step-number">1</div>
                                <span>Account</span>
                            </div>
                            <div class="step" id="step2Indicator">
                                <div class="step-number">2</div>
                                <span>Profile</span>
                            </div>
                            <div class="step" id="step3Indicator">
                                <div class="step-number">3</div>
                                <span>Interests</span>
                            </div>
                        </div>

                        <form method="POST" action="" enctype="multipart/form-data" id="registerForm">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                            
                            <!-- Step 1 -->
                            <div class="form-step active" id="step1">
                                <h5 class="mb-4 text-center">Basic Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" name="firstName" placeholder="First Name" required value="<?php echo $_POST['firstName'] ?? ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" class="form-control" name="lastName" placeholder="Last Name" required value="<?php echo $_POST['lastName'] ?? ''; ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label d-block text-center">I am a</label>
                                    <div class="d-flex gap-3 justify-content-center">
                                        <div class="gender-option" onclick="selectGender('male')" data-gender="male">
                                            <i class="bi bi-gender-male"></i>Male
                                        </div>
                                        <div class="gender-option" onclick="selectGender('female')" data-gender="female">
                                            <i class="bi bi-gender-female"></i>Female
                                        </div>
                                        <div class="gender-option" onclick="selectGender('other')" data-gender="other">
                                            <i class="bi bi-gender-ambiguous"></i>Other
                                        </div>
                                    </div>
                                    <input type="hidden" name="gender" id="gender" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="date" class="form-control" name="birthdate" required value="<?php echo $_POST['birthdate'] ?? ''; ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select" name="location" required>
                                            <option value="">Select Location</option>
                                            <option value="Colombo">Colombo</option>
                                            <option value="Kandy">Kandy</option>
                                            <option value="Galle">Galle</option>
                                            <option value="Jaffna">Jaffna</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Email Address" required value="<?php echo $_POST['email'] ?? ''; ?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required minlength="6">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" style="background: linear-gradient(135deg, #5b4dcc 0%, #7c6af0 100%); border: none;" onclick="nextStep(2)">Next Step <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="form-step" id="step2">
                                <h5 class="mb-4 text-center">Profile Details</h5>
                                
                                <div class="text-center mb-4">
                                    <div class="photo-upload" onclick="document.getElementById('photoInput').click()">
                                        <img id="previewImage" src="" alt="Preview">
                                        <i class="bi bi-camera-fill fs-2" style="color: #5b4dcc;"></i>
                                        <small>Click to upload photo</small>
                                    </div>
                                    <input type="file" name="photoInput" id="photoInput" accept="image/*" style="display: none;" onchange="previewPhoto(event)">
                                </div>

                                <div class="mb-3">
                                    <input type="text" class="form-control" name="occupation" placeholder="Occupation" value="<?php echo $_POST['occupation'] ?? ''; ?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select" name="education">
                                            <option value="">Select Education</option>
                                            <option value="High School">High School</option>
                                            <option value="Bachelor's Degree">Bachelor's Degree</option>
                                            <option value="Master's Degree">Master's Degree</option>
                                            <option value="PhD">PhD/Doctorate</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <select class="form-select" name="religion">
                                            <option value="">Select Religion</option>
                                            <option value="Buddhist">Buddhist</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Christian">Christian</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <textarea class="form-control" name="bio" placeholder="Tell us about yourself..." rows="3"><?php echo $_POST['bio'] ?? ''; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <select class="form-select" name="lookingFor">
                                        <option value="">Looking for</option>
                                        <option value="male">Men</option>
                                        <option value="female">Women</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(1)"><i class="bi bi-arrow-left"></i> Back</button>
                                    <button type="button" class="btn btn-primary" style="background: linear-gradient(135deg, #5b4dcc 0%, #7c6af0 100%); border: none;" onclick="nextStep(3)">Next Step <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="form-step" id="step3">
                                <h5 class="mb-4 text-center">Your Interests</h5>
                                <p class="text-center text-muted mb-4">Select at least 3 interests</p>

                                <div class="text-center mb-4" id="interestsContainer">
                                    <div class="mb-2">
                                        <span class="interest-tag" onclick="toggleInterest(this)">🎵 Music</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">🎬 Movies</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">📚 Reading</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">✈️ Travel</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">🍳 Cooking</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">🏃 Fitness</span>
                                    </div>
                                    <div class="mb-2">
                                        <span class="interest-tag" onclick="toggleInterest(this)">🎮 Gaming</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">🎨 Art</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">📷 Photography</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">🌱 Nature</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">🐾 Animals</span>
                                        <span class="interest-tag" onclick="toggleInterest(this)">☕ Coffee</span>
                                    </div>
                                </div>
                                <input type="hidden" name="selectedInterests" id="selectedInterests">

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" style="color: #5b4dcc;">Terms of Service</a> and <a href="#" style="color: #5b4dcc;">Privacy Policy</a>
                                    </label>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(2)"><i class="bi bi-arrow-left"></i> Back</button>
                                    <button type="submit" class="btn btn-primary btn-lg" style="background: linear-gradient(135deg, #5b4dcc 0%, #7c6af0 100%); border: none;">
                                        <i class="bi bi-check-circle"></i> Create Account
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted">Already have an account? <a href="login.php" style="color: #5b4dcc;">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentStep = 1;
        let selectedInterests = [];

        function selectGender(gender) {
            document.getElementById('gender').value = gender;
            document.querySelectorAll('.gender-option').forEach(el => el.classList.remove('selected'));
            document.querySelector(`[data-gender="${gender}"]`).classList.add('selected');
        }

        function toggleInterest(element) {
            const interest = element.textContent.trim();
            const index = selectedInterests.indexOf(interest);
            
            if (index === -1) {
                selectedInterests.push(interest);
                element.classList.add('selected');
            } else {
                selectedInterests.splice(index, 1);
                element.classList.remove('selected');
            }
            
            document.getElementById('selectedInterests').value = selectedInterests.join(',');
        }

        function previewPhoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewImage');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        function nextStep(step) {
            if (currentStep === 1) {
                const required = ['firstName', 'lastName', 'gender', 'birthdate', 'location', 'email', 'password'];
                for (let field of required) {
                    const el = document.getElementsByName(field)[0];
                    if (!el || !el.value) {
                        alert('Please fill in all required fields');
                        return;
                    }
                }
            }

            document.getElementById(`step${currentStep}`).classList.remove('active');
            document.getElementById(`step${step}`).classList.add('active');
            document.getElementById(`step${currentStep}Indicator`).classList.remove('active');
            document.getElementById(`step${step}Indicator`).classList.add('active');
            
            document.getElementById('progressBar').style.width = `${(step / 3) * 100}%`;
            currentStep = step;
        }

        function prevStep(step) {
            document.getElementById(`step${currentStep}`).classList.remove('active');
            document.getElementById(`step${step}`).classList.add('active');
            document.getElementById(`step${currentStep}Indicator`).classList.remove('active');
            document.getElementById(`step${step}Indicator`).classList.add('active');
            
            document.getElementById('progressBar').style.width = `${(step / 3) * 100}%`;
            currentStep = step;
        }
    </script>
</body>
</html>
