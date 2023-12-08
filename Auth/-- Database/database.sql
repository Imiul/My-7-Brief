CREATE DATABASE IF NOT EXISTS My_7_Brief;
USE My_7_Brief;


-- Bank Table 6
CREATE TABLE bank (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(20) UNIQUE,
    bank_logo VARCHAR(255) -- Adjust the length as needed
);

-- Agence Table 7
CREATE TABLE agence (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bank_name VARCHAR(30),
    longitude INT,
    latitude INT,
    bank_id INT,
    FOREIGN KEY (bank_id) REFERENCES bank(id) ON DELETE CASCADE
);

-- Distributeur Table 8
CREATE TABLE distributeur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bank_id INT,
    longitude INT,
    latitude INT,
    agence_id INT,
    FOREIGN KEY (agence_id) REFERENCES agence(id) ON DELETE CASCADE,
    FOREIGN KEY (bank_id) REFERENCES bank(id) ON DELETE CASCADE
);


-- Role Table 1
CREATE TABLE role (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE
);

-- Permition Table 1
CREATE TABLE permission (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE
);

-- Permition Of Role Table 1
CREATE TABLE PermissionOfRole (
    role_id INT,
    permission_id INT,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permission(id) ON DELETE CASCADE
);

-- Address Table 2
CREATE TABLE address (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ville VARCHAR(50),
    quartier VARCHAR(50),
    rue VARCHAR(50),
    code_postal VARCHAR(10),
    email VARCHAR(50),
    telephone INT 
);

-- User Table 3
CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255), -- Adjust the length as needed
    role_id VARCHAR(20),
    address_id INT,
    agence_id INT,
    FOREIGN KEY (address_id) REFERENCES address(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES role(name) ON DELETE CASCADE,
    FOREIGN KEY (agence_id) REFERENCES agence(id) ON DELETE CASCADE
);

-- Account Table 4
CREATE TABLE account (
    id INT PRIMARY KEY AUTO_INCREMENT,
    rib VARCHAR(20),
    devise VARCHAR(10),
    balance DECIMAL(10, 2), -- Adjust precision and scale as needed
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);
-- Transaction Table 5
CREATE TABLE transaction (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('credit', 'debit'),
    amount DECIMAL(10, 2), -- Adjust precision and scale as needed
    account_id INT,
    FOREIGN KEY (account_id) REFERENCES account(id) ON DELETE CASCADE
);








