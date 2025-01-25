<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
</head>

<body>
  <a href="/phpmvc/home/index">Back Home</a>
  <h1>Products</h1>
  <?php foreach ($products as $product) {
    echo '<h2>' . $product['name'] . '</h2>';
    echo '<p>' . htmlspecialchars($product['description']) . '</p>';
  } ?>
</body>

</html>