<?php
function findURL($array,$id)
{
	foreach ($array as $key)
	{
	if (gettype($key)=='object')
		{
			$stuff=$key->url;
			removeURL($stuff,$id);
			//clickURL($stuff,$id);
		}
		
	}
}

function removeURL($string,$id)
{
	include "includes/connectiondetails.php";
	$result = $con->query("SELECT `id`,`textafter` FROM `twitterapp` Where `id` = '$id' ");

  while ($row = mysqli_fetch_array($result))
  {
    $newtext=str_replace( $string, '', $row['textafter']);

    $idcurrent=($row['id']);

  	$con->query("UPDATE `twitterapp` SET `textafter` = '$newtext' WHERE `id` = '$idcurrent'"); //enter score to table 
  }
  mysqli_close($con);
}

function findMentions($array,$id)
{
	foreach ($array as $key)
	{

	if (gettype($key)=='object')
		{
			$stuff=$key->screen_name;
			removeMention($stuff,$id);
		}
		
	}
}

function removeMention($string,$id)
{
	include "includes/connectiondetails.php";
	$result = $con->query("SELECT `id`,`textafter` FROM `twitterapp` Where `id` = '$id' ");

  while ($row = mysqli_fetch_array($result))
  {
    $newtext=str_replace( $string, '', $row['textafter']);

    $idcurrent=($row['id']);

  	$con->query("UPDATE `twitterapp` SET `textafter` = '$newtext' WHERE `id` = '$idcurrent'"); //enter score to table 
  }
  mysqli_close($con);
}

function clickURL($string,$id)
{
	include "includes/connectiondetails.php";
	$result = $con->query("SELECT `id`,`text` FROM `twitterapp` Where `id` = '$id' ");//one result

  while ($row = mysqli_fetch_array($result))
  {
    //
    $arr = array('<a target="_blank" href=','>','</a>');
    $newtext=implode($string, $arr);
    $newtext=str_replace( $string, $newtext, $row['text']);

    $idcurrent=($row['id']);

  	$con->query("UPDATE `twitterapp` SET `text` = '$newtext' WHERE `id` = '$idcurrent'"); //enter score to table 
  }
  mysqli_close($con);
}

function findCoordinates($object,$id)
{

	foreach ($object as $ob)
	{
		if ($ob != 'Point')
			{
			$longitude=$ob[0];
			$latitude=$ob[1];	
			SendCoordinates($longitude,$latitude,$id);
			}	
	}
}

function SendCoordinates($longitude,$latitude,$id)
{
	include "includes/connectiondetails.php";

  	$con->query("UPDATE `twitterapp` SET `longitude` = '$longitude' WHERE `id` = '$id'"); //enter score to table
  	$con->query("UPDATE `twitterapp` SET `latitude` = '$latitude' WHERE `id` = '$id'");

	mysqli_close($con);
}

?>