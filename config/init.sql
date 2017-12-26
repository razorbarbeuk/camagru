CREATE DATABASE Camagru_bdd;

USE Camagru_bdd;

CREATE TABLE users(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    confirmed_token VARCHAR(255),
    confirmed_at DATETIME
);