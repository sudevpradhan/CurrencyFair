<?php

class Messageconsumer_Model extends Model {

  function __construct() {
    parent::__construct();
  }
  
  public function consume_message() {
    if(!isset($_POST['refreshkey']) || $_POST['refreshkey'] != REFRESH_KEY) {
      die ("Incorrect refresh key or refresh key missing!");
    }
    if(isset($_POST['honeypot']) && strlen($_POST['honeypot']) > 0) {
      die ("This could be spam.");
    }
    if(!isset($_POST['json'])) {
      die("you need to Post Json. This is a message consumer endpoint.");
    }
    
    $json = $_POST['json'];

    $postVals = json_decode($json, 1);

    if(json_last_error() != JSON_ERROR_NONE) {
      die('Error in JSON');
    }

    // Make sure only MAXSTORE items are Stored in memcache.
    // if it exceeds MAXSTORE them overqrite older values.
    $countStored = $this->memcacheGet('stored_' . MAXSTORE);
    if($countStored > MAXSTORE - 1 || !$countStored) {
      $countStored = 0;
    }
    $countStored++;
    $this->memcacheSet('stored_' . MAXSTORE, $countStored);

    $key = 'message_consumed_' . $countStored;
    $this->memcacheSet($key, $postVals) or die("Couldn't save anything to memcache...");
    
    $er = $this->memcacheGet($key);
  }
  
}
?>
