CREATE DATABASE IF NOT EXISTS addressdb;
USE mysql;

DELETE FROM user WHERE User='addressadmin';
INSERT INTO user (Host, User, Password, Select_priv, Insert_priv, ssl_cipher, x509_issuer, x509_subject) VALUES ('localhost', 'addressadmin', PASSWORD('password'), 'Y', 'Y', 'NULL', 'NULL', 'NULL');
FLUSH PRIVILEGES;
GRANT SELECT,INSERT,DELETE,UPDATE ON addressdb.* TO addressadmin@localhost;

USE addressdb;
DROP TABLE IF EXISTS contact;

CREATE TABLE contact (
PRIMARY KEY (`last_name`, `first_name`, `middle_initial`),
UNIQUE (`last_name`, `first_name`, `middle_initial`),
last_name VARCHAR(30) NOT NULL,
first_name VARCHAR(30) NOT NULL,
middle_initial CHAR,
phone_number VARCHAR(20),
address VARCHAR(255),
apt VARCHAR(20),
town VARCHAR(35),
state CHAR(2),
zipcode CHAR(5),
zipext CHAR(4)
);

