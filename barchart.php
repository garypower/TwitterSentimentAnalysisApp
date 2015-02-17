<html>
  <head>
    <link rel="icon" type="image/ico" href="images/twitterbirdfavicon.png"/>
    <title>Bar Chart</title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      google.load("visualization", "1.0", {packages:["corechart"]});

      google.setOnLoadCallback(drawChart);

      function drawChart() 
      {
<?php

    include "includes/connectiondetails.php";

    $numPos = $con->query("SELECT COUNT( score ) FROM twitterapp WHERE score = 'positive'");
    $numNeg = $con->query("SELECT COUNT( score ) FROM twitterapp WHERE score = 'negative'");
    $numNeu = $con->query("SELECT COUNT( score ) FROM twitterapp WHERE score = 'neutral'");
    $searchterm = $con->query("SELECT `searchterm` FROM  `twitterapp` LIMIT 1");

    $numPos = mysqli_fetch_array($numPos);
    $numNeg = mysqli_fetch_array($numNeg);
    $numNeu = mysqli_fetch_array($numNeu);
    $searchterm = mysqli_fetch_array($searchterm);

    mysqli_close($con);

    $numPos=$numPos['0'];
    
    $numNeg=$numNeg['0'];
    
    $numNeu=$numNeu['0'];
    
?>
var data = google.visualization.arrayToDataTable([
        ['Outcome', 'Tweets', { role: 'style' }],
        ['Positive', <?php echo $numPos ?>, '#009900'],        
        ['Negative', <?php echo $numNeg ?>, '#ff0000'],            
        ['Neutral', <?php echo $numNeu ?>, '#999999'],
      ]);


         

          var options = {
            'title': '<?php echo $searchterm['0']?> Sentiment Analysis',
            'colors': ['#000000'],
          };

          var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
          chart.draw(data, options);
        }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>