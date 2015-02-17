<?php
function alreadyscored(){

include "includes/connectiondetails.php";

$result = $con->query("SELECT * FROM `twitterapp`");


while ($row = mysqli_fetch_array($result))
{ 
      
        $UID = $row['id']; 
        //echo 'checking db';
        //echo  $UID;


        $check = $con->query("SELECT `score` FROM `twitterappStore` where uid = '$UID'");
        $check = mysqli_fetch_array($check);

        if ($check['score'] !='')//if it has been scored correctly before
        {
        	$analysis= $check['score'];

        	$con->query("UPDATE `twitterapp` SET score='$analysis' WHERE `id` = '$UID'");

        }


       
}
mysqli_close($con);

}

?>