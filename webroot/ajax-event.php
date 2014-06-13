<?php

require_once("../classes/db.php");
require_once("../classes/events.php");

$id =$_POST['id'];

$event = get_event_from_id($id);

$tt = get_timetable_count($id);


$str = "<p><strong>" . $event['event_name'] . "</strong><br/>";
$str = $str . $event['description'] . "</p>";

//then get the tt details;
$str=$str."<p><strong>Timetable</strong>";
$str=$str."<br />entries: $tt";
/*if($tt>=0 && $tt<2){
	$str=$str."<br />Link/email icon is not created with less than 2 date/time entries";
}*/
$str=$str."</p>";

//then get the email-sent details
$link = get_link($id);
$str = $str . "<p><strong>Email</strong>";
if(strlen($link['reference'])>0){
	$str = $str . "<br />A link has been created.<br/> Click the email icon to receive a copy";
}
else{
	$str = $str . "<br />A link has not yet been created.<br/>";
}
$str = $str . "</p>";

//then get the responses details
$str = $str . "<p><strong>Results</strong><br />";

if(event_has_poll_results($id)){
	$results = get_poll_count($id);
	if($results>1){
		$str = $str . $results . " people have responded so far.";
	}
	else if($results==1){
		$str = $str . $results . " person has responded so far.";
	}
	else{
		$str = $str ."None";
	}
}
else{
	$str = $str ."None";
}

$str = $str . "</p>";
//then show it
echo($str);
//hook into the desired class and get the values.

?>