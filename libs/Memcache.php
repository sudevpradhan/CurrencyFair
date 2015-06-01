<?php
/**
 * @file: Mock memcache functionality if memcache does not exist.
 */

class Memcached {
  public $filebasepath;
  function __construct() {
    $this->filebasepath = 'models/data/cache/';
  }
  
  public function get($key) {
    $filepath = $this->filebasepath . $key . '.txt';
    
    $jsoncontents = file_get_contents($filepath, FILE_USE_INCLUDE_PATH);
    
    // If file has an expiry header set.
    if (strpos($jsoncontents, ':EXPIRYFLATFILEHEADER') !== false) {
      // If file has expired then delete it and return false.
      if((filemtime($filepath) + STALEDATAALLOWED) <= time() ) {
        unlink($filepath);
        return false;
      }
      // If it is still not stale - continue.
      $contentsarr = explode(':EXPIRYFLATFILEHEADER', $jsoncontents);
      $jsoncontents = $contentsarr[1];
    }
    
    $contents = json_decode($jsoncontents, 1);
    return $contents;
  }
  
  public function set($key, $value, $expiry = 0) {
    $expiry = ($expiry > 0) ? ($expiry + time()) . ':EXPIRYFLATFILEHEADER' : '';
    $store_val = $expiry . json_encode($value);
    $filename = $this->filebasepath . $key . ".txt";
    file_put_contents($filename, $store_val);
    chmod($filename, fileperms($filename) | 128 + 16 + 2);
    return true;
  }
  
  public function getMulti($keys) {
    $contents = array();
    foreach($keys as $key) {
      $contents[] = $this->get($key);
    } 
    return $contents;
  }
  
  public function addServer($a, $b) {
    return true;
  }
}
