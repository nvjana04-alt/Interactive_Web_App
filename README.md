#  SoulMate Matrimony

A beautiful and modern matrimonial website built with PHP, MySQL, and Bootstrap. Find your perfect match with verified profiles, smart matching, and privacy protection.

![SoulMate Logo](images/logo.png)

##  Features

-  **User Authentication** - Secure login and registration system
-  **User Profiles** - Create detailed profiles with photos, interests, and preferences
-  **Browse Profiles** - Discover verified members and find your perfect match
-  **Verified Profiles** - All profiles are manually verified for safety
-  **Smart Matching** - Advanced algorithm to find compatible matches
-  **Privacy Protected** - Your data is encrypted and secure
-  **Responsive Design** - Works perfectly on desktop, tablet, and mobile
-  **Beautiful UI** - Modern gradient design with smooth animations

## 🛠️ Tech Stack

- **Backend:** PHP 7.4+
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework:** Bootstrap 5.3
- **Icons:** Bootstrap Icons

##  Project Structure

```
soulmate-matrimony/
├── auth/
│   ├── login.php          # User login page
│   ├── register.php       # Multi-step registration
│   └── logout.php         # Logout handler
├── includes/
│   ├── db.php             # Database configuration
│   └── functions.php      # Helper functions
├── css/
│   └── style.css          # Custom styles
├── images/
│   ├── logo.png           # Site logo
│   ├── hero-wedding.jpeg  # Hero carousel images
│   ├── hero-couple2.jpg
│   ├── hero-couple3.jpg
│   └── profile1-6.jpeg    # Sample profile images
├── uploads/
│   └── profiles/          # User uploaded profile photos
├── index.php              # Homepage
├── dashboard.php          # User dashboard
├── browse.php             # Browse profiles
├── profile.php            # View individual profile
├── contact.php            # Contact form
└── database.sql           # Database schema
```

##  Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Step 1: Clone or Download

```bash
git clone https://github.com/yourusername/soulmate-matrimony.git
```

Or download and extract the ZIP file to your web server directory.

### Step 2: Create Database

1. Open phpMyAdmin or MySQL command line
2. Create a new database named `soulmate_db`
3. Import the `database.sql` file:

```bash
mysql -u root -p soulmate_db < database.sql
```

### Step 3: Configure Database

Edit `includes/db.php` with your database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'soulmate_db');
```

### Step 4: Set Permissions

Ensure the uploads directory is writable:

```bash
chmod -R 755 uploads/
```

### Step 5: Access Website

Open your browser and navigate to:

```
http://localhost/Interactive_Web_App/intex.php

```

##  Database Schema

### Users Table
- `id` - Primary key
- `first_name`, `last_name` - User name
- `email` - Unique email address
- `password_hash` - Encrypted password
- `gender`, `birthdate` - Personal info
- `location`, `occupation`, `education` - Profile details
- `religion`, `bio`, `looking_for` - Preferences
- `interests` - Comma-separated interests
- `profile_image` - Profile photo path
- `is_verified` - Verification status
- `created_at`, `last_login` - Timestamps

### Contact Messages Table
- `id` - Primary key
- `name`, `email`, `phone` - Contact info
- `message` - Message content
- `created_at` - Timestamp

##  Color Scheme

| Color | Hex Code | Usage |
|-------|----------|-------|
| Primary Purple | `#5b4dcc` | Navbar, buttons |
| Secondary Purple | `#7c6af0` | Gradients, hover states |
| Accent Pink | `#ff6b9d` | Heart icon, highlights |
| Dark Background | `#1a1a2e` | Welcome section, footer |
| Light Background | `#f8f9fa` | Features section |

##  Security Features

- **Password Hashing** - Uses `password_hash()` with bcrypt
- **CSRF Protection** - Token-based CSRF prevention
- **SQL Injection Prevention** - PDO prepared statements
- **XSS Protection** - Output escaping with `htmlspecialchars()`
- **Input Sanitization** - All user inputs are sanitized

##  Responsive Breakpoints

- **Desktop:** 992px and above
- **Tablet:** 768px - 991px
- **Mobile:** Below 768px

##  Key Pages

### Homepage (index.php)
- Hero carousel with wedding imagery
- Welcome section with call-to-action buttons
- Feature highlights

### Login (auth/login.php)
- Email/password authentication
- "Remember me" option
- Password visibility toggle

### Register (auth/register.php)
- 3-step registration process:
  1. Basic Information (name, gender, birthdate, location, email, password)
  2. Profile Details (photo, occupation, education, religion, bio)
  3. Interests Selection

### Dashboard (dashboard.php)
- User profile summary
- Quick action buttons
- Profile statistics

### Browse (browse.php)
- Grid view of all profiles
- Profile cards with photo, age, location
- "View Profile" links

### Profile (profile.php)
- Full profile details
- Send interest button
- Back to browse link

### Contact (contact.php)
- Contact form with validation
- Contact information cards

##  Troubleshooting

### Database Connection Error
- Check `includes/db.php` credentials
- Ensure MySQL service is running
- Verify database exists

### Upload Issues
- Check `uploads/profiles/` directory permissions
- Ensure PHP `file_uploads` is enabled
- Check `upload_max_filesize` in php.ini

### Session Issues
- Ensure `session_start()` is working
- Check PHP session save path permissions

##  Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

##  License

This project is licensed under the MIT License.

##  Credits

- Bootstrap 5 - Frontend framework
- Bootstrap Icons - Icon library
- Images generated with AI

##  Contact

For support or inquiries:
- Email: support@soulmate.com
- Location: Jaffna, Sri Lanka

---

Made with 💕 in Sri Lanka | &copy; 2026 SoulMate Matrimony
