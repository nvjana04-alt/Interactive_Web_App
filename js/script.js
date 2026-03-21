// User data storage
let users = JSON.parse(localStorage.getItem('users')) || [];

// Sample profile data for browse page
const profiles = [
    {
        id: 1,
        name: "Vithujan",
        age: 24,
        location: "Jaffna",
        profession: "Software Engineer",
        education: "B.Sc. Computer Science",
        hobbies: "Reading, Traveling",
        about: "I'm a passionate software engineer who loves reading books and traveling. Looking for a life partner who shares similar interests.",
        image: "images/profile1.jpeg"
    },
    {
        id: 2,
        name: "Amara",
        age: 23,
        location: "Colombo",
        profession: "Doctor",
        education: "MBBS",
        hobbies: "Music, Dancing",
        about: "I am a caring doctor who loves to help others. Looking for someone who values family and kindness.",
        image: "images/profile2.jpeg"
    },
    {
        id: 3,
        name: "Kamal",
        age: 26,
        location: "Kandy",
        profession: "Teacher",
        education: "B.Ed.",
        hobbies: "Reading, Gardening",
        about: "Passionate about education and nature. Seeking a partner who appreciates simple joys of life.",
        image: "images/profile3.jpeg"
    },
    {
        id: 4,
        name: "Priya",
        age: 25,
        location: "Galle",
        profession: "Architect",
        education: "B.Arch",
        hobbies: "Art, Photography",
        about: "Creative architect who loves designing beautiful spaces. Looking for someone with similar creative interests.",
        image: "images/profile4.jpeg"
    },
    {
        id: 5,
        name: "Rajan",
        age: 27,
        location: "Jaffna",
        profession: "Business Owner",
        education: "MBA",
        hobbies: "Travel, Business",
        about: "Entrepreneur looking for a life partner to share dreams and build a future together.",
        image: "images/profile5.jpeg"
    },
    {
        id: 6,
        name: "Nithya",
        age: 24,
        location: "Colombo",
        profession: "Marketing Manager",
        education: "BBA",
        hobbies: "Fitness, Cooking",
        about: "Energetic marketing professional who loves fitness and trying new recipes.",
        image: "images/profile6.jpeg"
    }
];

// Save profiles to localStorage
localStorage.setItem('profiles', JSON.stringify(profiles));

