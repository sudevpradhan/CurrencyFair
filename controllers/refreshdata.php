<?php

class refreshdata extends Controller {
  public $data;
  function __construct() {
    parent::__construct();
    
  }
  
  public function index() {
    $this->data = $this->model->createStub();
    $this->view->render('refreshdata/index', $this->data);
  }
  
}
