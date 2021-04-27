<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', 'Qazscde440*');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




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
$title = '';
$description = '';
$price = '';
$folderName = '';
$imageName = '';

$folderName = randomStr(5);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');

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
        $image = $_FILES['image'] ?? null;
        $imageName = $_FILES['image']['name'];

        if ($image) {
            mkdir("./images/$folderName");
            move_uploaded_file($image['tmp_name'], "./images/$folderName/$imageName");
        }

        $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
        VALUES (:title, :image, :description, :price, :date )");

        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', "./images/$folderName/$imageName");
        $statement->bindValue(':price', $price);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':date', $date);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <!-- My own app.css file -->
    <link rel="stylesheet" href="app.css">

    <title>Products CRUD</title>
</head>

<body>
    <h1>Create new Product</h1>
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) : ?>
                <div><?php echo $error ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
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