// Function to display profile cards on browse page
function displayProfiles() {
    const profileCards = document.getElementById('profileCards');
    if (profileCards) {
        profileCards.innerHTML = '';
        profiles.forEach(profile => {
            const card = `
                <div class="col-md-4 mb-4">
                    <div class="card profile-card h-100 shadow-sm">
                        <img src="${profile.image}" class="card-img-top" alt="${profile.name}" style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">${profile.name}</h5>
                            <p class="card-text">
                                <i class="bi bi-calendar"></i> ${profile.age} years<br>
                                <i class="bi bi-geo-alt"></i> ${profile.location}<br>
                                <i class="bi bi-briefcase"></i> ${profile.profession}
                            </p>
                            <button class="btn btn-primary w-100" onclick="viewProfile(${profile.id})">
                                View Profile <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            profileCards.innerHTML += card;
        });
    }
}

// Function to view individual profile
function viewProfile(id) {
    const profile = profiles.find(p => p.id === id);
    if (profile) {
        localStorage.setItem('currentProfile', JSON.stringify(profile));
        window.location.href = 'profile.html';
    }
}

// Load profile data on profile page
function loadProfileData() {
    const profile = JSON.parse(localStorage.getItem('currentProfile'));
    if (profile) {
        document.getElementById('name').textContent = profile.name;
        document.getElementById('age').textContent = profile.age;
        document.getElementById('location').textContent = profile.location;
        document.getElementById('profession').textContent = profile.profession;
        document.getElementById('education').textContent = profile.education;
        document.getElementById('hobbies').textContent = profile.hobbies;
        document.getElementById('about').textContent = profile.about;
        
        const profileImage = document.getElementById('profileImage');
        if (profileImage) {
            profileImage.src = profile.image;
        }
    }
}

// Login form validation and handling - UPDATED to redirect to browse.html
if (document.getElementById('loginForm')) {
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (email && password) {
            // Get users from localStorage
            const users = JSON.parse(localStorage.getItem('users')) || [];
            
            // Check if user exists
            const user = users.find(u => u.email === email && u.password === password);
            
            if (user) {
                localStorage.setItem('currentUser', JSON.stringify(user));
                alert('Login successful! Welcome back ' + user.firstName + '!');
                // UPDATED: Redirect to browse page instead of index.html
                window.location.href = 'browse.html';
            } else {
                // Check if any users exist at all
                if (users.length === 0) {
                    showError('No users found. Please register first!');
                } else {
                    showError('Invalid email or password. Please try again.');
                }
            }
        } else {
            showError('Please fill in all fields.');
        }
    });
}

// Register form handling
if (document.getElementById('registerForm')) {
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const gender = document.getElementById('gender').value;
        const birthdate = document.getElementById('birthdate').value;
        const location = document.getElementById('location').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        // Validate password match
        if (password !== confirmPassword) {
            showError('Passwords do not match!');
            return;
        }
        
        // Validate password length
        if (password.length < 6) {
            showError('Password must be at least 6 characters!');
            return;
        }
        
        // Check if email already exists
        if (users.some(u => u.email === email)) {
            showError('Email already registered!');
            return;
        }
        
        // Create new user
        const newUser = {
            firstName,
            lastName,
            gender,
            birthdate,
            location,
            email,
            password,
            registeredDate: new Date().toISOString()
        };
        
        users.push(newUser);
        localStorage.setItem('users', JSON.stringify(users));
        
        alert('Registration successful! Please login.');
        window.location.href = 'login.html';
    });
}

// Contact form registration
if (document.getElementById('registrationForm')) {
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const message = document.getElementById('message').value;
        
        if (name && email && message) {
            alert(`Thank you ${name}! We will contact you soon at ${email}.`);
            this.reset();
        } else {
            alert('Please fill in all required fields (Name, Email, Message)');
        }
    });
}

// Quiz function
function calculateQuiz() {
    const q1 = parseInt(document.getElementById('q1').value);
    const q2 = parseInt(document.getElementById('q2').value);
    const q3 = parseInt(document.getElementById('q3').value);
    
    const score = q1 + q2 + q3;
    let result = '';
    
    if (score >= 2) {
        result = '🌟 High Compatibility! You seem to share many interests with our members!';
    } else if (score === 1) {
        result = '👍 Moderate Compatibility. You might find matches with similar interests!';
    } else {
        result = '💡 You have unique preferences. We have diverse members who might match with you!';
    }
    
    document.getElementById('quizResult').innerHTML = `
        <div class="alert alert-info mt-3">
            <strong>Your Compatibility Score: ${score}/3</strong><br>
            ${result}
        </div>
    `;
}

// Password visibility toggle
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}

// Password strength checker
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthDiv = document.getElementById('passwordStrength');
    
    if (strengthDiv) {
        let strength = 0;
        
        if (password.length >= 6) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        
        let strengthText = '';
        let strengthClass = '';
        
        if (password.length === 0) {
            strengthText = '';
        } else if (strength <= 2) {
            strengthText = 'Weak';
            strengthClass = 'text-danger';
        } else if (strength <= 4) {
            strengthText = 'Medium';
            strengthClass = 'text-warning';
        } else {
            strengthText = 'Strong';
            strengthClass = 'text-success';
        }
        
        strengthDiv.textContent = strengthText;
        strengthDiv.className = 'password-strength ' + strengthClass;
    }
}

// Interest selection for registration
let selectedInterests = [];

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
    
    // Update validation
    const interestsError = document.getElementById('interestsError');
    if (selectedInterests.length >= 3) {
        interestsError.style.display = 'none';
    } else {
        interestsError.style.display = 'block';
    }
}

// Gender selection
function selectGender(gender) {
    document.getElementById('gender').value = gender;
    
    // Update UI
    document.querySelectorAll('.gender-option').forEach(option => {
        option.classList.remove('selected');
    });
    document.querySelector(`.gender-option[data-gender="${gender}"]`).classList.add('selected');
}

// Photo preview
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

// Multi-step form navigation
let currentStep = 1;

function nextStep(step) {
    // Validate current step before proceeding
    if (!validateStep(currentStep)) {
        return;
    }
    
    document.getElementById(`step${currentStep}`).classList.remove('active');
    document.getElementById(`step${step}`).classList.add('active');
    
    // Update step indicators
    document.getElementById(`step${currentStep}Indicator`).classList.remove('active');
    document.getElementById(`step${step}Indicator`).classList.add('active');
    
    // Update progress bar
    const progressPercent = (step / 3) * 100;
    document.getElementById('progressBar').style.width = `${progressPercent}%`;
    
    currentStep = step;
}

function prevStep(step) {
    document.getElementById(`step${currentStep}`).classList.remove('active');
    document.getElementById(`step${step}`).classList.add('active');
    
    // Update step indicators
    document.getElementById(`step${currentStep}Indicator`).classList.remove('active');
    document.getElementById(`step${step}Indicator`).classList.add('active');
    
    // Update progress bar
    const progressPercent = (step / 3) * 100;
    document.getElementById('progressBar').style.width = `${progressPercent}%`;
    
    currentStep = step;
}

function validateStep(step) {
    let isValid = true;
    
    if (step === 1) {
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const gender = document.getElementById('gender').value;
        const birthdate = document.getElementById('birthdate').value;
        const location = document.getElementById('location').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (!firstName) isValid = false;
        if (!lastName) isValid = false;
        if (!gender) isValid = false;
        if (!birthdate) isValid = false;
        if (!location) isValid = false;
        if (!email) isValid = false;
        if (!password) isValid = false;
        if (password !== confirmPassword) isValid = false;
        
        if (!isValid) {
            showError('Please fill in all required fields correctly.');
        }
    }
    
    if (step === 3) {
        if (selectedInterests.length < 3) {
            showError('Please select at least 3 interests.');
            isValid = false;
        }
        
        const terms = document.getElementById('terms');
        if (!terms.checked) {
            showError('Please agree to the Terms of Service.');
            isValid = false;
        }
    }
    
    return isValid;
}

// Show error message
function showError(message) {
    const errorAlert = document.getElementById('errorAlert');
    const errorMessage = document.getElementById('errorMessage');
    
    if (errorAlert && errorMessage) {
        errorMessage.textContent = message;
        errorAlert.classList.remove('d-none');
        
        setTimeout(() => {
            errorAlert.classList.add('d-none');
        }, 3000);
    } else {
        alert(message);
    }
}

// Show success message
function showSuccess(message) {
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        successAlert.textContent = message;
        successAlert.classList.remove('d-none');
        
        setTimeout(() => {
            successAlert.classList.add('d-none');
        }, 3000);
    } else {
        alert(message);
    }
}

// Initialize pages on load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize browse page
    if (document.getElementById('profileCards')) {
        displayProfiles();
    }
    
    // Initialize profile page
    if (document.getElementById('profileImage') && window.location.href.includes('profile.html')) {
        loadProfileData();
    }
    
    // Initialize gender selection
    if (document.getElementById('gender')) {
        // Add click handlers for gender options if any are pre-selected
    }
    
    // Initialize password strength checker
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', checkPasswordStrength);
    }
    
    // Initialize confirm password validation
    const confirmPassword = document.getElementById('confirmPassword');
    if (confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            const password = document.getElementById('password').value;
            if (this.value !== password) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Add loading effect to buttons
    const submitBtn = document.getElementById('submitBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', function() {
            const spinner = document.getElementById('spinner');
            const submitIcon = document.getElementById('submitIcon');
            const submitText = document.getElementById('submitText');
            
            if (spinner && submitIcon && submitText) {
                spinner.classList.remove('d-none');
                submitIcon.classList.add('d-none');
                submitText.textContent = 'Creating Account...';
                
                setTimeout(() => {
                    spinner.classList.add('d-none');
                    submitIcon.classList.remove('d-none');
                    submitText.textContent = 'Create Account';
                }, 2000);
            }
        });
    }
    
    const loginBtn = document.getElementById('loginBtn');
    if (loginBtn) {
        loginBtn.addEventListener('click', function() {
            const spinner = document.getElementById('spinner');
            const loginIcon = document.getElementById('loginIcon');
            const btnText = document.getElementById('btnText');
            
            if (spinner && loginIcon && btnText) {
                spinner.classList.remove('d-none');
                loginIcon.classList.add('d-none');
                btnText.textContent = 'Logging in...';
                
                setTimeout(() => {
                    spinner.classList.add('d-none');
                    loginIcon.classList.remove('d-none');
                    btnText.textContent = 'Login';
                }, 2000);
            }
        });
    }
});