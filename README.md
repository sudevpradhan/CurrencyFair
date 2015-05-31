CurrencyFair Test
====

Main Algorithm
------------

- Store each post message in diffrent Memcache entry Insure there are never too may operations - view/edit trying to access the same entry at the same time 
- Rotate the storage keys - such that there are only a configurable MAX number of messages in the system
- Compute and store with cache expiry values when viewing - use time for expiry instead of hits as hits cannot be predcted
- Fetch computed data to display in graph i.e. the data with cache expiry - insure fetching effecient i.e. fetch all at once

Details
-------
- Takes messages in JSON at endpoint - http://basepath.com?url=
JSON Format:
{"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24-JAN-15 10:27:44", "originatingCountry" : "FR"}
- 


Main Pages
-------------

- Most Traded Currencies
- Currency trade pairs
- Send Single Json
- Refresh data


Contributors
------------

* Sudev Pradhan [sudevpradhan](https://github.com/sudevpradhan) [developer]
