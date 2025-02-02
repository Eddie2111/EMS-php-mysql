## Event Management System Documentation

### Objective

The goal of this project was to develop a simple, web-based event management system that allows users to create, manage, and view events, as well as register attendees and generate event reports. The app was named "EventFlow".

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
  - Registration for event is taken care by API call.
- **Event Dashboard**:

  - Events are displayed in a paginated, sortable, and filterable format.
- **Event Reports**:

  - Admins can download attendee lists for specific events in CSV format by calling the API.
  - Admins can check how many users signed up for an event.

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

Note: More documentation of the project is placed at ``/docs``, check it out for more available documents.

### Live Demo

- A Live demo has been setup by the help of [InfinityFree]()
- **Project URL**: → [Go to EventFlow](https://asm-ems.ct.ws/)

### Setup Instructions

#### Prerequisites

- **Docker** installed on your machine.
- **Docker Compose** installed on your machine.

#### Steps to Set Up

1. **Clone the Repository**:

   ```bash
   git clone https://github.com/Eddie2111/EMS-php-mysql.git
   cd EMS-php-mysql
   ```
2. **Set Up Environment Variables**:

   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Edit the `.env` file to set environment variables such as database credentials, JWT secret, etc.
   - If no ``.env`` file, please do create one inside your ``/app`` folder
3. **Run Setup Installer**:

   - Run the setup installer to create and setup the system with database and server:
     ```bash
     start ./run_install.sh
     ```

### Login Credentials

- **Admin User**:

  - Username: `admin@app.com`
  - Password: `admin123`
- **Regular User**:

  - Username: `user@app.com`
  - Password: `test123`
- **Caveat**:

  - There are multiple users in the database, you can use any of them to login.
  - The user password is the same but the email goes on ``user[0-9]@app.com``

### Project Structure

- **Root Directory**:

  - Used repository pattern to isolate the features as much as possible.
  - Contains `docker-compose.yml`, `README.md`, and other top-level files.
- **Common Directory**:

  - Contains shared UI components, guards, utilities, queryBuilder and static assets.
- **Services Directory**:

  - Contains UI components like forms, action logics, scripts, styles for each of the features.
- **API Directory**:

  - Contains API and the respective controllers and helpers

### Code Quality and Best Practices

- **Code Structure**:

  - Follow PSR-12 coding standards.
  - Use meaningful variable and function names.
- **Security**:

  - Use prepared statements to prevent SQL injection.
  - Hash passwords using bcrypt.
  - Use HTTPOnly and Secure cookies for session management.
  - Used Base64 to replicate the functionalities of Jsonwebtoken
  - Created a query builder from scratch to abstract the sql's.
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

This Event Management System provides a robust platform for managing events and attendees. The system is built using pure PHP, MySQL, and Docker for a scalable and secure solution. The documentation provided here should help you set up and run the project successfully. But if there is any issue, please contact me at tarek42223@gmail.com
