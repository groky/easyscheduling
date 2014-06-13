<?php
	/**
	 * load all the deleted events.
	 */
	include('./classes/events.php');
	
if(!user_is_logged_in()){
  	$contact_error="* You must be logged in to complete your request. <br />";
  	$contact_error=$contact_error . "Please Log in or Register on the Home page";
    show_page("l_o&contactuserror=".$contact_error);
  }
	
	$events = get_all_events(get_org_id());
	//print_r($events);
	$smarty->assign('title', "Old/Deleted Events");
	$smarty->assign('old_events',$events);
	$smarty->display('history.tpl.html');
?>