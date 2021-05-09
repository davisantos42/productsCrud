<?php

namespace app\models;

use app\Database;
use app\helpers\UtilHelper;

class Product {
    public  ? int $id             = null;
    public  ? string $title       = null;
    public  ? string $description = null;
    public  ? float $price        = null;
    public  ? string $imagePath   = null;
    public  ? array $imageFile    = null;
    public  ? string $imageName   = null;

    public function load($data) {
        $this->id          = $data['id'] ?? null;
        $this->title       = $data['title'];
        $this->description = $data['description'] ?? '';
        $this->price       = $data['price'];
        $this->imagePath   = $data['image'] ?? null;
        $this->imageFile   = $data['imageFile'] ?? null;
        $this->imageName   = $this->imageFile['name'] ?? null;
    }

    public function save() {
        $errors = [];
        if (!$this->title) {
            $errors[] = "Product title is required";
        }
        if (!$this->price) {
            $errors[] = "Product price is required";
        }

        if (!is_dir(__DIR__ . '/../public/images')) {
            mkdir(__DIR__ . '/../public/images');
        }

        $setImage = $this->imagePath ?? null;

        if ($this->imageFile && $setImage) {
            unlink(__DIR__ . "/../public/" . $this->imagePath);
        }

        if ($this->imageFile) {
            $folderName = UtilHelper::randomStr(8);
            mkdir(__DIR__ . "/../public/images/" . $folderName);
            move_uploaded_file($this->imageFile['tmp_name'], __DIR__ . "/../public/images/" . $folderName . "/$this->imageName");
            $this->imagePath = "images/" . $folderName . "/$this->imageName";
        } else {
            $this->imagePath = $setImage;
        }

        $db = Database::$db;

        if ($this->id) {
            $db->updateProduct($this);
        } else {
            $db->createProduct($this);
        }

        return $errors;

    }
}