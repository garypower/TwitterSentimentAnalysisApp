<?php
function tweet_add($tweets,$searchterm)
{
	include "includes/connectiondetails.php";

	$searchterm = sanitize($searchterm);
	
	foreach ($tweets as $tweet)
	{
		//print_r($tweet);
		
		foreach ($tweet as $t)
		{
			
			if (gettype($t)=='object')
			{
				$id=$t->id_str;//tweet id

				$text=$t->text;
				$text=mysqli_real_escape_string($con,$text);

				$time=$t->created_at;
				$time=mysqli_real_escape_string($con,$time);

				$userpic=$t->user->profile_image_url;

				$username=$t->user->name;
				$username=mysqli_real_escape_string($con,$username);

				$location=$t->user->location;
				$location=mysqli_real_escape_string($con,$location);

				$retweets=$t->retweet_count;
				$retweets=mysqli_real_escape_string($con,$retweets);

				$favourite=$t->favorite_count;
				$favourite=mysqli_real_escape_string($con,$favourite);

				$mentions=$t->entities->user_mentions;//these are array
				$urls=$t->entities->urls;


				$coordinates=$t->geo;
				
				
				$dbid = $con->query("SELECT COUNT( id ) FROM  `twitterapp` WHERE id =$id");
				$dbid= mysqli_fetch_array($dbid);

				if($dbid[0]==0)//if id is not found in storage
					{
					$con->query(
						"INSERT INTO `twitterapp`(`id`,`userURLpic` ,`username`, `text`,`location`,`created_at`,`retweets`,`favourites`,`searchterm`)
						 VALUES
						  	('$id','$userpic','$username','$text','$location','$time','$retweets','$favourite','$searchterm')") or die ($con->error);

					$con->query("INSERT INTO `twitterappStore`(`UID`) VALUES ('$id')"); //for db recall
					}
			}
		strip($id,$text);
		findMentions($mentions,$id);
		findURL($urls,$id);
		if (!is_null($coordinates))
			{
				findCoordinates($coordinates,$id);
			}
		}

	
	}

mysqli_close($con);
}

function sanitize($data)
{ 
	include "includes/connectiondetails.php";

	$data = mysqli_real_escape_string($con , $data);
	addslashes(htmlentities(strip_tags($data)));
	mysqli_close($con);
	return $data;
}


function tweets_with_statuses($tweets,$searchterm)
{ 
	include "includes/connectiondetails.php";
	$searchterm = sanitize($searchterm);
	
	foreach ($tweets as $t)
	{		
			if (gettype($t)=='object')
			{
				$id=$t->id_str;//tweet id

				$text=$t->text;
				$text=mysqli_real_escape_string($con,$text);

				$time=$t->created_at;
				$time=mysqli_real_escape_string($con,$time);

				$userpic=$t->user->profile_image_url;

				$username=$t->user->name;
				$username=mysqli_real_escape_string($con,$username);

				$location=$t->user->location;
				$location=mysqli_real_escape_string($con,$location);

				$retweets=$t->retweet_count;
				$retweets=mysqli_real_escape_string($con,$retweets);

				$favourite=$t->favorite_count;
				$favourite=mysqli_real_escape_string($con,$favourite);

				$mentions=$t->entities->user_mentions;//these are array
				$urls=$t->entities->urls;


				$coordinates=$t->geo;
				
				
				$dbid = $con->query("SELECT COUNT( id ) FROM  `twitterapp` WHERE id =$id");
				$dbid= mysqli_fetch_array($dbid);

				if($dbid[0]==0)//if id is not found in storage
					{
					$con->query(
						"INSERT INTO `twitterapp`(`id`,`userURLpic` ,`username`, `text`,`location`,`created_at`,`retweets`,`favourites`,`searchterm`)
						 VALUES
						  	('$id','$userpic','$username','$text','$location','$time','$retweets','$favourite','$searchterm')") or die ($con->error);

					$con->query("INSERT INTO `twitterappStore`(`UID`) VALUES ('$id')"); //for db recall
					}
			}
		strip($id,$text);
		findMentions($mentions,$id);
		findURL($urls,$id);
		if (!is_null($coordinates))
			{
				findCoordinates($coordinates,$id);
			}
		
	}
mysqli_close($con);
}

?>