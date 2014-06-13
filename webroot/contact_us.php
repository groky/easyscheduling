<?php
  //check if the user is logged in
  if(!user_is_logged_in()){
  	$contact_error="* You must be logged in to contact us. <br />";
  	$contact_error=$contact_error . "Please Log in or Register on the Home page";
    show_page("l_o&contactuserror=".$contact_error);
  }
  
  
  $name = get_request_var('name', "");
  $email = get_request_var('email', "");
  $subject = get_request_var('subject', "");
  
  $message = get_request_var('message', "");
  
  $send_info = get_request_var('send_info', false);
  
  if($send_info!==false){
  	if(!validate($subject, $message)){
  		error($errors);
  	}else{
  		do_email_from_contact($subject, $message);
  	}
  }
  
  function validate($subject, $message){
  	global $errors;
    
    $validate = true;
    
    if(!ctype_alpha($subject) && strlen($subject)<1){
      $errors = $errors . "* The subject cannot be blank <br />";
      $validate = false;
    }
    
    if(!ctype_alpha($message) && strlen($message)<1){
      $errors = $errors . "* Please supply a valid message <br />";
      $validate = false;
    }
    
    return $validate;
  }
?>

<form method="post" action="?" enctype="multipart/form-data" name="contact_form">
<h4>Send us your feedback, comment or request</h4>
<table class="body-table" id="contact-us" border="0">
    <tr>
    	<td colspan="2"><label>Subject</label></td>
    	<td><input type="text" name="subject" /></td>
    </tr>
    <tr>
    	<td colspan="2"><label>Message</label></td>
    	<td><textarea cols="50" rows="10" name="message"></textarea></td>
    </tr>    
      <tr>
        <td colspan="3" align="right"><input type="submit" value="Send" name="send_info" /></td>
      </tr>    
</table>
<input type="hidden" name="page_name" value="u_c" />
</form>