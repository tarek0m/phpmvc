<?php

namespace App;

use PDO;

class Database
{
  public function getConnection(): PDO
  {
    $dns = 'mysql:host=localhost;dbname=product_db;charset=utf8';
    return new PDO(
      $dns,
      'product_db_user',
      'secret',
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ]
    );
  }
}
