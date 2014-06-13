<?php
	$send = get_request_var('send', false);
	
	$name = get_request_var('name', "");
	$email = get_request_var('email', "");
	
	if($send!==false){
		validate($name, $email);

		if(strlen($errors)>0){
			error($errors);
		}
		else{
			//alert("Hey ya!");
			send_pw_email($name, $email);
			//alert("sent... changing..");
			show_page('s_p_u');
		}
	}
	
	function validate($name, $email){
		global $errors;
		
		$validated = true;
		
		if(!strlen($name)>0){
			$errors = $errors . "* Please insert your surname. <br />";
		}
	
		if(!check_email($email)){
			$errors = $errors . "* Please type a valid email address.";
		}
		
	}
?>

<form method="post" action="?" enctype="multipart/form-data" >
<table class="form-table" border="0" >
  <tr>
    <td>
      <h4>
        Forgotten Password
      </h4>
    </td>
  </tr>
   <tr>
    <td><label>Last Name</label></td>
    <td><input type="text" name="name" value="<?php echo($name);?>"/></td>
  </tr>
  <tr>
    <td><label>Email address</label></td>
    <td><input type="text" name="email" id="email-box" value="<?php echo($email); ?>" /></td>
  </tr>

   <tr>
      <td></td>
      <td><input type="submit" value="send" name="send" /></td>
    </tr>
    
</table>
<input type="hidden" name="page_name" value="p_f" />
</form>
