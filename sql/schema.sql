-- =============================================
-- Script de création de la base de données
-- Projet : Classes-PHP
-- =============================================

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS phase01_classes 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Sélection de la base
USE phase01_classes;

-- Création de la table utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;