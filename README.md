CurrencyFair Test
=================

USAGE
-----
- Review/Change settings in config/settings.php - e.g. "APP_BASE_URL", "REFRESH_KEY" 
- [code commented out for submission]IMPORTANT: All posts need send a "refreshkey" POST parameter - See config/settings.php to use/change "REFRESH_KEY"
- Posts need to send to endpoint - http://currencyfair-sudevpradhan.rhcloud.com/?url=messageconsumer
JSON format to be sent:
{"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24-JAN-15 10:27:44", "originatingCountry" : "FR"}
- Refresh data using this page (refreshes 50% of data): http://currencyfair-sudevpradhan.rhcloud.com/?url=refreshdata
- View Chart for "Most traded currencies by Amount" - http://currencyfair-sudevpradhan.rhcloud.com/
- View Currency pair of most traded Currencies - http://currencyfair-sudevpradhan.rhcloud.com/?url=currencypairs
NOTE: 
Chart data is refreshed only after "5 secs" after data changes. This limit can also be configured in settings.php. 
Also please note that there are only a few major random currencies which are generated by the "Refresh data" page which can also be configured in settings.php

Main Algorithm
--------------
- Check if memcache present - if yes use this/ else use a flat file system
- Store each post message in diffrent Memcache/file entry. This insures there are never too may operations - view/edit trying to access the same entry at the same time 
- Rotate the storage keys - such that there are only a configurable MAX number of messages in the system
- Compute and store with cache expiry values when viewing - use time for expiry instead of hits as hits cannot be predcted
- Fetch computed data to display in graph i.e. the data with cache expiry - insure fetching effecient i.e. fetch all at once


Details
-------
- Takes messages in JSON at endpoint.
- Stores this Json in memcache if present otherwise uses a flat filesystem.
- Computes and displays data using google charts.


Pages
----------
- Most Traded Currencies - Chart View
- Currency trade pairs - Chart View
- Send Single Json - Form to updateds the oldest entry
- Refresh data - Page to refresh 50% of older data

Contributors
------------
* Sudev Pradhan [sudevpradhan](https://github.com/sudevpradhan) [developer]
