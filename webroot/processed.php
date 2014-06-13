<?php
	
	$title = get_request_var('title', "");
	$reason = get_request_var('reason', "");
	
	$smarty->assign("title",$title);
	$smarty->assign("reason",$reason);
	$smarty->assign("name", get_name_from_cookie());
	
	$smarty->display('processed.tpl.html');
?>