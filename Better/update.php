<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', 'Qazscde440*');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare("SELECT * FROM products WHERE id= :id");
$statement->bindValue(':id', $id);
$statement->execute();

$product = $statement->fetch(PDO::FETCH_ASSOC);

function randomStr($n)
{
    $characters = 'abcdefghijklmnopqrstuvwxzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $string = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $string .= $characters[$index];
    }
    return $string;
}

$errors = [];
$title = $product['title'];
$description = $product['description'];
$price = $product['price'];
$folderName = '';
$imageName = '';
$imagePath = '';
$folderName = randomStr(8);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!$title) {
        $errors[] = "Product title is required";
    }

    if (!$price) {
        $errors[] = "Product price is required";
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {
        $image = $_FILES['image']; // always true
        $imageName = $_FILES['image']['name'];
        $setImage = $product['image'] ?? null;

        if ($setImage && $imageName) {
            unlink($product['image']);
        }

        if ($imageName) {
            mkdir("./images/$folderName");
            move_uploaded_file($image['tmp_name'], "./images/$folderName/$imageName");
            $imagePath = "./images/$folderName/$imageName";
        } else {
            $imagePath = $setImage;
        }

        $statement = $pdo->prepare("UPDATE products
        SET title = :title, image = :image, description = :description, price = :price WHERE id = :id");

        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':id', $id);

        $statement->execute();

        header('Location: index.php');
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- My own app.css file -->
    <link rel="stylesheet" href="app.css">

    <title>Products CRUD</title>
</head>

<body>
    <p>
        <a class="btn btn-outline-info" href="./index.php">Go back to Products</a>
    </p>

    <h1>Update Product <strong><?php echo $product['title']; ?></strong></h1>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
        <div><?php echo $error ?></div>
        <?php endforeach;?>
        <?php endif;?>
    </div>
    <form action="" method="post" enctype="multipart/form-data">

        <?php if ($product['image']): ?>
        <img class="update-image" src="<?php echo $product['image'] ?>" alt="">
        <?php endif?>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <br> <input type="file" name="image">
        </div>
        <div class="mb-3">
            <label class="form-label">Product Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Product Description</label>
            <textarea class="form-control" name="description"><?php echo $description; ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Product Price</label>
            <input type="number" step=".01" class="form-control" name="price" value="<?php echo $price; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</body>

</html>