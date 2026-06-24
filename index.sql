-- Maak database aan
CREATE DATABASE IF NOT EXISTS upload_systeem;
USE upload_systeem;

-- Tabel voor bestanden in database
CREATE TABLE bestanden (
    id INT AUTO_INCREMENT PRIMARY KEY,
    public_id VARCHAR(64) NOT NULL UNIQUE,
    naam VARCHAR(255) NOT NULL,
    type VARCHAR(100) NOT NULL,
    grootte INT NOT NULL,
    data LONGBLOB NOT NULL,
    upload_datum DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Index voor snellere zoekopdrachten
CREATE INDEX idx_naam ON bestanden(naam);
CREATE INDEX idx_type ON bestanden(type);
CREATE INDEX idx_upload_datum ON bestanden(upload_datum);
