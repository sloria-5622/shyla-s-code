<?php
/**
 * Database configuration and connection.
 *
 * IMPORTANT: This file uses placeholder/local-dev credentials only.
 * Do NOT commit real production credentials to a public repository.
 * For a real deployment, load these values from environment
 * variables instead, e.g.:
 *   getenv('DB_HOST') ?: 'localhost'
 */

class Database
{
    private string $host = "localhost";
    private string $db_name = "book_management_db";
    private string $username = "root";
    private string $password = "";   // set your local MySQL password here (not committed)
    public ?PDO $conn = null;

    public function getConnection(): PDO
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }

        return $this->conn;
    }
}
