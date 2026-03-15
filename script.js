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