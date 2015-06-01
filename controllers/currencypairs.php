<?php

class currencypairs extends Controller {
  public $jsoninfo;
  function __construct() {
    parent::__construct();
  }
  
  public function index() {
    $this->jsoninfo = $this->model->currencypairs_generate_data();
    $this->view->render('currencypairs/index', $this->jsoninfo);
  }
}
