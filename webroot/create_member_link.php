<?php
  include('./classes/events.php');
  
  if(!user_is_logged_in()){
    show_page('l_o');
  }
  
  $exist_message = "The link you have requested already exists. 
  It is listed below and has been sent to <br /><br />";
  $new_message = "The link has been created and appears below. You can copy and paste it. 
  It has also been sent to <br /><br />";
  
  $event_id = get_request_var("id", false);
  $ipx = get_ipx();
  $link_exists = false;
  //check if the event already has a link
  //if yes, present that link
  //otherwise create a link
  //create a message saying : "Sending #link# to #email#"
  //offer the close button
  
  if(event_has_ipx($event_id)){
    $link_info = get_link($event_id);
    $link_exists = true;
    $link = $link_info['link'];
  }
  else{
    $link = LINK."&id=$event_id&ipx=$ipx";
    //alert($link);
    create_link($event_id, $link, $ipx);
  }
  
  $event_info = get_event_from_id($event_id);
  $email = get_member_email($event_id);
  //alert($email);
  
  sendMail($link, $email, $event_info);
  //sendMail($link, 'kgrovers@yahoo.com', $event_info);
  
?>
<h3><?php echo($event_info['event_name']); ?></h3>
<br />
<br />
<p align="center"><font size="2px">
  <?php 
  
  if($link_exists==true){
    echo($exist_message . "<strong>" . $email . "</strong><br /><br />");
  } else{
    echo($new_message . "<strong>" . $email . "</strong><br /><br />");
  } 
  echo("<strong>".$link."</strong>");
  ?>
  <br />
  <br />
  <a href="?page_name=l_e"><img src="./images/close.jpeg" alt="close page" title="return to the list of events"></img></a>
  </font>
</p>