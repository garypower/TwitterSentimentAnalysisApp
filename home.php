<?php include "library/twitteroauth.php";
	  include "functions/database.php";
	  include "functions/score.php";
	  include "library/DatumboxAPI.php";
	  include "functions/datumbox.php";
	  include "functions/display.php";
	  include "functions/striptext.php";
	  include "functions/results.php";
	  include "functions/alreadyscored.php";
	  include "functions/clear.php";
	  include "includes/init.php";
	  include "functions/remove.php"
?>


<?php
include "includes/twitterappdetails.php";
if((!isset($_POST['select']) && (isset($_POST['Submit']) )))
{
	$errors[] = 'Please select what type of analysis you require. A hashtag, text or a persons twitter account.';
}

if(isset($_POST['keyword']) && empty($_POST['keyword']) === true && isset($_POST['select'])) // if no keyword is set
{
	$errors[] = 'Please fill in the text box provided.';
}

if (isset($_POST['keyword']) && empty($errors) === true)
{
	if(!isset($_POST['Content']))
	{
		if ($_POST['select'] == '@')
		{
			$_POST['keyword'] = str_replace("#", "@", $_POST['keyword']);
			$tweets =$twitter->get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$_POST['keyword'].'&count='.$_POST['count'].'&lang='.$_POST['lang'].'&result_type=');
		}
		if ($_POST['select'] == 'text')
		{
			$_POST['keyword'] = str_replace("@", "", $_POST['keyword']);
			$_POST['keyword'] = str_replace("#", "", $_POST['keyword']);
			$tweets =$twitter->get('https://api.twitter.com/1.1/search/tweets.json?q='.$_POST['keyword'].'&count='.$_POST['count'].'&lang='.$_POST['lang'].'&result_type='.$_POST['type']);
		}
		if ($_POST['select'] == '#')
		{
			$_POST['keyword'] = str_replace("@", "#", $_POST['keyword']);
			$_POST['keyword'] = str_replace(" ", "", $_POST['keyword']);
			$str = str_replace("#", "%23", $_POST['keyword']);
			$tweets =$twitter->get('https://api.twitter.com/1.1/search/tweets.json?q='.$str.'&count='.$_POST['count'].'&lang='.$_POST['lang']);
		}
	//'geocode=37.781157,-122.398720,1mi');
	}

	if(!isset($_POST['Content']) && empty($tweets) === true) // if no keyword is set
	{
		$errors[] = 'No Tweets available for '.$_POST['keyword'];
	}
	if (!isset($_POST['refresh']) && !isset($_POST['Content']))
	{
		clear();
	}
	if(!isset($_POST['Content']))
	{
		if ($_POST['select'] == '@')
		{
			tweets_with_statuses($tweets,$_POST['keyword']);
		}
		if ($_POST['select'] == 'text')
		{
			tweet_add($tweets,$_POST['keyword']); //send to db
		}
		if ($_POST['select'] == '#')
		{
			tweet_add($tweets,$_POST['keyword']); //send to db
		}
	alreadyscored();
	score();//score tweeta from db*/
	}
}
?>

<html>
<head>
	<title>GarysTwitterapp</title>
	<link href="style.css" rel="stylesheet" type="text/css" media = "screen"/>
	<link rel="icon" type="image/ico" href="images/twitterbirdfavicon.png"/>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
</head>

<body>
<header>
	<a href="http://csserver.ucd.ie/~gpower/twitterapp/home.php"> <img src="images/twitterbird.png" alt="Homepage link"/><em>Sentiment Analysis</em></a>

	<div id='searches'>
		<form action = "home.php" method="POST">
			<label><input type="radio" name="select" value="#" <?php if (isset($_POST['select']) && ($_POST['select']) == '#'){ echo 'checked';}?>>#</label>

			<label><input type="radio" name="select" value="text" <?php if (isset($_POST['select']) && ($_POST['select']) == 'text'){ echo 'checked';}?>>text</label>

			<label><input type="radio" name="select" value="@" <?php if (isset($_POST['select']) && ($_POST['select']) == '@'){ echo 'checked';}?>>@</label>


			<label> <input class="textbox" type="text" name="keyword" value="<?php if (isset($_POST['keyword'])){echo $_POST['keyword'];} ?>"/></label>
		
			<input type="Submit" value="Submit" class="button" name="Submit">
			<?php if (isset($_POST['keyword'])&& empty($errors) === true)
					{
						echo '<input type="Submit" value="Refresh" class="button" name="refresh">';
					} 
			?>

			<?php if (isset($_POST['keyword'])&& empty($errors) === true)
					{
						echo '<input type="Submit" value="Content" class="button" name="Content">';
					} 
			?>
	</div>

</header>

<div id='sidebar'>

			<label> Amount	<select type="text" name="count" class="textbox">
								  <option value="10">10</option>
								  <option value="50">50</option>
								  <option value="100">100</option>
								  <option value="250">250</option>
								  <option value="500">500</option>
							</select>
			</label>

			<label> Type 	<select type="text" name="type" class="textbox"> 
									<option value="latest">latest</option>
									<option value="popular">popular</option>
							</select>
			</label>

			<label> Language<select type="text" name="lang" class="textbox"> 
								<option value=""></option>
								<option value="en">en</option>
							</select>
			</label>

		</form><!--end of form-->

	<div id="results">
			<?php 
			if (isset($_POST['Content']))
			{
			$numadult = adultContent();
			echo "<script>$(document).ready(function(){alert('$numadult rows removed');})</script>";

			}
			if (isset($_POST['keyword']) && empty($errors) === true )
			{
				resultsWidget();
			}
			?>
	</div>

</div>

<div id='tweets'>

<?php

	if (isset($_POST['keyword']) && empty($errors) === true)
	{
		display();
	}
	if (empty($errors) === false)
	{
		output_errors($errors);
	}
?>

</div>

<footer>

<?php
if (isset($_POST['keyword']) && empty($errors) === true)
	{
	echo '<a href="piechart.php" target="_blank"><img src="images/piechart.png" alt="piechart link"/>Pie Chart</a>';
	echo '<a href="barchart.php" target="_blank"><img src="images/barchart.png" alt="barchart link"/>Bar Chart</a>'	;
	echo '<a href="histogram.php" target="_blank"><img src="images/histogram.png" alt="histogram link"/>Histogram</a>';
	echo '<a href="geochart.php" target="_blank"><img src="images/white-globe.png" alt="geo graph"/>Geography based</a>';
	}
?>

</footer>
	
</body>
</html>