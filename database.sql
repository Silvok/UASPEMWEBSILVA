-- Membuat database
CREATE DATABASE medical_equipment_db;

-- Gunakan database
USE medical_equipment_db;

-- Membuat tabel users dengan field tambahan
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    department VARCHAR(50) NOT NULL,
    role ENUM('admin', 'staff', 'technician') NOT NULL,
    join_date DATE NOT NULL
);

-- Membuat tabel medical_equipment
CREATE TABLE medical_equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    manufacturer VARCHAR(100) NOT NULL,
    purchase_date DATE NOT NULL,
    warranty_expiry DATE NOT NULL,
    maintenance_status ENUM('operational', 'maintenance', 'retired') NOT NULL,
    location VARCHAR(100) NOT NULL,
    last_inspection_date DATE NOT NULL,
    notes TEXT
);