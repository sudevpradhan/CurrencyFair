<?php

class View {
  public $data;
  function __construct() {

  }
  
  public function render($name, $data = false) {
    $this->data = $data;
    require 'views/header.php';
    require 'views/' . $name . '.php';
    require 'views/footer.php';
  }
  
}
