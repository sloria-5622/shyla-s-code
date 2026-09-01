<?php
/**
 * Book model
 * Handles all direct database interaction for the `books` table.
 * Every query uses a prepared statement with bound parameters.
 */

class Book
{
    private PDO $conn;
    private string $table = "books";

    // Public properties mirroring table columns
    public ?int $book_id = null;
    public string $title = "";
    public string $author = "";
    public string $isbn = "";
    public string $genre = "";
    public string $published_year = "";
    public int $quantity = 0;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    /** READ: return all books, most recently added first */
    public function getAll(): array
    {
        $query = "SELECT book_id, title, author, isbn, genre, published_year, quantity
                  FROM {$this->table}
                  ORDER BY book_id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /** READ ONE: fetch a single book by id (used to pre-fill the edit form) */
    public function getById(int $id): ?array
    {
        $query = "SELECT book_id, title, author, isbn, genre, published_year, quantity
                  FROM {$this->table}
                  WHERE book_id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** CREATE: insert a new book record */
    public function create(): bool
    {
        $query = "INSERT INTO {$this->table}
                    (title, author, isbn, genre, published_year, quantity)
                  VALUES
                    (:title, :author, :isbn, :genre, :published_year, :quantity)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":published_year", $this->published_year);
        $stmt->bindParam(":quantity", $this->quantity, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /** UPDATE: modify an existing book record */
    public function update(): bool
    {
        $query = "UPDATE {$this->table}
                  SET title = :title,
                      author = :author,
                      isbn = :isbn,
                      genre = :genre,
                      published_year = :published_year,
                      quantity = :quantity
                  WHERE book_id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":isbn", $this->isbn);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":published_year", $this->published_year);
        $stmt->bindParam(":quantity", $this->quantity, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->book_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /** DELETE: remove a book record by id */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE book_id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
