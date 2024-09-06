CREATE DATABASE IF NOT EXISTS lost_found;

USE lost_found;

-- Create the users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Create the lost_items table
CREATE TABLE IF NOT EXISTS lost_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    date_lost DATE NOT NULL,
    location_lost VARCHAR(100),
    image_path VARCHAR(255),
    status ENUM('reported', 'found', 'claimed') DEFAULT 'reported',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the found_items table
CREATE TABLE IF NOT EXISTS found_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    item_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    date_found DATE NOT NULL,
    location_found VARCHAR(100),
    image_path VARCHAR(255),
    status ENUM('reported', 'matched', 'claimed') DEFAULT 'reported',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create the matches table
CREATE TABLE IF NOT EXISTS matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lost_item_id INT,
    found_item_id INT,
    match_date DATE NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (lost_item_id) REFERENCES lost_items(id),
    FOREIGN KEY (found_item_id) REFERENCES found_items(id)
);
