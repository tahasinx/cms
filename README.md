> ⚠️ **Note:** This project was built as an early exploration when I began coding in 2016. It does not represent my current development standards or best practices. Please review the code with that historical context in mind.


# Clinic Management System (CMS)

## Overview

The Clinic Management System (CMS) is a web-based application designed to streamline the operations of a clinic or hospital. It provides modules for managing doctors, clients (patients), appointments, departments, events, lab requests, notifications, and more. The system supports multiple user roles: Admin, Doctor, and Client, each with their own dashboards and functionalities.

---

## Features

- **User Authentication**: Separate login portals for Admin, Doctor, and Client.
- **Role-Based Dashboards**: Each user type has a dedicated dashboard with relevant features.
- **Doctor Management**: Add, update, and manage doctor profiles, schedules, and certifications.
- **Client Management**: Register, update, and manage client profiles and appointment history.
- **Appointment Scheduling**: Book, approve, and manage appointments between clients and doctors.
- **Department Management**: Create and manage medical departments.
- **Event Management**: Add and list clinic events.
- **Lab Requests**: Request and manage lab tests and drug requests.
- **Chat System**: Internal chat between users.
- **Notifications**: System notifications for various actions.
- **Feedback & Ratings**: Clients can rate doctors and provide feedback.

---

## Database Structure

The database schema is defined in `cms.sql`. Key tables include:

- **admin**: Stores admin user details.
- **doctors**: Stores doctor profiles, credentials, and schedules.
- **clients**: Stores client (patient) profiles and credentials.
- **appointment**: Manages appointment details and statuses.
- **department**: Medical departments.
- **events**: Clinic events.
- **lab-requests**: Lab and drug requests.
- **chats** & **chat_rooms**: Messaging system.
- **notifications**: System notifications.
- **feedback**, **rating**: Client feedback and ratings for doctors.
- **schedule**: Doctor schedules.

> **Note:** All tables use InnoDB and utf8 encoding. See `cms.sql` for full schema and sample data.

---

## Code Structure

- `index.php`: Redirects to the main landing page (`home/index.php`).
- `home/`: Public landing pages, about, contact, events, and assets.
- `dashboard/`: Contains dashboards for Admin, Doctors, and Clients, each with their own classes, assets, and parts.
- `login/`: Authentication portals for each user type.
- `registration/`: Client registration module.
- `database/`: Database connection scripts.
- `mailer/`: Email sending functionality using PHPMailer.
- `cms.sql`: Database schema and sample data.

---

## Security Notes

- **Authentication**: Session-based authentication for all user types. Each dashboard checks for valid session variables.
- **Password Storage**: Passwords are currently stored in plaintext in the database. **It is strongly recommended to use password hashing (e.g., bcrypt) in production.**
- **SQL Injection**: SQL queries are constructed using string interpolation, which is vulnerable to SQL injection. **Prepared statements should be used for all database queries.**
- **File Uploads**: Profile pictures and certificates are uploaded to the server. Ensure proper file validation and permissions in production.
- **Session Security**: Sessions are used for authentication. Consider regenerating session IDs and using secure cookies in production.

---

## Setup Instructions

### Prerequisites
- PHP 7.0 or higher
- MySQL/MariaDB
- Web server (e.g., Apache, XAMPP, WAMP)

### Installation Steps

1. **Clone or Download the Project**
   - Place the project files in your web server's root directory (e.g., `htdocs` for XAMPP).

2. **Database Setup**
   - Create a database named `cms` in your MySQL/MariaDB server.
   - Import the `cms.sql` file to create tables and insert sample data:
     ```
     mysql -u root -p cms < cms.sql
     ```

3. **Configure Database Connection**
   - The database connection settings are in `database/Connect.php` and `database/connection.php`:
     - Default: `localhost`, user: `root`, password: ``, database: `cms`
   - Update these files if your database credentials are different.

4. **Set File Permissions**
   - Ensure the `gallery/` and its subfolders are writable for file uploads (profile pictures, certificates, etc.).

5. **Access the Application**
   - Open your browser and go to `http://localhost/cms/` (or your configured local domain).
   - The main landing page is at `home/index.php`.
   - Use the login portals for Admin, Doctor, or Client to access respective dashboards.

6. **Email Functionality (Optional)**
   - Configure SMTP settings in `mailer/index.php` if you want to enable email notifications.
   - The project uses PHPMailer for sending emails.

---

## Default Admin Credentials (Sample Data)
- **Username:** admin
- **Password:** 123456

> **Change the default credentials after first login for security.**

---

## Recommendations for Production
- Use strong, unique passwords and enable password hashing.
- Refactor SQL queries to use prepared statements.
- Set proper file and directory permissions.
- Use HTTPS for secure communication.
- Regularly update dependencies and libraries.

---

## License
This project is for educational purposes. For production use, review and enhance security, privacy, and compliance as needed. 