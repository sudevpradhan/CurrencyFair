  <div id="menu">
      <ul id="navigation-menu">
        <li><a href="<?php print APP_BASE_URL; ?>">Most Traded Currencies</a></li>
        <li><a href="<?php print APP_BASE_URL; ?>?url=currencypairs">Currency trade pairs</a></li>        
        <li><a href="<?php print APP_BASE_URL; ?>?url=enterjson">Send Single Json</a></li>
        <li><a href="<?php print APP_BASE_URL; ?>?url=refreshdata">Refresh data</a></li>        
      </ul>
    </div>
  
  </div>
<!--Footer section -->    
    <div id="footer">
      </br>
      <h3>CurrencyFair Test</h3>
      <strong>Only last <?php print MAXSTORE; ?> transactions are considerd at any given time.</strong></br>
      <p><i><strong>General Configurations</strong></br>
      Maximum number of entries stored: <?php print MAXSTORE; ?></br>
      Graph data refreshes after: <?php print STALEDATAALLOWED; ?> sec (if data changes)
      </i></p>
    </div>
  </body>
</html>
