# Book Management System — PHP & MySQL CRUD

A simple web application that performs full **Create, Read, Update, Delete**
operations on a MySQL `books` table, using plain PHP (PDO) with a clean
Model–View–Controller layout.

## Features

- Add a new book (Create)
- View all books in a table (Read)
- Edit an existing book via a dedicated form (Update)
- Delete a book with a JavaScript confirmation prompt (Delete)
- Server-side validation of all required fields
- All database access goes through **prepared statements** (PDO)
- Model, Controller, and View files are kept separate

## Project structure

```
php-mysql-crud-lastname/
├── database.sql                 # DB + table creation script (run this first)
├── config/
│   └── database.php             # PDO connection (Model layer helper)
├── models/
│   └── Book.php                 # Book model — all SQL/prepared statements live here
├── controllers/
│   └── BookController.php       # Validates input, talks to the model
├── assets/
│   └── style.css                # Styling for the UI
├── index.php                    # View: Add-book form + list of all books (Create/Read)
├── edit.php                     # View: Edit-book form (Update)
├── delete.php                   # Handles delete requests (Delete)
└── README.md
```

## Table schema (`books`)

| Field            | Type          | Notes              |
|-------------------|--------------|--------------------|
| book_id           | INT, AUTO_INCREMENT | Primary key |
| title             | VARCHAR(150) | Required |
| author            | VARCHAR(100) | Required |
| isbn              | VARCHAR(20)  | Required |
| genre             | VARCHAR(60)  | Required |
| published_year    | YEAR         | Required |
| quantity          | INT          | Required |
| created_at        | TIMESTAMP    | Auto-set |
| updated_at        | TIMESTAMP    | Auto-updated |

## Setup instructions

1. **Create the database.**
   Import `database.sql` into MySQL:
   ```bash
   mysql -u root -p < database.sql
   ```
   (or run its contents through phpMyAdmin).

2. **Configure your credentials.**
   Open `config/database.php` and set your local MySQL username/password:
   ```php
   private string $username = "root";
   private string $password = "";
   ```
   These are **local placeholders only** — no real credentials are committed
   to this repository.

3. **Run the app.**
   Place the project folder inside your PHP server's web root (e.g. XAMPP's
   `htdocs/`, or run PHP's built-in server from the project folder):
   ```bash
   php -S localhost:8000
   ```
   Then open `http://localhost:8000/index.php` in your browser.

## Notes

- All form input is escaped with `htmlspecialchars()` before being echoed
  back into HTML, to prevent XSS.
- All SQL queries use PDO prepared statements with bound parameters, so no
  user input is ever concatenated directly into SQL.
- Deleting a record asks for confirmation via a JavaScript `confirm()`
  dialog before the request is sent.
