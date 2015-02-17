<?php
function positive()
{
include "includes/connectiondetails.php";

$positive = $con->query("SELECT COUNT( score ) as 'score' FROM twitterapp WHERE score = 'positive'");

$numOfTweets = $con->query("SELECT COUNT( score ) as 'numOfTweets' FROM twitterapp ");

mysqli_close($con);

$positive = mysqli_fetch_array($positive);
$numOfTweets = mysqli_fetch_array($numOfTweets);

$percentage = round((($positive['score']) / ($numOfTweets['numOfTweets'])*100));

return $percentage;
}


function negative()
{
include "includes/connectiondetails.php";

$negative = $con->query("SELECT COUNT( score ) as 'score' FROM twitterapp WHERE score = 'negative'");

$numOfTweets = $con->query("SELECT COUNT( score ) as 'numOfTweets' FROM twitterapp ");

mysqli_close($con);

$negative = mysqli_fetch_array($negative);
$numOfTweets = mysqli_fetch_array($numOfTweets);

return $percentage = round((($negative['score']) / ($numOfTweets['numOfTweets'])*100));
}


function neutral()
{
include "includes/connectiondetails.php";

$neutral = $con->query("SELECT COUNT( score ) as 'score' FROM twitterapp WHERE score = 'neutral'");

$numOfTweets = $con->query("SELECT COUNT( score ) as 'numOfTweets' FROM twitterapp ");

mysqli_close($con);

$neutral = mysqli_fetch_array($neutral);
$numOfTweets = mysqli_fetch_array($numOfTweets);

return $percentage = round((($neutral['score']) / ($numOfTweets['numOfTweets'])*100));
}
?>