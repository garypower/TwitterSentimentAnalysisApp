
<?php
    include "includes/connectiondetails.php";

    $tablearray = $con->query("SELECT COUNT(`latitude`) AS result FROM `twitterapp` where latitude !=  '0' ");
    $searchterm = $con->query("SELECT `searchterm` FROM  `twitterapp` LIMIT 1");
    $tablearray = mysqli_fetch_array($tablearray);
    $searchterm = mysqli_fetch_array($searchterm);

    if ($tablearray['result']==0)
    {
      echo ('Sorry no geo coordinate information was provided!');
      exit;
    }


?>
<html>
  <head>
    <link rel="icon" type="image/ico" href="images/twitterbirdfavicon.png"/>
    <title>Geo Coordinates Graph</title>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawMarkersMap);

      function drawMarkersMap() {
      var data = google.visualization.arrayToDataTable([
        ['latitude','longitude','Value'],
<?php
    $newarray = $con->query("SELECT `latitude` ,`longitude` ,`text` , `username` ,`score` FROM `twitterapp` where latitude !=  '0' ");
    while  ($row = mysqli_fetch_array($newarray))
      {
      echo '[';
      echo $row['longitude'];
      echo ',';
      echo $row['latitude'];
      echo ',';

      if($row['score']== 'negative')
        {
          echo '1';
        }
      if($row['score']== 'neutral')
        {
          echo '2';
        }
      if($row['score']== 'positive')
        {
          echo '3';
        }
      if($row['score']== '')
        {
          echo '0';
        }
      echo '],';   
      } 
      mysqli_close($con);
?>
]);

      var options = {
        'title': '<?php echo $searchterm['0']?> Sentiment Analysis',
        displayMode: 'markers',
        colorAxis: {colors: ['green','white','red']}
      };

      var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    };
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>