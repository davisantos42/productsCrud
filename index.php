<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', 'Qazscde440*');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>Products CRUD</h1>

    <p><a href="create.php" class="btn btn-success">Create product</a></p>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Created date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $i => $product) : ?>
                <tr>
                    <th scope="row"><?php echo $i + 1; ?></th>
                    <td><img class="thumb-image" src="<?php echo $product['image']; ?>" alt=""></td>
                    <td><?php echo $product['title']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['create_date']; ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
                        <a href="delete.php" type="button" class="btn btn-sm btn-outline-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>