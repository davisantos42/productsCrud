<?php

namespace app\controllers;

use app\models\Product;
use app\Router;

define("HOME", 'Location: /products');

class ProductController {

    public static function index(Router $router) {
        $search   = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);
        $router->render("products/index", [
            'products' => $products,
            'search'   => $search,
        ]);
    }

    public static function create(Router $router) {
        $errors = [];

        $productData = [
            'title'       => '',
            'description' => '',
            'image'       => '',
            'price'       => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $productData['title']       = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['imageFile']   = $_FILES['image'] ?? null;
            $productData['price']       = (float) $_POST['price'];

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();

            if (empty($errors)) {

                header(HOME);
                exit;
            }
        }

        $router->render("products/create", [
            'product' => $productData,
            'errors'  => $errors,
        ]);
    }

    public static function update(Router $router) {
        $errors = [];
        $id     = $_GET['id'] ?? null;

        if (!$id) {
            header(HOME);
            exit;
        }

        $productData = $router->db->getProductById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_FILES['image']['name']) {
                $productData['imageFile'] = $_FILES['image'];
            }
            $productData['image']       = $productData[0]['image'];
            $productData['id']          = $id;
            $productData['title']       = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price']       = (float) $_POST['price'];

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();

            if (empty($errors)) {

                header(HOME);
                exit;
            }
        }

        $router->render("products/update", [
            'product' => $productData[0],
            'errors'  => $errors,
        ]);
    }

    public static function delete(Router $router) {

        $productId = $_POST['id'] ?? null;

        if (!$productId) {
            header(HOME);
            exit;
        }

        $router->db->deleteProduct($productId);

        header(HOME);

    }
}