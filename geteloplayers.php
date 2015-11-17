<?php
require_once('../mysql_connect.php');

$query = "SELECT name, elo FROM elo_players ORDER BY elo DESC";
$response = @mysqli_query($dbc, $query);

if($response){

  $json = array();

  while($row = mysqli_fetch_array($response)){
    $json[] = $row;
  }

  echo json_encode($json);
} 

else {
  echo "Couldn't issue database query: " . mysqli_error($dbc);
}

?>
