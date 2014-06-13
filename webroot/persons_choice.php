<?php
include("./classes/events.php");

$option_id = get_request_var('id',"");

$location = get_request_var('loc',"");
$start = get_request_var('s',"");
$start_time = get_request_var('st',"");
$end = get_request_var('end',"");
$end_time = get_request_var('et',"");
$count=get_request_var('count', "");

$event = get_request_var('event', "");

if(strlen($option_id)<1){
	//do the error thing
}

	$people = get_members_per_selection($option_id);
	
	$smarty->assign('event', $event);
	$smarty->assign('count', $count);
	$smarty->assign('start',$start);
	$smarty->assign('location',$location);
	
	if(strlen($end)>0){
		$smarty->assign('end',$end);
	}
	
	$smarty->assign('start_time',$start_time);
	$smarty->assign('end_time',$end_time);
	$smarty->assign('members',$people);
	$smarty->display('persons_choice.tpl.html');
?>