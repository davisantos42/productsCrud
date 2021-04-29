<?php

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];

if (!$title) {
    $errors[] = "Product title is required";
}

if (!$price) {
    $errors[] = "Product price is required";
}

if (!is_dir(__DIR__ . '/public/images')) {
    mkdir(__DIR__ . '/public/images');
}

$image = $_FILES['image']; // always true
$imageName = $_FILES['image']['name'];
$setImage = $product['image'] ?? null;

if ($imageName && $setImage) {
    unlink(__DIR__ . "/public/" . $product['image']);
}

if ($imageName) {
    mkdir(__DIR__ . "/public/images/$folderName");
    move_uploaded_file($image['tmp_name'], __DIR__ . "/public/images/$folderName/$imageName");
    $imagePath = "images/$folderName/$imageName";
} else {
    $imagePath = $setImage;
}