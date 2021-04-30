<?php

namespace app\controllers;

use app\Router;

class ProductController
{
    public static function index(Router $router)
    {
        $search = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);
        $router->render("products/index", [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public static function create()
    {
        echo "create page";

    }

    public static function update()
    {
        echo "update page";

    }

    public static function delete()
    {
        echo "delete page";
    }
}