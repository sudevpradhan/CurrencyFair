  <script type="text/javascript">

  // Load the Visualization API and the piechart package.
  google.load('visualization', '1', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
  google.setOnLoadCallback(drawChart);

  function drawChart() {

    // Create our data table out of JSON data loaded from server.
    var data = new google.visualization.DataTable(<?=$data?>);
    var options = {
        title: 'Most traded currencies by Amount - Converted to USD as base unit.',
        is3D: 'true',
        width: 800,
        height: 600
      };
    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('google_chart'));
    chart.draw(data, options);
  }
  </script>
</head>

  <body>
    <div id="content">
    
    
   <!--this div will hold the pie chart-->
    <div id="google_chart"></div>
  
