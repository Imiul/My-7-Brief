CREATE DATABASE IF NOT EXISTS My_7_Brief;
USE My_7_Brief;


-- Bank Table 6
CREATE TABLE bank (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(20) UNIQUE,
    bank_logo VARCHAR(255),
    softDelete TIMESTAMP NULL
);

-- Agence Table 7
CREATE TABLE agence (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bank_name VARCHAR(30),
    longitude INT,
    latitude INT,
    bank_id INT,
    FOREIGN KEY (bank_id) REFERENCES bank(id) ON DELETE CASCADE,
    softDelete TIMESTAMP NULL
);

-- Distributeur Table 8
CREATE TABLE distributeur (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bank_id INT,
    longitude INT,
    latitude INT,
    agence_id INT,
    FOREIGN KEY (agence_id) REFERENCES agence(id) ON DELETE CASCADE,
    FOREIGN KEY (bank_id) REFERENCES bank(id) ON DELETE CASCADE,
    softDelete TIMESTAMP NULL
);


-- Role Table 1
CREATE TABLE role (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE,
    softDelete TIMESTAMP NULL
);

-- Permition Table 1
CREATE TABLE permission (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE,
    softDelete TIMESTAMP NULL
);

-- Permition Of Role Table 1
CREATE TABLE PermissionOfRole (
    role_id INT,
    permission_id INT,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permission(id) ON DELETE CASCADE,
    softDelete TIMESTAMP NULL
);

-- Address Table 2
CREATE TABLE address (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ville VARCHAR(50),
    quartier VARCHAR(50),
    rue VARCHAR(50),
    code_postal VARCHAR(10),
    email VARCHAR(50),
    telephone INT,
    softDelete TIMESTAMP NULL
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
    FOREIGN KEY (role_id) REFERENCES role(name) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (agence_id) REFERENCES agence(id) ON DELETE CASCADE,
    softDelete TIMESTAMP NULL
);

-- Account Table 4
CREATE TABLE account (
    id INT PRIMARY KEY AUTO_INCREMENT,
    rib VARCHAR(20),
    devise VARCHAR(10),
    balance DECIMAL(10, 2), -- Adjust precision and scale as needed
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    softDelete TIMESTAMP NULL
);
-- Transaction Table 5
CREATE TABLE transaction (
    id INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('credit', 'debit'),
    amount DECIMAL(10, 2), -- Adjust precision and scale as needed
    account_id INT,
    FOREIGN KEY (account_id) REFERENCES account(id) ON DELETE CASCADE ,
    softDelete TIMESTAMP NULL
);







INSERT INTO `permission` (`name`)
VALUES 
  ('access_all'), ('data_analytics'), ('add_bank'), ('update_bank'), ('delete_bank'), 
  ('see_bank'), ('add_agence'), ('update_agence'), ('delete_agence'), ('see_agence'), 
  ('add_atm'), ('update_atm'), ('delete_atm'), ('see_atm'), ('add_permission'), 
  ('update_permission'), ('delete_permission'), ('see_permission'), ('add_role'), 
  ('update_role'), ('delete_role'), ('see_role'), ('add_address'), ('update_address'), 
  ('delete_address'), ('see_address'), ('add_user'), ('update_user'), ('delete_user'), 
  ('see_user'), ('add_account'), ('update_account'), ('delete_account'), 
  ('see_account'), ('add_transaction'), ('update_transaction'), ('delete_transaction'), 
  ('see_transaction'), ('user');

INSERT INTO `role` (`name`)
VALUES 
  ('ADMIN'), ('SUB_ADMIN'), ('USER'), ('ANALYTICS');

INSERT INTO `permissionofrole` (`role_id`, `permission_id`)
VALUES 
  (1, 1), (2, 6), (2, 10), (2, 14), (2, 18), (2, 22), (2, 26), (2, 30), 
  (2, 34), (2, 38), (3, 39), (4, 2);

INSERT INTO `address` (`ville`, `quartier`, `rue`, `code_postal`, `email`, `telephone`) 
VALUES 
  ('Safi', 'Sania', '13', '28200', 'amine@gmail.com', '0674859612');

INSERT INTO `bank` (`name`, `bank_logo`)
VALUES 
  ('Cih Bank', 'cih-img.svg');

INSERT INTO `agence` (`bank_name`, `longitude`, `latitude`, `bank_id`)
VALUES 
  ('Agence Safi', '154786', '152365', 1);

