<?php
/**
 * BookController
 * Sits between the views (UI) and the Book model.
 * Responsible for: reading input, validating it, calling the model,
 * and returning results/errors back to the view.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Book.php';

class BookController
{
    private Book $bookModel;

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->bookModel = new Book($db);
    }

    /** Return all books for the listing table */
    public function listBooks(): array
    {
        return $this->bookModel->getAll();
    }

    /** Return one book (array) for pre-filling the edit form, or null */
    public function getBook(int $id): ?array
    {
        return $this->bookModel->getById($id);
    }

    /**
     * Validate the submitted fields shared by create & update.
     * Returns an array of error messages (empty array = valid).
     */
    private function validate(array $data): array
    {
        $errors = [];

        if (empty(trim($data['title'] ?? ''))) {
            $errors[] = "Title is required.";
        }
        if (empty(trim($data['author'] ?? ''))) {
            $errors[] = "Author is required.";
        }
        if (empty(trim($data['isbn'] ?? ''))) {
            $errors[] = "ISBN is required.";
        }
        if (empty(trim($data['genre'] ?? ''))) {
            $errors[] = "Genre is required.";
        }
        if (empty($data['published_year']) || !ctype_digit((string)$data['published_year'])) {
            $errors[] = "A valid published year is required.";
        }
        if ($data['quantity'] === '' || $data['quantity'] === null || !ctype_digit((string)$data['quantity'])) {
            $errors[] = "Quantity is required and must be a whole number.";
        }

        return $errors;
    }

    /**
     * Handle the "Add record" form submission.
     * Returns an array of error messages (empty = success).
     */
    public function addBook(array $post): array
    {
        $errors = $this->validate($post);
        if (!empty($errors)) {
            return $errors;
        }

        $this->bookModel->title          = trim($post['title']);
        $this->bookModel->author         = trim($post['author']);
        $this->bookModel->isbn           = trim($post['isbn']);
        $this->bookModel->genre          = trim($post['genre']);
        $this->bookModel->published_year = trim($post['published_year']);
        $this->bookModel->quantity       = (int) $post['quantity'];

        if (!$this->bookModel->create()) {
            $errors[] = "Something went wrong while saving the book. Please try again.";
        }

        return $errors;
    }

    /**
     * Handle the "Update record" form submission.
     * Returns an array of error messages (empty = success).
     */
    public function updateBook(int $id, array $post): array
    {
        $errors = $this->validate($post);
        if (!empty($errors)) {
            return $errors;
        }

        $this->bookModel->book_id        = $id;
        $this->bookModel->title          = trim($post['title']);
        $this->bookModel->author         = trim($post['author']);
        $this->bookModel->isbn           = trim($post['isbn']);
        $this->bookModel->genre          = trim($post['genre']);
        $this->bookModel->published_year = trim($post['published_year']);
        $this->bookModel->quantity       = (int) $post['quantity'];

        if (!$this->bookModel->update()) {
            $errors[] = "Something went wrong while updating the book. Please try again.";
        }

        return $errors;
    }

    /** Handle deletion. Returns true on success. */
    public function deleteBook(int $id): bool
    {
        return $this->bookModel->delete($id);
    }
}
