CREATE DATABASE apartman_aidat_sistemi;

USE apartman_aidat_sistemi;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(10) NOT NULL,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE aidatlar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount FLOAT NOT NULL,
    due_date DATE NOT NULL,
    status VARCHAR(10) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);