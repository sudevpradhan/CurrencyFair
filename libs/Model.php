<?php

class Model {
  public $mem;
  
  function __construct() {
    $this->mem = new Memcached();
    $this->mem->addServer("127.0.0.1", 11211);
  }
  
  protected function memcacheGet($key) {
    return $this->mem->get($key);
  }
  
  protected function memcacheSet($key, $value, $expiry = 0) {
    return $this->mem->set($key, $value, $expiry);
  }
  
  protected function memcacheGetMulti($keys) {
    $items = $this->mem->getMulti($keys, $cas);
    return $items;
  }
}
