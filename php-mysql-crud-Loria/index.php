<?php
require_once __DIR__ . '/controllers/BookController.php';

$controller = new BookController();

$errors = [];
$success = "";

// Handle "Add record" form submission (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $errors = $controller->addBook($_POST);
    if (empty($errors)) {
        // Prevent form resubmission on refresh
        header("Location: index.php?added=1");
        exit;
    }
}

if (isset($_GET['added'])) {
    $success = "Book added successfully.";
}
if (isset($_GET['updated'])) {
    $success = "Book updated successfully.";
}
if (isset($_GET['deleted'])) {
    $success = "Book deleted successfully.";
}

// Read: fetch all books for the table
$books = $controller->listBooks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Management System</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">

    <h1>📚 Book Management System</h1>
    <p class="subtitle">A simple PHP &amp; MySQL CRUD application</p>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <!-- CREATE: Add new book form -->
    <div class="card">
        <h2>Add a New Book</h2>
        <form method="POST" action="index.php">
            <input type="hidden" name="action" value="add">
            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title"
                           value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" id="author" name="author"
                           value="<?= htmlspecialchars($_POST['author'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN *</label>
                    <input type="text" id="isbn" name="isbn"
                           value="<?= htmlspecialchars($_POST['isbn'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="genre">Genre *</label>
                    <input type="text" id="genre" name="genre"
                           value="<?= htmlspecialchars($_POST['genre'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="published_year">Published Year *</label>
                    <input type="number" id="published_year" name="published_year" min="0" max="2100"
                           value="<?= htmlspecialchars($_POST['published_year'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity *</label>
                    <input type="number" id="quantity" name="quantity" min="0"
                           value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Add Book</button>
        </form>
    </div>

    <!-- READ: Books table -->
    <div class="card">
        <h2>All Books</h2>
        <?php if (empty($books)): ?>
            <p class="empty-state">No books found. Add one using the form above.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Genre</th>
                        <th>Year</th>
                        <th>Qty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= (int)$book['book_id'] ?></td>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['isbn']) ?></td>
                        <td><?= htmlspecialchars($book['genre']) ?></td>
                        <td><?= htmlspecialchars($book['published_year']) ?></td>
                        <td><?= (int)$book['quantity'] ?></td>
                        <td class="actions">
                            <a class="btn btn-edit" href="edit.php?id=<?= (int)$book['book_id'] ?>">Edit</a>
                            <a class="btn btn-delete"
                               href="delete.php?id=<?= (int)$book['book_id'] ?>"
                               onclick="return confirm('Are you sure you want to delete \'<?= htmlspecialchars(addslashes($book['title'])) ?>\'? This cannot be undone.');">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
