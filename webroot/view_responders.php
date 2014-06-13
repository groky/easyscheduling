<?php
	require_once("./classes/events.php");
	
	$event_id = get_request_var('id', "");

	$event_info = get_event_from_id($event_id);
	$responders = get_all_responders($event_id);
	
	$smarty->assign('title', "Show all responders");
	$smarty->assign('event', $event_info);
	$smarty->assign('responders', $responders);

	$smarty->display('view_all_responders.tpl.html');
?>