<?php

namespace App\Controllers;

use Core\Viewer;

class Home
{
  public function __construct(private Viewer $viewer) {}
  public function index()
  {
    echo $this->viewer->render('shared/header', [
      'title' => 'Home',
    ]);
    echo $this->viewer->render('home/index');
  }
}
