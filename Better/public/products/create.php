<?php
/** @var $pdo \PDO */
require_once "../../database.php";
require_once "../../functions.php";

$errors = [];
$title = '';
$description = '';
$price = '';
$folderName = '';
$imageName = '';
$imagePath = '';
$folderName = randomStr(8);

$product = [
    "image" => "",
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "../../validate.php";

    if (empty($errors)) {

        $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
        VALUES (:title, :image, :description, :price, :date )");

        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));

        $statement->execute();

        header('Location: index.php');
    }
}
?>

<?php include_once "../../views/partials/header.php"?>

<body>
    <h1>Create new Product</h1>
    <p>
        <a class="btn btn-outline-info" href="./index.php">Go back to Products</a>
    </p>

    <?php include_once "../../views/products/form.php"?>

</body>

</html>