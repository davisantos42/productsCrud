<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', 'Qazscde440*');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$productId = $_GET['id'];

$statement = $pdo->prepare("DELETE FROM products WHERE id=$productId");
$statement->execute();

header('Location: index.php');
