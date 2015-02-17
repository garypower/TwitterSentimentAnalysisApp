<html>
  <head>
    <link rel="icon" type="image/ico" href="images/twitterbirdfavicon.png"/>
    <title>Histogram</title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable(
   <?php

    include "includes/connectiondetails.php";

    $tablearray = $con->query("SELECT `text` , `score` FROM `twitterapp` ");
    $searchterm = $con->query("SELECT `searchterm` FROM  `twitterapp` LIMIT 1");
    $searchterm = mysqli_fetch_array($searchterm);

    $json_a = array();
    $json_a['cols'] = array(array('id' => '', 'label' => 'tweet', 'type' => 'string'), array('id' => '', 'label' => 'sentiment', 'type' => 'number'));
    $rows = array();

    while  ($row = mysqli_fetch_array($tablearray))
    {
      $temp = array();
      $temp[] = array('v' => $row['text']);
    
    if($row['score']== 'negative')
    {
      $temp[] = array('v' => 1);
    }
    if($row['score']== 'neutral')
    {
      $temp[] = array('v' => 2);
    }
    if($row['score']== 'positive')
    {
      $temp[] = array('v' => 3);
    }
    $rows[] = array('c' => $temp);

  }
    mysqli_close($con);
    $json_a['rows'] = $rows;
    $json_table = json_encode($json_a);
    echo $json_table;
?>);

        var options = {
          'title': '<?php echo $searchterm['0']?> Sentiment Analysis',
          legend: { position: 'right' },
          colors: ['blue','red'],
          hAxis: {title: 'Negative (1), Neutral (2) , Positive (3)'},
          histogram: {bucketSize: 1},

        };

        var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>