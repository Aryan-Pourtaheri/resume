# PHP Quiz Application

A web-based quiz management system built with PHP and MySQL, supporting both student and teacher roles. This project allows teachers to create and manage exams and questions, while students can take exams and view their results.

---

## Features

- **User Authentication:** Login, registration, and password reset for users.
- **Role-Based Access:** Separate dashboards and features for students and teachers.
- **Exam Management:** Teachers can create, edit, and assign exams to classes.
- **Question Management:** Teachers can add, edit, and delete questions for each exam.
- **Student Interface:** Students can take assigned exams and view their scores.
- **Class & Department Management:** Organize users and exams by class and department.
- **Responsive Design:** Modern UI for both desktop and mobile.

---

## Folder Structure

```
quiz.sql
quiz-app/
  connection.php           # Database connection settings
  assets/
    css/                   # Stylesheets (e.g., demo.css)
    img/                   # Images (avatars, backgrounds, icons, etc.)
    js/                    # JavaScript files (main.js, config.js, etc.)
    vendor/                # Third-party libraries and fonts
  auth/
    auth-login.php         # Login page
    auth-register.php      # Registration page
    auth-forgot-password.php
    reset-password.php
  students/
    components/            # Student dashboard components
    fonts/
    html/
    js/
    libs/
    scss/
    tasks/
  teacher/
    components/            # Teacher dashboard components
    fonts/
    html/
    js/
    libs/
    scss/
    tasks/
```

---

## Database

The application uses a MySQL database. The schema and sample data are provided in [`quiz.sql`](quiz.sql):

- **Tables:** `users`, `roles`, `permissions`, `role_permissions`, `students`, `teachers`, `classes`, `departments`, `exams`, `questions`, `user_exams`
- **Relationships:** Foreign keys enforce links between users, roles, classes, exams, and questions.

To set up the database:

1. Create a database named `quiz`.
2. Import the [`quiz.sql`](quiz.sql) file using phpMyAdmin or the MySQL CLI.

---

## Setup & Usage

1. **Clone or copy the repository.**
2. **Import the database** using the provided [`quiz.sql`](quiz.sql) file.
3. **Configure database connection** in [`quiz-app/connection.php`](quiz-app/connection.php) with your MySQL credentials.
4. **Run the application** on a local or remote PHP server (e.g., XAMPP, WAMP, MAMP, or LAMP).
5. **Access the app** via your browser at `http://localhost/path-to-project/quiz-app/auth/auth-login.php`.

---

## Requirements

- PHP 7.4 or higher
- MySQL/MariaDB
- Web server (Apache, Nginx, etc.)

---

## Customization

- **Add new features** by extending the PHP files in `students/` and `teacher/`.
- **Change styles** in `assets/css/` or the SCSS files in `students/scss/` and `teacher/scss/`.
- **Update database structure** by modifying [`quiz.sql`](quiz.sql) and syncing changes with your MySQL server.

---

## License

This project is for educational purposes only.
