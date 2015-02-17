<?php
function strip($idin,$textin)
{
	$id=$idin;
	$text=$textin;

    $newtext=str_replace('@' , '', $text);
    $newtext=str_replace('RT' , '', $newtext);
    $newtext=str_replace('"' , '', $newtext);

    include "includes/connectiondetails.php";

  	$con->query("UPDATE `twitterapp` SET `textafter` = '$newtext' WHERE `id` = '$id'"); //enter score to table 
 	mysqli_close($con);
}
?>