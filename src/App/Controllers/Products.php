<?php

namespace App\Controllers;

use App\Models\Product;
use Core\Viewer;

class Products
{
  public function __construct(private Viewer $viewer, private Product $model) {}
  public function index()
  {
    echo $this->viewer->render('shared/header', [
      'title' => 'Products Index',
    ]);
    echo $this->viewer->render('Products/index');
  }

  public function view()
  {
    $products = $this->model->getData();

    echo $this->viewer->render('shared/header', [
      'title' => 'Products',
    ]);
    echo $this->viewer->render('Products/view', [
      'products' => $products
    ]);
  }

  public function showPage(string $title, int $id, int $page)
  {
    echo "Title: $title<br>";
    echo "ID: $id<br>";
    echo "Page: $page<br>";
  }
}
