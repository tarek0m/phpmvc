<?php

namespace App\Models;

use PDO;

class Product
{
  public function getData(): array
  {
    $dns = 'mysql:host=localhost;dbname=product_db;charset=utf8';
    $pdo = new PDO(
      $dns,
      'product_db_user',
      'secret',
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]
    );

    $stmt = $pdo->query('SELECT * FROM product');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $products;
  }
}
