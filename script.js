// PROFILE DATA WITH PHOTOS

const profiles = [
    { 
        id: 0, 
        name: "Vithujan", 
        age: 24, 
        location: "Jaffna", 
        hobbies: "Reading, Traveling, Photography", 
        profession: "Software Engineer",
        education: "B.Sc. Computer Science",
        religion: "Hindu",
        motherTongue: "Tamil",
        img: "profile1.jpeg",
        about: "I'm a passionate software engineer who loves reading books and traveling. Looking for a life partner who shares similar interests."
    },
    { 
        id: 1, 
        name: "Isuri Vimalasinghae", 
        age: 26, 
        location: "Kandy", 
        hobbies: "Music, Cooking, Yoga", 
        profession: "Doctor",
        education: "MBBS",
        religion: "Christian",
        motherTongue: "English",
        img: "profile3.jpeg",
        about: "A dedicated doctor who enjoys music and cooking. Seeking a caring and understanding partner for life."
    },
    { 
        id: 2, 
        name: "Karthihajni", 
        age: 24, 
        location: "Galle", 
        hobbies: "Hiking, Painting, Dancing", 
        profession: "Architect",
        education: "B.Arch",
        religion: "Hindu",
        motherTongue: "Tamil",
        img: "profile6.jpeg",
        about: "Creative architect who loves hiking and painting. Looking for someone who appreciates art and nature."
    },
    { 
        id: 3, 
        name: "Ruka wathina ", 
        age: 28, 
        location: "Colombo", 
        hobbies: "Swimming, Gaming, Reading", 
        profession: "Business Analyst",
        education: "MBA",
        religion: "Buddhist",
        motherTongue: "Sinhala",
        img: "profile4.jpeg",
        about: "Adventure seeker and food lover. Looking for someone to share life's beautiful moments."
    },
    { 
        id: 4, 
        name: "Sarah Wilson", 
        age: 27, 
        location: "Kandy", 
        hobbies: "Yoga, Writing, Gardening", 
        profession: "Teacher",
        education: "B.Ed",
        religion: "Christian",
        motherTongue: "English",
        img: "profile5.jpeg",
        about: "Passionate educator who believes in simple living and high thinking. Seeking an honest and kind partner."
    },
    { 
        id: 5, 
        name: "Raj Kumar", 
        age: 29, 
        location: "Jaffna", 
        hobbies: "Cricket, Music, Travel", 
        profession: "Civil Engineer",
        education: "B.E. Civil",
        religion: "Hindu",
        motherTongue: "Tamil",
        img: "profile2.jpeg",
        about: "Sports enthusiast and nature lover. Looking for a compatible life partner to build a happy future."
    }
];
// BROWSE PAGE - GENERATE CARDS


const profileCardsContainer = document.getElementById("profileCards");

if (profileCardsContainer) {
    profiles.forEach(profile => {
        const card = document.createElement("div");
        card.classList.add("col-md-6", "col-lg-4", "mb-4");

        card.innerHTML = `
            <div class="card h-100 shadow-sm">
                <img src="${profile.img}" 
                     class="card-img-top" 
                     alt="${profile.name}"
                     style="height: 250px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/400x300?text=Profile+Photo'">
                <div class="card-body">
                    <h5 class="card-title">${profile.name}</h5>
                    <p class="card-text">
                        <i class="bi bi-calendar text-primary"></i> Age: ${profile.age}<br>
                        <i class="bi bi-geo-alt text-primary"></i> ${profile.location}<br>
                        <i class="bi bi-briefcase text-primary"></i> ${profile.profession}
                    </p>
                    <a href="profile.html?id=${profile.id}" class="btn btn-primary w-100">
                        View Profile <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        `;

        profileCardsContainer.appendChild(card);
    });
}

// PROFILE PAGE - LOAD DATA

const nameElement = document.getElementById("name");

