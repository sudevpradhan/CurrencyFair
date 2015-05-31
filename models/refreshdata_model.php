<?php
class Refreshdata_Model extends Model {
  public $currencies;
  public $rates;
  function __construct() {
    parent::__construct();
    $this->setCurrencies();
  }
  
  public function createStub() {
    for ($i = 0; $i < (MAXSTORE/2); $i++ ) {
      // Get Random 2 currencies.
      $currency = array_rand($this->currencies, 2);
      $date = date("j-M-y G:i:s");
      $amtBuy = rand(100, 9999);
      
      // Some countries may have changed their currency, so ignore older currencies
      if(!isset($this->rates[$currency[0]]) || !isset($this->rates[$currency[1]])) {
        continue;
      }
      
      $c0Rate = $this->rates[$currency[0]];
      $c1Rate = $this->rates[$currency[1]];
      
      // Set a general random fluctuation.
      $rate = round((((($c0Rate/$c1Rate)/rand(1, 100)) + $c0Rate)/$c1Rate), 3);
      
      // If the rate calculated is too small PHP returns 0 so instead use the smaller currency rate.
      $rate = ($rate == 0) ? $c0Rate : $rate;
      // Calculate amout sold with current rate
      $amtSell = round($amtBuy/$rate, 3);
      
      $json_data = '{"userId": "' . rand(1, 99999) . '", "currencyFrom": "' . $currency[0] . '", "currencyTo": "' . $currency[1] . '", "amountSell": ' . $amtSell . ', "amountBuy": ' . $amtBuy . ', "rate": ' . $rate . ', "timePlaced" : "' . $date . '", "originatingCountry" : "' . $this->currencies[$currency[0]] . '"}';
      $data = array(
        'json' => $json_data,
        'refreshkey' => REFRESH_KEY
      );
      $params = http_build_query($data);
      
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, APP_BASE_URL . "?url=messageconsumer");      
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $server_output = curl_exec ($ch);
      curl_close ($ch);

    }
    $data = array();
    for($i=1; $i < MAXSTORE; $i++) {
      $data[] = $this->memcacheGet('message_consumed_' . $i);
    }
    return $data;
  }
  
  private function setCurrencies() {
    $this->currencies = json_decode(CURRENCIES, 1);
    // Rates to USD
    $this->rates = json_decode(CURRENCYRATES, 1);
  }
  
}
