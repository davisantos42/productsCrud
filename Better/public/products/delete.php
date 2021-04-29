<?php
/** @var $pdo \PDO */
require_once "../../database.php";

$productId = $_POST['id'] ?? null;

if (!$productId) {
    header('Location: index.php');
}

$statement = $pdo->prepare("DELETE FROM products WHERE id = :id");
$statement->bindValue(':id', $productId);

$statement->execute();

header('Location: index.php');