if (nameElement) {
    const params = new URLSearchParams(window.location.search);
    const id = parseInt(params.get("id")) || 0; // Default to first profile

    const profile = profiles.find(p => p.id === id) || profiles[0];

    // Update profile details
    document.getElementById("name").innerText = profile.name;
    document.getElementById("age").innerText = profile.age;
    document.getElementById("location").innerText = profile.location;
    document.getElementById("hobbies").innerText = profile.hobbies;
    
    // Update optional fields if they exist
    if (document.getElementById("profession")) {
        document.getElementById("profession").innerText = profile.profession;
    }
    if (document.getElementById("education")) {
        document.getElementById("education").innerText = profile.education;
    }
    if (document.getElementById("about")) {
        document.getElementById("about").innerText = profile.about;
    }

    const profileImage = document.getElementById("profileImage");
    if (profileImage) {
        profileImage.src = profile.img;
        profileImage.onerror = function() {
            this.src = 'https://via.placeholder.com/500x500?text=Profile+Photo';
        };
    }
}

// QUIZ FUNCTION

function calculateQuiz() {
    const q1 = parseInt(document.getElementById("q1")?.value) || 0;
    const q2 = parseInt(document.getElementById("q2")?.value) || 0;
    const q3 = parseInt(document.getElementById("q3")?.value) || 0;
    
    const score = q1 + q2 + q3;
    const result = document.getElementById("quizResult");
    
    let message = '';
    let bgClass = '';
    
    if (score >= 3) {
        message = "✨ Excellent compatibility! You're a perfect match! ✨";
        bgClass = 'bg-success text-white p-3 rounded';
    } else if (score >= 2) {
        message = "💫 Good compatibility! You can work things out! 💫";
        bgClass = 'bg-info text-white p-3 rounded';
    } else if (score >= 1) {
        message = "🌟 Moderate compatibility. Keep exploring! 🌟";
        bgClass = 'bg-warning p-3 rounded';
    } else {
        message = "💝 Low compatibility. But love can grow! 💝";
        bgClass = 'bg-secondary text-white p-3 rounded';
    }
    
    result.innerHTML = `<div class="${bgClass}">${message}</div>`;
}

// REGISTRATION FORM VALIDATION

const form = document.getElementById("registrationForm");

if (form) {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const name = document.getElementById("name")?.value.trim() || '';
        const email = document.getElementById("email")?.value.trim() || '';
        const phone = document.getElementById("phone")?.value.trim() || '';
        const message = document.getElementById("message")?.value.trim() || '';

        // Simple validation
        if (!name || !email || !message) {
            alert("Please fill in all required fields!");
            return;
        }

        if (!email.includes('@') || !email.includes('.')) {
            alert("Please enter a valid email address!");
            return;
        }

        alert("Registration Successful! 🎉 Welcome to SoulMate!");
        form.reset();
    });
}

// ================================
// AUTHENTICATION PAGES SCRIPTS
// ================================

// LOGIN PAGE FUNCTIONS

// Toggle password visibility
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput && toggleIcon) {
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
}

// Handle login form submission
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');
        const spinner = document.getElementById('spinner');
        const loginIcon = document.getElementById('loginIcon');
        const btnText = document.getElementById('btnText');
        const errorAlert = document.getElementById('errorAlert');

        // Reset previous errors
        if (errorAlert) errorAlert.classList.add('d-none');
        if (email) email.classList.remove('is-invalid');
        if (password) password.classList.remove('is-invalid');

        // Validate form
        let isValid = true;

        if (!email || !email.value || !email.value.includes('@')) {
            if (email) email.classList.add('is-invalid');
            isValid = false;
        }

        if (!password || !password.value) {
            if (password) password.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) return;

        // Show loading state
        if (loginBtn) loginBtn.disabled = true;
        if (spinner) spinner.classList.remove('d-none');
        if (loginIcon) loginIcon.classList.add('d-none');
        if (btnText) btnText.textContent = 'Signing in...';

        // Simulate login process
        setTimeout(function() {
            if (email.value && password.value) {
                // Store login state if remember me is checked
                const rememberMe = document.getElementById('rememberMe');
                if (rememberMe && rememberMe.checked) {
                    localStorage.setItem('soulmate_remember', email.value);
                }

                // Set session flag
                sessionStorage.setItem('soulmate_logged_in', 'true');
                sessionStorage.setItem('soulmate_user', email.value);

                // Redirect to browse page
                window.location.href = 'browse.html';
            } else {
                // Show error
                if (errorAlert) errorAlert.classList.remove('d-none');
                if (loginBtn) loginBtn.disabled = false;
                if (spinner) spinner.classList.add('d-none');
                if (loginIcon) loginIcon.classList.remove('d-none');
                if (btnText) btnText.textContent = 'Login';
            }
        }, 1500);
    });

    // Real-time validation removal
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const errorAlert = document.getElementById('errorAlert');

    if (emailInput) {
        emailInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            if (errorAlert) errorAlert.classList.add('d-none');
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            if (errorAlert) errorAlert.classList.add('d-none');
        });
    }
}

