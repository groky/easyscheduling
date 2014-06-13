<?php

function getCalendarByRange($id){
	global $conn;
  try{

    $sql = "select * from `jqcalendar` where `id` = " . $id;
    $handle = mysql_query($sql, $conn);
    //echo $sql;
    $row = mysql_fetch_object($handle);
	}catch(Exception $e){
  }
  return $row;
}
?>