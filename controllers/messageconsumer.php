<?php

class messageconsumer extends Controller {
  function __construct() {
    parent::__construct();
  }
  
  public function index() {
    
    $this->model->consume_message();
    
    $this->view->render('messageconsumer/index', "q");
  }
  
}
