-- Create and use database
CREATE DATABASE IF NOT EXISTS event_management;
USE event_management;

-- Drop tables if they exist
DROP TABLE IF EXISTS Attendee;
DROP TABLE IF EXISTS Event;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Role;

-- Create Role Table (needs to be first as User depends on it)
CREATE TABLE Role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);

-- Create User Table
CREATE TABLE User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    phone VARCHAR(20),
    roleId INT NOT NULL,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (roleId) REFERENCES Role(id)
);

-- Create Event Table
CREATE TABLE Event (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    startDate DATETIME NOT NULL,
    endDate DATETIME NOT NULL,
    location VARCHAR(255),
    capacity INT,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    creatorId INT NOT NULL,
    FOREIGN KEY (creatorId) REFERENCES User(id)
);

-- Create Attendee Table
CREATE TABLE Attendee (
    id INT AUTO_INCREMENT PRIMARY KEY,
    eventId INT NOT NULL,
    userId INT NOT NULL,
    registeredAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (eventId) REFERENCES Event(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES User(id) ON DELETE CASCADE,
    UNIQUE (eventId, userId)
);

-- Insert initial roles
INSERT INTO Role (name) VALUES 
    ('ADMIN'),
    ('USER');

-- seeder

-- Insert admin user
-- Password: admin123
INSERT INTO User (
    email,
    password,
    name,
    phone,
    roleId
) VALUES (
    'admin@app.com',
    '$argon2i$v=19$m=65536,t=4,p=1$b3haMERBb3hLcUhFWlJqUQ$JzDdnjAaUqsrYzXDSluCH8U0fpkZTunwngg9xXuM7ds',
    'Test Admin',
    '1234567890',
    1  -- ADMIN role
);

-- Insert test user
-- Password: test123
INSERT INTO User (
    email,
    password,
    name,
    phone,
    roleId
) VALUES (
    'user@app.com',
    '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA',
    'Test User',
    '0987654321',
    2  -- USER role
);

-- Insert test event
INSERT INTO Event (
    title,
    description,
    startDate,
    endDate,
    location,
    capacity,
    creatorId
) VALUES (
    'Test Event',
    'This is a test event',
    '2024-02-01 10:00:00',
    '2024-02-01 12:00:00',
    'Test Location',
    10,
    1  -- Created by admin
);

-- Insert test attendee
INSERT INTO Attendee (eventId, userId)
VALUES (1, 2);  -- User attending admin's event

-- end