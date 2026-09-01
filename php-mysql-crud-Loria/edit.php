<?php
require_once __DIR__ . '/controllers/BookController.php';

$controller = new BookController();

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : 0);

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$errors = [];

// Handle "Update record" form submission (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = $controller->updateBook($id, $_POST);
    if (empty($errors)) {
        header("Location: index.php?updated=1");
        exit;
    }
    // On validation error, re-show the form with submitted values
    $book = $_POST;
    $book['book_id'] = $id;
} else {
    $book = $controller->getBook($id);
    if (!$book) {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Book - Book Management System</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">

    <a class="back-link" href="index.php">&larr; Back to all books</a>
    <h1>Edit Book</h1>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- UPDATE: Edit book form -->
    <div class="card">
        <form method="POST" action="edit.php?id=<?= (int)$id ?>">
            <input type="hidden" name="id" value="<?= (int)$id ?>">
            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title"
                           value="<?= htmlspecialchars($book['title']) ?>">
                </div>
                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" id="author" name="author"
                           value="<?= htmlspecialchars($book['author']) ?>">
                </div>
                <div class="form-group">
                    <label for="isbn">ISBN *</label>
                    <input type="text" id="isbn" name="isbn"
                           value="<?= htmlspecialchars($book['isbn']) ?>">
                </div>
                <div class="form-group">
                    <label for="genre">Genre *</label>
                    <input type="text" id="genre" name="genre"
                           value="<?= htmlspecialchars($book['genre']) ?>">
                </div>
                <div class="form-group">
                    <label for="published_year">Published Year *</label>
                    <input type="number" id="published_year" name="published_year" min="0" max="2100"
                           value="<?= htmlspecialchars($book['published_year']) ?>">
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity *</label>
                    <input type="number" id="quantity" name="quantity" min="0"
                           value="<?= htmlspecialchars($book['quantity']) ?>">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

</div>
</body>
</html>
