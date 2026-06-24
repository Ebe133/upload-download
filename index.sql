-- Maak database aan
CREATE DATABASE IF NOT EXISTS upload_systeem;
USE upload_systeem;

-- Tabel voor gebruikers
CREATE TABLE IF NOT EXISTS gebruikers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gebruikersnaam VARCHAR(50) NOT NULL UNIQUE,
    wachtwoord VARCHAR(255) NOT NULL,
    registratie_datum DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel voor bestanden in database
CREATE TABLE IF NOT EXISTS bestanden (
    id INT AUTO_INCREMENT PRIMARY KEY,
    public_id VARCHAR(64) NOT NULL UNIQUE,
    naam VARCHAR(255) NOT NULL,
    type VARCHAR(100) NOT NULL,
    grootte INT NOT NULL,
    data LONGBLOB NOT NULL,
    upload_datum DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_naam (naam),
    INDEX idx_type (type),
    INDEX idx_upload_datum (upload_datum)
);

CREATE TABLE IF NOT EXISTS gebruikers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gebruikersnaam VARCHAR(50) NOT NULL UNIQUE,
    wachtwoord VARCHAR(255) NOT NULL,
    registratie_datum DATETIME DEFAULT CURRENT_TIMESTAMP
);
