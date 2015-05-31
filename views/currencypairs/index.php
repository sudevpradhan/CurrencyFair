  <script type="text/javascript">

  google.load('visualization', '1', {packages: ['corechart', 'bar']});
google.setOnLoadCallback(drawBarColors);

function drawBarColors() {
      var data = google.visualization.arrayToDataTable(<?=$data?>);
      var options = {
        title: 'Currency pair of most traded Currencies',
        chartArea: {width: '50%'},
        colors: ['#b0120a', '#ffab91'],
        hAxis: {
          title: 'Value Traded in USD',
          minValue: 0
        },
        vAxis: {
          title: 'Currency Pair'
        }
      };
      var chart = new google.visualization.BarChart(document.getElementById('google_chart'));
      chart.draw(data, options);
      }
  </script>
</head>

  <body>
    <div id="content">
    
    
   <!--this div will hold the pie chart-->
    <div id="google_chart"></div>
  