// Check for remembered email on login page load
if (document.getElementById('loginForm')) {
    window.addEventListener('load', function() {
        const rememberedEmail = localStorage.getItem('soulmate_remember');
        const emailInput = document.getElementById('email');
        const rememberMeCheckbox = document.getElementById('rememberMe');

        if (rememberedEmail && emailInput) {
            emailInput.value = rememberedEmail;
            if (rememberMeCheckbox) rememberMeCheckbox.checked = true;
        }
    });
}

// REGISTRATION PAGE FUNCTIONS

let currentStep = 1;
const totalSteps = 3;

function updateProgress() {
    const progressBar = document.getElementById('progressBar');
    if (progressBar) {
        const progress = (currentStep / totalSteps) * 100;
        progressBar.style.width = progress + '%';
    }

    // Update step indicators
    for (let i = 1; i <= totalSteps; i++) {
        const indicator = document.getElementById('step' + i + 'Indicator');
        if (indicator) {
            if (i < currentStep) {
                indicator.classList.remove('active');
                indicator.classList.add('completed');
                const stepNumber = indicator.querySelector('.step-number');
                if (stepNumber) stepNumber.innerHTML = '<i class="bi bi-check"></i>';
            } else if (i === currentStep) {
                indicator.classList.add('active');
                indicator.classList.remove('completed');
                const stepNumber = indicator.querySelector('.step-number');
                if (stepNumber) stepNumber.textContent = i;
            } else {
                indicator.classList.remove('active', 'completed');
                const stepNumber = indicator.querySelector('.step-number');
                if (stepNumber) stepNumber.textContent = i;
            }
        }
    }
}

function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
    // Show current step
    const currentStepElement = document.getElementById('step' + step);
    if (currentStepElement) currentStepElement.classList.add('active');
    currentStep = step;
    updateProgress();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep(step) {
    if (validateStep(currentStep)) {
        showStep(step);
    }
}

function prevStep(step) {
    showStep(step);
}

function validateStep(step) {
    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) errorAlert.classList.add('d-none');

    let isValid = true;

    if (step === 1) {
        // Validate Step 1
        const requiredFields = ['firstName', 'lastName', 'email', 'password', 'confirmPassword', 'birthdate', 'location'];

        requiredFields.forEach(field => {
            const element = document.getElementById(field);
            if (element) {
                if (!element.value.trim()) {
                    element.classList.add('is-invalid');
                    isValid = false;
                } else {
                    element.classList.remove('is-invalid');
                }
            }
        });

        // Validate gender
        const genderInput = document.getElementById('gender');
        if (genderInput && !genderInput.value) {
            const genderSelect = document.querySelector('.gender-select');
            if (genderSelect) genderSelect.classList.add('is-invalid');
            isValid = false;
        }

        // Validate email format
        const email = document.getElementById('email');
        if (email && email.value && !email.value.includes('@')) {
            email.classList.add('is-invalid');
            isValid = false;
        }

        // Validate password match
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        if (password && confirmPassword && password.value !== confirmPassword.value) {
            confirmPassword.classList.add('is-invalid');
            isValid = false;
        }

        // Validate password length
        if (password && password.value.length < 6) {
            password.classList.add('is-invalid');
            isValid = false;
        }
    }

    if (!isValid && errorAlert) {
        errorAlert.classList.remove('d-none');
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) errorMessage.textContent = 'Please fill in all required fields correctly';
    }

    return isValid;
}

