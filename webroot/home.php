<?php

if(!user_is_logged_in()){
  	$contact_error="* You must be logged in to complete your request. <br />";
  	$contact_error=$contact_error . "Please Log in or Register on the Home page";
    show_page("l_o&contactuserror=".$contact_error);
  }

 $smarty->display('home.tpl.html');
?>