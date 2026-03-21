-- SoulMate Matrimony Database Schema
-- Database Name: soulmate_db

-- Drop existing database if exists and create fresh
DROP DATABASE IF EXISTS soulmate_db;
CREATE DATABASE soulmate_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE soulmate_db;

-- Users table with secure password storage
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    birthdate DATE NOT NULL,
    location VARCHAR(50) NOT NULL,
    occupation VARCHAR(100),
    education VARCHAR(50),
    religion VARCHAR(50),
    bio TEXT,
    looking_for ENUM('male', 'female', 'both', 'other'),
    interests TEXT,
    profile_image VARCHAR(255),
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
) ENGINE=InnoDB;

-- Contact messages table
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Interests lookup table
CREATE TABLE interests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    icon VARCHAR(10),
    category VARCHAR(30)
) ENGINE=InnoDB;

-- Insert sample interests
INSERT INTO interests (name, icon, category) VALUES
('Music', '🎵', 'Entertainment'),
('Movies', '🎬', 'Entertainment'),
('Reading', '📚', 'Intellectual'),
('Travel', '✈️', 'Lifestyle'),
('Cooking', '🍳', 'Lifestyle'),
('Fitness', '🏃', 'Health'),
('Gaming', '🎮', 'Entertainment'),
('Art', '🎨', 'Creative'),
('Photography', '📷', 'Creative'),
('Nature', '🌱', 'Lifestyle'),
('Animals', '🐾', 'Lifestyle'),
('Coffee', '☕', 'Lifestyle');

-- Sample users (password for all: 'password')
-- Password hash generated with: password_hash('password', PASSWORD_DEFAULT)
INSERT INTO users (first_name, last_name, email, password_hash, gender, birthdate, location, occupation, education, bio, looking_for, interests, is_verified) VALUES
('Vithujan', 'Kumar', 'vithujan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male', '2000-05-15', 'Jaffna', 'Software Engineer', 'B.Sc. Computer Science', 'Passionate software engineer who loves reading and traveling.', 'female', 'Reading,Travel,Coding', TRUE),
('Amara', 'Silva', 'amara@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'female', '2001-03-20', 'Colombo', 'Doctor', 'MBBS', 'Caring doctor who loves music and dancing.', 'male', 'Music,Dancing,Travel', TRUE),
('Kamal', 'Perera', 'kamal@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male', '1998-08-10', 'Kandy', 'Teacher', 'B.Ed.', 'Passionate about education and nature.', 'female', 'Reading,Gardening,Nature', TRUE),
('Priya', 'Fernando', 'priya@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'female', '1999-12-25', 'Galle', 'Architect', 'B.Arch', 'Creative architect who loves designing beautiful spaces.', 'male', 'Art,Photography,Travel', TRUE),
('Rajan', 'Sivakumar', 'rajan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'male', '1997-07-15', 'Jaffna', 'Business Owner', 'MBA', 'Entrepreneur looking for a life partner to share dreams.', 'female', 'Business,Travel,Fitness', TRUE);