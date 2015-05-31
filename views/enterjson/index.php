<style>
.honeypot {display:none;}
</style>
</head>
<body>

<form action="?url=messageconsumer" method="post">
Json Message:<br>
<input type="text" name="json" value='{"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "<?php echo date('j-M-y G:i:s'); ?>", "originatingCountry" : "FR"}'>
<br>
Refresh Key:<br>
<input type="text" name="refreshkey">
<p class="honeypot">Please Leave Empty:</p>
<input class="honeypot" type="text" name="honeypot">

<input type="submit" value="Submit">
  
