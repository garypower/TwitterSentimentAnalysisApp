<?php
function display(){

include "includes/connectiondetails.php";

$result = $con->query("SELECT * FROM `twitterapp` ORDER BY `id` DESC ");//shows time in correct order


while ($row = mysqli_fetch_array($result))
{ //loop over the entire table
  //$newarray = $result->fetch_assoc();
    echo "<div class=";

      if ($row['score']=='negative') 
      {
        echo "negative";
      }
      if ($row['score']=='positive') 
      {
        echo "positive";
      }
      if ($row['score']=='neutral') 
      {
        echo "neutral";
      }
     if ($row['score']=='')
      {
        echo "error";
      }
    echo ">";
    echo '<img src='.$row['userURLpic'].'/>';

    echo '<b>'.$row['username'].'</b>'.'<br/>';

    echo '<em>'.$row['text'].'</em>'.'<br/>';

    echo '<hr>';

      echo "<div class='otherinfo'>";

      $row['Created_at']=substr($row['Created_at'],0,19);
      print ($row['Created_at']);

      echo ' <img src="images/retweet.png" alt="retweet image"/>retweets:';

      print ($row['retweets']);

      echo ' <img src="images/favourite.png" alt="favourite image"/>favourites:';

      print ($row['favourites']);

      echo "</div>";

    echo "</div>";


}

}
function resultsWidget()
{
  echo '<p> Results <hr>';
  echo 'Positive: <br/>' ;
  $P = Positive();
  echo "$P";
  echo '% <br/>';
  echo '<br/>';
  echo 'Negative:<br/>'; 
  $Neg = Negative();
  echo "$Neg";
  echo '% <br/>';
  echo '<br/>';
  echo 'Neutral:<br/>'; 
  $Neu = Neutral();
  echo "$Neu" ;
  echo '% <br/>';
  echo '<br/>';
  echo '</p>';
}

?>