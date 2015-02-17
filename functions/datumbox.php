<?php

function datumbox($tweet)
{

$api_key='cd991b07ec13f3888fbd92c113309475';

$DatumboxAPI = new DatumboxAPI($api_key);

return $DocumentClassification['TwitterSentimentAnalysis']=$DatumboxAPI->TwitterSentimentAnalysis($tweet);

//print_r($DocumentClassification);

}
function output_errors($errors)
{
	echo "<div class=error>";
	echo '<img src="images/twitterbird.png"/>';
	foreach ($errors as $key => $value)
    {
    echo "$value";
	echo "<br/>";
	}
	echo "</div>";
}

function adultcontent()
{
	include "includes/connectiondetails.php";
	$result = $con->query("SELECT `textafter`, `id` FROM  `twitterapp`");

	$removals=0;

	while($row = mysqli_fetch_array($result))
		{
		$tweet=$row['textafter'];
		$id= $row['id'];

		$api_key='cd991b07ec13f3888fbd92c113309475';

		$DatumboxAPI = new DatumboxAPI($api_key);

		$DocumentClassification['AdultContentDetection']=$DatumboxAPI->AdultContentDetection($tweet);

				if($DocumentClassification['AdultContentDetection']=='adult')
				{
					$con->query("Delete FROM `twitterapp` WHERE `id` = $id");
					$removals++;
				}
		}
	return $removals;
}
?>