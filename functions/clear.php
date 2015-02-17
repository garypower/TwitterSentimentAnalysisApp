<?php
function clear(){
	include "includes/connectiondetails.php";
$con->query("Delete from twitterapp");
mysqli_close($con);
}
?>