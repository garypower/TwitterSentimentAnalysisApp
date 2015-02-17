<?php
function score()
{
include "includes/connectiondetails.php";

$result = $con->query("SELECT `id`, `textafter` FROM  `twitterapp` WHERE `score` IS NULL");

  while ($row = mysqli_fetch_array($result))
  {
    $analysis=datumbox($row['textafter']);

    $idcurrent=($row['id']);

  	$con->query("UPDATE `twitterapp` SET score ='$analysis' WHERE `id` = '$idcurrent'"); //enter score to table 
  	$con->query("UPDATE `twitterappStore` SET score = '$analysis' WHERE `UID` = '$idcurrent'");
  }
 mysqli_close($con); 
}

?>