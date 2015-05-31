<?php

class Currencypairs_Model extends Model {

  public $currencypairs = array();
  
  function __construct() {
 
    parent::__construct();
    $this->currencypairs_fetch();
  }
  
  public function currencypairs_generate_data() {
    $graph = array(
      array('Currency 1 v/s Currency 2', 'Currency 1', 'Currency 2')
    );
    $valuestoshow = 0;
    foreach($this->currencypairs as $pair => $value) {
      if($valuestoshow == PAIRSTOSHOW) {
        break;
      }
      $graph[] = array($pair, $value[1], $value[2]);
      $valuestoshow++;
    }
    
    return json_encode($graph);
  }
  
  private function currencypairs_fetch() {

    // Check in cache
    $this->currencypairs = $this->memcacheGet('currencypairs');
    if(!$this->currencypairs) {
      // Create keys for all MAXSTORE number of messages stored
      $messageConsumedKeys = array_map(function($n) { return sprintf('message_consumed_%d', $n); }, range(1, MAXSTORE));

      // Fetch all MAXSTORE items effeciently
      $messageConsumed = $this->memcacheGetMulti($messageConsumedKeys);
      
      $currency_rates = json_decode(CURRENCYRATES, 1);
      
      $this->currencypairs = array();
      foreach($messageConsumed as $k => $message) {
        $comboKey1 = $message['currencyTo'] . '-' . $message['currencyFrom'];
        $comboKey2 = $message['currencyFrom'] . '-' . $message['currencyTo'];
        $rate = (isset($currency_rates[$message['currencyFrom']])) ? $currency_rates[$message['currencyFrom']] : 1;
        $sellvalue = floor($message['amountSell']);
        $buyvalue = floor($message['amountBuy']);
        $usdvalue = floor($message['amountSell'] * $rate);
        
        if(isset($this->currencypairs[$comboKey1])) {
          $this->currencypairs[$comboKey1] += array($usdvalue, $buyvalue, $sellvalue);
        }
        else if(isset($this->currencypairs[$comboKey2])) {
          $this->currencypairs[$comboKey2] += array($usdvalue, $sellvalue, $buyvalue);
        }
        else {
          $this->currencypairs[$comboKey1] = array($usdvalue, $buyvalue, $sellvalue);
        }     
      }
      
      // Sort the arrays descending per value.
      $usdval = array();
      foreach ($this->currencypairs as $key => $row) {
        $usdval[$key] = $row[0];
      }
      array_multisort($usdval, SORT_DESC, $this->currencypairs);
      
      // Set an expiry for maximum time for stale data - STALEDATAALLOWED
      $this->memcacheSet('currencypairs', $this->currencypairs, STALEDATAALLOWED);
    }  
      
  }
  
  // Quick sort - Checking if this could be quicker - nope :)
  public function quick($valuestosort) {
    $size = count($valuestosort);
    
    if($size <= 1) {
      return $valuestosort;
    }
    
    $midelem = ceil($size/2);
    $left = $right = $eq = array();
    
    for($i = 0; $i < $size; $i ++) {
      if($valuestosort[$midelem] > $valuestosort[$i]) {
        $left[] = $valuestosort[$i];
      }
      elseif($valuestosort[$midelem] < $valuestosort[$i]) {
        $right[] = $valuestosort[$i];
      }
      else {
        $eq[] = $valuestosort[$i];      
      }
    }
    return array_merge($this->quick($left), $eq, $this->quick($right));
  }
  
}

?>
