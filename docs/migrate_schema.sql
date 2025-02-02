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

-- Seeder

-- Insert admin user (already provided)
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

-- Insert test user (already provided)
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

-- Insert 10 additional users
INSERT INTO User (
    email,
    password,
    name,
    phone,
    roleId
) VALUES
    ('user1@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 1', '1112223333', 2),
    ('user2@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 2', '2223334444', 2),
    ('user3@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 3', '3334445555', 2),
    ('user4@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 4', '4445556666', 2),
    ('user5@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 5', '5556667777', 2),
    ('user6@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 6', '6667778888', 2),
    ('user7@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 7', '7778889999', 2),
    ('user8@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 8', '8889990000', 2),
    ('user9@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 9', '9990001111', 2),
    ('user10@app.com', '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 'User 10', '0001112222', 2);

-- Insert 5 additional events
INSERT INTO Event (
    title,
    description,
    startDate,
    endDate,
    location,
    capacity,
    creatorId
) VALUES
    ('Event 1', 'Description for Event 1', '2024-03-01 10:00:00', '2024-03-01 12:00:00', 'Location 1', 20, 1),
    ('Event 2', 'Description for Event 2', '2024-03-02 10:00:00', '2024-03-02 12:00:00', 'Location 2', 20, 1),
    ('Event 3', 'Description for Event 3', '2024-03-03 10:00:00', '2024-03-03 12:00:00', 'Location 3', 20, 1),
    ('Event 4', 'Description for Event 4', '2024-03-04 10:00:00', '2024-03-04 12:00:00', 'Location 4', 20, 1),
    ('Event 5', 'Description for Event 5', '2024-03-05 10:00:00', '2024-03-05 12:00:00', 'Location 5', 20, 1);

-- Insert 6 attendees on the first event
INSERT INTO Attendee (eventId, userId)
VALUES (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7);

-- end