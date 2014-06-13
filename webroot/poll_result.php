<?php
  include("./classes/profile.php");
  include("./classes/events.php");
  
  $event_id = get_request_var("id", false);
  $multi=get_request_var("multi", false);
  
  if(!user_is_logged_in()){
    show_page("l_o");
  }
  $event = get_event_from_id($event_id);
  //$time_table = get_timetable($event_id, LONG_DATE);
  $choices = get_poll_result_list($event_id);

  //$time_table_count = count($time_table);
  
  //echo("<pre>". print_r($event) . "</pre><br /><br />");
  //echo("<pre>". print_r($choices) . "</pre>");
  
  $smarty->assign('event', $event);
  $smarty->assign('choices', $choices);
  $smarty->display('poll_result.tpl.html');
  
?>

