CREATE DATABASE IF NOT EXISTS event_management;

USE event_management;

CREATE TABLE Roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name ENUM('ADMIN', 'USER') DEFAULT 'USER'
);

CREATE TABLE User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    phone VARCHAR(255),
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    role INT,
    FOREIGN KEY (role) REFERENCES Roles(id)
);

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
    creatorId INT,
    FOREIGN KEY (creatorId) REFERENCES User(id)
);

CREATE TABLE Attendee (
    id INT AUTO_INCREMENT PRIMARY KEY,
    eventId INT NOT NULL,
    userId INT NOT NULL,
    FOREIGN KEY (eventId) REFERENCES Event(id),
    FOREIGN KEY (userId) REFERENCES User(id),
    UNIQUE (eventId, userId)
);

-- dev seeders

-- create the user roles
INSERT INTO Roles (name) VALUES ('ADMIN'), ('USER');

-- create an admin user
-- admin plain text password : admin123
INSERT INTO User (
    email,
    password,
    name,
    phone,
    role,
    createdAt,
    updatedAt
) 
VALUES (
    'admin@app.com', 
    '$argon2i$v=19$m=65536,t=4,p=1$b3haMERBb3hLcUhFWlJqUQ$JzDdnjAaUqsrYzXDSluCH8U0fpkZTunwngg9xXuM7ds',
    'Test Admin', 
    '1234567890',
    1,
    NOW(), 
    NOW()
);

-- create a general user
-- user plain text password : test123
INSERT INTO User (
    email, 
    password, 
    name, 
    phone,
    role, 
    createdAt, 
    updatedAt
) 
VALUES (
    'user@app.com', 
    '$argon2i$v=19$m=65536,t=4,p=1$eHEyVm9MWm0vNXptWFkwWQ$+54+Soi/FnJGZdsq0v/Pv3anj0Q2TV7YhJfBX9WrcSA', 
    'Test User', 
    '0987654321',
    2,
    NOW(), 
    NOW()
);


-- create an event
INSERT INTO Event (title, description, startDate, endDate, location, capacity, createdAt, updatedAt, creatorId) 
VALUES ('Test Event', 'This is a test event', '2023-01-01 10:00:00', '2023-01-01 12:00:00', 'Test Location', 10, NOW(), NOW(), 1);

-- create an attendee
INSERT INTO Attendee (eventId, userId) 
VALUES (1, 2);
