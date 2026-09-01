<?php
require_once __DIR__ . '/controllers/BookController.php';

$controller = new BookController();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    $controller->deleteBook($id);
    header("Location: index.php?deleted=1");
    exit;
}

header("Location: index.php");
exit;
