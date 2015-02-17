<html>
<head>
	<link rel="icon" type="image/ico" href="images/twitterbirdfavicon.png"/>
	<title>Pie Chart</title>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript"> 

	google.load('visualization','1.0',{'packages':['corechart']});
	google.setOnLoadCallback(graphpie);


	function graphpie()
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

		echo 'numPos='.$numPos['0'].';';
		
		echo 'numNeg='.$numNeg['0'].';';
		
		echo 'numNeu='.$numNeu['0'].';';
		
	?>

		var data = new google.visualization.DataTable();
		data.addColumn('string','Outcome');
		data.addColumn('number','tweets');

		data.addRows(
			[
				['Positive',numPos],
				['Negative',numNeg],
				['Neutral',numNeu],
			]
			);

		var options = {
			'title':'<?php echo $searchterm['0']?> Sentiment Analysis',
			'width':800,
			'height':800,
			'is3D': 'true',
			'colors': ['#009900', '#ff0000', '#999999']
		};

		var graph = new google.visualization.PieChart(document.getElementById('charts'));
		graph.draw(data,options);

	}
</script>
</head>
<body>
	<div id="charts"></div>
</body>
</html>