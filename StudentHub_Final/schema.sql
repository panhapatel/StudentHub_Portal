-- StudentHub database schema (MySQL / MariaDB)
CREATE DATABASE IF NOT EXISTS studenthub CHARACTER SET utf8mb4;
USE studenthub;

CREATE TABLE IF NOT EXISTS students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    gender     VARCHAR(10)  NOT NULL,
    mobile     VARCHAR(15)  NOT NULL,
    course     VARCHAR(20)  NOT NULL,
    year       VARCHAR(1)   NOT NULL,
    semester   VARCHAR(1)   NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    username       VARCHAR(100) NOT NULL,
    email          VARCHAR(150) NOT NULL UNIQUE,
    password       VARCHAR(255) NOT NULL,
    role           VARCHAR(20)  NOT NULL DEFAULT 'student',
    remember_token VARCHAR(64)  NULL,   -- sha256 hash of the cookie token
    token_expiry   DATETIME     NULL
);

CREATE TABLE IF NOT EXISTS student_profiles (
    user_id        INT PRIMARY KEY,
    enrollment     VARCHAR(30)  NOT NULL,
    dob            DATE         NULL,
    gender         VARCHAR(10)  NULL,
    department     VARCHAR(100) NULL,
    course         VARCHAR(20)  NULL,
    semester       VARCHAR(20)  NULL,
    cgpa           DECIMAL(4,2) NULL,
    mobile         VARCHAR(15)  NULL,
    college_email  VARCHAR(150) NULL,
    personal_email VARCHAR(150) NULL,
    address        TEXT         NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS registrations (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    student_id        INT  NOT NULL,
    event_id          INT  NOT NULL,
    registration_date DATE NOT NULL,
    UNIQUE (student_id, event_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL,
    subject    VARCHAR(200) NOT NULL,
    message    TEXT         NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
