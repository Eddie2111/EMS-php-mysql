## Event Management System Documentation

### Objective

The goal of this project is to develop a simple, web-based event management system that allows users to create, manage, and view events, as well as register attendees and generate event reports.

## Project Overview

### Features

- **User Authentication**:
  - Users can register and log in securely.
  - Passwords are hashed for security.
  
- **Event Management**:
  - Users can create, update, view, and delete events.
  - Events include details such as name, description, start date, end date, location, and capacity.
  
- **Attendee Registration**:
  - Users can register for events.
  - Registration is limited to the event's capacity.
  
- **Event Dashboard**:
  - Events are displayed in a paginated, sortable, and filterable format.
  
- **Event Reports**:
  - Admins can download attendee lists for specific events in CSV format.

### Technologies Used

- **Backend**:
  - Pure PHP
  - Custom JWT module
  - Custom QueryBuilder module
  
- **Database**:
  - MySQL
  
- **Frontend**:
  - Bootstrap for responsive UI
  
- **Authentication**:
  - Custom auth guard with HTTPOnly and Secure cookies
  
- **Docker**:
  - Docker Compose for Apache-PHP and MySQL

- **Architecture**:
  - Repository pattern

### Setup Instructions

#### Prerequisites

- **Docker** installed on your machine.
- **Docker Compose** installed on your machine.

#### Steps to Set Up

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/Eddie2111/EMS-php-mysql.git
   cd event-management-system
   ```

2. **Build Docker Containers**:
   ```bash
   docker-compose up --build
   ```

3. **Set Up Environment Variables**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Edit the `.env` file to set environment variables such as database credentials, JWT secret, etc.

4. **Initialize the Database**:
   - Access the MySQL container:
     ```bash
     docker exec -it event-management-system_db_1 bash
     ```
   - Run the SQL scripts to initialize the database:
     ```bash
     mysql -u root -p < /path/to/your/database/schema.sql
     ```

5. **Run Migrations**:
   - Access the PHP container:
     ```bash
     docker exec -it event-management-system_app_1 bash
     ```

6. **Start the Application**:
   - The application should now be accessible at `http://localhost:8080`.

### Login Credentials

- **Admin User**:
  - Username: `admin@app.com`
  - Password: `admin123`
  
- **Regular User**:
  - Username: `test@app.com`
  - Password: `test123`

### Project Structure

- **Root Directory**:
  - Contains `docker-compose.yml`, `README.md`, and other top-level files.
  
- **Common Directory**:
  - Contains shared components, guards, and utilities.
  
- **Components Directory**:
  - Contains UI components like forms, navigation bars, etc.
  
- **Controllers Directory**:
  - Contains PHP controllers for handling business logic.
  
- **Models Directory**:
  - Contains PHP models representing database tables.
  
- **Views Directory**:
  - Contains PHP views for rendering HTML templates.

### Code Quality and Best Practices

- **Code Structure**:
  - Follow PSR-12 coding standards.
  - Use meaningful variable and function names.
  
- **Security**:
  - Use prepared statements to prevent SQL injection.
  - Hash passwords using bcrypt.
  - Use HTTPOnly and Secure cookies for session management.
  
- **Validation**:
  - Perform client-side and server-side validation.
  - Use regular expressions for input validation.

### Future Improvements

- **Search Functionality**:
  - Implement search across events and attendees.
  
- **Enhanced UX**:
  - Use AJAX for dynamic content loading.
  - Improve the user interface with more responsive designs.

### Conclusion

This Event Management System provides a robust platform for managing events and attendees. The system is built using pure PHP, MySQL, and Docker for a scalable and secure solution. The documentation provided here should help you set up and run the project successfully.