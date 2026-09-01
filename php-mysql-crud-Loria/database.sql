-- ============================================================
-- Book Management System - Database Setup
-- ============================================================
-- Run this file first (e.g. via phpMyAdmin, or:
--   mysql -u root -p < database.sql
-- ) to create the database and table used by the application.
-- ============================================================

CREATE DATABASE IF NOT EXISTS book_management_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE book_management_db;

CREATE TABLE IF NOT EXISTS books (
    book_id         INT AUTO_INCREMENT PRIMARY KEY,
    title           VARCHAR(150)  NOT NULL,
    author          VARCHAR(100)  NOT NULL,
    isbn            VARCHAR(20)   NOT NULL,
    genre           VARCHAR(60)   NOT NULL,
    published_year  YEAR          NOT NULL,
    quantity        INT           NOT NULL DEFAULT 1,
    created_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Sample data (optional - remove if you want to start empty)
INSERT INTO books (title, author, isbn, genre, published_year, quantity) VALUES
('The Hobbit', 'J.R.R. Tolkien', '9780547928227', 'Fantasy', 1937, 4),
('Clean Code', 'Robert C. Martin', '9780132350884', 'Programming', 2008, 6),
('1984', 'George Orwell', '9780451524935', 'Dystopian', 1949, 3);
