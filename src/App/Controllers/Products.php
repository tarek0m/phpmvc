<?php

namespace App\Controllers;

use App\Models\Product;

class Products
{
  public function index()
  {
    require 'views/products_index.php';
  }

  public function view()
  {
    require 'src/App/Models/Product.php';
    $model = new Product;
    $products = $model->getData();
    require 'views/products_view.php';
  }
}
