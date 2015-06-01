<?php
/**
 * Main file to load MVC.
 */
class Bootstrap {
  function __construct() {
    
    $path = isset($_GET['url']) ? $_GET['url'] : null;
    $url = explode('/', rtrim($path, '/'));
    
    $controller_name = $url[0];
    if($path === null) {
      $controller_name = 'mosttraded';
    }
    
    $file = 'controllers/'. $controller_name . '.php';
    
    if(!file_exists($file)) {
      throw new Exception("The file $file does not exist.");
    }
    
    // If memcache is not there in the server use flat file to store.
    if(!class_exists('Memcached')){
      require 'Memcache.php';
    }
    
    require $file;
    $controller = new $controller_name();
    
    $controller->loadModel($controller_name);
    
    $controller->index();
    
    if(isset($url[1])) {
      if(method_exists($controller, $url[1])) {
        $arg1 = (isset($url[2])) ? $url[2] : false;
        $controller->{$url[1]}($arg1);
      }
      else {
        throw new Exception("The file $file does not exist.");
      }
    }
  }
}