function selectGender(gender) {
    document.querySelectorAll('.gender-option').forEach(opt => opt.classList.remove('selected'));
    const selectedOption = document.querySelector('[data-gender="' + gender + '"]');
    if (selectedOption) selectedOption.classList.add('selected');
    const genderInput = document.getElementById('gender');
    if (genderInput) genderInput.value = gender;
}

function checkPasswordStrength() {
    const password = document.getElementById('password');
    const strengthBar = document.getElementById('passwordStrength');

    if (!password || !strengthBar) return;

    const value = password.value;
    let strength = 0;

    if (value.length >= 6) strength++;
    if (value.length >= 10) strength++;
    if (/[A-Z]/.test(value)) strength++;
    if (/[0-9]/.test(value)) strength++;
    if (/[^A-Za-z0-9]/.test(value)) strength++;

    strengthBar.className = 'password-strength';
    if (strength <= 2) {
        strengthBar.classList.add('weak');
    } else if (strength <= 4) {
        strengthBar.classList.add('medium');
    } else {
        strengthBar.classList.add('strong');
    }
}

function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewImage = document.getElementById('previewImage');
            const photoUpload = document.getElementById('photoUpload');
            if (previewImage) previewImage.src = e.target.result;
            if (photoUpload) photoUpload.classList.add('has-image');
        };
        reader.readAsDataURL(file);
    }
}

function toggleInterest(element) {
    if (element) {
        element.classList.toggle('selected');
        updateSelectedInterests();
    }
}

function updateSelectedInterests() {
    const selected = [];
    document.querySelectorAll('.interest-tag.selected').forEach(tag => {
        selected.push(tag.textContent);
    });
    const selectedInterestsInput = document.getElementById('selectedInterests');
    if (selectedInterestsInput) selectedInterestsInput.value = selected.join(',');
}

// Handle registration form submission
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const errorAlert = document.getElementById('errorAlert');
        const submitBtn = document.getElementById('submitBtn');
        const spinner = document.getElementById('spinner');
        const submitIcon = document.getElementById('submitIcon');
        const submitText = document.getElementById('submitText');

        if (errorAlert) errorAlert.classList.add('d-none');

        // Validate interests
        const selectedInterests = document.querySelectorAll('.interest-tag.selected');
        const interestsError = document.getElementById('interestsError');
        if (selectedInterests.length < 3) {
            if (interestsError) interestsError.style.display = 'block';
            return;
        }
        if (interestsError) interestsError.style.display = 'none';

        // Validate terms
        const termsCheckbox = document.getElementById('terms');
        if (termsCheckbox && !termsCheckbox.checked) {
            termsCheckbox.classList.add('is-invalid');
            return;
        }

        // Show loading
        if (submitBtn) submitBtn.disabled = true;
        if (spinner) spinner.classList.remove('d-none');
        if (submitIcon) submitIcon.classList.add('d-none');
        if (submitText) submitText.textContent = 'Creating Account...';

        // Simulate registration
        setTimeout(function() {
            // Store user data
            const userData = {
                firstName: document.getElementById('firstName')?.value || '',
                lastName: document.getElementById('lastName')?.value || '',
                email: document.getElementById('email')?.value || '',
                gender: document.getElementById('gender')?.value || '',
                birthdate: document.getElementById('birthdate')?.value || '',
                location: document.getElementById('location')?.value || '',
                occupation: document.getElementById('occupation')?.value || '',
                education: document.getElementById('education')?.value || '',
                religion: document.getElementById('religion')?.value || '',
                bio: document.getElementById('bio')?.value || '',
                lookingFor: document.getElementById('lookingFor')?.value || '',
                interests: document.getElementById('selectedInterests')?.value || '',
                photo: document.getElementById('previewImage')?.src || ''
            };

            sessionStorage.setItem('soulmate_user_data', JSON.stringify(userData));
            sessionStorage.setItem('soulmate_logged_in', 'true');
            sessionStorage.setItem('soulmate_user', userData.email);

            // Redirect to browse page
            window.location.href = 'browse.html';
        }, 2000);
    });

    // Real-time validation removal
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorAlert = document.getElementById('errorAlert');
            if (errorAlert) errorAlert.classList.add('d-none');
        });
    });
}
