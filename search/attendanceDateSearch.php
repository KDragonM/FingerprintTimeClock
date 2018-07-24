<?php
  $query = $_POST['query'];
  $team = $_POST['team'];
  require("secretSettings.php");
  $conn = null;

  try{
      $conn = new PDO("mysql:host=$SERVERNAME;dbname=$DBNAME", $USERNAME, $PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch(PDOException $e)
  {
      echo "\nConnection aborted: " . $e->getMessage();
      exit;
  }

  $getData = $conn->prepare("SELECT First_Name,Last_Name,timeScanned,ID FROM log WHERE timeScanned LIKE :query AND ID IN (SELECT ID FROM Student_Info WHERE TEAM = :queryTeam);");
  $getData->execute($arrayName = array(':query' => "%".$query."%",':queryTeam' => $team));
  //echo $getData;
  $data = $getData->fetchAll();
  //echo print_r($data,true);
  //echo "<hr>";
  $results = array();
  foreach ($data as $d) {
    $string = $d['First_Name'] . " " . $d['Last_Name'];
    array_push($results,$string);
  }
    $newResult = array_unique($results,SORT_STRING);
    $returnString = implode(", ",$newResult);
    echo "<textarea  style='width:100%;margin:0%;height:5em' rows='3'>".$returnString."</textarea>"




 ?>
