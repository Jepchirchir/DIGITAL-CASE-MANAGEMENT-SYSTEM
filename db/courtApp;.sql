CREATE DATABASE courtApp;

USE courtApp;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'police', 'lawyer', 'court') NOT NULL
);


CREATE TABLE felons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    id_number VARCHAR(20) NOT NULL UNIQUE,
    marital_status ENUM('single', 'married', 'divorced', 'widowed') NOT NULL,
    next_of_kin_title VARCHAR(50) NOT NULL,
    next_of_kin_contact VARCHAR(50) NOT NULL,
    case_description VARCHAR(255) NOT NULL,
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES users(id),
    verdict VARCHAR(50) NULL
);

