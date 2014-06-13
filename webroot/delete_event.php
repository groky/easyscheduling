<?php
	require_once("./classes/events.php");
	
	if(!user_is_logged_in()){
		show_page("l_o");
	}
	
	$event_id = get_request_var('id', "");
	
	delete_event($event_id);
	
	show_page("l_e");
	
?>