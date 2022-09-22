<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=product_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


$errors = [];

$title ='';
$price = '';
$description = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$date = date('Y-m-d H:i:s');



if (!$title) {
    $errors[] = "Product is required";
}
if (!$price) {
    $errors[] = "Product price is required";
}

if(!is_dir('images')) {
  mkdir('images');
}

if (empty($errors)) {
     $image = $_FILES['image'] ?? null;
     $imagePath = '';
     if ($image && $image['tmp_name']) {
      $imagePath = 'images/'.randomString(8).'/'.$image['name'];
      mkdir(dirname($imagePath));

      move_uploaded_file($image['tmp_name'], $imagePath);
     }
     


      $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                VALUES (:title, :image, :description, :price, :date)");
      $statement->bindvalue(':title', $title);
      $statement->bindvalue(':image', $imagePath);
      $statement->bindvalue(':description', $description);
      $statement->bindvalue(':price', $price);
      $statement->bindvalue(':date', $date);
      $statement->execute();
      header('Location: index.php');
    }
}

function randomString($n)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwzyzABCDEFGHIJKLOMNPQRSTUVWXYZ';
  $str ='';
  for ($i = 0; $i < $n; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $str .= $characters[$index];
  }

  return $str;
}


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
<h2>Create new Product</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
         <?php foreach ($errors as $errors): ?>
             <div><?php echo $errors ?></div>
       <?php endforeach; ?>
   </div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label>Product Image</label>
    <br>
    <input type="file" name="image">
  </div>
  <div class="form-group">
    <label>Product Title</label>
    <input type="text" name="title" class="form-control" value="<?php echo $title?> ">
  </div>
  <div class="form-group">
    <label>Product Description</label>
    <input type="text" class="form-control" name="description"><?php echo $description ?>
  </div>
  <div class="form-group">
    <label>Product Price</label>
    <input type="number" step=".01" name="price" value="<?php echo $price ?>" class="form-control">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>


</body>


 
</table>
</html>