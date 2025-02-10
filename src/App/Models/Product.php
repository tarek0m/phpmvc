<?php

namespace App\Models;

use App\Database;
use PDO;

class Product
{
  public function __construct(private Database $db) {}
  public function getData(): array
  {
    $pdo = $this->db->getConnection();
    $stmt = $pdo->query('SELECT * FROM product');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $products;
  }
}
