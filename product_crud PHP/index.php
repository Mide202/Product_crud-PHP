<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=product_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

$statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>  


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="app.css">
    <title>Products CRUD</title>
</head>
<body>
    <h2 class="text-danger">Products CRUD</h2>

    <p>
      <a href="create.php" class="btn btn-success">Create Product</a>
    </p>


</body>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Create</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($products as $i => $product ): ?>
    <tr>
        <th scope="row"><?php echo $i + 1 ?></th>
        <td>
          <img src="<?php echo $product['image'] ?>" class="thumb-image">
        </td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo $product['price'] ?></td>
        <td><?php echo $product['create_date'] ?></td>
        <td>

        <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</button>
        <form style="display:inline-block" method="post" action="delete.php">
        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
        <button  type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
    </td>


        
    </tr>

  <?php endforeach; ?>
  </tbody>
</table>
</html>