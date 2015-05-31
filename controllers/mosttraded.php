<?php

class mosttraded extends Controller {
  public $jsoninfo;
  function __construct() {
    parent::__construct();
  }
  
  public function index() {
    $this->jsoninfo = $this->model->mosttraded_generate_data();
    $this->view->render('mosttraded/index', $this->jsoninfo);
  }
}
