<?php

class Mosttraded_Model extends Model {

  public $mostTradedVal;
  
  function __construct() {
 
    parent::__construct();
    $this->mosttraded();
  }
  
  public function mosttraded_generate_data() {
  
    $rows = array();
    $table = array();
    $table['cols'] = array(
      // Labels for chart, these represent the column titles
      // One column is "string" and another one is in "number" format
      // pie chart only required "numbers" for calculating percentage 
      // string will be used for the column title.
      array('label' => 'Currency', 'type' => 'string'),
      array('label' => 'Percentage', 'type' => 'number')

    );
    
    $rows = array();
    foreach($this->mostTradedVal as $country => $totalTraded) {
        $temp = array();
        if(!isset($totalTraded)) continue;
        // Slice the Pie chart.
        $temp[] = array('v' => (string) $country ); 

        // Values of each slice of the chart.
        $temp[] = array('v' => (int) $totalTraded); 
        $rows[] = array('c' => $temp);
    }
    $table['rows'] = $rows;
    return json_encode($table);
  }
  
  private function mosttraded() {
    // Check in cache
    $this->mostTradedVal = $this->memcacheGet('most_traded');
    if(!$this->mostTradedVal) {
      // Create keys for all MAXSTORE number of messages stored
      $messageConsumedKeys = array_map(function($n) { return sprintf('message_consumed_%d', $n); }, range(1, MAXSTORE));

      // Fetch all MAXSTORE items effeciently
      $messageConsumed = $this->memcacheGetMulti($messageConsumedKeys);
      
      $currency_rates = json_decode(CURRENCYRATES, 1);
      $this->mostTradedVal = array();
      foreach($messageConsumed as $k => $message) {
        
        // Get a rate as per USD to make the graph in 1 standard currency - USD
        $rate = (isset($currency_rates[$message['currencyFrom']])) ? $currency_rates[$message['currencyFrom']] : 1;
        if(isset($this->mostTradedVal[$message['currencyFrom']])) {
          $this->mostTradedVal[$message['currencyFrom']] += $message['amountSell']*$rate;
        } else {
          $this->mostTradedVal[$message['currencyFrom']] = $message['amountSell']*$rate;
        }
        if(isset($this->mostTradedVal[$message['currencyTo']])) {
          $this->mostTradedVal[$message['currencyTo']] += $message['amountBuy']*$rate;
        } else {
          $this->mostTradedVal[$message['currencyTo']] = $message['amountBuy']*$rate;
        }
        
      }
      
      // Set an expiry for maximum time for stale data - STALEDATAALLOWED
      $this->memcacheSet('most_traded', $this->mostTradedVal, STALEDATAALLOWED);
    }
  }
  
}

?>
