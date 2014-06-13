<?php
	
	require_once("../classes/db.php");
	require_once("../classes/events.php");
	
	$id =$_POST['id'];
	
	$people = get_members_per_selection($id);
	
	$str = "";
	foreach($people as $person){
		$str=$str . $person['first_name'] . " " .  $person['last_name'] . "<br />";
	}
	echo($str);
	//hook into the desired class and get the values.
?>